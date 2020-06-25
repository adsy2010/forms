@extends('layouts.app')

@section('content')
    <v-app token="{!! auth()->user()->getRememberToken() !!}">
        <ct></ct>
    </v-app>
@endsection