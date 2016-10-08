<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Eloquents\MediaEloquent;
use App\Eloquents\TaxEloquent;

class SlideController extends Controller
{
    protected $slide;
    protected $slider;

    public function __construct(MediaEloquent $slide, TaxEloquent $slider) {
        canAccess('manage_cats');
        
        $this->slide = $slide;
        $this->slider = $slider;
    }

    public function index(Request $request) {
        $items = $this->slide->all($request->all());
        $slider_id = $request->has('slider_id') ? $request->get('slider_id') : null;
        return view('manage.slide.index', compact('items', 'slider_id'));
    }

    public function create(Request $request) {
        $slider_id = $request->has('slider_id') ? $request->get('slider_id') : null;
        return view('manage.slide.create', compact('slider_id'));
    }

    public function store(Request $request) {
        
        try {
            $this->slide->insert($request->all(), 'slide'); 
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        } catch (DbException $ex) {
            return redirect()->back()->withInput()->with('error_mess', $ex->getError());
        }
    }

    public function edit($id, Request $request) {
        $lang = current_locale();
        if ($request->has('lang')) {
            $lang = $request->get('lang');
        }
        $item = $this->slide->findByLang($id, ['medias.*', 'md.*'], $lang);
        $slider_id = $request->has('slider_id') ? $request->get('slider_id') : null;
        return view('manage.slide.edit', compact('item', 'slider_id'));
    }

    public function update($id, Request $request) { dd($request->all());
        try {
            $this->slide->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        if (!$this->slide->destroy($id)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        return response()->json($this->slide->actions($request));
    }
}
