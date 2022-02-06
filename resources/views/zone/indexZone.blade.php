@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center form-heading">Zone CRUD</h1> 
    <a href="{{ route('zone.create') }}" class="btn btn-primary btn-sm">Add Zone</a>

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
                <th scope="col">Zone Long Description</th>
                <th scope="col">Short Description</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allZones as $key => $zone)
                <tr>
                    <th scope="row">{{ $key + 1}}</th>
                    <td>{{ $zone->zone_code }}</td>
                    <td>{{ $zone->zone_long_description }}</td>
                    <td>{{ $zone->zone_short_description }}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('zone.edit', ['zone' => $zone->id]) }}">Edit</a>
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