<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Http\Resources\MenuItemResource;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::available()->with('category');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('is_featured')) {
            $query->featured();
        }

        $items = $query->get();
        return MenuItemResource::collection($items);
    }
}
