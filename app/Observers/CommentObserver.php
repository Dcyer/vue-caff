<?php

namespace App\Observers;

use App\Article;
use App\Comment;

class CommentObserver
{
    public function created(Comment $comment)
    {
        $comment->article->increment('reply_count');
        $comment->article->update(['last_reply_user_id' => $comment->user_id]);
    }

    public function deleted(Comment $comment)
    {
        $comment->article->decrement('reply_count');
    }
}