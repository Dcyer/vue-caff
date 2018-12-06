<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Requests\Api\ArticleRequest;
use App\Transformers\ArticleTransformer;
use App\User;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index(Request $request, Article $article)
    {
        $query = $article->query();

        if ($categoryId = $request->category_id) {
            $query->where('category_id', $categoryId);
        }

        $articles = $query->withOrder($request->order)->paginate(2);

        return $this->response->paginator($articles, new ArticleTransformer());
    }

    public function store(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all());
        $article->user_id = $this->user()->id;
        $article->save();

        return $this->response->array(['article_id' => $article->id])->setStatusCode(201);
    }

    public function show(Request $request, Article $article)
    {
        $article->visits()->increment();
        return $this->response->item($article, new ArticleTransformer());
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);
        $article->update($request->all());

        return $this->response->item($article, new ArticleTransformer());
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();

        return $this->response->noContent();
    }

    public function userIndex(User $user)
    {
        $articles = $user->articles()->orderBy('id', 'desc')->paginate(20);

        return $this->response->paginator($articles, new ArticleTransformer());
    }
}
