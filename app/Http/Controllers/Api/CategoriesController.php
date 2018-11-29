<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return $this->response->array($categories);
    }
}
