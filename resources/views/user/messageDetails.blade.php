@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">
                    <div class="card-heading p-2 heading-style">{{ $message->subject}}</div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ Route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ Route('user.messages') }}">Messages</a></li>
                                <li class="breadcrumb-item active" aria-current="page">'{{ $message->subject }}'</li>
                            </ol>
                        </nav>
                        <h3>{{$message->subject}}</h3>
                        @include('common.errors')
                        @include('common.success')
                        <hr>
                        <div class="well">
                            {!! $message->message !!}
                        </div>

                    </div>
                    <div class="card-footer">
                        Sent at {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$message->created_at)->format('H:i \o\n jS F Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection