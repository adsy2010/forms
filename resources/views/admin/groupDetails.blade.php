@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">
                    <div class="card-heading p-2 heading-style">{{ $group->name }} group details</div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ Route('admin.groups.view') }}">Groups List</a></li>
                                <li class="breadcrumb-item active" aria-current="page">'{{ $group->name }}' group details</li>
                            </ol>
                        </nav>
                        @include('common.errors')
                        @include('common.success')
                        <div class="well">
                            User information
                        </div>
                        <br>
                        <div>{{ $group->FirstName }}</div>
                        <div>{{ $group->LastName }}</div>
                        <div>{{ $group->email }}</div>

                        <br>
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Last change</th>
                            </tr>
                            @if(array() <=0 )
                                <tr><td colspan="5">No users in the database.</td></tr>
                            @endif
                            @foreach($group->groupmemberships as $s)
                                <tr class="clickable-row" data-href="{{ Route('admin.user.view', $s->user->id) }}">
                                    <td>{{ $s->id }}</td>
                                    <td>{{ $s->user->uid }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$s->updated_at)->format('H:i - jS F Y') }}</td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                    <div class="card-footer">This group contains {{ $group->groupmemberships->count() }} active directory users.</div>
                </div>
            </div>
        </div>
    </div>
@endsection