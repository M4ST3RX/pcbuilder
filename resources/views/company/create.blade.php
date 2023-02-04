@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class="card">
                    <div class="card-header">{{ __('Create Company') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('company.create') }}">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="company_name" class="col-md-12 col-form-label">{{ __('Company Name') }}</label>

                                    <div class="col-md-12">
                                        <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required maxlength="32" autocomplete="company_name" autofocus>

                                        @error('company_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="company_type" class="col-md-12 col-form-label">{{ __('Company Type') }}</label>

                                    <div class="col-md-12">
                                        <select name="company_type" class="form-control @error('company_type') is-invalid @enderror" id="company_type" required>
                                            <option value="" selected>Select a Company Type</option>
                                            @foreach($company_types as $company_type)
                                                <option value="{{ $company_type->id }}">{{ $company_type->type }}</option>
                                            @endforeach
                                        </select>

                                        @error('company_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="company_slogan" class="col-md-12 col-form-label">{{ __('Company Slogan') }}</label>

                                    <div class="col-md-12">
                                        <input id="company_slogan" type="text" maxlength="255" class="form-control @error('company_slogan') is-invalid @enderror" name="company_slogan" value="{{ old('company_name') }}" required autocomplete="company_slogan">

                                        @error('company_slogan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row mb-0 mt-4">
                                <div class="offset-md-5">
                                    <button type="submit" class="btn {{ (Auth::user()->money < 1e6) ? 'disabled' : '' }} btn-primary" {{ (Auth::user()->money < 1e6) ? 'disabled' : '' }}>
                                        {{ __('Create ($10,000)') }}
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
