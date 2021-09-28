<?php

namespace Database\Seeders;

use App\Models\FileStatus;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FileStatus::create([
            'nama_status' => 'Waiting for supporting docs.'
        ]);
        FileStatus::create([
            'nama_status' => 'PR Incorporating PA - Await instruction for FR/ Closed file'
        ]);
        FileStatus::create([
            'nama_status' => 'IA - Waiting for supporting docs.'
        ]);
        FileStatus::create([
            'nama_status' => 'PR - Reviewing documents'
        ]);
        FileStatus::create([
            'nama_status' => 'CLOSED FILE'
        ]);
    }
}
