<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'email' => 'admin@gmail.com',
                'username' => 'admin',
                'password' => bcrypt('123456'),
                'firstname' => 'admin',
                'lastname' => 'admin'
            ]
            ];

        foreach($data as $d) {
            User::create($d);
        }
    }
}
