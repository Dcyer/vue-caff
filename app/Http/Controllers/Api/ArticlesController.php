<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Requests\Api\ArticleRequest;
use App\Transformers\ArticleTransformer;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function store(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all());
        $article->user_id = $this->user()->id;
        $article->save();

        return $this->response->item($article, new ArticleTransformer());
    }
}
