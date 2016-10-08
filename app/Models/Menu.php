<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {

    protected $table = 'menus';
    protected $fillable = ['group_id', 'parent_id', 'menu_type', 'type_id', 'icon', 'open_type', 'order', 'status'];
    public $timestamps = false;

    public function joinLang($lang = null) {
        $lang = ($lang) ? $lang : current_locale();
        return $this->join('menu_desc as md', 'menus.id', '=', 'md.menu_id')
                        ->where('md.lang_code', '=', $lang);
    }

    public function langs() {
        return $this->belongsToMany('\App\Models\Lang', 'menu_desc', 'menu_id', 'lang_code');
    }

    public function group() {
        return $this->belongsTo('App\Models\MenuCat', 'group_id', 'id');
    }

    public function getObject() {
        switch ($this->menu_type) {
            case 5:
                $object = $this->join('service_desc as sd', function($join) {
                            $join->on('menus.type_id', '=', 'sd.service_id')
                            ->where('sd.lang_code', '=', current_locale())
                            ->where('sd.service_id', '=', $this->type_id);
                        })
                        ->first(['sd.title', 'sd.slug']);
                break;
            case 4:
                $object = $this->join('tax_desc as td', 'menus.type_id', '=', 'td.tax_id')
                        ->where('td.lang_code', '=', current_locale())
                        ->where('td.tax_id', '=', $this->type_id)
                        ->first(['td.name as title', 'td.slug']);
                break;
            case 3:
                $object = $this->join('tax_desc as td', 'menus.type_id', '=', 'td.tax_id')
                        ->where('td.lang_code', '=', current_locale())
                        ->where('td.tax_id', '=', $this->type_id)
                        ->first(['td.name as title', 'td.slug']);
                break;
            case 2:
                $object = $this->join('post_desc as pd', 'menus.type_id', '=', 'pd.post_id')
                        ->where('pd.lang_code', '=', current_locale())
                        ->where('pd.post_id', '=', $this->type_id)
                        ->first(['pd.title', 'pd.slug']);
                break;
            case 1:
                $object = $this->join('post_desc as pd', 'menus.type_id', '=', 'pd.post_id')
                        ->where('pd.lang_code', '=', current_locale())
                        ->where('pd.post_id', '=', $this->type_id)
                        ->first(['pd.title', 'pd.slug']);
                break;
            case 0:
                $object = null;
                break;
            default:
                $object = null;
                break;
        }
        return $object;
    }

    public function getItemRoute() {
        $route = null;
        switch ($this->menu_type) {
            case 0:
                break;
            case 1:
                $route = 'post.view';
                break;
            case 2:
                $route = 'page.view';
                break;
            case 3:
                $route = 'cat.view';
                break;
            case 4:
                $route = 'tag.view';
                break;
            case 5:
                $route = 'service.view';
                break;
            default:
                break;
        }
        return $route;
    }

    public function str_status() {
        if ($this->status == 1) {
            return trans('manage.active');
        }
        return trans('manage.disable');
    }

    public function str_open_type() {
        if ($this->open_type) {
            return trans('manage.newtab_tab');
        }
        return trans('manage.current_tab');
    }

}
