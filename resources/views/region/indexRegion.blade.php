@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center form-heading">Region CRUD</h1> 
    <a href="{{ route('region.create') }}" class="btn btn-primary btn-sm">Add Region</a>

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
                <th scope="col">Region Name</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allRegions as $key => $region)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $region->zone->zone_code }}</td>
                    <td>{{ $region->region_code }}</td>
                    <td>{{ $region->region_name }}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('region.edit', ['region' => $region->id]) }}">Edit</a>
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