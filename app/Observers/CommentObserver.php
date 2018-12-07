<?php

namespace App\Observers;

use App\Article;
use App\Comment;
use App\Notifications\ArticleComments;

class CommentObserver
{
    public function created(Comment $comment)
    {
        $comment->article->increment('reply_count');
        $comment->article->update(['last_reply_user_id' => $comment->user_id]);

        $comment->article->user->notify(new ArticleComments($comment));
    }

    public function deleted(Comment $comment)
    {
        $comment->article->decrement('reply_count');
    }
}