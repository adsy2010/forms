@extends('layouts.app')

@section('content')#
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">
                    <div class="card-heading p-2 heading-style">Personnel Details List</div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Personnel Details List</li>
                            </ol>
                        </nav>
                        @include('common.errors')
                        @include('common.success')
                        <div class="well">
                            Personnel information.
                            <hr>
                            <p>If you would like to add multiple records to the system, please upload a CSV file WITHOUT heading columns, with columns in order as follows:</p>
                            <table class="table">
                                <tr>
                                    <td>Email address</td>
                                    <td>Personnel number</td>
                                    <td>NI number</td>
                                </tr>
                                <tr>
                                    <td>example@mountbatten.hants.sch.uk</td>
                                    <td>1234567</td>
                                    <td>AB123456C</td>
                                </tr>
                            </table>
                            <hr>
                            <div class="thumbnail">
                                <div class="container">
                                <h4>Upload CSV Data file</h4>
                                    {{ Form::file('personnel_spreadsheet', ['style' => 'display:inline;']) }}
                                    {{ Form::submit('Upload data', ['class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                        </div>



                        <br>
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email Address</th>
                                <th>Personnel Number</th>
                                <th>NI Number</th>
                                <th>Created</th>
                            </tr>
                            @if($personnel->count() <=0 )
                                <tr><td colspan="5">No groups in the database.</td></tr>
                            @endif
                            @foreach($personnel as $s)
                                <tr class="clickable-row" data-href="{{ Route('admin.personnel.details', $s->id) }}">
                                    <td>{{ $s->id }}</td>
                                    <td>{{ $s->user->uid }}</td>
                                    <td>{{ $s->user->FirstName }}</td>
                                    <td>{{ $s->user->LastName }}</td>
                                    <td>{{ $s->email }}</td>
                                    <td>{{ $s->personnelNumber }}</td>
                                    <td>{{ $s->niNumber }}</td>
                                    <td>{{ $s->created_at }}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $personnel->links() }}
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection