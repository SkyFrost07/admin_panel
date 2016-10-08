<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;

class MenuEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Menu $model) {
        $this->model = $model;
    }

    public function rules($update = false) {
        
    }

    public function all($args = []) {
        $opts = [
            'fields' => ['menus.*', 'md.*'],
            'group_id' => -1,
            'orderby' => 'order',
            'order' => 'asc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
            'lang' => current_locale()
        ];

        $opts = array_merge($opts, $args);

        $result = $this->model->joinLang($opts['lang'])
                ->whereNotNull('md.title')
                ->where('md.title', 'like', '%' . $opts['key'] . '%')
                ->whereNotIn('menus.id', $opts['exclude'])
                ->select($opts['fields'])
                ->orderBy($opts['orderby'], $opts['order']);

        if ($opts['group_id'] > -1) {
            $result = $result->where('group_id', $opts['group_id']);
        }

        if ($opts['per_page'] == -1) {
            $result = $result->get();
        } else {
            $result = $result->paginate($opts['per_page']);
        }
        return $result;
    }

    public function insert($data) {
        if (!isset($data['order'])) {
            $data['order'] = $this->model->max('order') + 1;
        }

        $item = $this->model->create($data);

        $langs = get_langs(['fields' => ['id', 'code']]);
        foreach ($langs as $lang) {
            $lang_data = [
                'title' => isset($data['title']) ? $data['title'] : $data['name'],
                'link' => isset($data['link']) ? $data['link'] : ''
            ];
            $item->langs()->attach($lang->code, $lang_data);
        }
    }

    public function findCustom($id, $fields = ['md.*'], $lang = null) {
        return $this->model->joinLang($lang)
                        ->find($id, $fields);
    }

    public function update($id, $data) {

        $fillable = $this->model->getFillable();
        $fill_data = array_only($data, $fillable);
        $item = $this->model->find($id);
        $item->update($fill_data);

        $lang_data = $data['locale'];
        $item->langs()->sync([$data['lang'] => $lang_data], false);
    }

    public function updateOrder($id, $order, $parent = 0) {
        $item = $this->model->find($id);
        if ($item) {
            $item->update(['order' => $order, 'parent_id' => $parent]);
        }
    }

}
