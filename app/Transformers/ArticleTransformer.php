<?php

namespace App\Transformers;

use App\Article;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'category', 'comments'];

    public function transform(Article $article)
    {
        return [
            'id'                 => $article->id,
            'title'              => $article->title,
            'body'               => $article->body,
            'user_id'            => (int)$article->user_id,
            'category_id'        => (int)$article->category_id,
            'reply_count'        => (int)$article->reply_count,
            'view_count'         => (int)$article->visits()->count(),
            'vote_count'         => (int)$article->countVoters(),
            'last_reply_user_id' => (int)$article->last_reply_user_id,
            'excerpt'            => $article->excerpt,
            'slug'               => $article->slug,
            'votes'              => $article->voters,
            'created_at'         => $article->created_at->diffForHumans(),
            'updated_at'         => $article->updated_at->diffForHumans(),
        ];
    }

    public function includeUser(Article $article)
    {
        return $this->item($article->user, new UserTransformer());
    }

    public function includeCategory(Article $article)
    {
        return $this->item($article->category, new CategoryTransformer());
    }

    public function includeComments(Article $article)
    {
        return $this->collection($article->comments, new CommentTransformer());
    }
}