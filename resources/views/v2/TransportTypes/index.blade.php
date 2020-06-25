@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">

                    <div class="card-heading p-2 heading-style">PAGE INDEX</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @include('common.errors')
                        <div class="well">
                            <p class="lead">
                                @lang('leads.transportTypesIndex')
                            </p>
                        </div>

                        <hr>
                        <h2>Transport Types</h2>
                        <hr>
                            <a class="btn btn-primary" href="{{ Route('TransportType.create') }}">@lang('generic.create')</a><hr>
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Options</th>
                                </tr>
                                @foreach($transportTypes as $transportType)
                                    <tr>
                                        <td>{{ $transportType->id }}</td>
                                        <td>{{ $transportType->name }}</td>
                                        <td>edit - delete</td>
                                    </tr>
                                @endforeach
                                @if(!(count($transportTypes) > 0))
                                    <tr>
                                        <td colspan="3">No entries</td>
                                    </tr>
                                @endif
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
