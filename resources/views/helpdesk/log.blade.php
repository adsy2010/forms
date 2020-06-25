{{ Form::open(['url' => Route('helpdesk.log', ['desk' => $calls->id])]) }}
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1f648b; color: whitesmoke;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Log a call</h4>
            </div>
            <div class="modal-body">

                {{ Form::label('location', 'Location') }}
                {{ Form::text('location', null, ['class' => 'form-control', 'placeholder' => 'Location']) }}
                <hr>
                {{ Form::label('content', 'Call content') }}
                {{ Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Support request information...']) }}

            </div>
            <div class="modal-footer">
                {{ Form::submit('Log call', ['class' => 'btn btn-primary pull-left']) }}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{{ Form::close() }}
