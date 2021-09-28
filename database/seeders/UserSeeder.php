<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama_lengkap' => 'Developer',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'no_telepon' => '0894375384654',
            'kode_akses' => '30',
            'status_user' => 'Y',
            'log' => '-',
            'kode_adjuster' => 'K110',
        ]);
    }
}
