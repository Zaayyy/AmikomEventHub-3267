<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        \App\Models\User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Kategori
        $cat1 = \App\Models\Category::create([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);

        $cat2 = \App\Models\Category::create([
            'name' => 'Workshop',
            'slug' => 'workshop',
        ]);

        $cat3 = \App\Models\Category::create([
            'name' => 'Entertainment',
            'slug' => 'entertainment',
        ]);

        // Events (6 data)
        \App\Models\Event::create([
            'category_id' => $cat1->id,
            'title' => 'AI Conference 2026',
            'description' => 'Belajar AI terbaru.',
            'date' => '2026-06-01 10:00:00',
            'location' => 'Auditorium',
            'price' => 75000,
            'stock' => 100,
        ]);

        \App\Models\Event::create([
            'category_id' => $cat1->id,
            'title' => 'Cyber Security Talk',
            'description' => 'Keamanan digital modern.',
            'date' => '2026-06-05 13:00:00',
            'location' => 'Lab 1',
            'price' => 50000,
            'stock' => 80,
        ]);

        \App\Models\Event::create([
            'category_id' => $cat2->id,
            'title' => 'UI/UX Masterclass',
            'description' => 'Belajar desain UI/UX.',
            'date' => '2026-06-10 09:00:00',
            'location' => 'Lab Design',
            'price' => 60000,
            'stock' => 50,
        ]);

        \App\Models\Event::create([
            'category_id' => $cat2->id,
            'title' => 'Web Development Bootcamp',
            'description' => 'Belajar Laravel dari nol.',
            'date' => '2026-06-12 09:00:00',
            'location' => 'Lab Programming',
            'price' => 100000,
            'stock' => 40,
        ]);

        \App\Models\Event::create([
            'category_id' => $cat3->id,
            'title' => 'E-Sport Tournament',
            'description' => 'Kompetisi game antar mahasiswa.',
            'date' => '2026-06-15 18:00:00',
            'location' => 'Hall',
            'price' => 30000,
            'stock' => 200,
        ]);

        \App\Models\Event::create([
            'category_id' => $cat3->id,
            'title' => 'Music Festival',
            'description' => 'Konser musik kampus.',
            'date' => '2026-06-20 19:00:00',
            'location' => 'Lapangan',
            'price' => 120000,
            'stock' => 300,
        ]);
    }
}