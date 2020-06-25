@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">

                    <div class="card-heading heading-style">PAGE INDEX</div>
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
                        <h2>Claim #{{ $claim->id }}</h2>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
