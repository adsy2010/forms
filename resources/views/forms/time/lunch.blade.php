@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading heading-style">@lang('time.lunchPayClaimTitle')</div>
            <div class="panel-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('home') }}">@lang('generic.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ Route('claims.timeclaimdashboard') }}">@lang('time.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('time.lunchPayClaimTitle')</li>
                    </ol>
                </nav>
                @include('common.errors')
                @include('common.success')
                <div class="well">
                    <h4>@lang('generic.readCarefully')</h4>
                    @lang('time.welcomeMessageContinue')
                </div>
                @if(Route::current()->getName() == 'claims.time.lunch.current')
                    @php($dateperiodstart = Deadline::firstOfMonth(time()))
                    @php($dateperiodend   = Deadline::lastOfMonth(time()))
                    @else
                    @php($dateperiodstart = Deadline::firstOfMonth(time(), -1))
                    @php($dateperiodend   = Deadline::lastOfMonth(time(), -1))
                @endif
                @php($dateperiod = \Carbon\CarbonPeriod::create($dateperiodstart,$dateperiodend))
                {{ Form::open(['route' => 'claims.time.lunch.create']) }}
                {{ Form::hidden('month', Deadline::dateFromTimestamp($dateperiodstart)) }}
                <table class="table table-hover">
                    <tr>
                        <th>@lang('generic.date')</th>
                        <th style="text-align: center;">@lang('time.halfhour')</th>
                        <th style="text-align: center;">@lang('time.3/4hour')</th>
                        <th style="text-align: center;">@lang('time.notworked')</th>
                    </tr>

                @foreach($dateperiod as $day)
                        @if(date('d', strtotime($day)) % 11 == 0)
                            <tr>
                                <th width="125">Date</th>
                                <th style="text-align: center;">@lang('time.halfhour')</th>
                                <th style="text-align: center;">@lang('time.3/4hour')</th>
                                <th style="text-align: center;">@lang('time.notworked')</th>
                            </tr>
                        @endif
                    @php($dayNo = 'claim'.date('j', strtotime($day)))
                            <tr>
                                <td>{{ Form::date('day', $day, ['disabled' => 'disabled', 'class' => 'form-control']) }}</td>
                                <td style="vertical-align: middle; text-align: center">{{ Form::radio($dayNo, 0.5, null, ['class' => 'radiostyles']) }}</td>
                                <td style="vertical-align: middle; text-align: center">{{ Form::radio($dayNo, 0.75, null, ['class' => 'radiostyles']) }}</td>
                                <td style="vertical-align: middle; text-align: center">{{ Form::radio($dayNo, 0, null, ['class' => 'radiostyles', 'checked' => 'checked']) }}</td>
                            </tr>



                @endforeach
                    </table>
                <div class="panel-footer">

                    {{ Form::submit(__('generic.save'), ['class' => 'btn btn-primary']) }}
                    {{ Form::submit(__('generic.saveandsubmit'), ['class' => 'btn btn-success']) }}
                    <div class="pull-right" )>
                        <a href="{{ Route('claims.timelist.lunch') }}" , class="btn btn-warning"><span
                                    class="glyphicon glyphicon-th"><span class="visible-sm-inline visible-xs-inline"> @lang('generic.dashboard')</span></span> <span class="hidden-sm hidden-xs">Return to lunch pay claim dashboard</span></a>

                    </div>
                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
@endsection