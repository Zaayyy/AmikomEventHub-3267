<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\Partner;
use App\Models\Jabatan;
use App\Models\Pengurus;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);


        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        $seminar = Category::create([
            'name'=>'Seminar IT',
            'slug'=>'seminar-it'
        ]);

        $workshop = Category::create([
            'name'=>'Workshop',
            'slug'=>'workshop'
        ]);

        $entertainment = Category::create([
            'name'=>'Entertainment',
            'slug'=>'entertainment'
        ]);


        /*
        |--------------------------------------------------------------------------
        | PARTNER / PENYELENGGARA
        |--------------------------------------------------------------------------
        */

        $himaSi = Partner::create([
            'name' => 'HIMA Sistem Informasi',
            'logo_url' => 'https://ui-avatars.com/api/?name=HIMA+SI&background=4f46e5&color=fff',
            'description' => 'Organisasi mahasiswa Sistem Informasi yang aktif menyelenggarakan seminar, workshop, dan kegiatan komunitas digital.',
        ]);

        $amikomEvent = Partner::create([
            'name' => 'Amikom Event Committee',
            'logo_url' => 'https://ui-avatars.com/api/?name=Amikom+Event&background=0f172a&color=fff',
            'description' => 'Kepanitiaan kampus yang mengelola event hiburan, kompetisi, dan agenda besar mahasiswa.',
        ]);

        User::create([
            'name' => 'Admin HIMA SI',
            'email' => 'hima@amikom.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'partner_id' => $himaSi->id,
        ]);


        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */

        Event::create([
            'category_id'=>$seminar->id,
            'partner_id'=>$himaSi->id,
            'title'=>'AI Conference 2026',
            'description'=>'Belajar AI terbaru.',
            'date'=>'2026-06-01 10:00:00',
            'location'=>'Auditorium',
            'price'=>75000,
            'stock'=>100,
        ]);

        Event::create([
            'category_id'=>$seminar->id,
            'partner_id'=>$himaSi->id,
            'title'=>'Cyber Security Talk',
            'description'=>'Keamanan digital modern.',
            'date'=>'2026-06-05 13:00:00',
            'location'=>'Lab 1',
            'price'=>0,
            'stock'=>80,
        ]);

        Event::create([
            'category_id'=>$workshop->id,
            'partner_id'=>$himaSi->id,
            'title'=>'UI/UX Masterclass',
            'description'=>'Belajar UI UX.',
            'date'=>'2026-06-10 09:00:00',
            'location'=>'Lab Design',
            'price'=>60000,
            'stock'=>50,
        ]);

        Event::create([
            'category_id'=>$workshop->id,
            'partner_id'=>$himaSi->id,
            'title'=>'Laravel Bootcamp',
            'description'=>'Belajar Laravel.',
            'date'=>'2026-06-12 09:00:00',
            'location'=>'Lab Programming',
            'price'=>100000,
            'stock'=>40,
        ]);

        Event::create([
            'category_id'=>$entertainment->id,
            'partner_id'=>$amikomEvent->id,
            'title'=>'E-Sport Tournament',
            'description'=>'Kompetisi Game.',
            'date'=>'2026-06-15 18:00:00',
            'location'=>'Hall',
            'price'=>30000,
            'stock'=>200,
        ]);

        Event::create([
            'category_id'=>$entertainment->id,
            'partner_id'=>$amikomEvent->id,
            'title'=>'Music Festival',
            'description'=>'Festival Musik.',
            'date'=>'2026-06-20 19:00:00',
            'location'=>'Lapangan',
            'price'=>120000,
            'stock'=>300,
        ]);


        /*
        |--------------------------------------------------------------------------
        | JABATAN
        |--------------------------------------------------------------------------
        */

        $ketua = Jabatan::create([
            'name'=>'Ketua',
            'created_by'=>'admin'
        ]);

        $wakil = Jabatan::create([
            'name'=>'Wakil Ketua',
            'created_by'=>'admin'
        ]);

        $sekretaris = Jabatan::create([
            'name'=>'Sekretaris',
            'created_by'=>'admin'
        ]);

        $bendahara = Jabatan::create([
            'name'=>'Bendahara',
            'created_by'=>'admin'
        ]);


        /*
        |--------------------------------------------------------------------------
        | PENGURUS
        |--------------------------------------------------------------------------
        */

        Pengurus::create([
            'jabatan_id'=>$ketua->id,
            'name'=>'Anindya',
            'description'=>'Ketua Organisasi',
            'salary'=>5000000,
            'created_by'=>'admin'
        ]);

        Pengurus::create([
            'jabatan_id'=>$wakil->id,
            'name'=>'Budi',
            'description'=>'Wakil Ketua',
            'salary'=>4500000,
            'created_by'=>'admin'
        ]);

        Pengurus::create([
            'jabatan_id'=>$sekretaris->id,
            'name'=>'Citra',
            'description'=>'Sekretaris',
            'salary'=>4000000,
            'created_by'=>'admin'
        ]);

        Pengurus::create([
            'jabatan_id'=>$bendahara->id,
            'name'=>'Dinda',
            'description'=>'Bendahara',
            'salary'=>4200000,
            'created_by'=>'admin'
        ]);

    }
}
