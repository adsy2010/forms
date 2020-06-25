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
                        <li class="breadcrumb-item active" aria-current="page">Create Travel Claim</li>
                    </ol>
                </nav>
                @include('common.errors')
                @include('common.success')
                <div class="well">
                    <h4>@lang('generic.readCarefully')</h4>
                    @lang('travel.welcomeMessageContinue')
                </div>
                <br>
                <p class="small">@lang('travel.startedAt') {{ $travelclaim->created_at }}</p>
                <div class="row">

                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Overall claim summary</div>
                            <div class="panel-body">

                                {{ Form::open() }}
                                {{ Form::model($travelclaim, ['route' => ['claims.travel.edit', $travelclaim->id]]) }}
                                <table class="table">
                                    <tr>
                                        <td>Mileage</td>
                                        <td>{{ Form::number('mileage', $travelclaim->mileageclaims->sum('mileage'), ['class' => 'form-control', 'disabled' => 'disabled', 'step' => '0.1','onchange' => 'mileageCalculator(this.value, '.'0.539'.', "mileagetotal")']) }}</td>
                                        <td width="130">£{{ number_format($travelclaim->mileageclaims->sum('mileage') * 0.54, 2) }}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">Car Parking</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="glyphicon glyphicon-gbp"></i></span>
                                                    {{ Form::text('parking', null, ['class' => 'form-control', 'step' => '0.01']) }}
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Subsistence</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="glyphicon glyphicon-gbp"></i></span>
                                                    {{ Form::number('subsistence', null, ['class' => 'form-control', 'step' => '0.01']) }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Train Fare</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="glyphicon glyphicon-gbp"></i></span>
                                                    {{ Form::number('transport', null, ['class' => 'form-control', 'step' => '0.01']) }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="panel-footer">
                                <a class="btn btn-primary" href="">@lang('generic.save')</a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <a class="btn btn-sm btn-primary" href="{{ Route('claims.travel.create.mileage', ['id'=>$travelclaim->id]) }}">Add a mileage claim</a>
                <a href="#" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> @lang('travel.btnClearMileage')</a>

                <div class="panel panel-info" style="margin-top:10px;">
                    <div class="panel-heading">Mileage claims summary</div>
                    <div class="panel-body" style="margin: 0 10px;">
                        <table class="table table-hover table-striped">
                            <tr>
                                <th>Date and Time</th>
                                <th class="hidden-xs">Type</th>
                                <th class="hidden-xs">Mileage</th>
                                <th>Heading to</th>

                            </tr>
                        @foreach($travelclaim->mileageclaims as $mileageclaim)
                            <tr class="clickable-row" data-href="{{ Route('claims.travel.update.mileage', ['mileage' => $mileageclaim->id]) }}">
                                <td>{{ $mileageclaim->journeydate }}<br>{{ $mileageclaim->journeytime }}</td>
                                <td class="hidden-xs">{{ ($mileageclaim->mileagetype == 1) ? "Business" : "Training" }}</td>
                                <td class="hidden-xs">{{ $mileageclaim->mileage }}</td>
                                <td width="200">{{ $mileageclaim->destination }}</td>
                            </tr>
                        @endforeach
                        </table>
                    </div>
                    <div class="panel-footer">
                        @if($travelclaim->mileageclaims->count() > 0)
                            There are {{ $travelclaim->mileageclaims->count() }} mileage claims within this claim.

                        @else
                            No mileage claims
                        @endif
                    </div>
                </div>
                <div class="well">
                    @lang('travel.mileageActionHelp')
                </div>
            </div>
            <div class="panel-footer">
                {{ Form::submit('Save for later', ['class' => 'btn btn-primary']) }}
                {{ Form::submit('Submit Travel Claim', ['class' => 'btn btn-success']) }}
                <div class="pull-right">
                    <a href="{{ Route('claims.travel') }}" class="btn btn-warning"><span
                                class="glyphicon glyphicon-th"><span class="visible-sm-inline visible-xs-inline"> @lang('generic.dashboard')</span></span> <span class="hidden-sm hidden-xs">Return to travel claim dashboard</span></a>
                    <a href="{{ Route('claims.travel.delete', ['id' => $travelclaim->id]) }}"
                       class="btn btn-danger"><span class="glyphicon glyphicon-trash"><span class="visible-sm-inline visible-xs-inline"> @lang('generic.cancel')</span></span> <span class="hidden-sm hidden-xs">Cancel this travel claim</span></a>
                </div>
                {{ Form::close() }}
            </div>
        </div>

    </div>
@endsection