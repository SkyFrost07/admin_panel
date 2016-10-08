<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;

class AdminController extends Controller
{
    public function __construct() {
        canAccess('accept_manage');
    }
    
    public function index(){
        return view('manage.dashboard');
    }
    
    public function ajaxAction(Request $request){
        $valid = Validator::make($request->all(), [
            'action' => 'required'
        ]);
        if($valid->fails()){
            return ['success' => 0];
        }
        $action = $request->get('action');
        
        switch ($action){
            case 'toggle':
                $is_toggle = $request->has('is_toggle') ? $request->get('is_toggle') : 0;
                Session::put('is_toggle', $is_toggle);
        }
    }
}
