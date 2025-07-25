<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Get all active menu items
     */
    public function index(Request $request)
    {
        $query = MenuItem::active();

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $menuItems = $query->get();
        $categories = MenuItem::select('category')->distinct()->pluck('category');

        return response()->json([
            'success' => true,
            'data' => [
                'menu_items' => $menuItems,
                'categories' => $categories
            ]
        ]);
    }

    /**
     * Get a specific menu item
     */
    public function show($id)
    {
        $menuItem = MenuItem::find($id);

        if (!$menuItem) {
            return response()->json([
                'success' => false,
                'message' => 'Menu item not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $menuItem
        ]);
    }

    /**
     * Get menu items by category
     */
    public function byCategory($category)
    {
        $menuItems = MenuItem::active()->where('category', $category)->get();

        return response()->json([
            'success' => true,
            'data' => $menuItems
        ]);
    }

    /**
     * Get featured menu items
     */
    public function featured()
    {
        $featuredItems = MenuItem::active()
            ->whereIn('category', ['Hot Coffee', 'Specialty', 'Tea & Others'])
            ->inRandomOrder()
            ->take(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $featuredItems
        ]);
    }
}