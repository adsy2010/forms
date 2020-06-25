@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading heading-style">Travel Claims</div>
            <div class="panel-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Travel Claims</li>
                    </ol>
                </nav>
                @include('common.errors')
                @include('common.success')
                <div class="well">
                    @lang('travel.welcomeMessage')
                </div>
                <br>

                <a href="{{ Route('claims.travel.create') }}" class="btn btn-primary">Create new claim</a>
                <hr>
                <table class="table table-hover">
                    <tr>
                        <th>#</th>
                        <th>Created On</th>
                        <th>Claim total</th>
                        <th width="150px">Options</th>
                    </tr>

                    @foreach($travelclaims as $claim)
                        <tr>
                            <td>{{ $claim->id }}</td>
                            <td>{{ $claim->created_at }}</td>
                            <td>£{{ number_format($claim->subsistence + $claim->transport + $claim->parking, 2) }}</td>
                            <td align="right">
                                <a href="{{ Route('claims.travel.edit', ['id' => $claim->id]) }}" class="btn btn-sm btn-primary">continue claim</a>
                                <a href="{{ Route('claims.travel.delete', ['id' => $claim->id]) }}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                    @endforeach


                    @if(!(count($travelclaims) > 0))
                        <tr><td colspan="3">You currently have no unsubmitted travel claims.</td></tr>
                    @endif
                </table>

            </div>
        </div>
    </div>
@endsection