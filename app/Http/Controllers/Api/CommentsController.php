<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Comment;
use App\Http\Requests\Api\CommentRequest;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(CommentRequest $request, Article $article, Comment $comment)
    {
        $comment->body       = $request->body;
        $comment->article_id = $article->id;
        $comment->user_id    = $this->user()->id;
        $comment->save();

        return $this->response->collection($article->comments, new CommentTransformer())->setStatusCode(201);
    }

    public function destroy(Article $article, Comment $comment)
    {
        if ($comment->article_id != $article->id) {
            return $this->response->errorBadRequest();
        }

        $this->authorize('destroy', $comment);
        $comment->delete();

        return $this->response->collection($article->comments, new CommentTransformer());
    }
}
