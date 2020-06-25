@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">
                    <div class="card-heading p-2 heading-style">Users List</div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ Route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Messages</li>
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
                                <th width="50">Status</th>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Sent</th>
                            </tr>
                            @if($messages->count() <=0 )
                                <tr><td colspan="5">No messages in the database.</td></tr>
                            @endif
                            @foreach($messages as $s)
                                <tr class="clickable-row {{ ($s->read == 0) ? 'unread' : '' }}" data-href="{{ Route('user.message.view', $s->id) }}">
                                    <td class="text-center"><span class="glyphicon {{ ($s->read == 0) ? 'glyphicon-envelope' : 'glyphicon-eye-open' }}"></span></td>
                                    <td>{{ $s->id }}</td>
                                    <td>{{ $s->subject }}</td>
                                    <td>{{ $s->created_at }}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $messages->links() }}
                    </div>
                    <div class="card-footer">There are {{ $messages->count() }} messages in the database.</div>
                </div>
            </div>
        </div>
    </div>
@endsection