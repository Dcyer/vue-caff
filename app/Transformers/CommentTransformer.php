<?php

namespace App\Transformers;

use App\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
            'id'         => $comment->id,
            'user_id'    => (int)$comment->user_id,
            'topic_id'   => (int)$comment->article_id,
            'body'       => $comment->body,
            'user'       => $comment->user,
            'created_at' => $comment->created_at->diffForHumans(),
            'updated_at' => $comment->updated_at->diffForHumans(),
        ];
    }
}