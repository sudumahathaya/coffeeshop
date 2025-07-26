<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url',
            'preparation_time' => 'nullable|string|max:255',
            'ingredients' => 'nullable|array',
            'allergens' => 'nullable|array',
            'calories' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu-items', 'public');
            $validatedData['image'] = Storage::url($imagePath);
        } elseif ($request->image_url) {
            $validatedData['image'] = $request->image_url;
        }

        // Convert arrays to JSON
        if (isset($validatedData['ingredients']) && is_array($validatedData['ingredients'])) {
            // Keep ingredients as array for JSON casting
        }
        if (isset($validatedData['allergens']) && is_array($validatedData['allergens'])) {
            // Keep allergens as array for JSON casting
        }

        $menuItem = MenuItem::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Menu item created successfully',
            'menu_item' => $menuItem
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url',
            'preparation_time' => 'nullable|string|max:255',
            'ingredients' => 'nullable|array',
            'allergens' => 'nullable|array',
            'calories' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($menuItem->image && str_contains($menuItem->image, 'storage/menu-items/')) {
                $oldImagePath = str_replace('/storage/', '', $menuItem->image);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            $imagePath = $request->file('image')->store('menu-items', 'public');
            $validatedData['image'] = Storage::url($imagePath);
        } elseif ($request->image_url) {
            $validatedData['image'] = $request->image_url;
        }

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
        
        // Delete image if exists
        if ($menuItem->image && str_contains($menuItem->image, 'storage/menu-items/')) {
            $oldImagePath = str_replace('/storage/', '', $menuItem->image);
            Storage::disk('public')->delete($oldImagePath);
        }
        
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