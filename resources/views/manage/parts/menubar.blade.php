<?php

function nested_admenus($items, $depth = 0) {
    $html = '<ul class="' . (($depth == 0) ? 'navbar-menu' : 'sub-menu') . '">';
    foreach ($items as $item) {
        if (cando($item['cap'])) {
            $route_params = (isset($item['route_params'])) ? $item['route_params'] : [];
            $has_childs = (isset($item['childs']) && $item['childs']);
            $html .= '<li class="' . isSubActive($item['route']) . ' '.($has_childs ? 'has-sub' : '').'">';
            $html .= '<a href="' . route($item['route'], $route_params) . '" title="'.$item['name'].'"><i class="fa ' . (isset($item['icon']) ? $item['icon'] : 'fa-circle') . '"></i> <span>' . $item['name'] . '</span> ' . ($has_childs ? '<b></b>' : '') . '</a>';
            if ($has_childs) {
                $html .= nested_admenus($item['childs'], $depth + 1);
            }
            $html .= '</li>';
        }
    }
    $html .= '</ul>';

    return $html;
}
?>

<div class="collapse navbar-toggleable-sm" id="menu_bar">
    {!! nested_admenus($admenus) !!}
</div>