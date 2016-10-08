<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Eloquents\PostTypeEloquent;
use Illuminate\Validation\ValidationException;
use App\Exceptions\DbException;
use File;

class PageController extends Controller
{
    protected $page;
    protected $templates = [];

    public function __construct(PostTypeEloquent $page) {
        $this->page = $page;
        $this->templates = ['' => trans('manage.selection')];
        
        $view_path = config('view.paths')[0].'\front\templates';
        $files = File::files($view_path);
        foreach ($files as $file){
            $name = explode('.', basename($file))[0];
            $this->templates[$name] = $name;
        }
    }

    public function index(Request $request) {
        $items = $this->page->all('page', $request->all());
        return view('manage.page.index', ['items' => $items]);
    }

    public function create() {
        canAccess('publish_posts');

        return view('manage.page.create', ['templates' => $this->templates]);
    }

    public function store(Request $request) {
        canAccess('publish_posts');

        try {
            $this->page->insert($request->all(), 'page');
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        } catch (DbException $ex) {
            return redirect()->back()->withInput()->with('error_mess', $ex->getError());
        }
    }

    public function edit($id, Request $request) {
        canAccess('edit_my_post', $this->page->get_author_id($id));

        $lang = current_locale();
        if($request->has('lang')){
            $lang = $request->get('lang');
        }
        $item = $this->page->findByLang($id, ['posts.*', 'pd.*'], $lang);
        $templates = $this->templates;
        return view('manage.page.edit', compact('item', 'templates', 'lang'));
    }

    public function update($id, Request $request) {
        try {
            $this->page->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        if (!$this->page->changeStatus($id, 0)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        if(!cando('remove_other_posts')){
            return respons()->json(false);
        }
        return response()->json($this->page->actions($request));
    }
}
