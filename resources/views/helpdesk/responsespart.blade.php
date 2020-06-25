<hr>
<div class="row">
    <div class="col-md-10 col-sm-10 col-xs-8">{{ Form::text('respond',null, ['placeholder' => 'Enter a response...', 'class' => 'form-control']) }}</div>
    <div class="col-md-2 col-sm-2 col-xs-2">{{ Form::submit('Respond', ['class' => 'btn btn-primary']) }}</div>
</div>
<hr>
<div class="alert alert-info" style="background-color: #1f648b; color: whitesmoke;"> No responses</div>