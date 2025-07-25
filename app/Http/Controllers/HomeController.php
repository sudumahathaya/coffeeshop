<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured menu items
        $featuredProducts = MenuItem::active()
            ->whereIn('category', ['Hot Coffee', 'Specialty', 'Tea & Others'])
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('home', compact('featuredProducts'));
    }

    public function menu()
    {
        $menuItems = MenuItem::active()->get()->groupBy('category');
        $categories = MenuItem::select('category')->distinct()->pluck('category');
        
        return view('menu', compact('menuItems', 'categories'));
    }

    public function reservation()
    {
        return view('reservation');
    }

    public function blog()
    {
        // Sample blog posts data
        $blogPosts = [
            (object) [
                'id' => 1,
                'title' => 'The Art of Perfect Espresso',
                'slug' => 'art-of-perfect-espresso',
                'excerpt' => 'Master the fundamentals of espresso making with our comprehensive guide.',
                'category' => 'brewing',
                'author' => 'Tharaka Silva',
                'published_at' => '2024-12-15',
                'views' => 1250,
                'likes' => 89,
                'featured' => true
            ]
        ];

        $categories = [
            'brewing' => 'Brewing Guides',
            'culture' => 'Coffee Culture',
            'recipes' => 'Recipes',
            'news' => 'Café News',
            'health' => 'Health & Wellness'
        ];

        return view('blog', compact('blogPosts', 'categories'));
    }

    public function features()
    {
        return view('features');
    }

    public function contact()
    {
        $contactInfo = (object) [
            'address' => 'No.1, Mahamegawaththa Road, Maharagama',
            'phone' => '+94 77 186 9132',
            'whatsapp' => '+94 77 186 9132',
            'email_general' => 'info@cafeelixir.lk',
            'email_reservations' => 'reservations@cafeelixir.lk',
            'email_events' => 'events@cafeelixir.lk',
            'business_hours' => [
                'monday' => '6:00 AM - 10:00 PM',
                'tuesday' => '6:00 AM - 10:00 PM',
                'wednesday' => '6:00 AM - 10:00 PM',
                'thursday' => '6:00 AM - 10:00 PM',
                'friday' => '6:00 AM - 10:00 PM',
                'saturday' => '6:00 AM - 11:00 PM',
                'sunday' => '7:00 AM - 10:00 PM'
            ],
            'social_media' => [
                'facebook' => 'https://facebook.com/cafeelixir',
                'instagram' => 'https://instagram.com/cafeelixir',
                'twitter' => 'https://twitter.com/cafeelixir',
                'youtube' => 'https://youtube.com/cafeelixir',
                'tiktok' => 'https://tiktok.com/@cafeelixir'
            ]
        ];

        return view('contact', compact('contactInfo'));
    }

    // Handle contact form submission
    public function storeContact(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|in:general,reservation,catering,feedback,complaint,partnership,employment,media,other',
            'message' => 'required|string|max:2000',
            'contactMethod' => 'required|string|in:email,phone,whatsapp',
            'bestTime' => 'nullable|string|in:morning,afternoon,evening',
            'urgency' => 'required|string|in:normal,urgent,immediate',
            'newsletter' => 'nullable|boolean'
        ]);

        // Generate message ID
        $messageId = 'CM' . str_pad(ContactMessage::count() + 1, 6, '0', STR_PAD_LEFT);

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

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!',
            'message_id' => $messageId,
            'data' => $contactMessage
        ]);
    }

    // Handle newsletter subscription
    public function subscribeNewsletter(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|max:255'
        ]);

        NewsletterSubscriber::updateOrCreate(
            ['email' => $validatedData['email']],
            [
                'subscribed_at' => now(),
                'is_active' => true
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Thank you for subscribing to our newsletter!'
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
            'reservationDate' => 'required|date|after:today',
            'reservationTime' => 'required|string',
            'guests' => 'required|integer|min:1|max:20',
            'tableType' => 'nullable|string',
            'occasion' => 'nullable|string',
            'specialRequests' => 'nullable|string|max:1000',
            'emailUpdates' => 'nullable|boolean'
        ]);

        $reservationId = 'CE' . str_pad(Reservation::count() + 1, 6, '0', STR_PAD_LEFT);

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
            'user_id' => auth()->id(),
            'status' => 'confirmed'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reservation confirmed successfully!',
            'reservation_id' => $reservationId,
            'data' => $reservation
        ]);
    }

    // Get blog post by slug (for future single post view)
    public function showBlogPost($slug)
    {
        // This would typically fetch from database
        $post = (object) [
            'title' => 'Sample Blog Post',
            'content' => 'Full blog post content...',
            'author' => 'Author Name',
            'published_at' => now()
        ];

        return view('blog.single', compact('post'));
    }

    // Get business status (for API)
    public function getBusinessStatus()
    {
        $now = now();
        $currentDay = $now->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.
        $currentTime = $now->format('H:i');

        $isOpen = false;
        $message = 'Closed';

        // Check if currently open based on business hours
        if ($currentDay == 0) { // Sunday
            $isOpen = $currentTime >= '07:00' && $currentTime < '22:00';
        } elseif ($currentDay == 6) { // Saturday
            $isOpen = $currentTime >= '06:00' && $currentTime < '23:00';
        } else { // Monday to Friday
            $isOpen = $currentTime >= '06:00' && $currentTime < '22:00';
        }

        if ($isOpen) {
            // Check if closing soon (within 1 hour)
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
