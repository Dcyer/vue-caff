<?php

namespace App\Observers;

use App\Article;

class ArticleObserver
{
    public function created(Article $article)
    {
        $article->user->increment('post_counts');
        $article->category->increment('post_counts');
    }

    public function deleted(Article $article)
    {
        $article->user->decrement('post_counts');
        $article->category->decrement('post_counts');
    }

}