{{ Form::open() }}
<div id="photoModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1f648b; color: whitesmoke;">
                <h4 class="modal-title">Change photo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="well">
                    Attach a new photo to upload and replace this users existing photo.
                </div>
                <hr>
                {{ Form::file('photo') }}
            </div>
            <div class="modal-footer">
                {{ Form::submit('Change photo', ['class' => 'btn btn-primary pull-left']) }}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{{ Form::close() }}