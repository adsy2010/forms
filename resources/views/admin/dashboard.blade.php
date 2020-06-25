@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card">
                    <div class="card-heading bg-primary p-2 heading-style">Admin Dashboard</div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </nav>
                        @include('common.errors')
                        @include('common.success')
                        <div class="well">
                            Admin Dashboard
                        </div>
                        <br>
                        <h2>User Management</h2>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('admin.users.view') }}" class="btn bg-info" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-user"></span> Users</a></div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('admin.sessions.view') }}" class="btn bg-info" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-cloud"></span> User Sessions</a></div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('admin.groups.view') }}" class="btn bg-info" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-th-list"></span> AD Groups</a></div>
                        </div>
                        <h2>Human Resources</h2>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('admin.personnel.view') }}" class="btn bg-danger" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-credit-card"></span> HR Details</a></div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('admin.travelclaimssettings.view') }}" class="btn bg-danger" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-road"></span> Travel Claims</a></div>
                        </div>
                        <h2>Services</h2>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('admin.helpdesks.view') }}" class="btn bg-success" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-phone-alt"></span> Helpdesk</a></div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('admin.helpdesks.view') }}" class="btn bg-success" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-globe"></span> Absences</a></div>

                        </div>
                        <h2>Claims settings</h2>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('MileageType.index') }}" class="btn bg-warning" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-phone-alt"></span> Mileage Types</a></div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('TransportType.index') }}" class="btn bg-warning" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-globe"></span> Transport Types</a></div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('ClaimStatus.index') }}" class="btn bg-warning" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-globe"></span> Claim Statuses</a></div>

                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection