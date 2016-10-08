<?php

namespace App\Composers;

class AdMenuComposer {

    public function compose($view) {
        $menus = [
            ['name' => trans('menu.posts'), 'route' => 'post.index', 'route_params' => ['status' => 1], 'cap' => 'read_posts', 'icon' => 'fa-newspaper-o'],
            ['name' => trans('menu.pages'), 'route' => 'page.index', 'route_params' => ['status' => 1], 'cap' => 'read_posts', 'icon' => 'fa-copy'],
            ['name' => trans('menu.comments'), 'route' => 'comment.index', 'route_params' => ['status' => 1], 'cap' => 'publish_comments', 'icon' => 'fa-comments'],
            ['name' => trans('menu.cats'), 'route' => 'cat.index', 'cap' => 'manage_cats', 'icon' => 'fa-folder'],
            ['name' => trans('menu.tags'), 'route' => 'tag.index', 'cap' => 'manage_tags', 'icon' => 'fa-tags'],
            ['name' => trans('menu.medias'), 'route' => 'media.index', 'route_params' => ['status' => 1], 'cap' => 'read_posts', 'icon' => 'fa-file-image-o'],
            ['name' => trans('menu.albums'), 'route' => 'album.index', 'cap' => 'manage_cats', 'icon' => 'fa-image'],
            ['name' => trans('menu.files'), 'route' => 'file.manage', 'cap' => 'manage_files', 'icon' => 'fa-file'],
            ['name' => trans('menu.menucats'), 'route' => 'menucat.index', 'cap' => 'manage_menus', 'icon' => 'fa-bars'],
            ['name' => trans('menu.sliders'), 'route' => 'slider.index', 'cap' => 'manage_cats', 'icon' => 'fa-sliders'],
            ['name' => trans('menu.users'), 'route' => 'user.index', 'route_params' => ['status' => 1], 'cap' => 'read_users', 'icon' => 'fa-user'],
            ['name' => trans('menu.roles'), 'route' => 'role.index', 'cap' => 'manage_roles', 'icon' => 'fa-users'],
            ['name' => trans('menu.caps'), 'route' => 'cap.index', 'cap' => 'manage_caps', 'icon' => 'fa-sign-in'],
            ['name' => trans('menu.langs'), 'route' => 'lang.index', 'route_params' => ['status' => 1], 'cap' => 'manage_langs', 'icon' => 'fa-language'],
            ['name' => trans('menu.options'), 'route' => 'option.index', 'cap' => 'manage_options', 'icon' => 'fa-gear']
        ];

        $view->with('admenus', $menus);
    }

}
