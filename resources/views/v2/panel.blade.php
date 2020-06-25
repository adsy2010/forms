@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card">

                    <div class="card-heading bg-primary p-2 heading-style">PAGE INDEX</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @include('common.errors')
                        <div class="well">
                            <p class="lead">
                                @lang('leads.panel')
                            </p>
                        </div>

                        <hr>
                        <h2>Panel</h2>
                        <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('ClaimStatus.index') }}" class="btn bg-primary" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-file"></span> Claim Statuses</a></div>
                                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('TransportType.index') }}" class="btn bg-primary" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-file"></span> Transport Types</a></div>
                                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('MileageType.index') }}" class="btn bg-primary" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-file"></span> Mileage Types</a></div>
                                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('Form.index') }}" class="btn bg-primary" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-file"></span> Forms</a></div>
                                <div class="col-sm-6 col-md-6 col-lg-4 text-center" style="margin-bottom: 10px;"><a href="{{ Route('Claim.index') }}" class="btn bg-primary" style="padding:25px; min-width: 300px; font-size:36px;"><span class="glyphicon glyphicon-file"></span> Claims</a></div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
