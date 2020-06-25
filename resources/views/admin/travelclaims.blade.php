@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading heading-style">Admin Dashboard</div>
            <div class="panel-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Travel Claims</li>
                    </ol>
                </nav>
                @include('common.errors')
                @include('common.success')
                <div class="well">
                    Travel Claims settings can be set here
                </div>



                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4" align="right">NEW Training miles value: </div>
                            <div class="col-md-6">{{ Form::number('trainingMilesValue', null, ['class' => 'form-control']) }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" align="right">NEW Business miles value: </div>
                            <div class="col-md-6">{{ Form::number('businessMilesValue', null, ['class' => 'form-control']) }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" align="right">Date of change: </div>
                            <div class="col-md-6">{{ Form::date('dateOfChange', now(), ['class' => 'form-control']) }}</div>
                        </div>
                        <hr>
                        {{ Form::submit('Update values', ['class' => 'btn btn-primary']) }}
                    </div>


                    <div class="col-md-4">
                        Training miles current value: 123 set on DATE <br>
                        Business miles current value: 123 set on DATE
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection