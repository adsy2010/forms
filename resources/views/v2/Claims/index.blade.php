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
                                @lang('leads.claimsIndex')
                            </p>
                        </div>

                        <hr>
                        <h2>Claims</h2>
                        <hr>
                            <a class="btn btn-primary" href="{{ Route('Claim.create') }}">@lang('generic.create')</a><hr>
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Form</th>
                                    <th>Period</th>
                                    <th>Status</th>
                                    <th>Options</th>
                                </tr>
                                @foreach($claims as $claim)
                                    <tr>
                                        <td>{{ $claim->id }}</td>
                                        <td>{{ $claim->claimUser->FirstName }} {{ $claim->claimUser->LastName }}</td>
                                        <td>{{ $claim->claimForm->name }}</td>
                                        <td>{{ Carbon\Carbon::createFromDate(str_split($claim->period,4)[0], str_split($claim->period,4)[1])->format("F Y") }}</td>
                                        <td>{{ $claim->claimStatus->state }}</td>
                                        <td>edit - delete</td>
                                    </tr>
                                @endforeach
                                @if(!(count($claims) > 0))
                                    <tr>
                                        <td colspan="6">No entries</td>
                                    </tr>
                                @endif
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
