<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'image',
        'preparation_time',
        'ingredients',
        'allergens',
        'calories',
        'status',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'allergens' => 'array',
        'price' => 'decimal:2',
        'calories' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'active',
        'ingredients' => '[]',
        'allergens' => '[]',
    ];

    /**
     * Boot method to add model events
     */
    protected static function boot()
    {
        parent::boot();
        
        // Log when a new menu item is created
        static::created(function ($menuItem) {
            \Log::info('New menu item added to database', [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'category' => $menuItem->category,
                'price' => $menuItem->price,
                'status' => $menuItem->status
            ]);
        });
        
        // Log when a menu item is updated
        static::updated(function ($menuItem) {
            \Log::info('Menu item updated in database', [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'changes' => $menuItem->getChanges()
            ]);
        });
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->where('status', 'active')->orderBy('created_at', 'desc');
    }
    public function getFormattedPriceAttribute()
    {
        return 'Rs. ' . number_format((float) $this->price, 2);
    }

    public function getIngredientsListAttribute()
    {
        return is_array($this->ingredients) ? implode(', ', $this->ingredients) : '';
    }

    public function getAllergensListAttribute()
    {
        return is_array($this->allergens) ? implode(', ', $this->allergens) : '';
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Check if the menu item is available
     */
    public function isAvailable()
    {
        return $this->status === 'active';
    }

    /**
     * Get formatted creation date
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M d, Y g:i A');
    }
}