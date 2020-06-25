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
                @php($d = new Carbon\Carbon('first day of this month'))
                @php($e = new Carbon\Carbon('first day of last month'))
                @include('common.errors')
                @include('common.success')
                <div class="well">
                    <h4>@lang('generic.readCarefully')</h4>
                    @lang('time.welcomeMessageContinue')
                    You have until the 10th day of the following month to create a previous months claim.
                </div>

                <div class="row" style="text-align: center;">
                    @if(!Deadline::dateSubLimit(10))
                        @if(!$timeclaims->contains('month',$e->formatLocalized('%Y-%m-%d')))
                            <div class="col-md-6">
                                <a class="btn btn-primary" style="padding: 25px; min-width: 300px; width: 95%; font-size: 36px;" href="{{ Route('claims.time.lunch.last') }}">Create {{ Deadline::dateLimitMonth(10) }} Claim</a>
                            </div>
                        @endif
                    @endif
                    @if(!$timeclaims->contains('month',$d->formatLocalized('%Y-%m-%d')))
                        <div class="col-md-6">
                            <a class="btn btn-success" style="padding: 25px; min-width: 300px; width: 95%; font-size: 36px;" href="{{ Route('claims.time.lunch.current') }}">Create {{ Deadline::dateLimitMonth(0) }} Claim</a>

                        </div>
                    @endif
                </div>
                <hr>
                <div class="panel panel-info">
                    <div class="panel-heading"><h3>Unsubmitted claims</h3></div>
                    <div class="panel-body"><table class="table">
                            <tr>
                                <th>#</th>
                                <th>Claim Month</th>
                                <th width="245">Actions</th>
                            </tr>
                            @if(!(sizeof($timeclaims) > 0))
                                <tr>
                                    <td colspan="3">You have no unsubmitted claims</td>
                                </tr>
                            @endif
                            @foreach($timeclaims as $claim)
                                <tr>
                                    <td>{{ $claim->id }}</td>
                                    <td>{{ Carbon\Carbon::createFromTimestamp(strtotime($claim->month))->formatLocalized('%B %Y') }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary">continue</a>
                                        <a class="btn btn-sm btn-success">submit</a>
                                        <a class="btn btn-sm btn-danger">delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table></div>
                </div>
            </div>

        </div>
    </div>
@endsection