@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="">
            <div class="container">
                <div class="card">

                    <div class="card-heading p-2 heading-style">PAGE INDEX</div>
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

                        <hoursclaimitem-component></hoursclaimitem-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
