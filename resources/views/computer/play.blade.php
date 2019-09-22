@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-sm-6 my-2">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="rotate">
                            <i class="fa fa-user fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">{{ ($computer->uses_hdd()) ? 'HDD' : 'SSD' }}</h6>
                        <h1 class="display-6">{{ $computer->storage_size() }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 my-2">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="rotate">
                            <i class="fa fa-user fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Storage Speed</h6>
                        <h1 class="display-6">{{ $computer->storage_speed() . 'MB/s' }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 my-2">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="rotate">
                            <i class="fa fa-list fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Mining Power / hour</h6>
                        <h1 class="display-5">{{ $computer->video_power() }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
