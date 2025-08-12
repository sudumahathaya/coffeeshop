<?php

namespace App\Services;

use App\Models\MenuItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class MenuService
{
    private array $allowedImageTypes = ['jpeg', 'png', 'jpg', 'gif'];
    private int $maxImageSize = 2048; // KB

    /**
     * Create a new menu item
     */
    public function createMenuItem(array $data): array
    {
        try {
            // Validate data
            $this->validateMenuItemData($data);

            // Handle image upload
            $imageUrl = $this->handleImageUpload($data);
            if ($imageUrl) {
                $data['image'] = $imageUrl;
            }

            // Process ingredients and allergens
            $data = $this->processArrayFields($data);

            $menuItem = MenuItem::create($data);

            Log::info('Menu item created successfully', [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'category' => $menuItem->category
            ]);

            return [
                'success' => true,
                'message' => 'Menu item created successfully',
                'menu_item' => $menuItem->fresh(),
                'data' => $menuItem->fresh()
            ];

        } catch (\Exception $e) {
            Log::error('Menu item creation failed', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            
            return [
                'success' => false,
                'message' => 'Failed to create menu item: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update an existing menu item
     */
    public function updateMenuItem(int $id, array $data): array
    {
        try {
            $menuItem = MenuItem::findOrFail($id);

            // Validate data
            $this->validateMenuItemData($data, $id);

            // Handle image upload
            $imageUrl = $this->handleImageUpload($data, $menuItem);
            if ($imageUrl) {
                $data['image'] = $imageUrl;
            }

            // Process ingredients and allergens
            $data = $this->processArrayFields($data);

            $menuItem->update($data);

            Log::info('Menu item updated successfully', [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'changes' => $menuItem->getChanges()
            ]);

            return [
                'success' => true,
                'message' => 'Menu item updated successfully',
                'menu_item' => $menuItem->fresh(),
                'data' => $menuItem->fresh()
            ];

        } catch (\Exception $e) {
            Log::error('Menu item update failed', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Failed to update menu item: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete a menu item
     */
    public function deleteMenuItem(int $id): array
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
            $this->deleteImage($menuItem->image);
            
            $menuItem->delete();

            Log::info('Menu item deleted successfully', $itemInfo);

            return [
                'success' => true,
                'message' => 'Menu item deleted successfully'
            ];

        } catch (\Exception $e) {
            Log::error('Failed to delete menu item', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Failed to delete menu item: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Toggle menu item status
     */
    public function toggleStatus(int $id): array
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

            return [
                'success' => true,
                'message' => $newStatus === 'active' ? 'Menu item activated successfully' : 'Menu item deactivated successfully',
                'menu_item' => $menuItem->fresh()
            ];

        } catch (\Exception $e) {
            Log::error('Failed to toggle menu item status', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Failed to update menu item status: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get menu statistics
     */
    public function getMenuStatistics(): array
    {
        try {
            $categories = MenuItem::select('category')->distinct()->pluck('category');
            
            return [
                'success' => true,
                'stats' => [
                    'total_items' => MenuItem::count(),
                    'active_items' => MenuItem::where('status', 'active')->count(),
                    'inactive_items' => MenuItem::where('status', 'inactive')->count(),
                    'total_categories' => $categories->count(),
                    'average_price' => MenuItem::avg('price') ?? 0,
                    'highest_price' => MenuItem::max('price') ?? 0,
                    'lowest_price' => MenuItem::min('price') ?? 0,
                    'recent_items' => MenuItem::latest()->take(5)->get(['id', 'name', 'created_at']),
                    'last_updated' => now()->toISOString()
                ]
            ];

        } catch (\Exception $e) {
            Log::error('Failed to get menu statistics', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to retrieve menu statistics'
            ];
        }
    }

    /**
     * Validate menu item data
     */
    private function validateMenuItemData(array $data, ?int $excludeId = null): void
    {
        if (empty($data['name'])) {
            throw new \InvalidArgumentException('Menu item name is required');
        }

        if (empty($data['description'])) {
            throw new \InvalidArgumentException('Menu item description is required');
        }

        if (empty($data['category'])) {
            throw new \InvalidArgumentException('Menu item category is required');
        }

        if (!isset($data['price']) || $data['price'] <= 0) {
            throw new \InvalidArgumentException('Valid price is required');
        }

        // Check for duplicate names
        $query = MenuItem::where('name', $data['name']);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        if ($query->exists()) {
            throw new \InvalidArgumentException('Menu item with this name already exists');
        }
    }

    /**
     * Handle image upload
     */
    private function handleImageUpload(array $data, ?MenuItem $existingItem = null): ?string
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Validate image
            $this->validateImage($data['image']);

            // Delete old image if updating
            if ($existingItem && $existingItem->image) {
                $this->deleteImage($existingItem->image);
            }

            // Store new image
            $imagePath = $data['image']->store('menu-items', 'public');
            return Storage::url($imagePath);
        }

        if (isset($data['image_url']) && filter_var($data['image_url'], FILTER_VALIDATE_URL)) {
            return $data['image_url'];
        }

        return null;
    }

    /**
     * Validate uploaded image
     */
    private function validateImage(UploadedFile $image): void
    {
        if (!in_array($image->getClientOriginalExtension(), $this->allowedImageTypes)) {
            throw new \InvalidArgumentException('Invalid image type. Allowed types: ' . implode(', ', $this->allowedImageTypes));
        }

        if ($image->getSize() > $this->maxImageSize * 1024) {
            throw new \InvalidArgumentException("Image size must be less than {$this->maxImageSize}KB");
        }
    }

    /**
     * Delete image from storage
     */
    private function deleteImage(?string $imageUrl): void
    {
        if ($imageUrl && str_contains($imageUrl, 'storage/menu-items/')) {
            $imagePath = str_replace('/storage/', '', $imageUrl);
            Storage::disk('public')->delete($imagePath);
        }
    }

    /**
     * Process array fields (ingredients, allergens)
     */
    private function processArrayFields(array $data): array
    {
        if (isset($data['ingredients']) && is_string($data['ingredients'])) {
            $data['ingredients'] = array_filter(array_map('trim', explode(',', $data['ingredients'])));
        }
        
        if (isset($data['allergens']) && is_string($data['allergens'])) {
            $data['allergens'] = array_filter(array_map('trim', explode(',', $data['allergens'])));
        }

        return $data;
    }
}