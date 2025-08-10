<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index()
    {
        try {
            $menuItems = MenuItem::active()->get();
            $categories = MenuItem::select('category')->distinct()->pluck('category');
            
            return response()->json([
                'success' => true,
                'menu_items' => $menuItems,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch menu items: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch menu items: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $menuItem = MenuItem::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'menu_item' => $menuItem,
                'data' => $menuItem
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Menu item not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to fetch menu item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch menu item: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'category' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'image_url' => 'nullable|url',
                'preparation_time' => 'nullable|string|max:255',
                'ingredients' => 'nullable|string',
                'allergens' => 'nullable|string',
                'calories' => 'nullable|integer|min:0',
                'status' => 'required|in:active,inactive',
            ]);

            Log::info('Creating new menu item', [
                'name' => $validatedData['name'],
                'category' => $validatedData['category'],
                'price' => $validatedData['price'],
                'user_id' => auth()->id()
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('menu-items', 'public');
                $validatedData['image'] = Storage::url($imagePath);
            } elseif ($request->image_url) {
                $validatedData['image'] = $request->image_url;
            } else {
                // Set default image if none provided
                $validatedData['image'] = 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&h=300&fit=crop';
            }

            // Handle ingredients and allergens
            if (isset($validatedData['ingredients'])) {
                if (is_string($validatedData['ingredients'])) {
                    $validatedData['ingredients'] = array_filter(array_map('trim', explode(',', $validatedData['ingredients'])));
                }
            }
            
            if (isset($validatedData['allergens'])) {
                if (is_string($validatedData['allergens'])) {
                    $validatedData['allergens'] = array_filter(array_map('trim', explode(',', $validatedData['allergens'])));
                }
            }

            $menuItem = MenuItem::create($validatedData);

            Log::info('Menu item created successfully', [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'category' => $menuItem->category
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Menu item created successfully',
                'menu_item' => $menuItem->fresh(),
                'data' => $menuItem->fresh()
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Menu item validation failed', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Menu item creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create menu item: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $menuItem = MenuItem::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'category' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'image_url' => 'nullable|url',
                'preparation_time' => 'nullable|string|max:255',
                'ingredients' => 'nullable|string',
                'allergens' => 'nullable|string',
                'calories' => 'nullable|integer|min:0',
                'status' => 'nullable|in:active,inactive',
            ]);

            // Set default status if not provided
            if (!isset($validatedData['status'])) {
                $validatedData['status'] = 'active';
            }

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

            // Handle ingredients and allergens
            if (isset($validatedData['ingredients'])) {
                if (is_string($validatedData['ingredients'])) {
                    $validatedData['ingredients'] = array_filter(array_map('trim', explode(',', $validatedData['ingredients'])));
                }
            }
            
            if (isset($validatedData['allergens'])) {
                if (is_string($validatedData['allergens'])) {
                    $validatedData['allergens'] = array_filter(array_map('trim', explode(',', $validatedData['allergens'])));
                }
            }

            $menuItem->update($validatedData);

            Log::info('Menu item updated successfully', [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'changes' => $menuItem->getChanges()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Menu item updated successfully',
                'menu_item' => $menuItem->fresh(),
                'data' => $menuItem->fresh()
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Menu item not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Menu item update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update menu item: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $menuItem = MenuItem::findOrFail($id);
            $oldStatus = $menuItem->status;
            $newStatus = $menuItem->status === 'active' ? 'inactive' : 'active';
            
            $menuItem->update(['status' => $newStatus]);

            Log::info('Menu item status toggled', [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]);

            return response()->json([
                'success' => true,
                'message' => $newStatus === 'active' ? 'Menu item activated successfully' : 'Menu item deactivated successfully',
                'menu_item' => $menuItem->fresh()
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Menu item not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to toggle menu item status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update menu item status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $menuItem = MenuItem::findOrFail($id);
            
            // Store item info for logging
            $itemInfo = [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'category' => $menuItem->category
            ];
            
            // Delete image if exists
            if ($menuItem->image && str_contains($menuItem->image, 'storage/menu-items/')) {
                $oldImagePath = str_replace('/storage/', '', $menuItem->image);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            $menuItem->delete();

            Log::info('Menu item deleted successfully', $itemInfo);

            return response()->json([
                'success' => true,
                'message' => 'Menu item deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Menu item not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to delete menu item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete menu item: ' . $e->getMessage()
            ], 500);
        }
    }
}