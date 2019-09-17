@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $computer->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $computer->pc_brand->name }}</h6>
                        <p class="card-text"></p>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->hardware->name }}</td>
                            @if($item->computer_id)
                                <td><a href="{{ route('computer.remove-part', ['id' => $computer->id, 'item_id' => $item->id]) }}" class="btn btn-danger" role="button">Remove</a></td>
                            @else
                                <td><a href="{{ route('computer.add-part', ['id' => $computer->id, 'item_id' => $item->id]) }}" class="btn btn-primary" role="button">Add</a></td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
