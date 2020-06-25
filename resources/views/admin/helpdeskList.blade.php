@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading heading-style">Personnel Details List</div>
            <div class="panel-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Helpdesk List</li>
                    </ol>
                </nav>
                @include('common.errors')
                @include('common.success')
                <div class="well">
                    Helpdesks.
                </div>

                <table class="table table-hover">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Owner AD Group</th>
                        <th>Created</th>
                    </tr>
                    @foreach($helpdesks as $helpdesk)
                        <tr class="clickable-row" data-href="{{ Route('admin.helpdesk.view', $helpdesk->id) }}">
                            <td>{{ $helpdesk->id }}</td>
                            <td>{{ $helpdesk->name }}</td>
                            <td>{{ $helpdesk->description }}</td>
                            <td>{{ $helpdesk->ADGroupOwner->name }}</td>
                            <td>{{ $helpdesk->created_at }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
@endsection