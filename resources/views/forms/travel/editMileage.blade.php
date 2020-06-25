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
                        <li class="breadcrumb-item"><a href="{{ Route('claims.travel.edit', ['id' => $mileageclaim->claim->id]) }}">Current Claim</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Update Mileage</li>
                    </ol>
                </nav>
                @include('common.errors')
                @include('common.success')
                {{ Form::open() }}
                {{ Form::model($mileageclaim) }}

                @component('forms.travel.mileage')
                    @slot('mileagecolour', 'success')
                    @slot('mileagetitle')
                        @lang('travel.labelMileageDBEntry') #{{ $mileageclaim->id }}
                    @endslot
                    @slot('mileagefooter')
                        <div class="col-md-5 col-sm-5">
                            <a href="" class="btn btn-primary"><span
                                        class="glyphicon glyphicon-pencil"></span> @lang('travel.btnUpdate')</a>
                            <a href="{{ Route('claims.travel.deletemileage', ['mileage' => $mileageclaim->id]) }}"
                               class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>
                                @lang('travel.btnRemove')</a>
                        </div>
                    @endslot
                @endcomponent

                {{ Form::close() }}
                <a href="{{ Route('claims.travel.edit', ['id' => $mileageclaim->claim->id]) }}" class="btn btn-warning">Return to claim</a>
            </div>
        </div>
    </div>

@endsection