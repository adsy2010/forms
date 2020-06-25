@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">
                    <div class="card-heading heading-style p-2">Users List</div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Users List</li>
                            </ol>
                        </nav>
                        @include('common.errors')
                        @include('common.success')
                        <div class="well">
                            User information
                        </div>

                        <br>
                        <br>
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Created</th>
                            </tr>
                            @if($users->count() <=0 )
                                <tr><td colspan="5">No users in the database.</td></tr>
                            @endif
                            @foreach($users as $s)
                                <tr class="clickable-row" data-href="{{ Route('admin.user.view', $s->id) }}">
                                    <td>{{ $s->id }}</td>
                                    <td>{{ $s->FirstName }}</td>
                                    <td>{{ $s->LastName }}</td>
                                    <td>{{ $s->email }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$s->created_at)->format('H:i - jS F Y') }}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $users->links() }}
                    </div>
                    <div class="card-footer">There are {{ $users->count() }} users in the database.</div>
                </div>
            </div>
        </div>
    </div>
@endsection