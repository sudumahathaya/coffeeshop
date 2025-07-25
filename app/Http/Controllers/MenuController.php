<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::active()->get();
        $categories = MenuItem::select('category')->distinct()->pluck('category');
        
        return response()->json([
            'success' => true,
            'menu_items' => $menuItems,
            'categories' => $categories
        ]);
    }

    public function show($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'menu_item' => $menuItem
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|url',
            'preparation_time' => 'nullable|string|max:255',
            'ingredients' => 'nullable|array',
            'allergens' => 'nullable|array',
            'calories' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $menuItem = MenuItem::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Menu item created successfully',
            'menu_item' => $menuItem
        ]);
    }

    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|url',
            'preparation_time' => 'nullable|string|max:255',
            'ingredients' => 'nullable|array',
            'allergens' => 'nullable|array',
            'calories' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $menuItem->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Menu item updated successfully',
            'menu_item' => $menuItem
        ]);
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu item deleted successfully'
        ]);
    }

    public function toggleStatus($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update([
            'status' => $menuItem->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Menu item status updated successfully',
            'menu_item' => $menuItem
        ]);
    }
}