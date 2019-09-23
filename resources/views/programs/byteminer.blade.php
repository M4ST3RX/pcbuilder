@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ByteMiner</div>

                    <div class="card-body">
                        <p>Total ByteCoins: {{ $computer->byte_coins }}</p>
                        <p>Mined ByteCoins: {{ $computer->current_mined_coins() }}</p>
                        <p>Mine Speed: {{ $computer->mine_speed() }}</p>
                        <p>RAM capacity: {{ $computer->ram_mine_capacity() }}</p>
                        <p>0.00001 ByteCoin = 1024 bytes </p>
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
