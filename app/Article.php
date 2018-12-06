<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jcc\LaravelVote\CanBeVoted;

/**
 * App\Article
 *
 * @property int $id
 * @property int $user_id 用户 ID
 * @property int $category_id 分类 ID
 * @property string $title 标题
 * @property string $body 内容
 * @property int $reply_count 回复数量
 * @property int $view_count 查看数量
 * @property int $last_reply_user_id 最后回复用户 ID
 * @property int $order 排序
 * @property string|null $excerpt 文章摘要
 * @property string|null $slug SEO 优化
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Category $category
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereLastReplyUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereReplyCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereViewCount($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $voters
 */
class Article extends Model
{
    use CanBeVoted;

    protected $vote = User::class;

    protected $fillable = [
        'title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function visits()
    {
        return visits($this);
    }

    /**
     * @param $query
     * @param $order  default 活跃 excellent 精华 vote 投票 recent 最近 noreply 零回复
     * @return mixed
     */
    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'excellent':
                $query->excellent();
                break;
            case 'vote':
                $query->vote();
                break;
            case 'recent':
                $query->recent();
                break;
            case 'noreply':
                $query->noreply();
                break;
            default:
                $query->default();
                break;
        }

        return $query;
    }

    public function scopeDefault($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeExcellent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeVote($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeNoreply($query)
    {
        return $query->where('reply_count', 0);
    }
}
