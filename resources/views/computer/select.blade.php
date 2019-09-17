@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="computers">
                    @if(count($computers) > 0)
                        @foreach($computers as $computer)
                            <div class="card flex-row flex-wr computer">
                                <div class="card-header border-0">
                                    <img src="https://placehold.it/120" alt="">
                                </div>
                                <div class="card-body">
                                    <div class="card-top">
                                        {{ $computer->name }}
                                    </div>
                                    <div class="card-bottom">
                                        <a href="{{ route('computer.assembler', ['id' => $computer->id]) }}" role="button" class="btn btn-success">Assembler</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>You don't have a computer. Buy parts at the Shop and assemble it.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
