<?php

namespace App\Traits;

use App\Article;
use App\Comment;
use App\User;
use Carbon\Carbon;
use Cache;

trait StatisticsHelper
{
    protected $cache_keys               = 'dcynsd_statistics';
    protected $cache_expire_in_minutes = 65;

    public function getStatistics()
    {
        // 尝试从缓存中取出 cache_key 对应的数据，如果能取到，直接返回数据
        // 否则运行匿名函数中的代码来取出统计数据，返回的同时做了缓存
        return Cache::remember($this->cache_keys, $this->cache_expire_in_minutes, function () {
            return $this->calculateStatistics();
        });
    }

    public function calculateAndCacheStatistics()
    {
        // 取得统计数据
        $statistics = $this->calculateStatistics();
        // 放入缓存
        $this->cacheStatistics($statistics);
    }

    private function calculateStatistics()
    {
        $statistics = [
            'user_counts' => User::query()->count(),
            'article_counts' => Article::query()->count(),
            'comment_counts' => Comment::query()->count(),
        ];

        return $statistics;
    }

    private function cacheStatistics($statistics)
    {
        Cache::put($this->cache_keys, $statistics, $this->cache_expire_in_minutes);
    }
}