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
        $admin = Role::create(['label' => 'Administrator', 'name' => 'administrator', 'default' => 0]);
        $editor = Role::create(['label' => 'Editor', 'name' => 'editor', 'default' => 0]);
        $member = Role::create(['label' => 'Member', 'name' => 'member', 'default' => 1]);
        
        $admin->caps()->attach([1,2,3,4,5,6,7,8,9,10,11,12,13,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38]);
        $editor->caps()->attach([1,2,3,4,5,8,9,11,13,19,20,21,23,24,25,26,27,28,29,31,32,33,34,37]);
        $member->caps()->attach([1,2,4,8,9,20,21,25,27,29,32,34,37]);
    }
}
