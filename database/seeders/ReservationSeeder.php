<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $users = User::all();
        
        // Create sample reservations for today and upcoming days
        $reservations = [
            [
                'reservation_id' => 'CE000001',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '+94 77 123 4567',
                'reservation_date' => today(),
                'reservation_time' => '14:00:00',
                'guests' => 4,
                'table_type' => 'window',
                'occasion' => 'business',
                'special_requests' => 'Quiet table for business meeting',
                'email_updates' => true,
                'status' => 'confirmed',
                'user_id' => $users->first()->id ?? null,
            ],
            [
                'reservation_id' => 'CE000002',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@example.com',
                'phone' => '+94 77 234 5678',
                'reservation_date' => today()->addDay(),
                'reservation_time' => '18:30:00',
                'guests' => 2,
                'table_type' => 'corner',
                'occasion' => 'date',
                'special_requests' => 'Anniversary celebration',
                'email_updates' => true,
                'status' => 'pending',
                'user_id' => $users->skip(1)->first()->id ?? null,
            ],
            [
                'reservation_id' => 'CE000003',
                'first_name' => 'Mike',
                'last_name' => 'Johnson',
                'email' => 'mike@example.com',
                'phone' => '+94 77 345 6789',
                'reservation_date' => today(),
                'reservation_time' => '10:00:00',
                'guests' => 6,
                'table_type' => 'center',
                'occasion' => 'family',
                'special_requests' => 'High chair needed for toddler',
                'email_updates' => false,
                'status' => 'confirmed',
                'user_id' => null,
            ],
            [
                'reservation_id' => 'CE000004',
                'first_name' => 'Sarah',
                'last_name' => 'Wilson',
                'email' => 'sarah@example.com',
                'phone' => '+94 77 456 7890',
                'reservation_date' => today(),
                'reservation_time' => '16:00:00',
                'guests' => 3,
                'table_type' => 'outdoor',
                'occasion' => 'birthday',
                'special_requests' => 'Birthday cake arrangement',
                'email_updates' => true,
                'status' => 'pending',
                'user_id' => null,
            ],
            [
                'reservation_id' => 'CE000005',
                'first_name' => 'David',
                'last_name' => 'Brown',
                'email' => 'david@example.com',
                'phone' => '+94 77 567 8901',
                'reservation_date' => today()->addDays(2),
                'reservation_time' => '12:30:00',
                'guests' => 8,
                'table_type' => 'private',
                'occasion' => 'business',
                'special_requests' => 'Team lunch meeting, need projector',
                'email_updates' => true,
                'status' => 'confirmed',
                'user_id' => null,
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }

        // Create additional random reservations for the next 7 days
        for ($i = 0; $i < 15; $i++) {
            $randomDate = today()->addDays(rand(0, 7));
            $randomHour = rand(6, 21);
            $randomMinute = rand(0, 1) * 30; // 0 or 30 minutes
            
            Reservation::create([
                'reservation_id' => 'CE' . str_pad(6 + $i, 6, '0', STR_PAD_LEFT),
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => fake()->email(),
                'phone' => '+94 77 ' . fake()->numerify('### ####'),
                'reservation_date' => $randomDate,
                'reservation_time' => sprintf('%02d:%02d:00', $randomHour, $randomMinute),
                'guests' => rand(1, 8),
                'table_type' => fake()->randomElement(['window', 'corner', 'center', 'outdoor', null]),
                'occasion' => fake()->randomElement(['birthday', 'anniversary', 'business', 'date', 'family', null]),
                'special_requests' => rand(0, 1) ? fake()->sentence() : null,
                'email_updates' => fake()->boolean(),
                'status' => fake()->randomElement(['confirmed', 'pending', 'completed']),
                'user_id' => $users->random()->id ?? null,
            ]);
        }
    }
}