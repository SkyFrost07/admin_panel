<?php

function cando() {
    $args = func_get_args();
    return call_user_func_array(['Access', 'can'], $args);
}

function canAccess() {
    $args = func_get_args();
    return call_user_func_array(['Access', 'check'], $args);
}

function show_messes($txt_class = null, $box_class = null) {
    $result = '';
    if (Session::has('errors')) {
        $result = '<div class="alert alert-warning alert-dismissible border_box ' . $box_class . '">'
                . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                . '<div class="error_mess ' . $txt_class . '">' . trans('error.error_occurred') . '</div></div>';
    }
    if (Session::has('error_mess')) {
        $result = '<div class="alert alert-warning alert-dismissible border_box ' . $box_class . '">'
                . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                . '<div class="error_mess ' . $txt_class . '">' . Session::get('error_mess') . '</div></div>';
        Session::forget('error_mess');
    }
    if (Session::has('succ_mess')) {
        $result = '<div class="alert alert-success alert-dismissible border_box ' . $box_class . '">'
                . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                . '<div class="succ_mess ' . $txt_class . '">' . Session::get('succ_mess') . '</div></div>';
        Session::forget('succ_mess');
    }
    return $result;
}

/**
 * 
 * @param type $field field name
 * @param type $errors array errors
 * @return type
 */
function error_field($field) {
    $errors = Session::get('errors');
    if (count($errors) > 0) {
        if ($errors->has($field)) {
            return '<div class="help-block alert alert-danger">' . $errors->first($field) . '</div>';
        }
    }
    return '';
}

/*
 * 
 */
function validate_messes(){
   $errors = Session::get('errors');
   $resutl = '';
   if(count($errors) > 0){
       $resutl .= '<div class="error_messes">';
       foreach ($errors->all() as $err){
           $resutl .= '<div class="alert alert-danger">'.$err.'</div>';
       }
       $resutl .= '</div>';
   }
   return $resutl;
}

/**
 * 
 * @param type $length
 * @param type $model
 * @return type
 */
function makeToken($length = 17, $model = null) {
    $str = str_random($length);
    if ($model) {
        $token = $model->where('resetPasswdToken', $str)->first();
        if ($token) {
            $str = makeToken($length, $model);
        }
    }
    return $str;
}

function link_order($orderby) {
    $request = request();
    $route = $request->route()->getName();
    $order = 'asc';
    if ($request->has('order')) {
        if ($request->has('orderby')) {
            $c_orderby = $request->get('orderby');
            if ($c_orderby == $orderby) {
                $order = ($request->get('order') == 'asc') ? 'desc' : 'asc';
            }
        }
    }
    $args = array_merge($request->all(), ['orderby' => $orderby, 'order' => $order]);
    echo '<a href="' . route($route, $args) . '"><i class="fa fa-sort"></i></a>';
}

function selected($current, $values, $echo = true, $selected = "checked") {
    $result = false;
    if ($values) {
        if (is_object($values)) {
            foreach ($values as $item) {
                if ($item->id == $current) {
                    $result = true;
                    break;
                }
            }
        } elseif (is_array($values)) {
            if (in_array($current, $values)) {
                $result = true;
            }
        } else {
            if ($current == $values) {
                $result = true;
            }
        }
    }
    if ($result) {
        if ($echo)
            echo $selected;
        else
            return true;
    }else {
        return false;
    }
}

function isActive($route, $status = null, $active = 'active') {
    $request = request();
    $current_route = $request->route()->getName();
    if ($route == $current_route) {
        if ($request->has('status')) {
            $current_status = $request->get('status');
            if ($status == $current_status) {
                return $active;
            }
            return null;
        }
        return $active;
    }
    return null;
}

function isSubActive($route, $active = 'active') {
    if(Request::route()->getName() == $route || Request::is(trim(route($route, [], false).'/*', '\/'))){
        return $active;
    }
    return null;
}

function nested_option($items, $selected = 0, $parent = 0, $depth = 0) {
    $html = '';
    $intent = str_repeat('-- ', $depth);
    if (!is_array($selected)) {
        $selected = [$selected];
    }
    if ($items) {
        foreach ($items as $item) {
            if ($item->parent_id == $parent) {
                $select = in_array($item->id, $selected) ? 'selected' : '';
                $html .= '<option value="' . $item->id . '" ' . $select . '>' . $intent . $item->name . '</option>';
                $html .= nested_option($items, $selected, $item->id, $depth + 1);
            }
        }
    }
    return $html;
}

function list_menu_types() {
    return [
        0 => trans('menu.custom'),
        1 => trans('menu.post'),
        2 => trans('menu.page'),
        3 => trans('menu.cat'),
        4 => trans('menu.tag'),
        5 => trans('menu.service')
    ];
}

function makeRandDir($length = 16, $model) {
    $dir = str_random($length);
    $item = $model->where('rand_dir', $dir)->first();
    if ($item) {
        $dir = makeRandDir($length, $model);
    }
    return $dir;
}

function range_options($min, $max, $selected = 0) {
    $html = '';
    for ($i = $min; $i <= $max; $i++) {
        $select = ($i == $selected) ? 'selected' : '';
        $html .= '<option value="' . $i . '" ' . $select . '>' . $i . '</option>';
    }
    return $html;
}

function cat_check_lists($items, $checked = [], $parent = 0, $depth = 0) {
    $html = '';
    $intent = str_repeat("--- ", $depth);
    foreach ($items as $item) {
        if ($item->parent_id == $parent) {
            $check = in_array($item->id, $checked) ? 'checked' : '';
            $html .= '<li>' . $intent . '<label><input type="checkbox" name="cat_ids[]" ' . $check . ' value="' . $item->id . '"> ' . $item->name . '</label></li>';
            $html .= cat_check_lists($items, $checked, $item->id, $depth + 1);
        }
    }
    return $html;
}

function cutImgPath($full_url) {
    $path = parse_url($full_url)['path'];
    $img_path = $full_url;
    if ($path) {
        $arr_path = explode('/', trim($path, '/'));
        unset($arr_path[0]);
        unset($arr_path[1]);
        $img_path = implode('/', $arr_path);
    }
    return $img_path;
}

function getImageSrc($img_path, $size = 'full') {
    $img_path = trim($img_path, '/');
    $sizes = ['thumbnail', 'medium', 'large', 'full'];
    if (!in_array($size, $sizes)) {
        $size = 'full';
    }
    $url = 'uploads/' . $size . '/' . $img_path;
    if (File::exists(trim($url))) {
        return '/' . $url;
    }
    if (File::exists('uploads/full/' . $img_path)) {
        return '/uploads/full/' . $img_path;
    }
    return '/uploads/' . $size . '/no-image.jpg';
}

function strip_all_tags($string, $remove_breaks = false) {
    $string = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $string);
    $string = strip_tags($string);

    if ($remove_breaks)
        $string = preg_replace('/[\r\n\t ]+/', ' ', $string);

    return trim($string);
}

function trim_words( $text, $num_words = 55, $more = null ) {
	if ( null === $more ) {
		$more = __( '&hellip;' );
	}

	$original_text = $text;
	$text = strip_all_tags( $text );

//	if ( strpos( _x( 'words', 'Word count type. Do not translate!' ), 'characters' ) === 0 && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
//		$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
//		preg_match_all( '/./u', $text, $words_array );
//		$words_array = array_slice( $words_array[0], 0, $num_words + 1 );
//		$sep = '';
//	} else {
		$words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
		$sep = ' ';
//	}

	if ( count( $words_array ) > $num_words ) {
		array_pop( $words_array );
		$text = implode( $sep, $words_array );
		$text = $text . $more;
	} else {
		$text = implode( $sep, $words_array );
	}
        
        return $text;
}
