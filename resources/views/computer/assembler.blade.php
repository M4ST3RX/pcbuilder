@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                            <td><a href="{{ route('computer.add-part', ['id' => $computer->id, 'item_id' => $item->id]) }}" class="btn btn-primary" role="button">Add</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
