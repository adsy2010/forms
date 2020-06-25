@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading heading-style">{{ $calls->name }} :: Calls</div>
            <div class="panel-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ Route('helpdesk.dashboard') }}">Helpdesks</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ $calls->name }}</li>
                        <li class="breadcrumb-item active" aria-current="page">Calls</li>
                    </ol>
                </nav>
                @include('common.errors')
                @include('common.success')
                <div data-toggle="modal" data-target="#myModal" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Log new Call</div><hr>
                @php($groupAdmin = in_array($calls->ADgroup, json_decode(Auth::user()->groupmemberships->pluck('groupInfo')->pluck('id'))))
                @if(($groupAdmin && $calls->helpdeskCalls->count() == 0) || (!$groupAdmin && $calls->authcalls->count() == 0))
                    <em>No support calls in the database.</em>
                @endif
                    @if($groupAdmin)
                        @include('helpdesk.call')
                    @else
                        @foreach($calls->authcalls as $call)
                            @php($callinfo = $call)
                            <div id="thread-{{ $callinfo->id }}" class="row" style=" background-color: rgba(173,216,230,0.51); border-radius: 3px; border: 1px solid #c2c2c2; margin: 5px; ">
                                <a name="thread-{{ $callinfo->id }}"></a>
                                <div class="col-md-2 text-center" style="height:100%; padding:10px; font-size: 12px; border-right: 1px solid #c2c2c2;">
                                    @include('helpdesk.calluserdata')
                                </div>
                                <div class="col-md-10" style="padding: 0; border-left: 1px solid #c2c2c2;">
                                    @include('helpdesk.calldata')

                                </div>
                            </div>
                        @endforeach
                    @endif

            </div>
        </div>
    </div>
    @include('helpdesk.log')
    @include('helpdesk.assign')
    @include('helpdesk.close')
@endsection