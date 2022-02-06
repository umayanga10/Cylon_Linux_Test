@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-header" style="position: relative; left: 10%; width: 1000px; ">
        <h2 class="text-center  mb-5 form-heading">Zone Edit</h2> 
        <hr>
            <div class="card-body" style="position:relative; right: 9%;" >
                <form action="{{ route('zone.update', ['zone' => $zone->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="zoneCode" class="form-label">Zone Code</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="zoneCode" name="zoneCode" aria-describedby="zoneCode" readonly value="{{ $zone->zone_code }}">
                            @error('zoneCode')
                                <small class="fw-bold text-danger text-left">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="zoneLongDescription" class="form-label">Zone Long Description</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="zoneLongDescription" name="zoneLongDescription" value="{{ $zone->zone_long_description }}">
                            @error('zoneLongDescription')
                                <small class="fw-bold text-danger text-left">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="zoneShortDescription" class="form-label">Short Description</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="zoneShortDescription" name="zoneShortDescription" value="{{ $zone->zone_short_description }}">
                            @error('zoneShortDescription')
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