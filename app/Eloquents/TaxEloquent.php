<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use Illuminate\Validation\ValidationException;

class TaxEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Tax $model) {
        $this->model = $model;
    }

    public function rules($update = false) {
        if ($update) {
            return [
                'locale.name' => 'required',
                'lang' => 'required'
            ];
        }
        $code = current_locale();
        return [
            $code . '.name' => 'required'
        ];
    }

    public function all($type='cat', $args = []) {
        $opts = [
            'fields' => ['taxs.*', 'td.*'],
            'orderby' => 'td.name',
            'order' => 'asc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
        ];
        $opts = array_merge($opts, $args);

        $result = $this->model->joinLang()
                ->where('type', $type)
                ->whereNotNull('td.name')
                ->where('td.name', 'like', '%' . $opts['key'] . '%')
                ->whereNotIn('taxs.id', $opts['exclude'])
                ->select($opts['fields'])
                ->orderBy($opts['orderby'], $opts['order']);

        if ($opts['per_page'] == -1) {
            $result = $result->get();
        } else {
            $result = $result->paginate($opts['per_page']);
        }
        return $result;
    }

    public function insert($data, $type='cat') {
        $this->validator($data, $this->rules());

        if(isset($data['parent_id']) && $data['parent_id'] == 0){
            $data['parent_id'] = null;
        }
        $data['type'] = $type;
        if(isset($data['file_ids']) && $data['file_ids']){
            $data['image_id'] = $data['file_ids'][0];
        }
        $fillable = $this->model->getFillable();
        $fill_data = array_only($data, $fillable);
        $item = $this->model->create($fill_data);

        foreach (get_langs(['fields' => ['id', 'code']]) as $lang) {
            $lang_data = $data[$lang->code];
            $name = $lang_data['name'];
            $slug = isset($lang_data['slug']) ? $lang_data['slug'] : '';
            $lang_data['slug'] = (trim($slug) == '') ? str_slug($name) : str_slug($slug);

            $item->langs()->attach($lang->code, $lang_data);
        }
        return $item;
    }

    public function findByLang($id, $fields = ['taxs.*', 'td.*'], $lang = null) {
        $item = $this->model->joinLang($lang)
                ->find($id, $fields);
        if($item){
            return $item;
        }
        return $this->model->find($id);
    }

    public function update($id, $data) {
        $this->validator($data, $this->rules(true));

        if(isset($data['file_ids']) && $data['file_ids']){
            $data['image_id'] = $data['file_ids'][0];
        }
        if(isset($data['parent_id']) && $data['parent_id'] == 0){
            $data['parent_id'] = null;
        }
        $fillable = $this->model->getFillable();
        $fill_data = array_only($data, $fillable);
        $item = $this->model->findOrFail($id);
        $item->update($fill_data);

        $lang_data = $data['locale'];
        $name = $lang_data['name'];
        $slug = isset($lang_data['slug']) ? $lang_data['slug'] : '';
        $lang_data['slug'] = (trim($slug) == '') ? str_slug($name) : str_slug($slug);

        $item->langs()->sync([$data['lang'] => $lang_data], false);
    }
    
    public function tableCats($items, $parent = 0, $depth = 0) {
        $html = '';
        $indent = str_repeat("-- ", $depth);
        foreach ($items as $item) {
            if ($item->parent_id == $parent && $item->name) {
                $html .= '<tr>';
                $html .= '<td><input type="checkbox" name="check_items[]" class="check_item" value="' . $item->id . '" /></td>
                <td>' . $item->id . '</td>
                <td>' . $indent . ' ' . $item->name . '</td>
                <td>' . $item->slug . '</td>
                <td>' . $item->parent_name() . '</td>
                <td>' . $item->order . '</td>
                <td><a href="'.route('post.index', ['cats' => [$item->id], 'status' => 1]).'">' . $item->count . '</a></td>
                <td>
                    <a href="' . route('cat.edit', ['id' => $item->id]) . '" class="btn btn-sm btn-info" title="' . trans('manage.edit') . '"><i class="fa fa-edit"></i></a>
                </td>';
                $html .= '</tr>';
                $html .= $this->tableCats($items, $item->id, $depth + 1);
            }
        }
        return $html;
    }
    
    public function toNested($items, $parent = 0) {
        $results = [];
        foreach ($items as $item) {
            if ($item->parent_id == $parent) {
                $nitem = $item;
                $childs = $this->toNested($items, $item->id);
                $nitem['childs'] = $childs;
                $results[] = $nitem;
            }
        }
        return $results;
    }

    public function nestedMenus($lists, $parent) {
        $output = '';
        foreach ($lists as $key => $item) {
            if ($item->parent_id == $parent) {
                $output .= '<li data-id="' . $item->id . '" class="dd-item dd3-item">';
                $output.= '<div class="dd-handle dd3-handle"></div>';
                $output.= '<div class="dd3-content">'
                        . '<span class="title">' . $item->title . '</span>'
                        . '<span class="actions">'
                        . '<a href="#menu-edit-' . $item->id . '" data-toggle="collapse" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>'
                        . '</span>'
                        . '</div>'
                        . '<div id="menu-edit-' . $item->id . '" class="mi-content collapse">'
                        . '<div class="form-group"><label>' . trans('manage.title') . '</label>'
                        . Form::text('menus[' . $item->id . '][locale][title]', $item->title, ['class' => 'form-control'])
                        . '</div>'
                        . '<div class="form-group"><label>' . trans('manage.open_type') . '</label>'
                        . Form::select('menus[' . $item->id . '][open_type]', ['' => trans('manage.current_tab'), '_blank' => trans('manage.new_tab')], $item->open_type, ['class' => 'form-control'])
                        . '</div>'
                        . '<div class="form-group"><label>' . trans('manage.icon') . '</label>'
                        . Form::text('menus[' . $item->id . '][icon]', $item->icon, ['class' => 'form-control'])
                        . '</div>'
                        . '</div>';
                $output2 = $this->nestedMenus($lists, $item->id);
                if ($output2 != '') {
                    $output .= '<ol class="childs dd-list">' . $output2 . '</ol>';
                }
                $output .= '</li>';
            }
        }
        return $output;
    }

}
