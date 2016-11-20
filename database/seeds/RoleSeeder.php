<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['label' => 'Administrator', 'name' => 'administrator', 'default' => 0]);
        Role::create(['label' => 'Editor', 'name' => 'editor', 'default' => 0]);
        Role::create(['label' => 'Member', 'name' => 'member', 'default' => 1]);
    }
}
