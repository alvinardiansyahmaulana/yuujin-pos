<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Alvin Ardiansyah Maulana',
            'email' => 'alvin@yuujin.com',
            'password' => bcrypt('bandung12345'),
        ]);
    }
}
