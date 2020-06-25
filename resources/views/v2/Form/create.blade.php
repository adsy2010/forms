@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="card card-default">

                    <div class="card-heading p-2 heading-style">Form</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @include('common.errors')
                        <div class="well">
                            <p class="lead">
                                @lang('leads.formCreate')
                            </p>
                        </div>

                        <hr>
                        <h2>Add Form</h2>
                        <hr>
                        <form action="{{ Route('Form.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 text-right">Name</div>
                                <div class="col-md-3"><input name="name" type="text" class="form-control"></div>
                                <div class="col-md-3"><label for="isClaim">Form is a claim?</label> <input id="isClaim" name="isClaim" type="checkbox" class="checkbox-inline" value="1"></div>
                                <div class="col-md-3"><input class="btn btn-primary" type="submit" value="Add Form"></div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-offset-1"><a class="btn btn-warning" href="{{ Route('Form.index') }}">Return to form list</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
