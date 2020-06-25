@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading heading-style">Travel Claims</div>
            <div class="panel-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('home') }}">@lang('generic.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ Route('claims.travel') }}">Travel Claims</a></li>
                        <li class="breadcrumb-item"><a href="{{ Route('claims.travel.edit', ['id' => $travelclaim->id]) }}">Current Claim</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Mileage</li>
                    </ol>
                </nav>
                @include('common.errors')
                @include('common.success')
                {{ Form::open(['route' => ['claims.travel.addmileage', $travelclaim->id]]) }}
                @if(isset($failed))
                    {{ Form::model($failed) }}
                @endif
                @component('forms.travel.mileage')
                    @slot('mileagetitle', 'Add mileage to claim')
                    @slot('mileagecolour', 'info')
                    @slot('mileagefooter')
                        <div class="col-md-5 col-sm-5">{{ Form::submit(__('travel.btnAddMileage'), ['class' => 'btn btn-primary']) }}</div>
                        <div class="col-md-7 col-sm-7">Business mileage: 14 pence per mile
                            <br>Training mileage: 14 pence per mile
                        </div>
                    @endslot
                @endcomponent
                {{ Form::close() }}
                <a href="{{ Route('claims.travel.edit', ['id' => $travelclaim->id]) }}" class="btn btn-warning">Return to claim</a>
            </div>
        </div>
    </div>

@endsection