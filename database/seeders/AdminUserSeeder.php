<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_users')->insert([
            'name' => 'ADMIN PAMSIMAS',
            'email' => 'admin@pamsimas.com',
            'password' => bcrypt('admin123')
        ]);
    }
}
