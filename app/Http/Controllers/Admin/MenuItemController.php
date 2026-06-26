<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Http\Resources\MenuItemResource;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::with('category');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->orderBy('category_id')->orderBy('display_number')->get();
        return MenuItemResource::collection($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|string',
            'display_number' => 'required|integer',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Handled file upload manually, but API expects image_url (can be string or file)
        if ($request->hasFile('image')) {
             $path = $request->file('image')->store('menu_items', 'public');
             $validated['image_url'] = url('storage/' . $path);
        }

        $menuItem = MenuItem::create($validated);
        return new MenuItemResource($menuItem->load('category'));
    }

    public function show(MenuItem $menuItem)
    {
        return new MenuItemResource($menuItem->load('category'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'category_id' => 'exists:categories,id',
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'price' => 'numeric|min:0',
            'image_url' => 'nullable|string',
            'display_number' => 'integer',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
             $path = $request->file('image')->store('menu_items', 'public');
             $validated['image_url'] = url('storage/' . $path);
        }

        $menuItem->update($validated);
        return new MenuItemResource($menuItem->load('category'));
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return response()->json(['message' => 'Menu item deleted']);
    }
}
