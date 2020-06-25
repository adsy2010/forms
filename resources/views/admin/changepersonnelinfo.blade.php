{{ Form::open() }}
<div id="personnelinfoModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1f648b; color: whitesmoke;">
                <h4 class="modal-title">Change personnel data</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="well">
                    Please enter replacement personnel data. Any section left blank will not be changed.
                </div>
                {{ Form::text('NI', null, ['class' => 'form-control']) }}
            </div>
            <div class="modal-footer">
                {{ Form::submit('Change personnel data', ['class' => 'btn btn-primary pull-left']) }}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{{ Form::close() }}