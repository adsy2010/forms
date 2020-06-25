@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">

                    <div class="card-heading p-2 heading-style">Mileage Types</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @include('common.errors')
                        <div class="well">
                            <p class="lead">
                                @lang('leads.mileageTypesCreate')
                            </p>
                        </div>

                        <hr>
                        <h2>Add Mileage Type</h2>
                        <hr>
                        <form action="{{ Route('MileageType.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 text-right">Name</div>
                                <div class="col-md-4"><input name="name" type="text" class="form-control"></div>
                                <div class="col-md-4"><input class="btn btn-primary" type="submit" value="Add Mileage Type"></div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-offset-1"><a class="btn btn-warning" href="{{ Route('MileageType.index') }}">Return to mileage types list</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
