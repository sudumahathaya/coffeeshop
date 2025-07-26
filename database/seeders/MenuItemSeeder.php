<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $menuItems = [
            [
                'name' => 'Classic Espresso',
                'description' => 'Rich, bold espresso shot with perfect crema. The foundation of all great coffee drinks.',
                'category' => 'Hot Coffee',
                'price' => 320.00,
                'image' => 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=400&h=300&fit=crop',
                'preparation_time' => '2-3 min',
                'ingredients' => ['Espresso beans', 'Water'],
                'allergens' => [],
                'calories' => 5,
                'status' => 'active',
            ],
            [
                'name' => 'Cappuccino',
                'description' => 'Perfect balance of espresso, steamed milk, and foam. Traditional Italian favorite.',
                'category' => 'Hot Coffee',
                'price' => 480.00,
                'image' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&h=300&fit=crop',
                'preparation_time' => '3-4 min',
                'ingredients' => ['Espresso', 'Steamed milk', 'Milk foam'],
                'allergens' => ['Dairy'],
                'calories' => 120,
                'status' => 'active',
            ],
            [
                'name' => 'Café Latte',
                'description' => 'Smooth espresso with steamed milk and delicate foam art. Creamy and comforting.',
                'category' => 'Hot Coffee',
                'price' => 520.00,
                'image' => 'https://images.unsplash.com/photo-1561882468-9110e03e0f78?w=400&h=300&fit=crop',
                'preparation_time' => '4-5 min',
                'ingredients' => ['Espresso', 'Steamed milk', 'Milk foam'],
                'allergens' => ['Dairy'],
                'calories' => 150,
                'status' => 'active',
            ],
            [
                'name' => 'Caramel Macchiato',
                'description' => 'Rich espresso with vanilla syrup, steamed milk, and caramel drizzle. Sweet perfection.',
                'category' => 'Specialty',
                'price' => 650.00,
                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop',
                'preparation_time' => '5-6 min',
                'ingredients' => ['Espresso', 'Vanilla syrup', 'Steamed milk', 'Caramel sauce'],
                'allergens' => ['Dairy'],
                'calories' => 250,
                'status' => 'active',
            ],
            [
                'name' => 'Iced Coffee',
                'description' => 'Cold brew coffee served over ice with your choice of milk. Perfect for hot days.',
                'category' => 'Cold Coffee',
                'price' => 580.00,
                'image' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&h=300&fit=crop',
                'preparation_time' => '3-4 min',
                'ingredients' => ['Cold brew coffee', 'Ice', 'Milk'],
                'allergens' => ['Dairy'],
                'calories' => 80,
                'status' => 'active',
            ],
            [
                'name' => 'Vanilla Frappuccino',
                'description' => 'Blended ice coffee with vanilla flavor and whipped cream. A delightful treat.',
                'category' => 'Cold Coffee',
                'price' => 720.00,
                'image' => 'https://images.unsplash.com/photo-1506976785307-8732e854ad03?w=400&h=300&fit=crop',
                'preparation_time' => '4-5 min',
                'ingredients' => ['Coffee', 'Ice', 'Vanilla syrup', 'Whipped cream'],
                'allergens' => ['Dairy'],
                'calories' => 300,
                'status' => 'active',
            ],
            [
                'name' => 'Ceylon Tea',
                'description' => 'Authentic Sri Lankan black tea with rich flavor and golden color. A local favorite.',
                'category' => 'Tea & Others',
                'price' => 380.00,
                'image' => 'https://images.unsplash.com/photo-1597318374671-96ee162414ca?w=400&h=300&fit=crop',
                'preparation_time' => '3-4 min',
                'ingredients' => ['Ceylon tea leaves', 'Hot water'],
                'allergens' => [],
                'calories' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Premium Hot Chocolate',
                'description' => 'Rich, creamy hot chocolate made with premium cocoa and topped with marshmallows.',
                'category' => 'Tea & Others',
                'price' => 550.00,
                'image' => 'https://images.unsplash.com/photo-1542990253-a781e04c0082?w=400&h=300&fit=crop',
                'preparation_time' => '4-5 min',
                'ingredients' => ['Premium cocoa', 'Steamed milk', 'Marshmallows'],
                'allergens' => ['Dairy'],
                'calories' => 280,
                'status' => 'active',
            ],
            [
                'name' => 'Butter Croissant',
                'description' => 'Flaky, buttery croissant baked fresh daily. Perfect with your morning coffee.',
                'category' => 'Food & Snacks',
                'price' => 280.00,
                'image' => 'https://images.unsplash.com/photo-1555507036-ab794f4afe5b?w=400&h=300&fit=crop',
                'preparation_time' => 'Ready now',
                'ingredients' => ['Flour', 'Butter', 'Yeast', 'Salt'],
                'allergens' => ['Gluten', 'Dairy'],
                'calories' => 220,
                'status' => 'active',
            ],
            [
                'name' => 'Club Sandwich',
                'description' => 'Triple-layer sandwich with chicken, bacon, and fresh vegetables. A hearty meal option.',
                'category' => 'Food & Snacks',
                'price' => 850.00,
                'image' => 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=400&h=300&fit=crop',
                'preparation_time' => '8-10 min',
                'ingredients' => ['Bread', 'Chicken', 'Bacon', 'Lettuce', 'Tomato', 'Mayo'],
                'allergens' => ['Gluten', 'Dairy'],
                'calories' => 650,
                'status' => 'active',
            ],
        ];

        foreach ($menuItems as $item) {
            MenuItem::create($item);
        }
    }
}