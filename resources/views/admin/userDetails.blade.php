@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">
                    <div class="card-heading p-2 heading-style">{{ $user->uid }} details</div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ Route('admin.users.view') }}">Users List</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $user->uid }} details</li>
                            </ol>
                        </nav>
                        @include('common.errors')
                        @include('common.success')
                        <div class="well">
                            Your user information summary is below. If you believe any information is
                            incorrect please flag the user and add notes for any details that
                            cannot be changed as some details are centrally managed on a different system.
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="thumbnail">
                                    <br>
                                    <img class="mx-auto d-block rounded-circle" src="{{ file_exists("images/staff/".strtoupper($user->uid).".jpg")? "/images/staff/{$user->uid}.jpg" : '/images/staff/placeholder.png' }}" alt="...">
                                    <br><div class="caption">
                                        <h3 class="text-center">{{ $user->FirstName }} {{ $user->LastName }}</h3>
                                        <table class="" style="margin: 0 auto; width: 300px;">
                                            @if(!empty($user->personneldetails))
                                                <tr><td>Personnel Number</td><td align="right">{{ $user->personneldetails->personnelNumber }}</td></tr>
                                                <tr><td>National Insurance Number</td><td align="right">{{ $user->personneldetails->niNumber }}</td></tr>
                                            @endif
                                            @if(!empty($user->linemanager))
                                                <tr><td>Line Manager</td><td align="right">{{ $user->linemanager->manager->FirstName }} {{ $user->linemanager->manager->LastName }}</td></tr>
                                            @endif
                                            @if(!empty($user->staffdetails))
                                                    <tr><td>Position</td><td align="right">{{ $user->staffdetails->position }}</td></tr>
                                                    <tr><td>Extension</td><td align="right">{{ $user->staffdetails->extension }}</td></tr>
                                            @endif

                                        </table>
                                        <hr>

                                        <div class="row">
                                            {{ Form::model($user) }}
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
                                                <div data-toggle="modal" data-target="#linemanagerModal" style="margin-top:14px;" class="btn btn-warning"><span class="glyphicon glyphicon-pawn"></span> Change Line Manager</div>
                                                <div data-toggle="modal" data-target="#photoModal" style="margin-top:14px;" class="btn btn-warning"><span class="glyphicon glyphicon-camera"></span> Change photo</div>
                                                <div data-toggle="modal" data-target="#personnelinfoModal" style="margin-top:14px;" class="btn btn-warning"><span class="glyphicon glyphicon-credit-card"></span> Change personnel info</div>
                                                <div data-toggle="modal" data-target="#flagModal" style="margin-top:14px;" class="btn btn-danger"><span class="glyphicon glyphicon-flag"></span> Flag user</div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>



                        <br>
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>AD Group</th>
                                <th>Last change</th>
                            </tr>
                            @if(array() <=0 )
                                <tr><td colspan="5">No users in the database.</td></tr>
                            @endif
                            @foreach($user->groupmemberships as $s)
                                <tr class="clickable-row" data-href="{{ Route('admin.group.view', $s->groupInfo->id) }}">
                                    <td>{{ $s->id }}</td>
                                    <td>{{ $s->groupInfo->name }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$s->updated_at)->format('H:i \o\n jS F Y') }}</td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                    <div class="card-footer">This user is part of {{ $user->groupmemberships->count() }} active directory groups.</div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.changelinemanager')
    @include('admin.changepersonnelinfo')
    @include('admin.changephoto')
@endsection