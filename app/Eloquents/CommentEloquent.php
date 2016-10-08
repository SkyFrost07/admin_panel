<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use App\Eloquents\UserEloquent;
use Illuminate\Validation\ValidationException;

class CommentEloquent extends BaseEloquent {

    protected $model;
    protected $user;

    public function __construct(\App\Models\Comment $model, UserEloquent $user) {
        $this->model = $model;
        $this->user = $user;
    }

    public function rules($update = false) {
        return [
            'content' => 'required',
            'post_id' => 'required'
        ];
    }

    public function all($args = []) {
        $opts = [
            'fields' => ['*'],
            'status' => 1,
            'orderby' => 'created_at',
            'order' => 'desc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
            'post_id' => null,
            'author_id' => null
        ];
        $opts = array_merge($opts, $args);
        
        $result = $this->model->where('content', 'like', '%' . $opts['key'] . '%')
                ->where('status', $opts['status'])
                ->select($opts['fields'])
                ->orderBy($opts['orderby'], $opts['order']);

        if ($opts['post_id']) {
            $result = $result->where('post_id', $opts['post_id']);
        }

        if ($opts['author_id']) {
            $result = $result->where('author_id', $opts['author_id']);
        }

        if ($opts['per_page'] == -1) {
            $result = $result->get();
        } else {
            $result = $result->paginate($opts['per_page']);
        }
        return $result;
    }

    public function insert($data) {
        $this->validator($data, $this->rules());

        if (isset($data['author_id'])) {
            $author = $this->user->find($data['author_id']);
            if($author){
                $data['author_email'] = $author->email;
                $data['author_name'] = $author->name;
            }
        }else{
            $user = auth()->user();
            $data['author_id'] = $user->id;
            $data['author_email'] = $user->email;
            $data['author_name'] = $user->name;
        }
        if(!isset($data['status'])){
            $data['status'] = 1;
        }
        $data['agent'] = request()->header('User-Agent');
        $data['author_ip'] = request()->ip();
        $item = $this->model->create($data);
        return $item->post()->increment('comment_count');
    }

    public function update($id, $data) {
        $this->validator($data, $this->rules($id));

        if (isset($data['time'])) {
            $time = $data['time'];
            $date = date('Y-m-d', strtotime($time['year'] . '-' . $time['month'] . '-' . $time['day']));
            $data['created_at'] = $date;
        }
        if (isset($data['author_id'])) {
            $author = $this->user->find($data['author_id']);
            if($author){
                $data['author_email'] = $author->email;
                $data['author_name'] = $author->name;
            }
        }
        $fillable = $this->model->getFillable();
        $data = array_only($data, $fillable);
        return $this->model->where('id', $id)->update($data);
    }
    
    public function destroy($ids) {
        if(!is_array($ids)){
            $ids = [$ids];
        }
        if($ids){
            foreach ($ids as $id){
                $item = $this->model->find($id);
                $item->post()->decrement('comment_count');
            }
            return true;
        }
        return parent::destroy($ids);
    }

}
