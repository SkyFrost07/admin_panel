<div class="modal fade" id="files-modal" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{trans('file.modal_title')}}</h4>
            </div>
            <div class="modal-body">

                <ul class="nav nav-tabs files-tab" role="tablist">
                    <li class="nav-item"><a class="active nav-link tab-upload-files" href="#upload-files-tab" role="tab" data-toggle="tab">{{trans('file.upload')}}</a></li>
                    <li class="nav-item"><a class="nav-link tab-select-files" href="#select-files-tab" role="tab" data-toggle="tab">{{trans('file.select_files')}}</a></li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="upload-files-tab">
                        {!! Form::open(['method' => 'post', 'route' => 'file.store', 'files' => true]) !!}
                        <div class="form-group">
                            <button type="button" class="btn-choose-files btn btn-default">
                                <i class="fa fa-upload"></i> {{trans('manage.choose_files')}}
                                {!! Form::file('files[]', ['id' => "files-input", 'multiple']) !!}
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div role="tabpanel" class="tab-pane" id="select-files-tab">
                        <ul class="list-inline files-list">

                        </ul>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <span class="btn btn-default"><span class="num_selected">0</span> {{trans('file.is_selected')}}</span>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> {{trans('file.close')}}</button>
                <button type="button" class="btn btn-primary btn-submit-files"><i class="fa fa-check"></i> {{trans('file.submit_selected')}}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    var current_locale = "{{current_locale()}}";
    var _all_files_url = "{{route('ajax_action')}}";
    var text_has_selected = "{{trans('manage.has_selected')}}";
</script>
<script src="/js/filemanager.js"></script>

