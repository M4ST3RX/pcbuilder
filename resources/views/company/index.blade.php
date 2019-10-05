@extends('layouts.app')

@php
    $player = \App\Player::where('user_id', Auth::id())->first();
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                    <div class="card text-center">
                        @include('company.tabs', ['active' => $active])
                        <div class="card-body">
                            <h5 class="card-title">{{ $company->name }}</h5>
                            <p class="card-text">{{ $company->slogan }}</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
