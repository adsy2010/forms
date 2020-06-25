@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card panel-default">
                    <div class="card-heading p-2 heading-style">User Sessions</div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">User Sessions</li>
                            </ol>
                        </nav>
                        @include('common.errors')
                        @include('common.success')
                        {!! Form::open(['url' => Route('admin.sessions.create')]) !!}
                        <div id="sessioncreateform">
                            <div class="form-group">
                                <div class="col-md-2">{{ Form::label('username') }}</div>
                                <div class="col-md-10">{{ Form::text('username', null, ['class' => 'form-control']) }}</div>


                            </div>
                            <div class="form-group">
                                <div class="col-md-2">{{ Form::label('token') }}</div>
                                <div class="col-md-10">{{ Form::text('token', null, ['class' => 'form-control']) }}</div>
                            </div>
                            {{ Form::submit('Create Custom Token!',  ['class' => 'btn btn-primary']) }}
                        </div>
                        {!! Form::close() !!}
                        <hr>
                        <div class="well">
                            All user sessions are created and used almost instantly under regular use.
                            Occasionally sessions may be left behind or a login link may be needed.
                            Use this page for this.
                        </div>
                        <a class="btn btn-danger" href="{{ Route('admin.sessions.purge') }}">Purge unused sessions</a>
                        <br>
                        <br>
                        <table class="table table-responsive">
                            <tr>
                                <th>#</th>
                                <th>UID</th>
                                <th>Token</th>
                                <th>Created</th>
                                <th>Token link</th>
                            </tr>
                            @if($usersession->count() <=0 )
                                <tr><td colspan="5">No sessions in the database.</td></tr>
                            @endif
                            @foreach($usersession as $s)
                                <tr>
                                    <td>{{ $s->id }}</td>
                                    <td>{{ $s->uid }}</td>
                                    <td>{{ $s->token }}</td>
                                    <td>{{ $s->created_at }}</td>
                                    <td><a href="{{ Route('authorise.token', ['user' => $s->uid, 'token' => $s->token]) }}">{{ Route('authorise.token', ['user' => $s->uid, 'token' => $s->token]) }}</a></td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $usersession->links() }}
                    </div>
                    <div class="card-footer">There are {{ $usersession->count() }} sessions in the database.</div>
                </div>
            </div>
        </div>
    </div>
@endsection