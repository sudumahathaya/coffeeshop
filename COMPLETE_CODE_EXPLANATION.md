# Café Elixir Project - Complete Code Explanation (Singlish)

## 1. Project Root Files

### 1.1 composer.json - PHP Dependencies Manager
```json
{
    "$schema": "https://getcomposer.org/schema.json",
    "name": "laravel/laravel",              // Project name
    "type": "project",                      // Project type
    "description": "The skeleton application for the Laravel framework.",
    "require": {
        "php": "^8.2",                      // PHP version 8.2 or higher ona
        "laravel/framework": "^12.0",       // Laravel framework version 12
        "laravel/tinker": "^2.10.1"         // Laravel REPL tool (command line testing)
    },
    "require-dev": {                        // Development-only dependencies
        "laravel/breeze": "^2.3",           // Authentication scaffolding
        "laravel/pint": "^1.13",            // Code formatting tool
        "phpunit/phpunit": "^11.5.3"        // Testing framework
    },
    "autoload": {                           // Class auto-loading configuration
        "psr-4": {
            "App\\": "app/",                // App namespace points to app/ folder
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    }
}
```
**Mokadda wenne:** Meken kiyanne project eke dependencies mokakda, PHP version eka mokakda, autoloading kohomaida kiyala.

### 1.2 package.json - Frontend Dependencies
```json
{
    "private": true,                        // NPM package private (publish wenne na)
    "type": "module",                       // ES6 modules use karanawa
    "scripts": {
        "build": "vite build",              // Production build command
        "dev": "vite"                       // Development server command
    },
    "devDependencies": {
        "@tailwindcss/forms": "^0.5.2",     // Form styling library
        "alpinejs": "^3.4.2",               // Lightweight JS framework
        "axios": "^1.8.2",                  // HTTP requests walata
        "laravel-vite-plugin": "^1.2.0",    // Laravel-Vite integration
        "vite": "^6.2.4"                    // Build tool (Webpack alternative)
    }
}
```
**Mokadda wenne:** Frontend assets (CSS, JS) compile karanna, development server run karanna commands.

### 1.3 .env.example - Environment Configuration Template
```env
# Application Basic Settings
APP_NAME=Laravel                           # Application name
APP_ENV=local                             # Environment (local/staging/production)
APP_KEY=                                  # Encryption key (auto-generated)
APP_DEBUG=true                            # Debug mode (production walata false)
APP_URL=http://localhost                  # Base URL

# Database Configuration
DB_CONNECTION=sqlite                      # Database type (sqlite/mysql/pgsql)
DB_DATABASE=database/database.sqlite     # SQLite file path

# Session Configuration
SESSION_DRIVER=database                   # Session storage method
SESSION_LIFETIME=120                      # Session timeout (minutes)

# Mail Configuration
MAIL_MAILER=log                          # Mail driver (log/smtp/mailgun)
MAIL_FROM_ADDRESS="hello@example.com"    # Default sender email

# Café Elixir Specific Settings
CAFE_NAME="Café Elixir"                  # Business name
CAFE_EMAIL="info@cafeelixir.lk"          # Contact email
CAFE_PHONE="+94 77 186 9132"             # Contact phone
LOYALTY_POINTS_PER_RUPEE=0.1             # Points earning rate (1 point per Rs.10)
ORDER_TAX_RATE=0.1                       # Tax percentage (10%)
```
**Mokadda wenne:** Application eke configuration values store karanne meken. Production walata deploy karaddi me values change karanawa.

## 2. Bootstrap & Configuration

### 2.1 bootstrap/app.php - Application Bootstrap
```php
<?php
use Illuminate\Foundation\Application;

// Create Laravel application instance
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',      // Web routes file
        commands: __DIR__.'/../routes/console.php',
        health: '/up',                          // Health check endpoint
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,  // Admin middleware alias
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Exception handling configuration
    })->create();
```
**Mokadda wenne:** Laravel application eka configure karanne meken. Routes, middleware, exception handling setup karanawa.

### 2.2 config/app.php - Main Application Configuration
```php
<?php
return [
    'name' => env('APP_NAME', 'Laravel'),           // App name (.env file eken gannawa)
    'env' => env('APP_ENV', 'production'),          // Environment
    'debug' => (bool) env('APP_DEBUG', false),      // Debug mode
    'url' => env('APP_URL', 'http://localhost'),    // Base URL
    'timezone' => 'UTC',                            // Default timezone
    'locale' => env('APP_LOCALE', 'en'),            // Default language
    'cipher' => 'AES-256-CBC',                      // Encryption algorithm
    'key' => env('APP_KEY'),                        // Encryption key
];
```
**Mokadda wenne:** Application eke basic settings define karanne meken.

### 2.3 config/database.php - Database Configuration
```php
<?php
return [
    'default' => env('DB_CONNECTION', 'sqlite'),    // Default database connection
    
    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],
        
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
        ],
    ],
];
```
**Mokadda wenne:** Database connections configure karanne meken. SQLite (development) saha MySQL (production) support karanne.

## 3. Database Layer - Models

### 3.1 User Model (app/Models/User.php)
```php
<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;                    // Traits include karanne

    // Mass assignment allowed fields
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    // Hidden fields (JSON response walata include wenne na)
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Attribute casting (data types convert karanne)
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',      // String to Carbon date
            'password' => 'hashed',                 // Auto-hash passwords
        ];
    }

    // Relationship: User has many orders (One-to-Many)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relationship: User has many reservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Relationship: User has many loyalty points
    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }

    // Relationship: User has many profile change requests
    public function profileChangeRequests()
    {
        return $this->hasMany(ProfileChangeRequest::class);
    }

    // Accessor: Calculate total loyalty points (Virtual attribute)
    public function getTotalLoyaltyPointsAttribute()
    {
        $earned = $this->loyaltyPoints()->where('type', 'earned')->sum('points');
        $redeemed = $this->loyaltyPoints()->where('type', 'redeemed')->sum('points');
        return $earned - $redeemed;
    }

    // Accessor: Determine loyalty tier based on points
    public function getLoyaltyTierAttribute()
    {
        $points = $this->total_loyalty_points;
        
        if ($points >= 1500) return 'Platinum';    // 25% discount
        if ($points >= 500) return 'Gold';         // 15% discount
        return 'Bronze';                           // 5% discount
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }
}
```
**Mokadda wenne:** User model eken database eke users table eka represent karanne. Relationships, accessors, helper methods define karala tiyenawa.

### 3.2 MenuItem Model (app/Models/MenuItem.php)
```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'name', 'description', 'category', 'price', 'image',
        'preparation_time', 'ingredients', 'allergens', 'calories', 'status',
    ];

    // Attribute casting
    protected $casts = [
        'ingredients' => 'array',               // JSON string to PHP array
        'allergens' => 'array',                 // JSON string to PHP array
        'price' => 'decimal:2',                 // Decimal with 2 decimal places
        'calories' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Default attribute values
    protected $attributes = [
        'status' => 'active',
        'ingredients' => '[]',
        'allergens' => '[]',
    ];

    // Model events (lifecycle hooks)
    protected static function boot()
    {
        parent::boot();
        
        // Event: When new menu item is created
        static::created(function ($menuItem) {
            \Log::info('New menu item added to database', [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'category' => $menuItem->category,
                'price' => $menuItem->price,
            ]);
        });
        
        // Event: When menu item is updated
        static::updated(function ($menuItem) {
            \Log::info('Menu item updated in database', [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'changes' => $menuItem->getChanges(),   // What fields changed
            ]);
        });
    }

    // Query scopes (reusable query conditions)
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

    // Accessor: Format price with currency
    public function getFormattedPriceAttribute()
    {
        return 'Rs. ' . number_format((float) $this->price, 2);
    }

    // Accessor: Convert ingredients array to comma-separated string
    public function getIngredientsListAttribute()
    {
        return is_array($this->ingredients) ? implode(', ', $this->ingredients) : '';
    }

    // Accessor: Convert allergens array to comma-separated string
    public function getAllergensListAttribute()
    {
        return is_array($this->allergens) ? implode(', ', $this->allergens) : '';
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->status === 'active';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M d, Y g:i A');
    }
}
```
**Mokadda wenne:** MenuItem model eken menu_items table eka represent karanne. JSON fields (ingredients, allergens) handle karanne, query scopes, accessors define karala tiyenawa.

### 3.3 Order Model (app/Models/Order.php)
```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'user_id', 'customer_name', 'customer_email', 'customer_phone',
        'items', 'subtotal', 'tax', 'discount', 'total', 'status', 'order_type',
        'special_instructions', 'completed_at',
    ];

    protected $casts = [
        'items' => 'array',                     // Order items as JSON array
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    // Relationship: Order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Order has many loyalty points
    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }

    // Query scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Accessors
    public function getFormattedTotalAttribute()
    {
        return 'Rs. ' . number_format($this->total, 2);
    }

    public function getTotalItemsAttribute()
    {
        return collect($this->items)->sum('quantity');  // Calculate total item count
    }
}
```
**Mokadda wenne:** Order model eken orders table eka represent karanne. Order items JSON format eke store karanne, relationships define karala tiyenawa.

### 3.4 Reservation Model (app/Models/Reservation.php)
```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id', 'first_name', 'last_name', 'email', 'phone',
        'reservation_date', 'reservation_time', 'guests', 'table_type',
        'occasion', 'special_requests', 'email_updates', 'status', 'user_id',
    ];

    protected $casts = [
        'reservation_date' => 'date',          // String to Carbon date
        'email_updates' => 'boolean',          // 0/1 to true/false
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Accessor: Combine first and last name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Query scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('reservation_date', '>=', now()->toDateString())
                    ->where('status', '!=', 'cancelled');
    }
}
```
**Mokadda wenne:** Reservation model eken reservations table eka represent karanne. Date casting, relationships, query scopes define karala tiyenawa.

## 4. Database Migrations

### 4.1 Users Table Migration
```php
// database/migrations/0001_01_01_000000_create_users_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();                               // Auto-increment primary key
            $table->string('name');                     // VARCHAR(255)
            $table->string('email')->unique();         // VARCHAR(255) with unique constraint
            $table->timestamp('email_verified_at')->nullable();  // Email verification timestamp
            $table->string('password');                 // Hashed password
            $table->rememberToken();                   // "Remember me" token
            $table->timestamps();                      // created_at, updated_at
        });

        // Create password reset tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();        // Email as primary key
            $table->string('token');                   // Reset token
            $table->timestamp('created_at')->nullable();
        });

        // Create sessions table (for database session driver)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
```
**Mokadda wenne:** Database eke users table eka create karanne meken. Migration eka run karaddi `up()` method eka execute wenawa, rollback karaddi `down()` method eka execute wenawa.

### 4.2 Menu Items Table Migration
```php
// database/migrations/2024_12_20_000002_create_menu_items_table.php
public function up(): void
{
    Schema::create('menu_items', function (Blueprint $table) {
        $table->id();
        $table->string('name');                     // Item name
        $table->text('description')->nullable();   // Item description (can be null)
        $table->string('category');                // Category (Hot Coffee, Cold Coffee, etc.)
        $table->decimal('price', 8, 2);            // Price (8 digits total, 2 decimal places)
        $table->string('image')->nullable();       // Image URL/path
        $table->string('preparation_time')->nullable();  // e.g., "3-4 min"
        $table->json('ingredients')->nullable()->default('[]');  // JSON array of ingredients
        $table->json('allergens')->nullable()->default('[]');    // JSON array of allergens
        $table->integer('calories')->nullable();   // Calorie count
        $table->enum('status', ['active', 'inactive'])->default('active');
        $table->timestamps();
        
        // Database indexes for better query performance
        $table->index(['category', 'status']);     // Composite index
        $table->index(['status', 'created_at']);   // For recent active items
        $table->index('price');                    // For price-based queries
    });
}
```
**Mokadda wenne:** Menu items table eka create karanne. JSON columns (ingredients, allergens), indexes performance walata add karala tiyenawa.

### 4.3 Orders Table Migration
```php
// database/migrations/2024_12_20_000004_create_orders_table.php
public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('order_id')->unique();      // Custom order ID (ORD000001)
        $table->foreignId('user_id')->nullable()   // Foreign key to users table
              ->constrained()                      // Creates foreign key constraint
              ->onDelete('set null');              // If user deleted, set to null
        $table->string('customer_name');
        $table->string('customer_email')->nullable();
        $table->string('customer_phone')->nullable();
        $table->json('items');                     // Order items as JSON
        $table->decimal('subtotal', 10, 2);        // 10 digits total, 2 decimal
        $table->decimal('tax', 10, 2)->default(0);
        $table->decimal('discount', 10, 2)->default(0);
        $table->decimal('total', 10, 2);
        $table->enum('status', [                   // Order status enum
            'pending', 'confirmed', 'preparing', 'ready', 'completed', 'cancelled'
        ])->default('pending');
        $table->enum('order_type', ['dine_in', 'takeaway', 'delivery'])->default('dine_in');
        $table->text('special_instructions')->nullable();
        $table->timestamp('completed_at')->nullable();
        $table->timestamps();
    });
}
```
**Mokadda wenne:** Orders table eka create karanne. Foreign key constraints, enum fields, JSON column define karala tiyenawa.

## 5. Controllers - Request Handling

### 5.1 HomeController (app/Http/Controllers/HomeController.php)
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\ContactMessage;

class HomeController extends Controller
{
    // Display home page
    public function index()
    {
        // Get 3 random featured products for homepage display
        $featuredProducts = MenuItem::active()      // Only active items
                                  ->inRandomOrder() // Random order
                                  ->take(3)         // Limit to 3 items
                                  ->get();          // Execute query

        // Pass data to view
        return view('home', compact('featuredProducts'));
    }

    // Display menu page with all items and categories
    public function menu()
    {
        $menuItems = MenuItem::active()->get();     // Get all active menu items
        $categories = MenuItem::select('category')  // Get unique categories
                             ->distinct()
                             ->pluck('category');   // Return as array

        return view('menu', compact('menuItems', 'categories'));
    }

    // Handle contact form submission (AJAX)
    public function storeContact(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|in:general,reservation,catering,feedback,complaint',
            'message' => 'required|string|max:2000',
            'contactMethod' => 'required|string|in:email,phone,whatsapp',
            'bestTime' => 'nullable|string|in:morning,afternoon,evening',
            'urgency' => 'required|string|in:normal,urgent,immediate',
            'newsletter' => 'nullable|boolean'
        ]);

        // Generate unique message ID
        $messageId = 'CM' . str_pad(ContactMessage::count() + 1, 6, '0', STR_PAD_LEFT);

        // Create contact message record in database
        $contactMessage = ContactMessage::create([
            'message_id' => $messageId,
            'first_name' => $validatedData['firstName'],
            'last_name' => $validatedData['lastName'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'subject' => $validatedData['subject'],
            'message' => $validatedData['message'],
            'contact_method' => $validatedData['contactMethod'],
            'best_time' => $validatedData['bestTime'],
            'urgency' => $validatedData['urgency'],
            'newsletter' => $validatedData['newsletter'] ?? false,
        ]);

        // Return JSON response for AJAX request
        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!',
            'message_id' => $messageId,
            'data' => $contactMessage
        ]);
    }

    // Handle reservation form submission
    public function storeReservation(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'reservationDate' => 'required|date|after:today',  // Must be future date
            'reservationTime' => 'required|string',
            'guests' => 'required|integer|min:1|max:20',       // 1-20 guests allowed
            'tableType' => 'nullable|string',
            'occasion' => 'nullable|string',
            'specialRequests' => 'nullable|string|max:1000',
            'emailUpdates' => 'nullable|boolean'
        ]);

        // Generate unique reservation ID
        $reservationId = 'CE' . str_pad(Reservation::count() + 1, 6, '0', STR_PAD_LEFT);

        // Create reservation record
        $reservation = Reservation::create([
            'reservation_id' => $reservationId,
            'first_name' => $validatedData['firstName'],
            'last_name' => $validatedData['lastName'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'reservation_date' => $validatedData['reservationDate'],
            'reservation_time' => $validatedData['reservationTime'],
            'guests' => $validatedData['guests'],
            'table_type' => $validatedData['tableType'],
            'occasion' => $validatedData['occasion'],
            'special_requests' => $validatedData['specialRequests'],
            'email_updates' => $validatedData['emailUpdates'] ?? false,
            'user_id' => auth()->id(),              // Current logged-in user ID
            'status' => 'pending'                   // Requires admin approval
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reservation submitted successfully!',
            'reservation_id' => $reservationId,
            'data' => $reservation
        ]);
    }

    // Get business status (open/closed) - API endpoint
    public function getBusinessStatus()
    {
        $now = now();
        $currentDay = $now->dayOfWeek;              // 0=Sunday, 1=Monday, etc.
        $currentTime = $now->format('H:i');

        $isOpen = false;
        $message = 'Closed';

        // Check business hours
        if ($currentDay == 0) {                     // Sunday
            $isOpen = $currentTime >= '07:00' && $currentTime < '22:00';
        } elseif ($currentDay == 6) {               // Saturday
            $isOpen = $currentTime >= '06:00' && $currentTime < '23:00';
        } else {                                    // Monday to Friday
            $isOpen = $currentTime >= '06:00' && $currentTime < '22:00';
        }

        if ($isOpen) {
            $closingTime = ($currentDay == 6) ? '23:00' : '22:00';
            $closingSoon = $currentTime >= date('H:i', strtotime($closingTime . ' -1 hour'));
            $message = $closingSoon ? 'Closing Soon' : 'Open Now';
        }

        return response()->json([
            'is_open' => $isOpen,
            'message' => $message,
            'current_time' => $currentTime,
            'day' => $now->format('l')
        ]);
    }
}
```
**Mokadda wenne:** HomeController eken public pages (home, menu, contact, reservation) handle karanne. Form submissions validate karala database eke save karanne.

### 5.2 MenuController (app/Http/Controllers/MenuController.php)
```php
<?php
namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    // Get all menu items (API endpoint)
    public function index()
    {
        try {
            $menuItems = MenuItem::all();
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

    // Get single menu item
    public function show($id)
    {
        try {
            $menuItem = MenuItem::findOrFail($id);      // Find or throw 404
            
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
        }
    }

    // Create new menu item (Admin only)
    public function store(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'category' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // 2MB max
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
                'user_id' => auth()->id()
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Store uploaded file in public/storage/menu-items/
                $imagePath = $request->file('image')->store('menu-items', 'public');
                $validatedData['image'] = Storage::url($imagePath);
            } elseif ($request->image_url) {
                $validatedData['image'] = $request->image_url;
            } else {
                // Default image if none provided
                $validatedData['image'] = 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&h=300&fit=crop';
            }

            // Convert comma-separated strings to arrays
            if (isset($validatedData['ingredients'])) {
                if (is_string($validatedData['ingredients'])) {
                    $validatedData['ingredients'] = array_filter(
                        array_map('trim', explode(',', $validatedData['ingredients']))
                    );
                }
            }
            
            if (isset($validatedData['allergens'])) {
                if (is_string($validatedData['allergens'])) {
                    $validatedData['allergens'] = array_filter(
                        array_map('trim', explode(',', $validatedData['allergens']))
                    );
                }
            }

            // Create menu item in database
            $menuItem = MenuItem::create($validatedData);

            Log::info('Menu item created successfully', [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Menu item created successfully',
                'menu_item' => $menuItem->fresh(),      // Get updated model
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

    // Update existing menu item
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
                    $validatedData['ingredients'] = array_filter(
                        array_map('trim', explode(',', $validatedData['ingredients']))
                    );
                }
            }

            // Update menu item
            $menuItem->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Menu item updated successfully',
                'menu_item' => $menuItem->fresh(),
            ]);

        } catch (\Exception $e) {
            Log::error('Menu item update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update menu item: ' . $e->getMessage()
            ], 500);
        }
    }

    // Toggle menu item status (active/inactive)
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
                'message' => $newStatus === 'active' ? 
                    'Menu item activated successfully' : 
                    'Menu item deactivated successfully',
                'menu_item' => $menuItem->fresh()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to toggle menu item status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update menu item status'
            ], 500);
        }
    }

    // Delete menu item
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
            
            // Delete image file if exists
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
        } catch (\Exception $e) {
            Log::error('Failed to delete menu item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete menu item'
            ], 500);
        }
    }
}
```
**Mokadda wenne:** MenuController eken menu items CRUD operations (Create, Read, Update, Delete) handle karanne. Image upload, validation, error handling, logging implement karala tiyenawa.

### 5.3 OrderController (app/Http/Controllers/OrderController.php)
```php
<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Create new order
    public function store(Request $request)
    {
        // Validate order data
        $validatedData = $request->validate([
            'items' => 'required|array|min:1',                    // At least 1 item
            'items.*.id' => 'required|exists:menu_items,id',      // Valid menu item IDs
            'items.*.quantity' => 'required|integer|min:1',       // Positive quantities
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:20',
            'order_type' => 'required|in:dine_in,takeaway,delivery',
            'special_instructions' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cash,card,online,mobile',
            'payment_token' => 'nullable|string',                 // For online payments
        ]);

        // Use database transaction for data consistency
        DB::beginTransaction();
        
        try {
            // Calculate order totals
            $subtotal = 0;
            $orderItems = [];

            foreach ($validatedData['items'] as $item) {
                $menuItem = MenuItem::find($item['id']);
                $itemTotal = $menuItem->price * $item['quantity'];
                $subtotal += $itemTotal;

                $orderItems[] = [
                    'id' => $menuItem->id,
                    'name' => $menuItem->name,
                    'price' => $menuItem->price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal
                ];
            }

            $tax = $subtotal * 0.1;                    // 10% tax
            $total = $subtotal + $tax;

            // Generate unique order ID
            $orderId = 'ORD' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT);

            // Process payment (simplified for demo)
            $paymentStatus = 'pending';
            $transactionId = null;
            
            if ($validatedData['payment_method'] === 'cash') {
                $paymentStatus = 'pending';             // Pay at café
            } elseif ($validatedData['payment_method'] === 'mobile') {
                $paymentStatus = 'completed';           // Simulate mobile payment
                $transactionId = 'MOB' . time() . rand(1000, 9999);
            }

            // Create order record
            $order = Order::create([
                'order_id' => $orderId,
                'user_id' => Auth::id(),
                'customer_name' => $validatedData['customer_name'],
                'customer_email' => $validatedData['customer_email'],
                'customer_phone' => $validatedData['customer_phone'],
                'items' => $orderItems,                 // Store as JSON
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'order_type' => $validatedData['order_type'],
                'special_instructions' => $validatedData['special_instructions'],
                'payment_method' => $validatedData['payment_method'],
                'payment_status' => $paymentStatus,
                'transaction_id' => $transactionId,
                'status' => 'confirmed'
            ]);

            // Award loyalty points (1 point per Rs. 10 spent)
            if (Auth::check()) {
                $pointsEarned = floor($total / 10);
                
                LoyaltyPoint::create([
                    'user_id' => Auth::id(),
                    'points' => $pointsEarned,
                    'type' => 'earned',
                    'description' => "Points earned from order #{$orderId}",
                    'order_id' => $order->id
                ]);
            }

            DB::commit();                               // Commit transaction

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $orderId,
                'order' => $order,
                'payment_status' => $paymentStatus
            ]);

        } catch (\Exception $e) {
            DB::rollback();                             // Rollback on error
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get order details
    public function show($orderId)
    {
        $order = Order::where('order_id', $orderId)->firstOrFail();
        
        // Check if user owns this order or is admin
        if (Auth::check() && (Auth::id() === $order->user_id || Auth::user()->isAdmin())) {
            return response()->json([
                'success' => true,
                'order' => $order
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Order not found or access denied'
        ], 404);
    }

    // Update order status (Admin only)
    public function updateStatus(Request $request, $orderId)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,completed,cancelled'
        ]);

        $order = Order::where('order_id', $orderId)->firstOrFail();
        $oldStatus = $order->status;
        $order->update(['status' => $validatedData['status']]);

        // Set completion timestamp
        if ($validatedData['status'] === 'completed') {
            $order->update(['completed_at' => now()]);
        }

        // Broadcast real-time update (if WebSocket configured)
        // broadcast(new \App\Events\OrderUpdated($order))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'order' => $order,
            'old_status' => $oldStatus,
            'new_status' => $validatedData['status']
        ]);
    }

    // Get all orders (Admin only)
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }

    // Delete order (Admin only)
    public function destroy($orderId)
    {
        try {
            $order = Order::where('order_id', $orderId)->firstOrFail();
            
            // Only allow deletion of cancelled or pending orders
            if (!in_array($order->status, ['cancelled', 'pending'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only cancelled or pending orders can be deleted'
                ], 400);
            }
            
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete order: ' . $e->getMessage()
            ], 500);
        }
    }
}
```
**Mokadda wenne:** OrderController eken order placement, status updates, order management handle karanne. Database transactions, loyalty points calculation, payment processing simulate karala tiyenawa.

### 5.4 AdminController (app/Http/Controllers/AdminController.php)
```php
<?php
namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Admin dashboard with statistics
    public function dashboard()
    {
        // Calculate dashboard statistics
        $stats = [
            'total_users' => User::count('id'),
            'new_users_today' => User::whereDate('created_at', '=', today())->count('id'),
            'total_reservations' => Reservation::count('id'),
            'pending_reservations' => Reservation::where('status', '=', 'pending')->count('id'),
            'revenue_today' => Order::whereDate('created_at', '=', today())->sum('total'),
            'revenue_month' => Order::whereMonth('created_at', '=', now()->month)->sum('total'),
            'popular_items' => [
                ['name' => 'Cappuccino', 'orders' => 45],
                ['name' => 'Latte', 'orders' => 38],
                ['name' => 'Espresso', 'orders' => 32],
                ['name' => 'Americano', 'orders' => 28]
            ],
            'recent_users' => User::latest('created_at')->take(5)->get()
        ];

        // Chart data for dashboard
        $chartData = [
            'daily_sales' => [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'data' => [12000, 15000, 18000, 14000, 22000, 25000, 20000]
            ]
        ];

        return view('admin.dashboard', compact('stats', 'chartData'));
    }

    // Reservations management page
    public function reservations()
    {
        // Get today's reservations and statistics
        $todayReservations = Reservation::whereDate('reservation_date', '=', today())->get();
        $pendingReservations = Reservation::where('status', '=', 'pending')->get();
        $confirmedReservations = Reservation::where('status', '=', 'confirmed')->get();
        $totalGuests = Reservation::whereDate('reservation_date', '=', today())->sum('guests');
        
        // All reservations for the table (paginated)
        $reservations = Reservation::with('user')           // Eager load user relationship
            ->orderBy('reservation_date', 'desc')
            ->latest('reservation_time')
            ->paginate(20);                                 // 20 items per page

        $stats = [
            'today_count' => $todayReservations->count(),
            'pending_count' => $pendingReservations->count(),
            'confirmed_count' => $confirmedReservations->count(),
            'total_guests' => $totalGuests
        ];

        return view('admin.reservations.index', compact('reservations', 'stats'));
    }

    // Approve reservation
    public function approveReservation(Request $request, $id)
    {
        $validatedData = $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $reservation = Reservation::findOrFail($id);
        
        if ($reservation->status === 'confirmed') {
            return response()->json([
                'success' => false,
                'message' => 'This reservation is already confirmed.'
            ], 400);
        }
        
        // Update reservation status
        $reservation->update([
            'status' => 'confirmed',
            'admin_notes' => $validatedData['admin_notes'] ?? null,
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);
        
        // Award loyalty points to user (if registered user)
        if ($reservation->user_id) {
            \App\Models\LoyaltyPoint::create([
                'user_id' => $reservation->user_id,
                'points' => 50,                             // Bonus points for reservation
                'type' => 'earned',
                'description' => "Bonus points for confirmed reservation #{$reservation->reservation_id}"
            ]);
        }
        
        // Broadcast real-time update (if WebSocket configured)
        // broadcast(new \App\Events\ReservationUpdated($reservation))->toOthers();
        
        return response()->json([
            'success' => true,
            'message' => 'Reservation approved successfully! Customer earned 50 loyalty points.',
            'reservation' => $reservation
        ]);
    }

    // Reject reservation
    public function rejectReservation(Request $request, $id)
    {
        $validatedData = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $reservation = Reservation::findOrFail($id);
        
        $reservation->update([
            'status' => 'rejected',
            'rejection_reason' => $validatedData['rejection_reason'],
            'admin_notes' => $validatedData['admin_notes'] ?? null,
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Reservation rejected successfully.',
            'reservation' => $reservation
        ]);
    }

    // Get real-time dashboard data (API endpoint)
    public function getDashboardData()
    {
        $stats = [
            'total_users' => User::count('id'),
            'new_users_today' => User::whereDate('created_at', '=', today())->count('id'),
            'total_reservations' => Reservation::count('id'),
            'pending_reservations' => Reservation::where('status', '=', 'pending')->count('id'),
            'revenue_today' => Order::whereDate('created_at', '=', today())->sum('total'),
            'revenue_month' => Order::whereMonth('created_at', '=', now()->month)->sum('total'),
            'active_orders' => Order::whereIn('status', ['pending', 'confirmed', 'preparing'])->count('id'),
            'completed_orders_today' => Order::where('status', '=', 'completed')
                                             ->whereDate('created_at', '=', today())->count('id'),
        ];

        $recentActivity = [
            'recent_orders' => Order::with('user')->latest('created_at')->take(5)->get(),
            'recent_reservations' => Reservation::with('user')->latest('created_at')->take(5)->get(),
            'recent_users' => User::latest('created_at')->take(5)->get(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats,
            'activity' => $recentActivity,
            'timestamp' => now()->toISOString()
        ]);
    }
}
```
**Mokadda wenne:** AdminController eken admin dashboard, reservations management, statistics calculation handle karanne. Real-time data updates walata API endpoints provide karanne.

## 6. Middleware - Request Filtering

### 6.1 AdminMiddleware (app/Http/Middleware/AdminMiddleware.php)
```php
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    // Handle incoming request
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')
                           ->with('error', 'Please login to access this area.');
        }

        // Check if user has admin role
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin privileges required.');
        }

        // Allow request to continue
        return $next($request);
    }
}
```
**Mokadda wenne:** AdminMiddleware eken admin routes walata access control karanne. Admin role nathi users lata 403 error ekak return karanne.

## 7. Routes - URL Mapping

### 7.1 Web Routes (routes/web.php)
```php
<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes (authentication nathi users lata access karanna puluwan)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/reservation', [HomeController::class, 'reservation'])->name('reservation');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Contact form submission
Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');

// Newsletter subscription
Route::post('/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter'])
     ->name('newsletter.subscribe');

// Reservation submission
Route::post('/reservation', [HomeController::class, 'storeReservation'])
     ->name('reservation.store');

// Authentication routes (login, register, password reset)
require __DIR__.'/auth.php';

// Authenticated user routes (login wela inna users lata)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.view');
    
    // Profile management
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User orders
    Route::get('/user/orders', [UserController::class, 'orders'])->name('user.orders');
    Route::post('/user/reorder-last', [UserController::class, 'reorderLast'])
         ->name('user.reorder-last');
});

// Admin routes (admin role eka thiyena users lata)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/menu', [AdminController::class, 'menuManagement'])->name('menu');
    
    // Reservation management
    Route::post('/reservations/{id}/approve', [AdminController::class, 'approveReservation'])
         ->name('reservations.approve');
    Route::post('/reservations/{id}/reject', [AdminController::class, 'rejectReservation'])
         ->name('reservations.reject');
    
    // API endpoints for real-time data
    Route::get('/api/dashboard-data', [AdminController::class, 'getDashboardData'])
         ->name('api.dashboard-data');
});

// Public API routes
Route::get('/api/menu', [MenuController::class, 'index'])->name('api.menu.index');
Route::post('/api/orders', [OrderController::class, 'store'])->name('api.orders.store');
```
**Mokadda wenne:** Routes file eken URL patterns define karanne. Middleware groups walata different access levels set karanne.

### 7.2 API Routes (routes/api.php)
```php
<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\OrderController;

// Get authenticated user info
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API routes (authentication nathi)
Route::prefix('v1')->group(function () {
    // Menu routes
    Route::get('/menu', [MenuController::class, 'index']);
    Route::get('/menu/{id}', [MenuController::class, 'show']);
    Route::get('/menu/category/{category}', [MenuController::class, 'byCategory']);
    Route::get('/menu/featured', [MenuController::class, 'featured']);
    
    // Order routes (guest orders walata)
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{orderId}', [OrderController::class, 'show']);
});

// Protected API routes (authentication ona)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // User-specific routes
    Route::get('/user/orders', function (Request $request) {
        return $request->user()->orders()->latest()->get();
    });
    
    Route::get('/user/reservations', function (Request $request) {
        return $request->user()->reservations()->latest()->get();
    });
    
    Route::get('/user/loyalty', function (Request $request) {
        $user = $request->user();
        return [
            'points' => $user->total_loyalty_points,
            'tier' => $user->loyalty_tier
        ];
    });
});
```
**Mokadda wenne:** API routes file eken RESTful API endpoints define karanne. Mobile apps, external integrations walata use karanna puluwan.

## 8. Frontend Layer

### 8.1 Master Layout (resources/views/layouts/master.blade.php)
```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- User data for JavaScript -->
    @auth
        <meta name="user-name" content="{{ Auth::user()->name }}">
        <meta name="user-email" content="{{ Auth::user()->email }}">
    @endauth

    <title>@yield('title', 'Coffee Paradise - Premium Coffee Experience')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS Variables -->
    <style>
        :root {
            --coffee-primary: #8B4513;      /* Brown color */
            --coffee-secondary: #D2691E;    /* Orange-brown color */
            --coffee-accent: #CD853F;       /* Light brown */
            --coffee-dark: #2F1B14;         /* Dark brown */
            --coffee-light: #F5F5DC;        /* Beige */
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        /* Navbar Styles */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);               /* Glass effect */
            border-bottom: 2px solid var(--coffee-primary);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--coffee-primary) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--coffee-dark) !important;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: white !important;
            background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
            transform: translateY(-2px);
        }

        /* Button Styles */
        .btn-coffee {
            background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-coffee:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(139, 69, 19, 0.4);
            color: white;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" id="mainNavbar">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-cup-hot-fill me-2"></i>Café Elixir
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                           href="{{ route('home') }}">
                            <i class="bi bi-house me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('menu') ? 'active' : '' }}" 
                           href="{{ route('menu') }}">
                            <i class="bi bi-journal-text me-1"></i>Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reservation') ? 'active' : '' }}"
                           href="{{ route('reservation') }}">
                            <i class="bi bi-calendar-check me-1"></i>Reservation
                        </a>
                    </li>
                    <!-- More navigation items... -->
                </ul>

                <!-- User Authentication Section -->
                <div class="d-flex gap-2">
                    @guest
                        <!-- Not logged in users -->
                        <a href="{{ route('login') }}" class="btn btn-outline-coffee">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-coffee">
                            <i class="bi bi-person-plus me-1"></i>Register
                        </a>
                    @else
                        <!-- Logged in users -->
                        <!-- Cart Button -->
                        <div class="position-relative me-2">
                            <button class="btn btn-outline-coffee" data-bs-toggle="modal" data-bs-target="#cartModal">
                                <i class="bi bi-cart me-1"></i>Cart
                                <span class="cart-counter" style="display: none;">0</span>
                            </button>
                        </div>
                        
                        <!-- User Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-coffee dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('user.orders') }}">
                                    <i class="bi bi-receipt me-2"></i>My Orders
                                </a></li>
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-gear me-2"></i>Admin Panel
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5><i class="bi bi-cup-hot-fill me-2"></i>Café Elixir</h5>
                    <p class="mb-3">Experience the perfect blend of premium coffee, exceptional service, and cozy atmosphere.</p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('menu') }}">Menu</a></li>
                        <li><a href="{{ route('reservation') }}">Reservation</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <!-- More footer content... -->
            </div>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Global notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} position-fixed notification-toast`;
            notification.style.cssText = `
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 350px;
                border-radius: 15px;
                animation: slideInRight 0.5s ease;
            `;
            
            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <span class="flex-grow-1">${message}</span>
                    <button type="button" class="btn-close ms-2" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // Form submission handlers (prevent page refresh)
        document.addEventListener('DOMContentLoaded', function() {
            // Handle contact form submissions
            document.addEventListener('submit', function(e) {
                const form = e.target;
                
                if (form.classList.contains('contact-form')) {
                    e.preventDefault();
                    handleContactSubmission(form);
                }
                
                if (form.classList.contains('reservation-form')) {
                    e.preventDefault();
                    handleReservationSubmission(form);
                }
            });
        });

        // Contact form submission handler
        function handleContactSubmission(form) {
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
            submitBtn.disabled = true;

            // Send AJAX request
            fetch('/contact', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Your message has been sent successfully!', 'success');
                    form.reset();
                } else {
                    showNotification('Failed to send message. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Message sent successfully!', 'success');
                form.reset();
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

        // Reservation form submission handler
        function handleReservationSubmission(form) {
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');

            fetch('/reservation', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Reservation submitted successfully!', 'success');
                    form.reset();
                }
            })
            .catch(error => {
                showNotification('Reservation submitted successfully!', 'success');
                form.reset();
            });
        }
    </script>

    <!-- Include additional JavaScript files -->
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/payment.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
```
**Mokadda wenne:** Master layout eken common HTML structure define karanne. Navigation, footer, CSS/JS includes, authentication checks, form handling JavaScript implement karala tiyenawa.

### 8.2 Cart Management JavaScript (public/js/cart.js)
```javascript
// Cart Management System
class CafeElixirCart {
    constructor() {
        this.cart = this.loadCart();        // Load cart from localStorage
        this.init();                        // Initialize cart functionality
    }

    init() {
        this.updateCartDisplay();           // Update cart counter and modal
        this.bindEvents();                  // Bind event listeners
        this.createCartModal();             // Create cart modal HTML
    }

    // Load cart data from localStorage
    loadCart() {
        try {
            return JSON.parse(localStorage.getItem('cafeElixirCart')) || [];
        } catch (error) {
            console.error('Error loading cart:', error);
            return [];
        }
    }

    // Save cart data to localStorage
    saveCart() {
        try {
            localStorage.setItem('cafeElixirCart', JSON.stringify(this.cart));
        } catch (error) {
            console.error('Error saving cart:', error);
        }
    }

    // Add item to cart
    addItem(item) {
        const existingItem = this.cart.find(cartItem => cartItem.id === item.id);
        
        if (existingItem) {
            existingItem.quantity += 1;     // Increase quantity if item exists
        } else {
            this.cart.push({                // Add new item
                id: item.id || Date.now(),
                name: item.name,
                price: parseFloat(item.price),
                quantity: 1,
                image: item.image || 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=80&h=80&fit=crop'
            });
        }

        this.saveCart();
        this.updateCartDisplay();
        this.showNotification(`${item.name} added to cart!`, 'success');
    }

    // Remove item from cart
    removeItem(itemId) {
        const itemIndex = this.cart.findIndex(item => item.id === itemId);
        if (itemIndex !== -1) {
            const itemName = this.cart[itemIndex].name;
            this.cart.splice(itemIndex, 1);        // Remove item from array
            this.saveCart();
            this.updateCartDisplay();
            this.showNotification(`${itemName} removed from cart`, 'warning');
        }
    }

    // Update item quantity
    updateQuantity(itemId, change) {
        const item = this.cart.find(cartItem => cartItem.id === itemId);
        if (item) {
            item.quantity += change;
            if (item.quantity <= 0) {
                this.removeItem(itemId);           // Remove if quantity becomes 0
            } else {
                this.saveCart();
                this.updateCartDisplay();
            }
        }
    }

    // Clear entire cart
    clearCart() {
        this.cart = [];
        this.saveCart();
        this.updateCartDisplay();
        this.showNotification('Cart cleared successfully', 'info');
    }

    // Calculate total price
    getTotal() {
        return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    // Calculate total items count
    getTotalItems() {
        return this.cart.reduce((total, item) => total + item.quantity, 0);
    }

    // Update cart display (counter and modal)
    updateCartDisplay() {
        this.updateCartCounter();
        this.updateCartModal();
    }

    // Update cart counter badge
    updateCartCounter() {
        const cartCounters = document.querySelectorAll('.cart-counter');
        const totalItems = this.getTotalItems();

        cartCounters.forEach(counter => {
            if (totalItems > 0) {
                counter.textContent = totalItems;
                counter.style.display = 'inline-block';
                counter.classList.add('animate-bounce');    // Add animation
                setTimeout(() => counter.classList.remove('animate-bounce'), 500);
            } else {
                counter.style.display = 'none';
            }
        });
    }

    // Update cart modal content
    updateCartModal() {
        const cartItemsContainer = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');
        const emptyCartMessage = document.getElementById('emptyCartMessage');
        const cartFooter = document.getElementById('cartFooter');

        if (!cartItemsContainer) return;

        if (this.cart.length === 0) {
            // Show empty cart message
            cartItemsContainer.innerHTML = '';
            if (emptyCartMessage) emptyCartMessage.style.display = 'block';
            if (cartFooter) cartFooter.style.display = 'none';
        } else {
            // Show cart items
            if (emptyCartMessage) emptyCartMessage.style.display = 'none';
            if (cartFooter) cartFooter.style.display = 'block';

            // Generate cart items HTML
            cartItemsContainer.innerHTML = this.cart.map(item => `
                <div class="cart-item d-flex align-items-center py-3 border-bottom">
                    <img src="${item.image}" class="cart-item-image me-3" alt="${item.name}">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">${item.name}</h6>
                        <small class="text-muted">Rs. ${item.price.toFixed(2)} each</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary" onclick="cart.updateQuantity('${item.id}', -1)">
                            <i class="bi bi-dash"></i>
                        </button>
                        <span class="mx-2 fw-bold">${item.quantity}</span>
                        <button class="btn btn-sm btn-outline-secondary" onclick="cart.updateQuantity('${item.id}', 1)">
                            <i class="bi bi-plus"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger ms-2" onclick="cart.removeItem('${item.id}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="text-end ms-3">
                        <strong>Rs. ${(item.price * item.quantity).toFixed(2)}</strong>
                    </div>
                </div>
            `).join('');

            // Update total
            if (cartTotal) {
                cartTotal.textContent = `Rs. ${this.getTotal().toFixed(2)}`;
            }
        }
    }

    // Create cart modal HTML
    createCartModal() {
        if (document.getElementById('cartModal')) return;

        const modalHTML = `
            <div class="modal fade" id="cartModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-coffee text-white">
                            <h5 class="modal-title">
                                <i class="bi bi-cart me-2"></i>Your Cart
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div id="emptyCartMessage" class="text-center py-5" style="display: none;">
                                <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                                <h5 class="mt-3 text-muted">Your cart is empty</h5>
                                <p class="text-muted">Add some delicious items from our menu!</p>
                                <a href="/menu" class="btn btn-coffee" data-bs-dismiss="modal">
                                    <i class="bi bi-cup-hot me-2"></i>Browse Menu
                                </a>
                            </div>
                            <div id="cartItems"></div>
                        </div>
                        <div class="modal-footer" id="cartFooter" style="display: none;">
                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Total: <span id="cartTotal">Rs. 0.00</span></h5>
                                    <button class="btn btn-outline-danger" onclick="cart.clearCart()">
                                        <i class="bi bi-trash me-2"></i>Clear Cart
                                    </button>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-coffee btn-lg" onclick="cart.proceedToCheckout()">
                                        <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    // Bind event listeners
    bindEvents() {
        // Add to cart buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.add-to-cart')) {
                e.preventDefault();
                const button = e.target.closest('.add-to-cart');
                this.handleAddToCart(button);
            }
        });

        // Cart modal trigger
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-bs-target="#cartModal"]')) {
                this.updateCartDisplay();
            }
        });
    }

    // Handle add to cart button click
    handleAddToCart(button) {
        const item = {
            id: button.getAttribute('data-id') || Date.now(),
            name: button.getAttribute('data-name'),
            price: button.getAttribute('data-price'),
            image: button.getAttribute('data-image')
        };

        if (!item.name || !item.price) {
            this.showNotification('Invalid item data', 'error');
            return;
        }

        // Show loading state
        const originalHTML = button.innerHTML;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Adding...';
        button.disabled = true;

        setTimeout(() => {
            this.addItem(item);

            // Success state
            button.innerHTML = '<i class="bi bi-check-lg me-1"></i>Added!';
            button.classList.add('btn-success');
            button.classList.remove('btn-coffee');

            // Reset button after 2 seconds
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.disabled = false;
                button.classList.remove('btn-success');
                button.classList.add('btn-coffee');
            }, 2000);
        }, 500);
    }

    // Proceed to checkout
    proceedToCheckout() {
        if (this.cart.length === 0) {
            this.showNotification('Your cart is empty!', 'warning');
            return;
        }

        // For demo purposes, show coming soon message
        this.showNotification('Checkout functionality coming soon!', 'info');
    }

    // Show notification
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} position-fixed notification-toast`;
        notification.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 350px;
            border-radius: 15px;
            animation: slideInRight 0.5s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        `;

        const iconMap = {
            'success': 'check-circle-fill',
            'error': 'exclamation-triangle-fill',
            'warning': 'exclamation-triangle-fill',
            'info': 'info-circle-fill'
        };

        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-${iconMap[type]} me-2"></i>
                <span class="flex-grow-1">${message}</span>
                <button type="button" class="btn-close ms-2" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.animation = 'slideOutRight 0.5s ease';
                setTimeout(() => notification.remove(), 500);
            }
        }, 4000);
    }
}

// Initialize cart when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.cart = new CafeElixirCart();
});
```
**Mokadda wenne:** Cart management system eka JavaScript class ekak widihata implement karala tiyenawa. localStorage eke cart data store karanne, add/remove/update operations handle karanne.

## 9. Database Seeders - Sample Data

### 9.1 MenuItemSeeder (database/seeders/MenuItemSeeder.php)
```php
<?php
namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
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
            // More menu items...
        ];

        // Create each menu item in database
        foreach ($menuItems as $item) {
            MenuItem::create($item);
        }
    }
}
```
**Mokadda wenne:** MenuItemSeeder eken sample menu items database eke create karanne. Development/testing walata sample data provide karanne.

### 9.2 AdminUserSeeder (database/seeders/AdminUserSeeder.php)
```php
<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@cafeelixir.lk',
            'password' => Hash::make('admin123'),       // Hash password
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create test customer
        User::create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }
}
```
**Mokadda wenne:** AdminUserSeeder eken default admin user saha test customer create karanne. Development walata login credentials provide karanne.

## 10. Services - Business Logic

### 10.1 LoyaltyService (app/Services/LoyaltyService.php)
```php
<?php
namespace App\Services;

use App\Models\User;
use App\Models\LoyaltyPoint;
use App\Models\Order;

class LoyaltyService
{
    // Award points for an order
    public function awardPointsForOrder(Order $order): int
    {
        if (!$order->user_id) {
            return 0;                               // No points for guest orders
        }

        // Calculate points: 1 point per Rs. 10 spent
        $pointsEarned = floor($order->total / 10);

        // Create loyalty point record
        LoyaltyPoint::create([
            'user_id' => $order->user_id,
            'points' => $pointsEarned,
            'type' => 'earned',
            'description' => "Points earned from order #{$order->order_id}",
            'order_id' => $order->id
        ]);

        return $pointsEarned;
    }

    // Award bonus points for reservation
    public function awardReservationBonus(User $user): int
    {
        $bonusPoints = 50;

        LoyaltyPoint::create([
            'user_id' => $user->id,
            'points' => $bonusPoints,
            'type' => 'earned',
            'description' => 'Bonus points for making a reservation'
        ]);

        return $bonusPoints;
    }

    // Redeem points for reward
    public function redeemPoints(User $user, int $points, string $description): bool
    {
        if ($user->total_loyalty_points < $points) {
            return false;                           // Insufficient points
        }

        LoyaltyPoint::create([
            'user_id' => $user->id,
            'points' => $points,
            'type' => 'redeemed',
            'description' => $description
        ]);

        return true;
    }

    // Get user's loyalty tier
    public function getUserTier(User $user): string
    {
        $points = $user->total_loyalty_points;
        
        if ($points >= 1500) return 'Platinum';    // 25% discount
        if ($points >= 500) return 'Gold';         // 15% discount
        return 'Bronze';                           // 5% discount
    }

    // Get discount percentage for user's tier
    public function getTierDiscount(User $user): int
    {
        $tier = $this->getUserTier($user);
        
        return match($tier) {
            'Platinum' => 25,
            'Gold' => 15,
            'Bronze' => 5,
            default => 0
        };
    }

    // Get points needed for next tier
    public function getPointsToNextTier(User $user): int
    {
        $currentPoints = $user->total_loyalty_points;
        
        if ($currentPoints < 500) {
            return 500 - $currentPoints;           // To Gold
        } elseif ($currentPoints < 1500) {
            return 1500 - $currentPoints;          // To Platinum
        }
        
        return 0;                                  // Already at highest tier
    }
}
```
**Mokadda wenne:** LoyaltyService eken loyalty program eke business logic implement karanne. Points calculation, tier determination, redemption handle karanne.

## 11. Events - Real-time Updates

### 11.1 OrderUpdated Event (app/Events/OrderUpdated.php)
```php
<?php
namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // Define broadcast channel
    public function broadcastOn()
    {
        return new Channel('orders');               // Public channel
    }

    // Define broadcast data
    public function broadcastWith()
    {
        return [
            'id' => $this->order->id,
            'order_id' => $this->order->order_id,
            'status' => $this->order->status,
            'customer_name' => $this->order->customer_name,
            'total' => $this->order->total,
            'updated_at' => $this->order->updated_at->toISOString()
        ];
    }
}
```
**Mokadda wenne:** OrderUpdated event eken order status changes real-time broadcast karanne. WebSocket connections walata data send karanne.

## 12. Frontend Views - Blade Templates

### 12.1 Home Page (resources/views/home.blade.php)
```html
@extends('layouts.master')

@section('title', 'Cafe Elixir - Home')
@section('description', 'Welcome to Cafe Elixir. Experience premium coffee, cozy atmosphere, and exceptional service.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content" data-aos="fade-up">
                    <h1 class="hero-title">Welcome to Café Elixir</h1>
                    <p class="hero-subtitle">Where every cup tells a story of passion, quality, and exceptional taste.</p>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('menu') }}" class="btn btn-coffee btn-lg">
                            <i class="bi bi-journal-text me-2"></i>Explore Menu
                        </a>
                        <a href="{{ route('reservation') }}" class="btn btn-outline-coffee btn-lg">
                            <i class="bi bi-calendar-check me-2"></i>Make Reservation
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="text-center">
                    <img src="img/cup.png" alt="Coffee Cup" class="img-fluid rounded-circle floating">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-coffee mb-3">Why Choose Café Elixir?</h2>
                <p class="lead text-muted">We're passionate about delivering exceptional coffee experiences</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-cup-hot"></i>
                    </div>
                    <h4 class="mb-3">Premium Beans</h4>
                    <p class="text-muted">Sourced directly from the finest coffee farms around the world.</p>
                </div>
            </div>
            <!-- More feature items... -->
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-coffee mb-3">Featured Coffee Selection</h2>
            </div>
        </div>

        <div class="row g-4">
            @foreach($featuredProducts as $index => $product)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="card card-coffee">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-star-fill"></i> {{ number_format(4.5 + (rand(0, 50) / 100), 1) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-coffee">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ $product->description }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-coffee mb-0">Rs. {{ number_format($product->price, 2) }}</span>
                            @auth
                                <button class="btn btn-coffee btn-sm add-to-cart" 
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}" 
                                        data-price="{{ $product->price }}"
                                        data-image="{{ $product->image }}">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-coffee btn-sm">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Login to Order
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Add to cart functionality
    document.addEventListener('DOMContentLoaded', function() {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                const productPrice = parseFloat(this.getAttribute('data-price'));
                const productImage = this.getAttribute('data-image');

                // Get existing cart from localStorage
                let cart = JSON.parse(localStorage.getItem('cafeElixirCart')) || [];

                // Check if item already exists in cart
                const existingItemIndex = cart.findIndex(item => item.id === productId);

                if (existingItemIndex !== -1) {
                    // Item exists, increase quantity
                    cart[existingItemIndex].quantity += 1;
                    showNotification(`Increased ${productName} quantity in cart!`, 'info');
                } else {
                    // New item, add to cart
                    cart.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        image: productImage,
                        quantity: 1
                    });
                    showNotification(`${productName} added to cart!`, 'success');
                }

                // Save updated cart to localStorage
                localStorage.setItem('cafeElixirCart', JSON.stringify(cart));

                // Update cart display if function exists
                if (typeof updateCartDisplay === 'function') {
                    updateCartDisplay();
                }

                // Add visual feedback
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check me-1"></i>Added!';
                this.disabled = true;

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 1500);
            });
        });
    });
</script>
@endpush
```
**Mokadda wenne:** Home page eken hero section, features, featured products display karanne. Add to cart functionality JavaScript walata implement karala tiyenawa.

## 13. Admin Panel

### 13.1 Admin Dashboard (resources/views/admin/dashboard.blade.php)
```html
@extends('layouts.admin')

@section('title', 'Admin Dashboard - Café Elixir')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="mb-0 text-muted">Welcome back! Here's what's happening at Café Elixir today.</p>
        </div>
        <div>
            <span class="badge bg-success fs-6">
                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                System Online
            </span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Users</div>
                            <div class="h4 mb-0" data-stat="total_users">{{ number_format($stats['total_users']) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> +<span data-stat="new_users_today">{{ $stats['new_users_today'] }}</span> today
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Reservations</div>
                            <div class="h4 mb-0" data-stat="total_reservations">{{ number_format($stats['total_reservations']) }}</div>
                            <div class="text-warning small">
                                <i class="bi bi-clock"></i> <span data-stat="pending_reservations">{{ $stats['pending_reservations'] }}</span> pending
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Today's Revenue</div>
                            <div class="h4 mb-0" data-stat="revenue_today">Rs. {{ number_format($stats['revenue_today'], 2) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-trending-up"></i> +12.5%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Monthly Revenue</div>
                            <div class="h4 mb-0" data-stat="revenue_month">Rs. {{ number_format($stats['revenue_month'], 2) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> +8.2%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Daily Sales Overview</h5>
                    <p class="text-muted small mb-0">Revenue trends for the past week</p>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Popular Items</h5>
                    <p class="text-muted small mb-0">Most ordered items today</p>
                </div>
                <div class="card-body">
                    @foreach($stats['popular_items'] as $item)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">{{ $item['name'] }}</h6>
                            <small class="text-muted">{{ $item['orders'] }} orders</small>
                        </div>
                        <div class="progress" style="width: 100px; height: 8px;">
                            <div class="progress-bar bg-coffee" style="width: {{ ($item['orders'] / 100) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart using Chart.js
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['daily_sales']['labels']) !!},
            datasets: [{
                label: 'Daily Sales (Rs.)',
                data: {!! json_encode($chartData['daily_sales']['data']) !!},
                borderColor: '#8B4513',
                backgroundColor: 'rgba(139, 69, 19, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rs. ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
```
**Mokadda wenne:** Admin dashboard eken statistics cards, charts, popular items display karanne. Chart.js library eka use karala data visualization implement karala tiyenawa.

## 14. Key Features Summary

### 14.1 Authentication System
- Laravel Breeze package use karala login/register implement karala tiyenawa
- Role-based access control (admin/customer)
- Password hashing, remember me functionality
- Email verification support

### 14.2 Order Management
- Cart system localStorage eke implement karala tiyenawa
- Order placement with item validation
- Order status tracking (pending → confirmed → preparing → ready → completed)
- Payment method support (cash, card, mobile - card/mobile coming soon)

### 14.3 Reservation System
- Table booking with date/time validation
- Guest count limits (1-20 people)
- Admin approval workflow
- Special requests handling

### 14.4 Loyalty Program
- Points earning: 1 point per Rs. 10 spent
- Tier system: Bronze (5%), Gold (15%), Platinum (25%) discounts
- Bonus points for reservations (50 points)
- Points redemption system

### 14.5 Admin Panel
- Dashboard with real-time statistics
- Menu management (CRUD operations)
- Order status management
- Reservation approval/rejection
- User management
- Profile/reservation change request handling

### 14.6 Real-time Features
- Cart updates without page refresh
- Notification system
- AJAX form submissions
- Real-time stats updates (API polling)
- WebSocket support ready (commented out)

### 14.7 Security Features
- CSRF protection
- Input validation
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade templating)
- Role-based access control
- Password hashing

Meka thamai oyage complete Café Elixir project eke code explanation eka. Viva exam ekakata yanakota me details walata refer karanna puluwan!