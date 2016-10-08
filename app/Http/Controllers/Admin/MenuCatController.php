<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\MenuEloquent;
use App\Eloquents\TaxEloquent;
use Illuminate\Validation\ValidationException;

class MenuCatController extends Controller {

    protected $menucat;
    protected $menu;
    protected $post;
    protected $page;
    protected $cat;

    public function __construct(TaxEloquent $menucat, MenuEloquent $menu) {
        canAccess('manage_menus');

        $this->menucat = $menucat;
        $this->menu = $menu;
    }

    public function index(Request $request) {
        $data = $request->all();
        $menucats = $this->menucat->all('menucat', $data);
        return view('manage.menucat.index', ['items' => $menucats]);
    }

    public function create() {
        return view('manage.menucat.create');
    }

    public function store(Request $request) {
        try {
            $this->menucat->insert($request->all(), 'menucat');
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        } catch (DbException $ex) {
            return redirect()->back()->withInput()->with('error_mess', $ex->getMess());
        }
    }
    
    public function storeItems(Request $request){
        $menu_items = $request->get('menuItems');
        if($menu_items){
            foreach ($menu_items as $item){ 
                $item = (array) $item;
                $item['group_id'] = $request->get('group_id');
                $item['type_id'] = isset($item['id']) ? $item['id'] : 0;
                $item['lang'] = $request->has('lang') ? $request->get('lang') : current_locale();
                $this->menu->insert($item);
            }
        }
        if($request->wantsJson() || $request->ajax()){
            return response()->json(['success' => true]);
        }
        return true;
    }

    public function edit($id, Request $request) {
        
        $lang = current_locale();
        if ($request->has('lang')) {
            $lang = $request->get('lang');
        }
        $item = $this->menucat->findByLang($id, ['taxs.id', 'td.slug', 'td.name'], $lang);
        return view('manage.menucat.edit', compact('item', 'lang'));
    }

    public function update($id, Request $request) {     
        try {
            $this->menucat->update($id, $request->all());
            
            $menus = $request->get('menus');
            if($menus){
                foreach ($menus as $menu_id => $menu){
                    $menu = (array) $menu;
                    $menu['lang'] = $request->get('lang');
                    $this->menu->update($menu_id, $menu);
                }
            }
            
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function updateOrderItems(Request $request){
        $menus = $request->get('menus'); 
        if($menus){
            $this->nestedOrderUpdate($menus);
        }
        return response()->json(trans('manage.update_success'));
    }
    
    public function nestedOrderUpdate($items, $parent=0){
        foreach ($items as $key => $item){
            $this->menu->updateOrder($item['id'], $key, $parent);
            if(count($item['childs']) > 0){
                $this->nestedOrderUpdate($item['childs'], $item['id']);
            }
        }
    }
    
    public function destroy($id) {
        if (!$this->menucat->destroy($id)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        return response()->json($this->menucat->actions($request));
    }

    public function getNestedMenus(Request $request) {
        $menus = $this->menu->all($request->all());
        $nested = $this->menucat->toNested($menus);
        return $nested;
    }

}
