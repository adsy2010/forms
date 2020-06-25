@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading heading-style">Travel Claims</div>
            <div class="panel-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ Route('claims.travel') }}">Travel Claims</a></li>
                        <li class="breadcrumb-item"><a href="{{ Route('claims.travel.edit', ['id' => $travelclaim]) }}">Edit Travel Claim</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Delete Travel Claim</li>
                    </ol>
                </nav>
                @include('common.errors')
                @include('common.success')
                <div class="well">
                    <h4>Please read the following information carefully</h4>
                    Create a new travel claim. Please supply any relevant receipts and tickets in a named envelope to HR as proof of purchase.
                    Include the ID of the travel claim submission which will be sent to you via email and added to your message box on this system.
                    The ID will not exist until the form is submitted. Mileage costs will be automatically calculated using values from the date of travel.
                </div>
                <br>

                <h3>Are you sure you wish to delete this travel claim?</h3>

                {{ $travelclaim }}
                {{ $travelclaim->mileageclaims }}

                <div class="panel panel-info">
                    <div class="panel-heading">Claim summary</div>
                    <div class="panel-body">
                        Claim was started at {{ $travelclaim->created_at }}
                        {{ Form::open() }}
                        {{ Form::model($travelclaim, ['route' => ['claims.travel.edit', $travelclaim->id]]) }}
                        <table class="table">
                            <tr>
                                <th>Mileage type</th>
                                <th width="100">Miles</th>
                                <th width="138">Total claimed</th>
                            </tr>
                            <tr>
                                <td>Mileage</td>
                                <td>{{ $amount = $travelclaim->mileageclaims->sum('mileage') }}</td>
                                <td>£{{ number_format($amount * 0.54, 2) }}</td>
                            </tr>

                            <tr>
                                <td colspan="2">Car Parking</td>
                                <td>
                                    £{{ number_format($travelclaim->parking, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Subsistence</td>
                                <td>
                                    £{{ number_format($travelclaim->subsistence, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Train Fare</td>
                                <td>
                                    £{{ number_format($travelclaim->transport, 2) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-footer">
                        {{ Form::open(['route' => ['claims.travel.delete', $travelclaim->id]]) }}
                        {{ Form::submit('Yes', ['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                        <a href="{{ Route('claims.travel') }}", class="btn btn-warning"><span class="glyphicon glyphicon-th"></span> Travel claim dashboard</a>
                        <a href="{{ Route('claims.travel.edit', ['id' => $travelclaim->id]) }}", class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit claim</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection