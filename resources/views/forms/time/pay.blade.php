@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading heading-style">@lang('time.payClaimTitle')</div>
            <div class="panel-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('home') }}">@lang('generic.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ Route('claims.timeclaimdashboard') }}">@lang('time.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('time.payClaimTitle')</li>
                    </ol>
                </nav>
                @include('common.errors')
                @include('common.success')
                <div class="well">
                    <h4>@lang('generic.readCarefully')</h4>
                    @lang('time.welcomeMessageContinue')
                </div>
                @if(Route::is('claims.time.pay.current'))
                    @php($dateperiodstart = Deadline::firstOfMonth(time()))
                    @php($dateperiodend   = Deadline::lastOfMonth(time()))
                @else
                    @php($dateperiodstart = Deadline::firstOfMonth(time(), -1))
                    @php($dateperiodend   = Deadline::lastOfMonth(time(), -1))
                @endif
                @php($dateperiod = \Carbon\CarbonPeriod::create($dateperiodstart,$dateperiodend))
                {{ Form::open(['route' => 'claims.time.pay.create']) }}

                {{ Form::hidden('month', Deadline::dateFromTimestamp($dateperiodstart)) }}

                <table class="table">
                    <tr>
                        <th width="100">Date</th>
                        <th style="text-align: center;">Hours claimed</th>
                    </tr>

                    @foreach($dateperiod as $day)
                        @if(date('d', strtotime($day)) % 11 == 0)
                            <tr>
                                <th width="100">Date</th>
                                <th style="text-align: center;">Hours claimed</th>
                            </tr>
                        @endif
                            <tr>
                                <td>{{ Form::date('day', $day, ['disabled' => 'disabled', 'class' => 'form-control']) }}</td>
                                <td align="center">{{ Form::number('claim'.date('j', strtotime($day)), null, ['class' => 'form-control', 'placeholder' => 'hours in decimal e.g. 7.5']) }}</td>
                            </tr>



                    @endforeach
                </table>
            </div>
            <div class="panel-footer">

                {{ Form::submit(__('generic.save'), ['class' => 'btn btn-primary']) }}
                <div class="pull-right" )>
                    <a href="{{ Route('claims.timelist.pay') }}" , class="btn btn-warning"><span
                                class="glyphicon glyphicon-th"><span class="visible-sm-inline visible-xs-inline"> @lang('generic.dashboard')</span></span> <span class="hidden-sm hidden-xs">Return to pay claim dashboard</span></a>

                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection