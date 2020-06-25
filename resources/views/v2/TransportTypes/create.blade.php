@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">

                    <div class="card-heading p-2 heading-style">Transport Types</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @include('common.errors')
                        <div class="well">
                            <p class="lead">
                                @lang('leads.transportTypesCreate')
                            </p>
                        </div>

                        <hr>
                        <h2>Add Transport Type</h2>
                        <hr>
                            <form action="{{ Route('TransportType.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 text-right">Name</div>
                                    <div class="col-md-4"><input name="name" type="text" class="form-control"></div>
                                    <div class="col-md-4"><input class="btn btn-primary" type="submit" value="Add Transport Type"></div>
                                </div>
                            </form>
                            <hr>
                    <div class="row">
                        <div class="col-md-offset-1"><a class="btn btn-warning" href="{{ Route('TransportType.index') }}">Return to transport types list</a></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
