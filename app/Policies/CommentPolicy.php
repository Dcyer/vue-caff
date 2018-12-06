<?php

namespace App\Policies;

use App\Comment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function destroy(User $currentUser, Comment $comment)
    {
        return $currentUser->isAuthorOf($comment) || $currentUser->isAuthorOf($comment->article);
    }
}
