# Café Elixir - Complete Coffee Shop Management System

A comprehensive coffee shop management system built with Laravel 11, featuring customer ordering, reservations, loyalty programs, and admin management.

## Features

### Customer Features
- **Menu Browsing**: View categorized menu with detailed item information
- **Online Ordering**: Place orders with real-time cart management
- **Table Reservations**: Book tables with date/time selection
- **User Dashboard**: Track orders, reservations, and loyalty points
- **Loyalty Program**: Earn points and unlock tier benefits
- **Contact System**: Send inquiries with automated responses

### Admin Features
- **Dashboard Analytics**: Sales reports, user statistics, revenue tracking
- **Order Management**: View, update, and track all orders
- **Reservation Management**: Manage table bookings and availability
- **Menu Management**: Add, edit, and manage menu items
- **User Management**: View and manage customer accounts
- **Contact Management**: Handle customer inquiries

### Technical Features
- **Authentication System**: Secure login/registration with role-based access
- **Database Design**: Optimized schema for coffee shop operations
- **API Endpoints**: RESTful API for mobile app integration
- **Responsive Design**: Mobile-first Bootstrap 5 interface
- **Real-time Updates**: Dynamic content updates without page refresh

## Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- SQLite (default) or MySQL

### Step 1: Clone and Install Dependencies
```bash
git clone <repository-url>
cd cafe-elixir
composer install
npm install
```

### Step 2: Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### Step 3: Database Setup
```bash
# Create SQLite database
touch database/database.sqlite

# Run migrations and seeders
php artisan migrate
php artisan db:seed
```

### Step 4: Build Assets
```bash
npm run build
```

### Step 5: Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## Default Login Credentials

### Admin Account
- **Email**: admin@cafeelixir.lk
- **Password**: admin123

### Test Customer Account
- **Email**: customer@example.com
- **Password**: password

## Database Schema

### Core Tables
- **users**: Customer and admin accounts with role-based access
- **menu_items**: Coffee menu with categories, pricing, and nutritional info
- **orders**: Customer orders with items, pricing, and status tracking
- **reservations**: Table bookings with customer details and preferences
- **loyalty_points**: Point earning/redemption system
- **contact_messages**: Customer inquiries and support tickets
- **newsletter_subscribers**: Email subscription management

## API Documentation

### Public Endpoints
```
GET /api/v1/menu - Get all menu items
GET /api/v1/menu/{id} - Get specific menu item
GET /api/v1/menu/category/{category} - Get items by category
GET /api/v1/menu/featured - Get featured items
POST /api/v1/orders - Place new order
GET /api/v1/orders/{orderId} - Get order details
```

### Protected Endpoints (Requires Authentication)
```
GET /api/v1/user/orders - Get user's orders
GET /api/v1/user/reservations - Get user's reservations
GET /api/v1/user/loyalty - Get loyalty point details
```

## Business Logic

### Loyalty Program
- **Bronze Tier**: 0-499 points (5% discount)
- **Gold Tier**: 500-1,499 points (15% discount)
- **Platinum Tier**: 1,500+ points (25% discount)
- **Point Earning**: 1 point per Rs. 10 spent
- **Reservation Bonus**: 50 points per confirmed reservation

### Order Management
- **Order Statuses**: pending → confirmed → preparing → ready → completed
- **Order Types**: dine_in, takeaway, delivery
- **Tax Calculation**: 10% tax on subtotal
- **Automatic Point Award**: Points credited on order completion

### Reservation System
- **Advance Booking**: Up to 30 days in advance
- **Time Slots**: 30-minute intervals during business hours
- **Guest Limits**: 1-20 people per reservation
- **Status Tracking**: pending → confirmed → completed/cancelled

## Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

### Database Reset
```bash
php artisan migrate:fresh --seed
```

## Production Deployment

### Environment Variables
Update `.env` for production:
```
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
MAIL_MAILER=smtp
```

### Optimization Commands
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

## Support

For technical support or business inquiries:
- **Email**: info@cafeelixir.lk
- **Phone**: +94 77 186 9132
- **Address**: No.1, Mahamegawaththa Road, Maharagama

## License

This project is proprietary software developed for Café Elixir.