@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center form-heading">Purchase Order View</h2>
    
    <div class="col-md-8">
        <div class="card-body">
            @if (session('success_status'))
                <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session('success_status') }}
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-8">
        <div class="card-body">
            @if (session('warning_status'))
                <div class="alert alert-warning" role="alert" id="success-alert">
                    {{ session('warning_status') }}
                </div>
            @endif
        </div>
    </div>

    <form action="{{ url('/convertInv') }}" method="POST">
        @csrf
    
            <div class="row mt-2">

                <div class="col-md-2">
                    <label for="region" class="form-label">Region</label>
                    <select class="form-select" name="region" id="region" onchange="get_Grid_Data();">
                        <option value="" readonly>Select Region</option>
                        @foreach ($allRegions as $region)
                            <option value="{{ $region->id }}">{{ $region->region_code }}</option>    
                        @endforeach
                    </select>
                    @error('region')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="territory" class="form-label">Territory</label>
                    <select class="form-select" name="territory" id="territory" onchange="get_Grid_Data();">
                        <option value="" readonly>Select Territory</option>
                        @foreach ($allTerritory as $territory)
                            <option value="{{ $territory->id }}" {{ (old('territory') == $territory->id ? "selected" : "") }} >{{ $territory->territory_code }}</option>    
                        @endforeach

                    </select>
                    @error('territory')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="poNumber" class="form-label">PO NO</label>
                    <select class="form-select" name="poNumber" id="poNumber" onchange="get_Grid_Data();">
                        <option value="" readonly>Select PO NO</option>
                        @foreach ($allPoList as $po)
                            <option value="{{ $po->id }}">{{ $po->po_number }}</option>    
                        @endforeach
                    </select>
                    @error('poNumber')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="fromDate" class="form-label">From Date</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="datepicker" name="fromDate" placeholder="YYYY-MM-DD" onchange="get_Grid_Data();">
                    </div>
                    @error('fromDate')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="toDate" class="form-label">To Date</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="datepicker2" name="toDate" placeholder="YYYY-MM-DD" onchange="get_Grid_Data();">
                    </div>
                    @error('toDate')
                        <small class="fw-bold text-danger">{{ $message }}</small>    
                    @enderror
                </div>

                

            </div>
       

        <table class="table table-striped table-hover mt-5" id="po_table">
            <thead>
                <tr>
                    <th>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="mainCheckBox">
                            <label class="form-check-label">Check All</label>
                        </div>
                    </th>
                    <th scope="col">Region</th>
                    <th scope="col">Territory</th>
                    <th scope="col">Distributor</th>
                    <th scope="col">PO NUMBER</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Total</th>
                    <th scope="col" class="remove">Action</th>
                </tr>
            </thead>
            <tbody id="tbody">
                
            </tbody>
        </table>
        

        {{-- <input type="hidden" name="row_count" value="{{ $key }}"> --}}

        <button type="submit" class="btn btn-info btn-sm mt-4">Convert To Invoice</button>
        <button type="button" id="export_button" class="btn btn-success btn-sm mt-4">Export</button>
    </form>

    
</div>

<script>
    $( function() {
  
        $( "#datepicker" ).datepicker({
        dateFormat: "yy-mm-dd"
        });

        $( "#datepicker2" ).datepicker({
        dateFormat: "yy-mm-dd"
        });

    } );

    window.onload = function() {
        get_Grid_Data();
    };
</script>

<script>
    function get_Grid_Data() {

        let region = document.getElementById("region").value;
        let territory = document.getElementById("territory").value;
        let poNumber = document.getElementById("poNumber").value;
        let fromDate = document.getElementById("datepicker").value;
        let toDate = document.getElementById("datepicker2").value;

        $.ajax({
            url: "{{ route('purchaseOrder.poList') }}",
            type: "GET",
            data:{ 
                _token:'{{ csrf_token() }}',
                region: region,
                territory: territory,
                poNumber: poNumber,
                fromDate:fromDate,
                toDate:toDate
             
            },
            success: function(data){
                var str = "";

                var json_value = JSON.parse(data);

                for (var i=0; i < json_value.length; i++) {

                    let po_number = json_value[i].po_number;
                    let region_name = json_value[i].region_name;
                    let territory_name = json_value[i].territory_name;
                    let name = json_value[i].name;
                    let date = json_value[i].po_date;
                    let total_amount = json_value[i].total_amount;
                    let timeAmPm = json_value[i].timeAmPm;

                    let id = json_value[i].id;

                    str +=  "<tr>"+
                                "<td>"+
                                    "<div class='form-check'>"+
                                        "<input class='form-check-input' type='checkbox' name='checkbox[]' id='checkbox_"+i+"' value='"+id+"'>"+
                                        "<label class='form-check-label' for='flexCheckDefault'></label>"+
                                    "</div>"+
                                "</td>"+
                                "<td>"+region_name+"</td>"+
                                "<td>"+territory_name+"</td>"+
                                "<td>"+name+"</td>"+
                                "<td>"+po_number+"</td>"+
                                "<td>"+date+"</td>"+
                                "<td>"+timeAmPm+"</td>"+
                                "<td>"+total_amount.toFixed(2)+"</td>"+
                                "<td><a href='/purchaseOrder/"+id+"' type='button' class='btn btn-secondary btn-sm'>View</a></td>"+
                            "</tr>";

                            // "<td><a href='{{ route('purchaseOrder.show', ['purchaseOrder' => '"+id+"']) }}' type='button' class='btn btn-secondary btn-sm'>View</a></td>"+

                }
                $('#tbody').html(str);
            }
        });
        

    }

</script>
 
<script>
    $('#mainCheckBox').click(function() {
        if ($(this).is(':checked')) {
            $('input:checkbox').attr('checked', true);
        } else {
            $('input:checkbox').attr('checked', false);
        }
    });
</script>

<script>
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });
</script>


<script>
    function html_table_to_excel(type)
    {
        var data = document.getElementById('po_table');

        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

        XLSX.writeFile(file, 'Purchase Order.' + type);
    }

    const export_button = document.getElementById('export_button');

    export_button.addEventListener('click', () =>  {
        html_table_to_excel('xlsx');
    });
</script>
@endsection