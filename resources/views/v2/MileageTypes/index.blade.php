@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">

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
                                @lang('leads.mileageTypesIndex')
                            </p>
                        </div>

                        <hr>
                        <h2>Mileage Types</h2>
                        <hr>
                            <a class="btn btn-primary" href="{{ Route('MileageType.create') }}">@lang('generic.create')</a><hr>
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Options</th>
                                </tr>
                                @foreach($mileageTypes as $mileageType)
                                    <tr>
                                        <td>{{ $mileageType->id }}</td>
                                        <td>{{ $mileageType->name }}</td>
                                        <td>edit - delete</td>
                                    </tr>
                                @endforeach
                                @if(!(count($mileageTypes) > 0))
                                    <tr>
                                        <td colspan="3">No entries</td>
                                    </tr>
                                @endif
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
