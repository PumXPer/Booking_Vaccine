<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'admin',
                'id_card' => '1234567899874',
                'role' => 'ADMIN',
                'email' => 'admin@my-db.com',
                'password' => bcrypt('1234')
            ],
            [
                'name' => 'user',
                'id_card' => '2234567899874',
                'role' => 'USER',
                'email' => 'user@my-db.com',
                'password' => bcrypt('1234')
            ]
        ];

        foreach($user as $key=> $value) {
            User::create($value);
        }
    }
}
