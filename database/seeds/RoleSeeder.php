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
        $caps = [
            'edit_other_posts', 'remove_other_posts', 'edit_other_users', 'remove_other_users', 'edit_other_users', 'edit_other_posts',
            'edit_other_comments', 'remove_other_comments', 'edit_other_files', 'remove_other_files', 'dit_other_posts',
            'publish_posts', 'edit_my_post', 'remove_my_post', 'manage_roles', 'manage_caps', 'edit_my_user', 'remove_my_user',
            'publish_users', 'accept_manage', 'manage_users', 'manage_posts', 'read_users', 'read_posts', 'manage_langs',
            'manage_cats', 'manage_tags', 'edit_my_comment', 'remove_my_comment', 'publish_comments', 'manage_menus', 'publish_files',
            'edit_my_file', 'remove_my_file', 'manage_files', 'read_files', 'manage_options'
        ];
        $admin = Role::create(['label' => 'Administrator', 'name' => 'administrator', 'default' => 0]);
        $editor = Role::create(['label' => 'Editor', 'name' => 'editor', 'default' => 0]);
        $member = Role::create(['label' => 'Member', 'name' => 'member', 'default' => 1]);
    }
}
