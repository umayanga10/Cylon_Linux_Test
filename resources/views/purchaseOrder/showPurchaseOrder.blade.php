@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center form-heading">Purchase Order {{ $purchaseOrderHeader->po_number }} View</h2> <a href="{{ route('purchaseOrder.index') }}" class="btn btn-primary btn-sm">Back</a>

    <form action="{{ route('purchaseOrder.store') }}" method="POST">
        @csrf
        {{-- form header start --}}

            {{-- first row start --}}
            <div class="row mt-2">

                <div class="col-md-3">
                    <label for="zoneCode" class="form-label">Zone</label>
                    <select class="form-select" name="zone" id="zone">
                        <option value="" readonly>Select Zone</option>
                        @foreach ($allZones as $zone)
                            <option value="{{ $zone->id }}" {{ $purchaseOrderHeader->zone_id == $zone->id ? "selected" : "" }}>{{ $zone->zone_code }}</option>    
                        @endforeach
                    </select>
                    @error('zone')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="region" class="form-label">Region</label>
                    <select class="form-select" name="region" id="region">
                        <option value="" readonly>Select Region</option>
                        @foreach ($allRegions as $region)
                            <option value="{{ $region->id }}" {{ $purchaseOrderHeader->region_id == $region->id ? "selected" : "" }}>{{ $region->region_code }}</option>    
                        @endforeach
                    </select>
                    @error('region')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="territory" class="form-label">Territory</label>
                    <select class="form-select" name="territory" id="territory">
                        <option value="" readonly>Select Territory</option>
                        @foreach ($allTerritory as $territory)
                            <option value="{{ $territory->id }}" {{ $purchaseOrderHeader->territory_id == $territory->id ? "selected" : "" }} >{{ $territory->territory_code }}</option>    
                        @endforeach

                    </select>
                    @error('territory')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="distributor" class="form-label">Distributor</label>
                    <select class="form-select" name="distributor" id="distributor">
                        <option value="" readonly>Select Distributor</option>
                        @foreach ($allUsers as $user)
                            <option value="{{ $user->id }}" {{ $purchaseOrderHeader->user_id == $user->id ? "selected" : "" }}>{{ $user->name }}</option>    
                        @endforeach
                    </select>
                    @error('distributor')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

            </div>
            {{-- first row end --}}

            {{-- second row start --}}
            <div class="row mt-2">

                <div class="col-md-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="text" class="form-control" id="datepicker" name="date" value="{{ $purchaseOrderHeader->po_date }}">
                    @error('date')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="poNumber" class="form-label">PO No</label>
                    <input type="text" class="form-control" id="poNumber" name="poNumber" value="{{ $purchaseOrderHeader->po_number }}" readonly>
                    @error('poNumber')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="remark" class="form-label">Remark</label>
                    <input type="text" class="form-control" id="remark" name="remark" value="{{ $purchaseOrderHeader->remark }}">
                    @error('remark')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

            </div>
            {{-- second row end --}}

        {{-- form header end --}}

        {{-- form grid start --}}

        <table class="table mt-5">
            <thead>
                <tr>
                    <th scope="col">SKU CODE</th>
                    <th scope="col">SKU NAME</th>
                    <th scope="col">UNIT PRICE</th>
                    <th scope="col">AVB QTY</th>
                    <th scope="col">ENTER QTY</th>
                    <th scope="col">UNITS</th>
                    <th scope="col">TOTAL PRICE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrderItemList as $row)
                    <tr>
                        <th>{{ $row->product->sku_code }}</th>
                        <th>{{ $row->product->sku_name }}</th>
                        <th>{{ number_format((float)$row->product->MRP, 2, '.', '') }}</th>
                        <th>{{ $row->product->weightVolume }}</th>
                        <th>{{ $row->enter_qty }}</th>
                        <th>{{ $row->enter_qty }} {{ $row->product->unit }}</th>
                        <th>{{ number_format((float)$row->total_price, 2, '.', '') }}</th>
                        
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        {{-- form grid start --}}

        {{-- <button type="submit" class="btn btn-success mt-4">Save</button> --}}
    </form>

    
</div>

<script>
    $( function() {
  
        $( "#datepicker" ).datepicker({
        dateFormat: "yy-mm-dd"
        });

    } );
</script>
<script>
    function checkQtyValidation(key) {

        let concat_unit = "";
        
        let product_avb_qty = document.getElementById("qty_"+key).value;
        let product_enter_qty = document.getElementById("enter_qty_"+key).value;

        let product_units__name = document.getElementById("units__name_"+key).value;

        // console.log("product_avb_qty "+product_avb_qty);
        // console.log("product_enter_qty "+product_enter_qty);

        let float_product_avb_qty = parseFloat(product_avb_qty);
        let float_product_enter_qty = parseFloat(product_enter_qty);

        if(float_product_avb_qty < float_product_enter_qty) {

            alert("You cannot add " +float_product_enter_qty+ " , AVB QTY is "+float_product_avb_qty);
            document.getElementById("enter_qty_"+key).value = 0;
        }else {

            concat_unit = float_product_enter_qty+" "+product_units__name;
            document.getElementById("calc_units_"+key).value = concat_unit;
        }

    }

    let total_cost = 0.00;

    function calculateTotal(key) {

        let product_avb_qty = document.getElementById("qty_"+key).value;
        let product_enter_qty = document.getElementById("enter_qty_"+key).value;
        let product_MRP = document.getElementById("MRP_"+key).value;

        let float_product_avb_qty = parseFloat(product_avb_qty);
        let float_product_enter_qty = parseFloat(product_enter_qty);
        let float_product_MRP = parseFloat(product_MRP);

        let total = "";

        total = float_product_enter_qty * float_product_MRP;
        document.getElementById("calc_total_"+key).value = total.toFixed(2);

    }

    
</script>
@endsection