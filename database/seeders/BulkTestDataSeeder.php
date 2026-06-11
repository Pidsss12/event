<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TicketType;
use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class BulkTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // -----------------------------------------------------------------
        // 1. Create 55 test users (you can adjust the number here)
        // -----------------------------------------------------------------
        $users = [];
        for ($i = 1; $i <= 55; $i++) {
            $users[] = User::create([
                'name' => "Test User {$i}",
                'email' => "test{$i}@example.com",
                'password' => Hash::make('password'), // password: password
                'balance' => 1000000, // 1,000,000 IDR
                // keep default role = 'user' (if role column exists it will use default)
            ]);
        }

        // -----------------------------------------------------------------
        // 2. Gather existing ticket types – we need them to attach bookings.
        // -----------------------------------------------------------------
        $ticketTypes = TicketType::all();
        if ($ticketTypes->isEmpty()) {
            $this->command->info('No ticket types found – aborting bulk booking creation.');
            return;
        }

        // -----------------------------------------------------------------
        // 3. For each user, create a random number of bookings (5‑10).
        //    This will give us roughly 275‑550 bookings, satisfying "ratusan".
        // -----------------------------------------------------------------
        $paymentMethods = ['Wallet EventHub', 'Transfer Bank', 'E-Wallet', 'Minimarket'];
        foreach ($users as $user) {
            $bookingCount = rand(5, 10);
            for ($b = 0; $b < $bookingCount; $b++) {
                $ticket = $ticketTypes->random();
                $quantity = rand(1, 3);
                $method = $paymentMethods[array_rand($paymentMethods)];
                $isPaid = $method === 'Wallet EventHub';
                $status = $isPaid ? 'paid' : 'pending';
                $proof = null;
                if (!$isPaid) {
                    // dummy proof filename – UI will still display a link.
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
