<?php

namespace App\Traits;

use App\Article;
use App\Comment;
use Carbon\Carbon;
use DB;
use Cache;

trait HotArticleHelper
{
    /**
     * 临时文章数据
     * @var array
     */
    protected $articles = [];

    protected $view_weight    = 1;  // 文章查看次数权重
    protected $comment_weight = 4;  // 文章回复次数权重
    protected $pass_days      = 7;  // 统计的天数
    protected $article_number = 7;  // 返回的数量

    protected $cache_key               = 'dcynsd_hot_articles';
    protected $cache_expire_in_minutes = 65;

    public function getHotArticles()
    {
        // 尝试从缓存中取出 cache_key 对应的数据，如果能取到，直接返回数据
        // 否则运行匿名函数中的代码来取出活跃用户数量，返回的同时做了缓存
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function () {
            return $this->calculateHotArticles();
        });
    }

    public function calculateAndCacheHotArticles()
    {
        // 取得热门文章列表
        $hot_articles = $this->calculateHotArticles();
        // 放入缓存
        $this->cacheHotArticles($hot_articles);
    }

    private function calculateHotArticles()
    {
        $this->calculateCommentScore();
//        $this->calculateCommentScore();

        // 数组按照得分排序
        $articles = array_sort($this->articles, function ($article) {
            return $article['score'];
        });

        // 我们需要的是倒叙，高分靠前，第二个参数为保持数组的 KEY 不变
        $articles = array_reverse($articles, true);

        // 只获取想要的数量
        $articles = array_slice($articles, 0, $this->article_number, true);

        // 新建一个空集合
        $hot_articles = collect();

        foreach ($articles as $article_id => $article) {
            $article = $this->find($article_id);

            if ($article) {
                // 如果数据库找到该用户，将此用户实体放入集合的末尾
                $hot_articles->push($article);
            }
        }

        return $hot_articles;
    }

    private function calculateViewScore()
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
        // 从评论数据表里取出限定时间范围 `$pass_days` 内，有发表过评论的文章
        // 并且同时取出文章此段时间内发布评论的数量
        $comment_articles = Comment::query()->select(DB::raw('article_id, count(*) as comment_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('article_id')
            ->get();

        // 根据评论数量计算得分
        foreach ($comment_articles as $value) {
            $comment_score = $value->comment_count * $this->comment_weight;
            if (isset($this->articles[$value->article_id])) {
                $this->articles[$value->article_id]['score'] += $comment_score;
            } else {
                $this->articles[$value->article_id]['score'] = $comment_score;
            }
        }
    }

    private function cacheHotArticles($hot_articles)
    {
        Cache::put($this->cache_key, $hot_articles, $this->cache_expire_in_minutes);
    }
}