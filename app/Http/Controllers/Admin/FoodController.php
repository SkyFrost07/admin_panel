<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\FoodEloquent;
use Illuminate\Validation\ValidationException;

class FoodController extends Controller
{
    protected $food;

    public function __construct(FoodEloquent $food) {
        $this->food = $food;
    }

    public function index(Request $request) {
        $items = $this->food->all($request->all());
        return view('manage.food.index', ['items' => $items]);
    }

    public function create() {
        canAccess('publish_posts');

        return view('manage.food.create');
    }

    public function store(Request $request) {
        canAccess('publish_posts');

        try {
            $this->food->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        } catch (DbException $ex) {
            return redirect()->back()->withInput()->with('error_mess', $ex->getError());
        }
    }

    public function edit($id, Request $request) {
        canAccess('edit_my_post', $this->food->get_author_id($id));

        $lang = current_locale();
        if($request->has('lang')){
            $lang = $request->get('lang');
        }
        $item = $this->food->findByLang($id, ['posts.*', 'pd.*'], $lang);
        return view('manage.food.edit', compact('item', 'lang'));
    }

    public function update($id, Request $request) {
        try {
            $this->food->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        if (!$this->food->changeStatus($id, 0)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        if(!cando('remove_other_posts')){
            return respons()->json(false);
        }
        return response()->json($this->food->actions($request));
    }
}
