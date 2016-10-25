<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Eloquents\TaxEloquent;
use Illuminate\Validation\ValidationException;
use App\Exceptions\DbException;
use DB;

class CatController extends Controller {

    protected $cat;
    protected $locale;

    public function __construct(TaxEloquent $cat) {
        canAccess('manage_cats');

        $this->cat = $cat;
        $this->locale = current_locale();
    }

    public function index(Request $request) {
        $cats = $this->cat->all('cat', $request->all()); 
        $tableCats = $this->cat->tableCats($cats); 
        return view('manage.cat.index', ['items' => $cats, 'tableCats' => $tableCats]);
    }

    public function create() {
        $parents = $this->cat->all('cat', [
            'fields' => ['taxs.id', 'taxs.parent_id', 'td.name'],
            'per_page' => -1,
            'orderby' => 'td.name'
        ]);
        return view('manage.cat.create', ['parents' => $parents, 'lang' => $this->locale]);
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $this->cat->insert($request->all(), 'cat');
            DB::commit();
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        } catch (DbException $ex) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error_mess', $ex->getMess());
        }
    }

    public function edit($id, Request $request) {
        $lang = current_locale();
        if($request->has('lang')){
            $lang = $request->get('lang');
        }
        $item = $this->cat->findByLang($id, ['taxs.*', 'td.*'], $lang);
        $parents = $this->cat->all([
            'fields' => ['taxs.id', 'taxs.parent_id', 'td.name'],
            'exclude' => [$id],
            'per_page' => -1,
            'orderby' => 'td.name'
        ]);
        return view('manage.cat.edit', compact('lang', 'item', 'parents'));
    }

    public function update($id, Request $request) {
        try {
            $this->cat->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        if (!$this->cat->destroy($id)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) { dd($request->all());
        return response()->json($this->cat->actions($request));
    }

}
