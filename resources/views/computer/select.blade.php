@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
            </div>
            <div class="col-md-12 row computers">
                @foreach($computers as $computer)
                    <div class="col-md-4 computer">
                        <div class="computer-card" data-id="{{ $computer->id }}">
                            <div class="computer-title">{{ $computer->name }}</div>

                            <div class="computer-card-body">
                                Level {{ $computer->level }}
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-4 computer">
                    <div class="computer-card">
                        <div class="computer-title">+ New Computer</div>

                        <div class="computer-card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
