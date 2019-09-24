@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ByteMiner</div>

                    <div class="card-body">
                        <p>Total ByteCoins: {{ $computer->byte_coins }} <a style="margin-left: 10px" href="{{ route('programs.byteminer.sell') }}" role="button" class="btn btn-sm btn-primary">Sell - ${{ number_format($computer->byte_coins * 381, 2, '.', ' ') }}</a></p>
                        <p>Mined ByteCoins: {{ $computer->current_mined_coins() }}</p>
                        <p>Mine Speed: {{ $computer->mine_speed() }}</p>
                        <p>RAM capacity: {{ $computer->ram_mine_capacity() }}</p>
                        <p>0.0001 ByteCoin = 3096 bytes</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
