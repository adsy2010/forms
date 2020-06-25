@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
            <div class="card card-default">

                <div class="card-heading p-2 heading-style">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @include('common.errors')
                    <div class="well">
                        <p class="lead">
                            Welcome {{ Auth::user()->FirstName }}. You have logged in to Mountbatten's Service portal!
                            You can manage your account and interact with various services from this portal.
                        </p>
                    </div>

                    <hr>
                    <h2>My information</h2>
                    <hr>
                    <div class="row">

                        @if(Auth::user()->team->count() > 0)
                            <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('user.team.view') }}" class="btn bg-info" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-pawn"></span> My Team</a></div>
                        @endif
                        <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('user.personnel.view') }}" class="btn bg-info" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-credit-card"></span> My Details</a></div>
                    </div>

                    <h2>Services</h2>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-success" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-phone-alt"></span> Helpdesk calls</a></div>
                        <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('home') }}" class="btn bg-success" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-phone"></span> Staff Contact</a></div>
                        <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('home') }}" class="btn bg-success" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-globe"></span> Absences</a></div>
                        <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('home') }}" class="btn bg-success" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-lock"></span> Lockers</a></div>
                        <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('home') }}" class="btn bg-success" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-education"></span> MFL SCORM</a></div>
                    </div>

                    <h2>Claims</h2>
                    <hr>

                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="#" class="btn bg-primary" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-file"></span> Submissions</a></div>
                        <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-warning" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-time"></span> Time Claims</a></div>
                        <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="" class="btn bg-warning" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-road"></span> Travel Claims</a></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
