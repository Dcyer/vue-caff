<?php

namespace App\Traits;

use App\Article;
use App\Comment;
use Carbon\Carbon;
use DB;
use Cache;

trait ActiveUserHelper
{
    /**
     * 临时用户数据
     * @var array
     */
    protected $users = [];

    protected $article_weight = 4;  // 发布文章权重
    protected $comment_weight = 1;  // 回复文章权重
    protected $pass_days      = 7;  // 统计的天数
    protected $user_number    = 6;  // 返回的数量

    protected $cache_key               = 'dcynsd_active_users';
    protected $cache_expire_in_minutes = 65;

    public function getActiveUsers()
    {
        // 尝试从缓存中取出 cache_key 对应的数据，如果能取到，直接返回数据
        // 否则运行匿名函数中的代码来取出活跃用户数量，返回的同时做了缓存
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function () {
            return $this->calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers()
    {
        // 取得活跃用户列表
        $active_users = $this->calculateActiveUsers();
        // 放入缓存
        $this->cacheActiveUsers($active_users);
    }

    private function calculateActiveUsers()
    {
        $this->calculateArticleScore();
        $this->calculateCommentScore();

        // 数组按照得分排序
        $users = array_sort($this->users, function ($user) {
            return $user['score'];
        });

        // 我们需要的是倒叙，高分靠前，第二个参数为保持数组的 KEY 不变
        $users = array_reverse($users, true);

        // 只获取想要的数量
        $users = array_slice($users, 0, $this->user_number, true);

        // 新建一个空集合
        $active_users = collect();

        foreach ($users as $user_id => $user) {
            $user = $this->find($user_id);

            if ($user) {
                // 如果数据库找到该用户，将此用户实体放入集合的末尾
                $active_users->push($user);
            }
        }

        return $active_users;
    }

    private function calculateArticleScore()
    {
        // 从文章数据表里取出限定时间范围 `$pass_days` 内，有发表过文章的用户
        // 并且同时取出用户此段时间内发布文章的数量
        $article_users = Article::query()->select(DB::raw('user_id, count(*) as article_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();

        // 根据文章数量计算得分
        foreach ($article_users as $value) {
            $this->users[$value->user_id]['score'] = $value->article_count * $this->article_weight;
        }
    }

    private function calculateCommentScore()
    {
        // 从评论数据表里取出限定时间范围 `$pass_days` 内，有发表过评论的用户
        // 并且同时取出用户此段时间内发布评论的数量
        $comment_users = Comment::query()->select(DB::raw('user_id, count(*) as comment_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();

        // 根据评论数量计算得分
        foreach ($comment_users as $value) {
            $comment_score = $value->comment_count * $this->comment_weight;
            if (isset($this->users[$value->user_id])) {
                $this->users[$value->user_id]['score'] += $comment_score;
            } else {
                $this->users[$value->user_id]['score'] = $comment_score;
            }
        }
    }

    private function cacheActiveUsers($active_users)
    {
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_minutes);
    }
}