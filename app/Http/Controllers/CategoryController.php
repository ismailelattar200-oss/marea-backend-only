<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::active()->ordered()->get();
        $data = CategoryResource::collection($categories)->resolve();
        $json = json_encode(['data' => $data], JSON_INVALID_UTF8_SUBSTITUTE);
        return response($json, 200, ['Content-Type' => 'application/json']);
    }
}
