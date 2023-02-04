@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('computer.create') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <input id="computer-name" type="text" class="form-control @error('computer-name') is-invalid @enderror" name="computer-name" placeholder="Enter a name for your computer" value="{{ old('computer-name') }}" required autofocus>

                                @error('computer-name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
