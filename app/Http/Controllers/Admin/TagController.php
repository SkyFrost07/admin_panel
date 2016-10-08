<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Eloquents\TaxEloquent;

class TagController extends Controller
{
    protected $tag;

    public function __construct(TaxEloquent $tag) {
        canAccess('manage_tags');

        $this->tag = $tag;
    }

    public function index(Request $request) {
        $data = $request->all();
        $tags = $this->tag->all('tag', $data);
        return view('manage.tag.index', ['items' => $tags]);
    }

    public function create() {
        return view('manage.tag.create');
    }

    public function store(Request $request) {
        try {
            $this->tag->insert($request->all(), 'tag');
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        } catch (DbException $ex) {
            return redirect()->back()->withInput()->with('error_mess', $ex->getMess());
        }
    }

    public function edit($id, Request $request) {
        $lang = current_locale();
        if($request->has('lang')){
            $lang = $request->get('lang');
        }
        $item = $this->tag->findByLang($id, ['taxs.*', 'td.*'], $lang);
        return view('manage.tag.edit', compact('item', 'lang'));
    }

    public function update($id, Request $request) {
        try {
            $this->tag->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        if (!$this->tag->destroy($id)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        return response()->json($this->tag->actions($request));
    }
}
