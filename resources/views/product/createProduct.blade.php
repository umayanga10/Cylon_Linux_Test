@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-header" style="position: relative; left: 10%; width: 1000px; ">
            <h2 class="text-center mb-5 form-heading">ADD Product - (SKU)</h2> 
        <div class="card-body" style="position:relative; right: 9%;" >
                <form action="{{ route('product.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="skuId" class="form-label">SKU ID</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="skuId" name="skuId" value="{{ $concat_id }}" readonly>
                            @error('skuId')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                        
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="skuCode" class="form-label">SKU Code</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="skuCode" name="skuCode">
                            @error('skuCode')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="skuName" class="form-label">SKU Name</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="skuName" name="skuName">
                            @error('skuName')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="mrp" class="form-label">MRP</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="mrp" name="mrp">
                            @error('mrp')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3 ms-md-auto text-end">
                            <label for="distributorPrice" class="form-label">Distributor Price</label>
                        </div>
                        <div class="col-md-3 me-md-auto">
                            <input type="text" class="form-control" id="distributorPrice" name="distributorPrice">
                            @error('distributorPrice')
                                <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row ">

                        <div class="col-md-3 offset-md-3 text-end">
                            <label for="weightVolume" class="form-label">Weight/Volume</label>
                        </div>

                        <div class="col-md-6 me-md-auto">
                            <div class="d-flex">

                                <div class="col-md-4 me-3">
                                    <input type="text" class="form-control" id="weightVolume" name="weightVolume">
                                    @error('weightVolume')
                                        <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                                    @enderror
                                </div>
                    
                                <div class="col-sm-4">
                                    <select class="form-select" name="unit" id="unit" >
                                        <option value="" readonly>Select</option>
                                        <option value="Kg">Kg</option>    
                                        <option value="g">g</option>    
                                        <option value="ml">ml</option>    
                                        <option value="Packet">Packet</option>    
                                    </select>
                                    @error('unit')
                                        <small class="fw-bold text-danger text-start">{{ $message }}</small>    
                                    @enderror
                                </div>

                            </div>
                        </div>
                        
                    </div>

                    <div class="col-md-12 mt-5 text-center" style="position:relative; left: 12%;">
                        <button type="submit" class="btn btn-primary me-ms-auto">Add Product</button>
                    </div>
                    
                </form>

</div>
@endsection