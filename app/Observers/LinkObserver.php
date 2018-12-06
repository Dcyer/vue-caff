<?php

namespace App\Observers;

use App\Link;
use Illuminate\Support\Facades\Cache;

class LinkObserver
{
    public function saved(Link $link)
    {
        // 在保存时清空 cache_key 对应的缓存
        Cache::forget($link->cache_key);
    }
}