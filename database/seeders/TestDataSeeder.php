<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TicketType;
use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 3 test users
        $users = [];
        for ($i = 1; $i <= 3; $i++) {
            $users[] = User::create([
                'name' => "Test User {$i}",
                'email' => "test{$i}@example.com",
                'password' => Hash::make('password'), // password: password
                'balance' => 1000000, // IDR 1,000,000
            ]);
        }

        // Ensure we have some ticket types to associate bookings with
        $ticketTypes = TicketType::all();
        if ($ticketTypes->isEmpty()) {
            $this->command->info('No ticket types found – seeder will not create bookings.');
            return;
        }

        // For each user, create 3 bookings (total 9 bookings)
        foreach ($users as $user) {
            for ($j = 1; $j <= 3; $j++) {
                $ticket = $ticketTypes->random();
                $quantity = rand(1, 3);
                $paymentMethods = ['Wallet EventHub', 'Transfer Bank', 'E-Wallet', 'Minimarket'];
                $method = $paymentMethods[array_rand($paymentMethods)];
                $isPaid = $method === 'Wallet EventHub';
                $status = $isPaid ? 'paid' : 'pending';
                $proof = null;
                if (!$isPaid) {
                    // store a dummy image placeholder (using Faker would require additional setup)
                    // We'll just set a dummy filename; the file does not need to exist for testing UI.
                    $proof = 'dummy_proof_' . Str::random(5) . '.jpg';
                }

                Booking::create([
                    'user_id' => $user->id,
                    'event_id' => $ticket->event_id,
                    'ticket_type_id' => $ticket->id,
                    'booking_code' => 'EVT-' . strtoupper(Str::random(8)),
                    'quantity' => $quantity,
                    'total_price' => $ticket->price * $quantity,
                    'payment_status' => $status,
                    'payment_method' => $method,
                    'proof_of_payment' => $proof,
                    'booked_at' => now(),
                ]);
            }
        }
    }
}
?>
