<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use Illuminate\Validation\ValidationException;

class PostTypeEloquent extends BaseEloquent {

    protected $model;
    protected $tax;

    public function __construct(\App\Models\PostType $model, \App\Models\Tax $tax) {
        $this->model = $model;
        $this->tax = $tax;
    }
    
    public function rules($update = false) {
        if (!$update) {
            $code = current_locale();
            return [
                $code . '.title' => 'required'
            ];
        }
        return [
            'locale.title' => 'required',
            'lang' => 'required'
        ];
    }

    public function all($type='post', $args = []) {
        $opts = [
            'fields' => ['posts.*', 'pd.*'],
            'status' => 1,
            'orderby' => 'posts.created_at',
            'order' => 'desc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
            'cats' => [],
            'tags' => [],
            'with_cats' => false,
            'with_tags' => false
        ];

        $opts = array_merge($opts, $args);

        $result = $this->model->joinLang();

        if ($opts['cats']) {
            $cat_ids = $this->inCats($opts['cats']);
            $result = $result->join('post_tax as pt', function($join) use ($cat_ids) {
                $join->on('posts.id', '=', 'pt.post_id')
                        ->whereIn('tax_id', $cat_ids);
            });
        }
        if ($opts['tags']) {
            $tag_ids = $opts['tags'];
            $result = $result->join('post_tax as pt', function($join) use ($tag_ids) {
                $join->on('posts.id', '=', 'pt.post_id')
                        ->whereIn('tax_id', $tag_ids);
            });
        }

        $result = $result->where('post_type', $type)
                ->whereNotNull('pd.title')
                ->where('posts.status', $opts['status'])
                ->where('pd.title', 'like', '%' . $opts['key'] . '%')
                ->whereNotIn('posts.id', $opts['exclude'])
                ->select($opts['fields'])
                ->groupBy('posts.id')
                ->orderBy($opts['orderby'], $opts['order']);

        if ($opts['with_cats']) {
            $result->with('cats');
        }
        if ($opts['with_tags']) {
            $result->with('tags');
        }

        if ($opts['per_page'] == -1) {
            $result = $result->get();
        } else {
            $result = $result->paginate($opts['per_page']);
        }
        return $result;
    }

    public function insert($data, $type='post') {
        $this->validator($data, $this->rules());

        $data['author_id'] = auth()->id();
        if (isset($data['time'])) {
            $time = $data['time'];
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($time['year'] . '-' . $time['month'] . '-' . $time['day'] . ' ' . date('H:i:s')));
        }
        if (isset($data['file_ids']) && $data['file_ids']) {
            $data['thumb_id'] = $data['file_ids'][0];
        }
        if (isset($data['gallery_ids']) && $data['gallery_ids']) {
            $data['thumb_ids'] = json_encode($data['gallery_ids']);
        }
        $data['post_type'] = $type;
        $item = $this->model->create($data);

        $langs = get_langs(['fields' => ['id', 'code']]);

        if (isset($data['cat_ids'])) {
            $item->cats()->attach($data['cat_ids']);
            $item->cats()->increment('count');
        }

        if (isset($data['new_tags'])) {
            foreach ($data['new_tags'] as $tag) {
                $newtag = $this->tax->create(['type' => 'tag', 'count' => 1]);
                foreach ($langs as $lang) {
                    $tag_desc = [
                        'name' => $tag,
                        'slug' => str_slug($tag)
                    ];
                    $newtag->langs()->attach($lang->code, $tag_desc);
                }
                $item->tags()->attach($newtag->id);
            }
        }

        if (isset($data['tag_ids'])) {
            $item->tags()->attach($data['tag_ids']);
        }

        foreach ($langs as $lang) {
            $lang_data = $data[$lang->code];
            $title = $lang_data['title'];
            $slug = $lang_data['slug'];

            $lang_data['slug'] = ($slug) ? str_slug($slug) : str_slug($title);

            $item->langs()->attach($lang->code, $lang_data);
        }

        return $item;
    }

    public function findByLang($id, $fields = ['posts.*', 'pd.*'], $lang = null) {
        $item = $this->model->joinLang($lang)
                ->find($id, $fields);
        if ($item) {
            return $item;
        }
        return $this->model->find($id);
    }

    public function update($id, $data) {
        $this->validator($data, $this->rules(true));

        if (isset($data['file_ids']) && $data['file_ids']) {
            $data['thumb_id'] = $data['file_ids'][0];
        }
        if (isset($data['gallery_ids']) && $data['gallery_ids']) {
            $data['thumb_ids'] = json_encode($data['gallery_ids']);
        }
        if (isset($data['time'])) {
            $time = $data['time'];
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($time['year'] . '-' . $time['month'] . '-' . $time['day'] . ' ' . date('H:i:s')));
        }
        $fillable = $this->model->getFillable();
        $fill_data = array_only($data, $fillable);
        $item = $this->model->find($id);
        $item->update($fill_data);

        $old_tags = $item->tags()->lists('id')->toArray();
        $old_cats = $item->cats()->lists('id')->toArray();

        $item->cats()->detach();

        if (isset($data['tag_ids'])) {
            $item->tags()->decrement('count');
            $item->tags()->attach($data['tag_ids']);
            $item->tags()->increment('count');
        } else {
            $item->tags()->attach($old_tags);
        }

        if (isset($data['cat_ids'])) {
            $item->cats()->decrement('count');
            $item->cats()->attach($data['cat_ids']);
            $item->cats()->increment('count');
        } else {
            $item->cats()->attach($old_cats);
        }

        $langs = get_langs(['fields' => ['id', 'code']]);
        if (isset($data['new_tags'])) {
            foreach ($data['new_tags'] as $tag) {
                $newtag = $this->tax->create(['type' => 'tag', 'count' => 1]);
                foreach ($langs as $lang) {
                    $tag_desc = [
                        'name' => $tag,
                        'slug' => str_slug($tag)
                    ];
                    $newtag->langs()->attach($lang->code, $tag_desc);
                }
                $item->tags()->attach($newtag->id);
            }
        }

        $lang_data = $data['locale'];
        $name = $lang_data['title'];
        $slug = $lang_data['slug'];
        $lang_data['slug'] = (trim($slug) == '') ? str_slug($name) : str_slug($slug);

        $item->langs()->sync([$data['lang'] => $lang_data], false);
    }

    public function destroy($ids) {
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        if ($ids) {
            foreach ($ids as $id) {
                $item = $this->model->find($id);
                if ($item) {
                    $item->tags()->decrement('count');
                    $item->cats()->decrement('count');
                    $item->delete();
                }
            }
            return true;
        }
        return false;
    }

    public function inCats($cat_ids){
        $ids = $this->tax->whereIn('parent_id', $cat_ids)->lists('id')->toArray();
        $result = array_merge($cat_ids, $ids);
        if($ids){
            $result = array_unique(array_merge($result, $this->inCats($ids)));
        }
        return $result;
    }
    
}
