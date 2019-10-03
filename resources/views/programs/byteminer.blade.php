@extends('layouts.app')

@php
    $player = \App\Player::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class="card">
                    <div class="card-header">ByteMiner</div>

                    <div class="card-body">
                        <p>Total ByteCoins: {{ number_format($player->bytecoin / 100000, 5) }} <a style="margin-left: 10px" href="{{ route('programs.byteminer.sell') }}" role="button" class="btn {{ ($player->bytecoin * 381 < 100000) ? 'disabled' : '' }} btn-sm btn-primary">Sell - ${{ number_format($player->bytecoin * 381 / 100000, 2, '.', ' ') }}</a></p>
                        <p>Mined ByteCoins: {{ number_format($computer->current_mined_coins() / 100000, 5) }}</p>
                        <p>Mine Speed: {{ number_format($computer->mine_speed() / 100000, 5) . ' ByteCoin / minute' }}</p>
                        <p>RAM capacity: {{ $computer->ram_mine_capacity() }}</p>
                        <p>0.00001 ByteCoin = 4096 bytes</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('programs.byteminer.collect') }}" role="button" class="btn btn-success">Collect Coins</a>
                        <a href="{{ route('programs.byteminer.mine') }}" role="button" class="btn btn-{{ ($computer->mine_start_time) ? 'danger' : 'primary' }}">{{ ($computer->mine_start_time) ? 'Stop Mining' : 'Mine Coins' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
