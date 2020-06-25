{{ Form::open() }}
<div id="linemanagerModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1f648b; color: whitesmoke;">
                <h4 class="modal-title">Change line manager</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div>Select a new line manager from the list of all users.</div>
                {{ Form::select('linemanager',[1,2,3],null) }}
            </div>
            <div class="modal-footer">
                {{ Form::submit('Change line manager', ['class' => 'btn btn-primary pull-left']) }}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{{ Form::close() }}
