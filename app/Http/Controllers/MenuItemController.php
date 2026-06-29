<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Http\Resources\MenuItemResource;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = MenuItem::available()->with('category');

            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->has('is_featured')) {
                $query->featured();
            }

            $items = $query->get();
            $data = MenuItemResource::collection($items)->resolve();
            $json = json_encode(['data' => $data], JSON_INVALID_UTF8_SUBSTITUTE);
            return response($json, 200, ['Content-Type' => 'application/json']);
        } catch (\Throwable $e) {
            $msg = mb_convert_encoding($e->getMessage(), 'UTF-8', 'UTF-8');
            $json = json_encode(['error' => $msg, 'class' => get_class($e)], JSON_INVALID_UTF8_SUBSTITUTE);
            return response($json, 200, ['Content-Type' => 'application/json']);
        }
    }
}
