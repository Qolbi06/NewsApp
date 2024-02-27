<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeader extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new \App\Models\User;
        $admin->name = 'Admin';
        $admin->email = 'Admin@google.com';
        $admin->role = 'Admin';
        $admin->password = bcrypt('admin');
        $admin->save();
    }
}