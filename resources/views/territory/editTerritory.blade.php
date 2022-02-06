@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-header" style="position: relative; left: 10%; width: 1000px; ">
            <h2 class="text-center mb-5 form-heading">Territory Edit</h2> 
        <hr>
            <div class="card-body" style="position:relative; right: 9%;" >
                <form action="{{ route('territory.update', ['territory' => $territory->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="zoneCode" class="form-label">Zone</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <select class="form-select" name="zone" id="zone">
                                <option value="" readonly>Select Zone</option>
                                @foreach ($allZones as $zone)
                                    <option value="{{ $zone->id }}" {{ $zone->id == $territory->zone_id ? "selected" : "" }}>{{ $zone->zone_code }}</option>    
                                @endforeach
                            </select>
                            @error('zone')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="region" class="form-label">Region</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <select class="form-select" name="region" id="region">
                                <option value="" readonly>Select Region</option>
                                @foreach ($allRegions as $region)
                                    <option value="{{ $region->id }}" {{ $region->id == $territory->region_id ? "selected" : "" }}>{{ $region->region_code }}</option>    
                                @endforeach
                            </select>
                            @error('region')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="territoryCode" class="form-label">Territory Code</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="territoryCode" name="territoryCode" value="{{ $territory->territory_code }}" readonly>
                            @error('territoryCode')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="territoryName" class="form-label">Territory Name</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="territoryName" name="territoryName" value="{{ $territory->territory_name }}">
                            @error('territoryName')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mt-5 text-center" style="position:relative; left: 12%;">
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
    </div>
</div>
@endsection