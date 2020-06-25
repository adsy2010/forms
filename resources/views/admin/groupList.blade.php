@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">
                    <div class="card-heading p-2 heading-style">Groups List</div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Groups List</li>
                            </ol>
                        </nav>
                        @include('common.errors')
                        @include('common.success')
                        <div class="well">
                            Groups information
                        </div>

                        <br>
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>Group Name</th>
                                <th>Created</th>
                            </tr>
                            @if($groups->count() <=0 )
                                <tr><td colspan="5">No groups in the database.</td></tr>
                            @endif
                            @foreach($groups as $s)
                                <tr class="clickable-row" data-href="{{ Route('admin.group.view', $s->id) }}">
                                    <td>{{ $s->id }}</td>
                                    <td>{{ $s->name }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$s->created_at)->format('H:i - jS F Y') }}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $groups->links() }}
                    </div>
                    <div class="card-footer">There are {{ $groups->count() }} groups in the database.</div>
                </div>
            </div>
        </div>
    </div>
@endsection