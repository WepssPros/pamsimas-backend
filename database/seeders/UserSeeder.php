<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Buat beberapa user dummy
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // Password default
                'username' => $faker->unique()->userName,
                'profile_picture' => $faker->imageUrl(),
                'ktp' => $faker->randomNumber(8),
                'verified' => $faker->boolean(),
            ]);
        }
    }
}
