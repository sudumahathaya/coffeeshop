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
        $menuItems = MenuItem::all();
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
            'menu_item' => $menuItem,
            'data' => $menuItem
        ]);
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
                    $validatedData['ingredients'] = array_map('trim', explode(',', $validatedData['ingredients']));
                }
            }
            
            if (isset($validatedData['allergens'])) {
                if (is_string($validatedData['allergens'])) {
                    $validatedData['allergens'] = array_map('trim', explode(',', $validatedData['allergens']));
                }
            }

            $menuItem = MenuItem::create($validatedData);

            // Broadcast real-time stats update
            $this->broadcastStatsUpdate();

            return response()->json([
                'success' => true,
                'message' => 'Menu item created successfully',
                'menu_item' => $menuItem
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
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
                    $validatedData['ingredients'] = array_map('trim', explode(',', $validatedData['ingredients']));
                }
            }
            
            if (isset($validatedData['allergens'])) {
                if (is_string($validatedData['allergens'])) {
                    $validatedData['allergens'] = array_map('trim', explode(',', $validatedData['allergens']));
                }
            }

            $menuItem->update($validatedData);

            // Broadcast real-time stats update
            $this->broadcastStatsUpdate();

            return response()->json([
                'success' => true,
                'message' => 'Menu item updated successfully',
                'menu_item' => $menuItem,
                'data' => $menuItem
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
            $menuItem->update([
                'status' => $menuItem->status === 'active' ? 'inactive' : 'active'
            ]);

            // Broadcast real-time stats update
            $this->broadcastStatsUpdate();

            return response()->json([
                'success' => true,
                'message' => 'Menu item status updated successfully',
                'menu_item' => $menuItem
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Menu item not found'
            ], 404);
        } catch (\Exception $e) {
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
            
            // Delete image if exists
            if ($menuItem->image && str_contains($menuItem->image, 'storage/menu-items/')) {
                $oldImagePath = str_replace('/storage/', '', $menuItem->image);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            $menuItem->delete();

            // Broadcast real-time stats update
            $this->broadcastStatsUpdate();

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
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete menu item: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Broadcast real-time statistics update
     */
    private function broadcastStatsUpdate()
    {
        $categories = MenuItem::select('category')->distinct()->pluck('category');
        
        $stats = [
            'total_items' => MenuItem::count(),
            'active_items' => MenuItem::where('status', 'active')->count(),
            'inactive_items' => MenuItem::where('status', 'inactive')->count(),
            'total_categories' => $categories->count(),
            'average_price' => MenuItem::avg('price') ?? 0,
            'highest_price' => MenuItem::max('price') ?? 0,
            'lowest_price' => MenuItem::min('price') ?? 0,
        ];

        // In a real application, you would broadcast this via WebSockets
        // For now, we'll store it in session for the next request
        session(['menu_stats_updated' => $stats]);
    }
}