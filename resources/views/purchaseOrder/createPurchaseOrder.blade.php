@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center form-heading">Purchase Order</h2> 

    <form action="{{ route('purchaseOrder.store') }}" method="POST">
        @csrf

            <div class="row mt-2">

                <div class="col-md-3">
                    <label for="zoneCode" class="form-label">Zone</label>
                    <select class="form-select" name="zone" id="zone">
                        <option value="" readonly>Select Zone</option>
                        @foreach ($allZones as $zone)
                            <option value="{{ $zone->id }}">{{ $zone->zone_code }}</option>    
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
                            <option value="{{ $region->id }}">{{ $region->region_code }}</option>    
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
                            <option value="{{ $territory->id }}" {{ (old('territory') == $territory->id ? "selected" : "") }} >{{ $territory->territory_code }}</option>    
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
                            <option value="{{ $user->id }}">{{ $user->name }}</option>    
                        @endforeach
                    </select>
                    @error('distributor')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

            </div>
            
            <div class="row mt-2">

                <div class="col-md-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="text" class="form-control" id="datepicker" name="date" value="{{ date('Y-m-d') }}">
                    @error('date')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="poNumber" class="form-label">PO No</label>
                    <input type="text" class="form-control" id="poNumber" name="poNumber" value="{{ $concat_id }}" readonly>
                    @error('poNumber')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="remark" class="form-label">Remark</label>
                    <input type="text" class="form-control" id="remark" name="remark" value="">
                    @error('remark')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

            </div>

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
                @foreach ($allProducts as $key => $product)
                    <tr id="tr_{{ $key }}">
                        <th>
                            <div class="input-group input-group-sm">
                                <input type="hidden" name="product_id_{{ $key }}" id="product_id_{{ $key }}" value="{{ $product->id }}">
                                <input type="text" name="sku_code_{{ $key }}" id="sku_code_{{ $key }}" value="{{ $product->sku_code }}" readonly class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </th>
                        <th>
                            <div class="input-group input-group-sm">
                                <input type="text" name="sku_name_{{ $key }}" id="sku_name_{{ $key }}" value="{{ $product->sku_name }}" readonly class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </th>
                        <th>
                            <div class="input-group input-group-sm">
                                <input type="text" name="MRP_{{ $key }}" id="MRP_{{ $key }}" value="{{ number_format((float)$product->MRP, 2, '.', '') }}" readonly class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </th>
                        <th>
                            <div class="input-group input-group-sm">
                                <input type="text" name="qty_{{ $key }}" id="qty_{{ $key }}" value="{{ $product->weightVolume }}" readonly class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </th>
                        <th>
                            <div class="input-group input-group-sm">
                                <input type="number" class="form-control" name="enter_qty_{{ $key }}" id="enter_qty_{{ $key }}" onblur="check_Qty_Validation({{ $key }});" onkeyup=" calculate_Total_price({{ $key }})" min="0" max="{{ $product->weightVolume }}" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="0"> 
                            </div>
                        </th>
                        <th>
                            <div class="input-group input-group-sm">
                                <input type="text" readonly name="calc_units_{{ $key }}" id="calc_units_{{ $key }}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="0">
                                <input type="hidden" name="units__name_{{ $key }}" id="units__name_{{ $key }}" value="{{ $product->unit }}">
                            </div>
                        </th>
                        <th>
                            <div class="input-group input-group-sm">
                                <input type="text" readonly name="calc_total_{{ $key }}" id="calc_total_{{ $key }}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="0.00">
                            </div>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <input type="hidden" name="row_count" value="{{ $key }}">

        <button type="submit" class="btn btn-primary mt-4" style="position:relative; left: 50%;">Add PO</button>
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
    function check_Qty_Validation(key) {

        let concat_unit = "";
        
        let product_avb_qty = document.getElementById("qty_"+key).value;
        let product_enter_qty = document.getElementById("enter_qty_"+key).value;

        let product_units__name = document.getElementById("units__name_"+key).value;

        // console.log("product_avb_qty "+product_avb_qty);
        // console.log("product_enter_qty "+product_enter_qty);

        let float_product_avb_qty = parseFloat(product_avb_qty);
        let float_product_enter_qty = parseFloat(product_enter_qty);

        if(float_product_avb_qty < float_product_enter_qty) {

            alert("You cannot add " +float_product_enter_qty+ " , Aailable Quntity is "+float_product_avb_qty);
            document.getElementById("enter_qty_"+key).value = 0;
        }else {

            if(Number.isNaN(float_product_enter_qty)){
                float_product_enter_qty = 0;
            }

            concat_unit = float_product_enter_qty+" "+product_units__name;
            document.getElementById("calc_units_"+key).value = concat_unit;
        }

        if(product_enter_qty == "") {
            document.getElementById("enter_qty_"+key).value = 0;
        }

    }

    let total_cost = 0.00;

    function calculate_Total_price(key) {

        let product_avb_qty = document.getElementById("qty_"+key).value;
        let product_enter_qty = document.getElementById("enter_qty_"+key).value;
        let product_MRP = document.getElementById("MRP_"+key).value;

        let float_product_avb_qty = parseFloat(product_avb_qty);
        let float_product_enter_qty = parseFloat(product_enter_qty);
        let float_product_MRP = parseFloat(product_MRP);

        let total = "";

        total = float_product_enter_qty * float_product_MRP;
        
        if(Number.isNaN(total)){
            total = 0;
        }else {

        }

        document.getElementById("calc_total_"+key).value = total.toFixed(2);

    }

    
</script>
@endsection