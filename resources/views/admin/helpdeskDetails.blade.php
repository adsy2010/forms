@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading heading-style">Helpdesk Details</div>
            <div class="panel-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ Route('admin.helpdesks.view') }}">Helpdesk List</a></li>
                        <li class="breadcrumb-item" aria-current="page">Helpdesk Details</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $helpdesk->name }}</li>
                    </ol>
                </nav>
                @include('common.errors')
                @include('common.success')
                <div class="well">
                    Helpdesks.
                </div>

                {{ Form::open() }}
                {{ Form::model($helpdesk) }}
                {{ Form::label('name', 'Service desk name') }}
                {{ Form::text('name', null, ['class' => 'form-control']) }}
                <hr>
                {{ Form::label('description', 'Description') }}
                {{ Form::textarea('description') }}
                {{ Form::close() }}

            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
@endsection