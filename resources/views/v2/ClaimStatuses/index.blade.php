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
                                @lang('leads.card')
                            </p>
                        </div>

                        <hr>
                        <h2>Claim Statuses</h2>
                        <hr>
                            <a class="btn btn-primary" href="{{ Route('ClaimStatus.create') }}">@lang('generic.create')</a><hr>
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Options</th>
                                </tr>
                                @foreach($claimStatuses as $claimStatus)
                                    <tr>
                                        <td>{{ $claimStatus->id }}</td>
                                        <td>{{ $claimStatus->state }}</td>
                                        <td>edit - delete</td>
                                    </tr>
                                @endforeach
                                @if(!(count($claimStatuses) > 0))
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
