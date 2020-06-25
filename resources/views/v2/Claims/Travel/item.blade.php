@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="">
            <div class="container">
                <div class="card">

                    <div class="card-heading heading-style p-2">PAGE INDEX</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @include('common.errors')
                        <div class="well">
                            <p class="lead">
                                @lang('leads.item')
                            </p>
                        </div>

                        <travelclaimitem-component></travelclaimitem-component>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
