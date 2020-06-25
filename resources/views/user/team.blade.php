@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card panel-default">
                    <div class="card-heading p-2 heading-style">My Team</div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ Route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">My Team</li>
                            </ol>
                        </nav>
                        @include('common.errors')
                        @include('common.success')
                        <div class="well">
                            Your team below are line managed by you.
                        </div>

                        <table class="table">
                            <tr>
                                <th>#</th>
                                <th>UID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Position</th>
                                <th></th>
                            </tr>
                            @foreach($team as $member)
                                <tr>
                                    <td>{{ $member->user->id }}</td>
                                    <td>{{ $member->user->uid }}</td>
                                    <td>{{ $member->user->FirstName }}</td>
                                    <td>{{ $member->user->LastName }}</td>
                                    <td>{{ $member->user->staffdetails->position }}</td>
                                    <td><div data-toggle="modal" data-target="#flagModal" class=""><span class="text-danger fa fa-flag" title="Flag this person"></span></div></td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.flagaproblem')
@endsection