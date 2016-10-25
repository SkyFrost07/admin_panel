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
            'publish_posts', 'edit_my_post', 'edit_other_posts', 'remove_my_post', 'remove_other_posts', 'manage_roles', 'manage_caps', 'edit_my_user', 'remove_my_user', 'publish_users', 'edit_other_users', 'remove_other_users', 'accept_manage', 'manage_users', 'manage_posts', 'read_users', 'read_posts', 'manage_langs', 'manage_cats', 'manage_tags', 'edit_my_comment', 'edit_other_comments', 'remove_my_comment', 'remove_other_comments', 'publish_comments', 'manage_menus', 'publish_files', 'edit_my_file', 'edit_other_files', 'remove_my_file', 'remove_other_files', 'manage_files', 'read_files', 'manage_options'
        ];
        foreach ($caps as $cap) {
            Cap::create(['name' => $cap]);
        }
        $my_caps = Cap::where('name', 'like', '%_my_%')->get();
        foreach ($my_caps as $cap) {
            $cap->higher = str_replace('_my_', '_other_', $cap->name);
        }
    }
}
