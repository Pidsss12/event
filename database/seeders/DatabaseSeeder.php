<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users
        $admin = User::create([
            'name' => 'Admin EventHub',
            'email' => 'admin@eventhub.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'balance' => 0.00,
        ]);

        $user = User::create([
            'name' => 'Alex User',
            'email' => 'user@eventhub.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'balance' => 2500000.00, // 2.5 million IDR
        ]);

        // Seed Categories
        $categories = [
            [
                'name' => 'Conference & Workshop',
                'slug' => 'conference-workshop',
                'description' => 'Professional development, industry summits, and skill workshops.',
                'icon' => 'presentation'
            ],
            [
                'name' => 'Music & Concerts',
                'slug' => 'music-concerts',
                'description' => 'Live musical performances, festivals, and concerts.',
                'icon' => 'music'
            ],
            [
                'name' => 'Technology & Startups',
                'slug' => 'tech-startups',
                'description' => 'Hackathons, coding conferences, and startup pitch events.',
                'icon' => 'cpu'
            ],
            [
                'name' => 'Art & Design',
                'slug' => 'art-design',
                'description' => 'Exhibitions, design sprints, and galleries.',
                'icon' => 'palette'
            ],
            [
                'name' => 'Sports & Wellness',
                'slug' => 'sports-wellness',
                'description' => 'Marathons, fitness workshops, and tournaments.',
                'icon' => 'activity'
            ]
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[] = \App\Models\EventCategory::create($cat);
        }

        // Seed Events
        $events = [
            [
                'category_id' => $categoryModels[0]->id,
                'organizer_id' => $admin->id,
                'title' => 'Big Conference & Workshop 2026',
                'slug' => 'big-conference-workshop-2026',
                'description' => 'Join the grandest conference and workshop of the year. Featuring top keynote speakers, hands-on workshops, and unparalleled networking opportunities. Learn the latest trends in business, technology, and leadership from global industry leaders.',
                'location' => 'Mandalay Bay Convention Center, Las Vegas & Virtual',
                'latitude' => 36.0919,
                'longitude' => -115.1761,
                'date_time' => now()->addDays(30)->setHour(9)->setMinute(0),
                'banner_image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1200&auto=format&fit=crop',
                'status' => 'approved',
            ],
            [
                'category_id' => $categoryModels[1]->id,
                'organizer_id' => $admin->id,
                'title' => 'Sound of Summer Music Festival',
                'slug' => 'sound-of-summer-music-festival',
                'description' => 'Experience the biggest music festival featuring multi-genre artists, spectacular light shows, food trucks, and interactive art installations. A night to remember under the starry sky.',
                'location' => 'Carnival Ground Beach Area, Jakarta',
                'latitude' => -6.1197,
                'longitude' => 106.8502,
                'date_time' => now()->addDays(45)->setHour(16)->setMinute(30),
                'banner_image' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=1200&auto=format&fit=crop',
                'status' => 'approved',
            ],
            [
                'category_id' => $categoryModels[2]->id,
                'organizer_id' => $admin->id,
                'title' => 'Global Tech Innovation Summit',
                'slug' => 'global-tech-innovation-summit',
                'description' => 'Explore the future of Artificial Intelligence, Quantum Computing, and Blockchain. Watch live demos, hear from visionary founders, and network with leading developers and VC firms.',
                'location' => 'Silicon Valley Innovation Hub, California',
                'latitude' => 37.7749,
                'longitude' => -122.4194,
                'date_time' => now()->addDays(60)->setHour(10)->setMinute(0),
                'banner_image' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?q=80&w=1200&auto=format&fit=crop',
                'status' => 'approved',
            ],
            [
                'category_id' => $categoryModels[3]->id,
                'organizer_id' => $admin->id,
                'title' => 'UI/UX Design Masterclass 2.0',
                'slug' => 'ui-ux-design-masterclass-2-0',
                'description' => 'Elevate your design career with this intensive masterclass. Learn advanced typography, color theory, design systems, and product research methodology with hands-on mentoring.',
                'location' => 'Design Lab Studio, Bandung & Zoom',
                'latitude' => -6.9175,
                'longitude' => 107.6191,
                'date_time' => now()->addDays(15)->setHour(13)->setMinute(0),
                'banner_image' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=1200&auto=format&fit=crop',
                'status' => 'approved',
            ]
        ];

        foreach ($events as $evtData) {
            $event = \App\Models\Event::create($evtData);

            // Seed Ticket Types for each event
            \App\Models\TicketType::create([
                'event_id' => $event->id,
                'name' => 'Silver Ticket',
                'price' => 150000.00,
                'capacity' => 100,
                'remaining' => 100,
            ]);

            \App\Models\TicketType::create([
                'event_id' => $event->id,
                'name' => 'Gold Ticket',
                'price' => 350000.00,
                'capacity' => 50,
                'remaining' => 50,
            ]);

            \App\Models\TicketType::create([
                'event_id' => $event->id,
                'name' => 'Platinum VIP',
                'price' => 750000.00,
                'capacity' => 20,
                'remaining' => 20,
            ]);
        }

        $this->call(TestDataSeeder::class);
    }
}
