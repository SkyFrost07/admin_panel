<div class="modal fade" id="files_modal" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document" style="width: 93%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{trans('file.modal_title')}}</h4>
            </div>
            <div class="modal-body" style="padding: 0;">
                <iframe id="files-frame" src="" style="width: 100%; min-height: 65vh; overflow: auto;" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('file.close')}}</button>
                <button type="button" class="btn btn-primary"><i class="fa fa-check"></i> {{trans('file.submit_selected')}}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
                    var current_locale = '<?php echo current_locale(); ?>';
</script>


