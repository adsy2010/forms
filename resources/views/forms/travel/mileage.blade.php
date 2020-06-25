<div class="panel panel-{{ $mileagecolour }}">
    <div class="panel-heading">{{ $mileagetitle }}</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-8">
                <div class="tags">
                    <label class="btn btn-default">
                    <span class="">@lang('travel.btnTrainingMileage') {{ Form::radio('mileagetype', 0, null, ['class' => 'badgebox']) }}
                        <span class="badge">&check;</span>
                    </span>
                    </label>
                    <label class="btn btn-default">
                    <span class="">@lang('travel.btnBusinessMileage') {{ Form::radio('mileagetype', 1, null, ['class' => 'badgebox']) }}
                        <span class="badge">&check;</span>
                    </span>
                    </label> @lang('generic.required')
                </div>

            </div>
            <div class="col-md-4">


            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">{{ Form::label('journeydate', 'Journey Date') }} @lang('generic.required'){{ Form::date('journeydate', null, ['placeholder' => 'dd/mm/yyyy','class' => 'form-control']) }}</div>
            <div class="col-md-6">{{ Form::label('journeytime', 'Journey Time') }} @lang('generic.required'){{ Form::time('journeytime', null, ['placeholder' => 'hh:mm', 'class' => 'form-control']) }}</div>
        </div>

        <div class="row">
            <div class="col-md-6">{{ Form::label('origin', 'Travelling From') }} @lang('generic.required'){{ Form::text('origin', null, ['class' => 'form-control', 'placeholder' => 'origin']) }}</div>
            <div class="col-md-6">{{ Form::label('destination', 'Heading to') }} @lang('generic.required'){{ Form::text('destination', null, ['class' => 'form-control', 'placeholder' => 'destination']) }}</div>
        </div>

        <div class="row">
            <div class="col-md-9">{{ Form::label('reason') }} @lang('generic.required'){{ Form::text('reason', null, ['placeholder' => 'Reason for travel', 'class' => 'form-control']) }}</div>
            <div class="col-md-3">{{ Form::label('mileage') }} @lang('generic.required'){{ Form::number('mileage', null, ['placeholder' => 'Mileage' ,'class' => 'form-control', 'step' => '0.1']) }}</div>
        </div>

    </div>
    <div class="panel-footer">
        <div class="row">
            {{ $mileagefooter }}
        </div>
    </div>
</div>