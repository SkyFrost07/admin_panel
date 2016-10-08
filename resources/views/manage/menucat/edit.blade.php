@extends('layouts.manage')

@section('title', trans('manage.man_menucats'))

@section('page_title', trans('manage.edit'))

@section('bodyAttrs', 'ng-app="ngMenu" ng-controller="MenuCtrl"')

@section('content')

{!! show_messes() !!}

@if($item)

@include('manage.parts.lang_edit_tabs', ['route' => 'menucat.edit'])

{!! Form::open(['method' => 'put', 'route' => ['menucat.update', $item->id], 'ng-submit' => 'updateOrder($event)']) !!}

<div class="row">
    <div class="col-sm-4">

        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('locale[name]', $item->name, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('locale.name') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.slug')}}</label>
            {!! Form::text('locale[slug]', $item->slug, ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
        </div>

        <input type="hidden" name="lang" value="{{$lang}}">
        {!! error_field('lang') !!}


        <div class="panel-group list_types" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#page_type" aria-expanded="true" aria-controls="collapseOne">
                            {{trans('manage.pages')}}
                        </a>
                    </h4>
                </div>
                <div id="page_type" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="max-mdh" ng-if="pages.length > 0">
                            <div ng-repeat="page in pages"><label><input type="checkbox" ng-click="addMenu(page, 2)"> {% page.title %}</label></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#cat_type" aria-expanded="false" aria-controls="collapseTwo">
                            {{trans('manage.category')}}
                        </a>
                    </h4>
                </div>
                <div id="cat_type" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <div class="max-mdh" ng-if="cats.length > 0">
                            <div ng-repeat="cat in cats"><label><input type="checkbox" ng-click="addMenu(cat, 3)"> {% cat.name %}</label></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#post_type" aria-expanded="false" aria-controls="collapseThree">
                            {{trans('manage.posts')}}
                        </a>
                    </h4>
                </div>
                <div id="post_type" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <div class="max-mdh" ng-if="posts.length > 0">
                            <div ng-repeat="post in posts"><label><input type="checkbox" ng-click="addMenu(post, 1)"> {% post.title %}</label></div>
                        </div>
                    </div>
                    
                    <div class="paginate">
                        <ul class="pager pagination-sm" ng-if="post_total > post_last_page">
                            <li><a href="javascript:void(0)" ng-click="postGoUrl(post_prev_page_url)"><i class="fa fa-arrow-left"></i> {{trans('manage.previous')}}</a></li>
                            <li><a href="javascript:void(0)" ng-click="postGoUrl(post_next_page_url)">{{trans('manage.next')}} <i class="fa fa-arrow-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#custom_type" aria-expanded="false" aria-controls="collapseThree">
                            {{trans('manage.custom')}}
                        </a>
                    </h4>
                </div>
                <div id="custom_type" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <div class="form-group">
                            <label>{{trans('manage.title')}}</label>
                            <input type="text" ng-model="newcustom.title" class="form-control" placeholder="{{trans('manage.title')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('manage.url')}}</label>
                            <input type="text" ng-model="newcustom.link" class="form-control" placeholder="http://">
                        </div>
                    </div>
                </div>
            </div>

            <br />
            <button type="button" ng-click="createMenus()" class="btn btn-primary btn-sm btn-add-menu"><i class="fa fa-plus"></i> {{trans('manage.add_to_menu')}}</button>
        </div>

    </div>

    <div class="col-sm-6">

        <h3 class="box-title"><label>{{trans('manage.list_menus')}}</label></h3>

        <script type="text/ng-template" id="items_renderer.html">
            <div class="mi-inner">
                <div ui-nested-sortable-handle class="handle">
                    {% item.title %}
                </div>
                <div class="">
                    <div class="btn-edit">
                        <span class="title">{% item.menu_type | menutype %}</span>
                        <a href="#mi-content-{% item.id %}" role="button" data-toggle="collapse" data-parent="#menus_sortable" aria-expanded="true" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" ng-click="removeMenu(item)" ng-confirm="{{trans('manage.remove')}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    </div>
                    <div class="collapse mi-content" role="tabpanel" id="mi-content-{% item.id %}">
                        <div class="form-group">
                            <label>{{trans('manage.target')}}: </label> <span ng-menu-target="{% item.id %}"></span>
                        </div>
                        <div class="form-group">
                            <label>{{trans('manage.title')}}</label>
                            <input type="text" name="menus[{% item.id %}][locale][title]" value="{% item.title %}" class="form-control item-title">
                        </div>
                        <div class="form-group" ng-if="item.menu_type==0">
                            <label>{{trans('manage.url')}}</label>
                            <input type="text" name="menus[{% item.id %}][locale][link]" value="{% item.link %}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('manage.open_type') }}</label>
                            <select name="menus[{% item.id %}][open_type]" class="form-control">
                                <option ng-selected="item.open_type==''" value=" ">{{trans('manage.current_tab')}}</option>
                                <option ng-selected="item.open_type=='_blank'" value="_blank">{{trans('manage.new_tab')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{trans('manage.icon')}}</label>
                            <input type="text" name="menus[{% item.id %}][icon]" value="{% item.icon %}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('manage.status') }}</label>
                            <select name="menus[{% item.id %}][status]" class="form-control">
                                <option ng-selected="item.status==1" value="1">{{trans('manage.active')}}</option>
                                <option ng-selected="item.status==0" value="0">{{trans('manage.disable')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <ol ui-nested-sortable="options" ng-model="item.childs">
              <li class="menu-item" ng-repeat="item in item.childs" ui-nested-sortable-item="" ng-include="'items_renderer.html'">
              </li>
            </ol>
        </script>

        <div class="panel-group">
            <ol ui-nested-sortable="options" ng-model="menus" id="menus_sortable">
                <li class="menu-item" ng-repeat="item in menus" ui-nested-sortable-item="" ng-include="'items_renderer.html'"></li>
            </ol>
        </div>

        <br />
        <div class="form-group">
            <a href="{{route('menucat.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>
        </div>
    </div>
</div>

{!! Form::close() !!}

@else
<p>{{trans('manage.no_item')}}</p>
@endif

@stop

@section('foot')

<script src="/plugins/angular/angular.min.js"></script>
<script src="/plugins/angular/angular-nestedSortable.js"></script>
<script src="/admin_src/js/menu.js"></script>
<script>

    var group_id = '<?php echo ($item) ? $item->id : 0; ?>';
    var menu_nested_url = '<?php echo route('menucat.to_nested', ['group_id' => ($item) ? $item->id : -1]); ?>';
    var menu_type_url = '<?php echo route('menu.get_type') ?>';
    var store_items_url = '<?php echo route('menucat.store_items') ?>';
    var order_items_url = '<?php echo route('menucat.update_order_items') ?>';
    var api_url = '<?php echo route('dashboard') . '/api/'; ?>';
    var menu_type = <?php echo json_encode(list_menu_types()); ?>;
    var _lang = '<?php echo $lang; ?>';
    var remove_item_url = '<?php echo route('menu.asyn_destroy'); ?>';

</script>

@stop

