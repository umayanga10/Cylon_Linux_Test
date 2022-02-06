@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-header" style="position: relative; left: 10%; width: 1000px; ">
        <h2 class="text-center  mb-5 form-heading">Region Edit</h2> 
        <hr>
            <div class="card-body" style="position:relative; right: 9%;" >
                <form action="{{ route('region.update', ['region' => $region->id]) }}" method="POST">
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
                                    <option value="{{ $zone->id }}" {{ $zone->id == $region->zone_id ? "selected" : "" }} >{{ $zone->zone_code }}</option>    
                                @endforeach
                            </select>
                            @error('zone')
                                <small class="fw-bold text-danger text-left">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="regionCode" class="form-label">Region Code</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="regionCode" name="regionCode" value="{{ $region->region_code }}" readonly>
                            @error('regionCode')
                                <small class="fw-bold text-danger text-left">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="regionName" class="form-label">Region Name</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="regionName" name="regionName" value="{{ $region->region_name }}">
                            @error('regionName')
                                <small class="fw-bold text-danger text-left">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mt-5 text-center" style="position:relative; left: 12%; ">
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
    </div>
</div>
@endsection