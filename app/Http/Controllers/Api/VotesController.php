<?php

namespace App\Http\Controllers\Api;

use App\Article;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $this->user()->upVote($article);
        $voters = $article->voters;
        return $this->response->array($voters);
    }

    public function destroy(Article $article)
    {
        $this->user()->cancelVote($article);
        $voters = $article->voters;
        return $this->response->array(count($voters) > 0 ? $voters : ['users' => []]);
    }
}
