<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        // Choose a random ticket type that will be created in the seeder
        $ticket = TicketType::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $paymentMethods = ['Wallet EventHub', 'Transfer Bank', 'E-Wallet', 'Minimarket'];
        $method = $this->faker->randomElement($paymentMethods);
        $isPaid = $method === 'Wallet EventHub';
        $status = $isPaid ? 'paid' : 'pending';
        $proof = null;
        if (!$isPaid) {
            // use a placeholder image from Faker for proof
            $proof = $this->faker->image('storage/app/public/proofs', 640, 480, null, false);
            // store filename only
        }

        $bookingCode = 'EVT-' . strtoupper(Str::random(8));

        return [
            'user_id' => $user->id,
            'event_id' => $ticket->event_id,
            'ticket_type_id' => $ticket->id,
            'booking_code' => $bookingCode,
            'quantity' => $this->faker->numberBetween(1, 5),
            'total_price' => $ticket->price * $this->faker->numberBetween(1, 5),
            'payment_status' => $status,
            'payment_method' => $method,
            'proof_of_payment' => $proof,
            'booked_at' => now(),
        ];
    }
}
?>
