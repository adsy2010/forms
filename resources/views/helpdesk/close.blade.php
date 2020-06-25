{{ Form::open() }}
<div id="closeModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1f648b; color: whitesmoke;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Close call</h4>
            </div>
            <div class="modal-body">
                Close reason
                <hr>
                Create a dropdown here
            </div>
            <div class="modal-footer">
                {{ Form::submit('Close call', ['class' => 'btn btn-danger pull-left']) }}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{{ Form::close() }}
