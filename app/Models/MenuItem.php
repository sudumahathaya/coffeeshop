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
    ];

    protected $attributes = [
        'status' => 'active',
        'ingredients' => '[]',
        'allergens' => '[]',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
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
}