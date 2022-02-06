@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center form-heading">Territory CRUD</h1> 
    <a href="{{ route('territory.create') }}" class="btn btn-primary btn-sm">Add Territory</a>

    <div class="col-md-12">
        <div class="card-body">
            @if (session('success_status'))
                <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session('success_status') }}
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Zone Code</th>
                <th scope="col">Region Code</th>
                <th scope="col">Territory Code</th>
                <th scope="col">Territory Name</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allTerritory as $key => $territory)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $territory->zone->zone_code }}</td>
                    <td>{{ $territory->region->region_code }}</td>
                    <td>{{ $territory->territory_code }}</td>
                    <td>{{ $territory->territory_name }}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('territory.edit', ['territory' => $territory->id]) }}">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });

</script>
@endsection