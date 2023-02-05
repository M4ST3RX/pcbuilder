@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class="card" data-id="{{ $mine->id }}">
                    <div class="card-header">{{ $mine->name }} Miner</div>

                    @php
                        // minimum value $5
                        $converted_balance = floor($computer->wallet->getBalance($mine->currency_id) * $mine->exchange_rate * 100) / 100;
                    @endphp

                    <div class="card-body">
                        <p>Total {{ $mine->currency->name }}: {{ $computer->wallet->getBalance($mine->currency_id) }} <button role="button" style="margin-left: 10px" class="btn btn-sm btn-primary miner_sell{{ ($converted_balance < 5) ? ' disabled' : '' }}">Sell - ${{ number_format($converted_balance, 2, '.', ' ') }}</button></p>
                        <p>Mined Blocks: {{ number_format($computer->getMinedBlocks($mine->id)) }}</p>
                        <p>Mine Speed: {{ number_format($computer->getMiningSpeed($mine->id), 2) . ' blocks / minute' }}</p>
                        <p>RAM capacity: {{ $computer->ram_mine_capacity($mine->id) }}</p>
                    </div>
                    <div class="card-footer">
                        <button role="button" class="btn miner_toggle {{ ($computer->mine_id == $mine->id) ? 'btn-success' : 'btn-primary' }}" {{ !$computer->isComplete() || ($computer->mine_id != null && $computer->mine_id != $mine->id) ? 'disabled' : ''}}>{{ ($computer->mine_id == $mine->id) ? 'Collect' : 'Mine Coins' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
