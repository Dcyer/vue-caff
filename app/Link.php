<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Link
 *
 * @property int $id
 * @property string $title 资源的描述
 * @property string $link 资源的链接
 * @property string $logo 资源的LOGO
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Link extends Model
{
    protected $fillable = ['title', 'link', 'logo'];

    public    $cache_key               = 'dcynsd_links';
    protected $cache_expire_in_minutes = 1440;

    public function getAllCached()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出 links 表中所有的数据，返回的同时做了缓存。
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function () {
            return $this->all();
        });
    }
}
