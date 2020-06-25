@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card panel-default">
            <div class="card-heading p-2 heading-style">My Details</div>
            <div class="card-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Details</li>
                    </ol>
                </nav>
                @include('common.errors')
                @include('common.success')
                <div class="well">
                    This is your personnel and user information for the
                    Mountbatten Services system. If any details do not appear to be correct,
                    please flag them by using the "Flag a problem button"
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="thumbnail">
                            <br>
                            <img class="mx-auto d-block rounded-circle" src="{{ file_exists(storage_path("app/public/images/staff/".strtoupper(Auth::user()->uid).".jpg")) ? "/files/images/staff/".Auth::user()->uid.".jpg" : '/images/staff/placeholder.png' }}" alt="...">
                            <br><div class="caption">
                                <h3 class="text-center">{{ Auth::user()->FirstName }} {{ Auth::user()->LastName }}</h3>
                                <table class="" style="margin: 0 auto; width: 300px;">
                                    @if(!empty(Auth::user()->personneldetails))
                                        <tr><td>Personnel Number</td><td align="right">{{ Auth::user()->personneldetails->personnelNumber }}</td></tr>
                                        <tr><td>National Insurance Number</td><td align="right">{{ Auth::user()->personneldetails->niNumber }}</td></tr>
                                    @endif
                                    @if(!empty(Auth::user()->linemanager))
                                        <tr><td>Line Manager</td><td align="right">{{ Auth::user()->linemanager->manager->FirstName }} {{ Auth::user()->linemanager->manager->LastName }}</td></tr>
                                    @endif
                                    @if(!empty(Auth::user()->staffdetails))
                                        <tr><td>Position</td><td align="right">{{ Auth::user()->staffdetails->position }}</td></tr>
                                        <tr><td>Extension</td><td align="right">{{ Auth::user()->staffdetails->extension }}</td></tr>
                                    @endif

                                </table>
                                <hr>

                                <div class="row">
                                    {{ Form::model(Auth::user()) }}
                                    <div class="col-md-6">{{ Form::label('FirstName', 'First Name') }} {{ Form::text('FirstName', null, ['class' => 'form-control', 'disabled' => 'disabled']) }}</div>
                                    <div class="col-md-6">{{ Form::label('LastName', 'Last Name') }} {{ Form::text('LastName', null, ['class' => 'form-control', 'disabled' => 'disabled']) }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        {{ Form::label('email', 'Email address') }}
                                        {{ Form::text('email', null, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div data-toggle="modal" data-target="#flagModal" class="btn btn-danger"><span class="glyphicon glyphicon-flag"></span> Flag a problem</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
            </div>
        </div>
    </div>
    @include('user.flagaproblem')
@endsection