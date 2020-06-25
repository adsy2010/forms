{{ Form::open() }}
<div id="flagModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1f648b; color: whitesmoke;">
                <h4 class="modal-title">Flag issues</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="well">Please only fill in the relevant boxes before submitting. Only changed information is necessary for this form.</div>
                <div class="row">
                    <div class="col-md-4">{{ Form::label('niNumberchange', 'Wrong NI Number?') }}</div>
                    <div class="col-md-8">{{ Form::text('niNumberchange', null, ['class' => 'form-control', 'placeholder' => 'NI Number i.e AB123456C']) }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4">{{ Form::label('linemanagerchange', 'Line manager not right?') }}</div>
                    <div class="col-md-8">{{ Form::text('linemanagerchange', null, ['class' => 'form-control', 'placeholder' => 'Enter line manager if known otherwise please state unknown']) }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4">{{ Form::label('positionchange', 'Job title not right?') }}</div>
                    <div class="col-md-8">{{ Form::text('positionchange', null, ['class' => 'form-control', 'placeholder' => 'Job title expected']) }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4">{{ Form::label('extensionchange', 'Phone extension not right?') }}</div>
                    <div class="col-md-8">{{ Form::number('extensionchange', null, ['class' => 'form-control', 'placeholder' => 'Your current landline extension number i.e. 110']) }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4">{{ Form::label('emailchange', 'Email address not correct?') }}</div>
                    <div class="col-md-8">{{ Form::email('emailchange', null, ['class' => 'form-control', 'placeholder' => 'Enter expected email address']) }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4">{{ Form::label('namechange', 'Name changing?') }}</div>
                    <div class="col-md-8">{{ Form::text('namechange', null, ['class' => 'form-control', 'placeholder' => 'Enter your new name and date of change']) }}</div>
                </div>

            </div>
            <div class="modal-footer">
                {{ Form::submit('Flag issues', ['class' => 'btn btn-primary pull-left']) }}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{{ Form::close() }}
