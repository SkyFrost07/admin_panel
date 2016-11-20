<?php

use Illuminate\Database\Seeder;
use App\Models\Cap;

class CapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $caps = [
            'publish_posts' => [[1, 2, 3]], 
            'edit_other_posts' => [[1, 2]], 
            'edit_my_post' => [[1, 2, 3], 'edit_other_posts'],  
            'remove_other_posts' => [[1, 2]], 
            'remove_my_post' => [[1, 2, 3], 'remove_other_posts'],
            'manage_roles' => [[1]], 
            'manage_caps' => [[1]], 
            'edit_other_users' => [[1]], 
            'remove_other_users' => [[1]], 
            'edit_my_user' => [[1, 2, 3], 'edit_other_users'], 
            'remove_my_user' => [[1, 2, 3], 'remove_other_users'], 
            'publish_users' => [[1]], 
            'accept_manage' => [[1]], 
            'manage_users' => [[1]], 
            'manage_posts' => [[1]], 
            'read_users' => [[1, 2, 3]], 
            'read_posts' => [[1, 2, 3]], 
            'manage_langs' => [[1]], 
            'manage_cats' => [[1]], 
            'manage_tags' => [[1, 2]], 
            'edit_other_comments' => [[1, 2]], 
            'edit_my_comment' => [[1, 2, 3], 'edit_other_comments'], 
            'remove_other_comments' => [[1, 2]], 
            'remove_my_comment' => [[1, 2, 3], 'remove_other_comments'], 
            'publish_comments' => [[1, 2, 3]], 
            'manage_menus' => [[1]], 
            'publish_files' => [[1, 2, 3]], 
            'edit_other_files' => [[1, 2]], 
            'edit_my_file' => [[1, 2, 3], 'edit_other_files'], 
            'remove_other_files' => [[1, 2]], 
            'remove_my_file' => [[1, 2, 3], 'remove_other_files'], 
            'manage_files' => [[1]], 
            'read_files' => [[1, 2, 3]], 
            'manage_options' => [[1]]
        ];
        foreach ($caps as $cap => $attrs) {
            $data = ['name' => $cap];
            if (isset($attrs[1])) {
                $data['higher'] = $attrs[1];
            }
            $cap_item = Cap::create($data);
            $cap_item->roles()->attach($attrs[0]);
        }
    }
}
