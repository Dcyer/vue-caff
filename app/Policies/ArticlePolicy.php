<?php

namespace App\Policies;

use App\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function update(User $currentUser, Article $article)
    {
        return $currentUser->id === $article->user_id;
    }
}
