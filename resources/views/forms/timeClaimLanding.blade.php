@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="panel panel-default">
                    <div class="panel-heading heading-style">Time claims</div>
                    <div class="panel-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ Route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Time claims dashboard</li>
                            </ol>
                        </nav>
                        <div class="well">This is a work in progress and functionality may be limited.</div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6 text-center" style="margin-bottom: 10px;"><a href="{{ Route('claims.timelist.lunch') }}" class="btn bg-primary" style="padding:25px; min-width: 300px; width: 95%; font-size:36px;"> Lunchtime claims</a></div>
                            <div class="col-sm-6 col-md-6 col-lg-6 text-center" style="margin-bottom: 10px;"><a href="{{ Route('claims.timelist.pay') }}" class="btn bg-success" style="padding:25px; min-width: 300px; width: 95%;  font-size:36px;"> Pay claims</a></div>
                        </div>
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection