<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name' => 'Admin', 'slug' => 'admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('admin'), 'role_id' => 1]);
        User::create(['name' => 'Editor', 'slug' => 'editor', 'email' => 'editor@gmail.com', 'password' => bcrypt('editor'), 'role_id' => 2]);
        User::create(['name' => 'Member', 'slug' => 'member', 'email' => 'member@gmail.com', 'password' => bcrypt('member'), 'role_id' => 3]);
    }
}
