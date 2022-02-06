<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\PurchaseOrderHeader;
use App\Models\PurchaseOrderItemList;
use App\Models\Region;
use App\Models\Territory;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => []]);
    }

    public function index() {

        $allRegions = Region::all();
        $allTerritory = Territory::all();
        $allPoList = PurchaseOrderHeader::all();

        return view('purchaseOrder.indexPurchaseOrder')->with('allRegions', $allRegions)
                                                        ->with('allTerritory', $allTerritory)
                                                        ->with('allPoList', $allPoList);
                                                      
        
    }

    public function create() {

        $allZones = Zone::all();
        $allRegions = Region::all();
        $allTerritory = Territory::all();
        $allProducts = Product::all();
        $concat_id = $this->generatePOCode();
        $allUsers = DB::select("SELECT * FROM users WHERE usertype = '1' ");

        return view('purchaseOrder.createPurchaseOrder')->with('allZones', $allZones)
                                                        ->with('allRegions', $allRegions)
                                                        ->with('allTerritory', $allTerritory)
                                                        ->with('allUsers', $allUsers)
                                                        ->with('allProducts', $allProducts)
                                                        ->with('concat_id', $concat_id);

    }

    public function show($id) {

        $allZones = Zone::all();
        $allRegions = Region::all();
        $allTerritory = Territory::all();
        $allProducts = Product::all();
        $allUsers = DB::select("SELECT * FROM users WHERE usertype = '1' ");

        $purchaseOrderHeader = PurchaseOrderHeader::where('id', '=', $id)->first();
        $purchaseOrderItemList = PurchaseOrderItemList::where('purchase_order_header_id', '=', $purchaseOrderHeader->id)->get();

        return view('purchaseOrder.showPurchaseOrder')->with('allZones', $allZones)
                                                    ->with('allRegions', $allRegions)
                                                    ->with('allTerritory', $allTerritory)
                                                    ->with('allUsers', $allUsers)
                                                    ->with('allProducts', $allProducts)
                                                    ->with('purchaseOrderItemList', $purchaseOrderItemList)
                                                    ->with('purchaseOrderHeader', $purchaseOrderHeader);
    }

    public function store(Request $request) {

        // dd($request->all());

        $validated = $request->validate([
            'zone' => 'required',
            'region' => 'required',
            'territory' => 'required',
            'distributor' => 'required',
            'date' => 'required',
            'poNumber' => 'required'
        ]);

        $po_code = $this->generatePOCode();

        $header_id = PurchaseOrderHeader::create([
                        'zone_id' => $request->input('zone'),
                        'region_id' => $request->input('region'),
                        'territory_id' => $request->input('territory'),
                        'user_id' => $request->input('distributor'),
                        'po_date' => $request->input('date'),
                        'po_number' => $po_code,
                        'remark' => $request->input('remark'),
                    ]);

        $last_insert_id = $header_id->id;

        $row_count = $request->input("row_count");

        for($i = 0; $i <= $row_count; $i++) {

            $old_qty = "";
            $new_qty = "";
            $qty_diff = "";
            $product_id = "";

            $old_qty = $request->input('qty_'.$i);
            $new_qty = $request->input('enter_qty_'.$i);

            $product_id = $request->input('product_id_'.$i);

            if($new_qty !== 0 && !empty($product_id)) {

                $qty_diff = $old_qty - $new_qty;

                Product::where('id', $product_id)->update([
                    'weightVolume' => $qty_diff,
                ]);

            }


            $PurchaseOrderItemList_obj = new PurchaseOrderItemList();
            $PurchaseOrderItemList_obj->purchase_order_header_id = $last_insert_id;
            $PurchaseOrderItemList_obj->product_id = $product_id;
            $PurchaseOrderItemList_obj->enter_qty = $new_qty;
            $PurchaseOrderItemList_obj->total_price = $request->input('calc_total_'.$i);    
            $PurchaseOrderItemList_obj->save();
            
        }

        return redirect()->route('home')->with('success_status','PurchaseOrder Creadted');

    }

    public function generatePOCode() {

        $max_id_result = DB::select('SELECT MAX(id) as id FROM purchase_order_headers');
        $current_max_id = $max_id_result[0]->id;
        $auto_generated_max_id = DB::select("SELECT id, LPAD(id,5,'0') as Num FROM purchase_order_headers WHERE id = '$current_max_id'");
        // dd(count($auto_generated_max_id));
        if(count($auto_generated_max_id) == 0) {

            $concat_id = 'TEPO-00001';

        }else {

            $incremented_id = str_pad(intval($auto_generated_max_id[0]->Num) + 1, strlen($auto_generated_max_id[0]->Num), '0', STR_PAD_LEFT);
            $concat_id = 'TEPO-'.$incremented_id;

        }

        return $concat_id;

    }

    public function poList(Request $request) {

        $region = $request->input('region');
        $territory = $request->input('territory');
        $poNumber = $request->input('poNumber');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        // echo $region."--".$territory."--".$poNumber."--".$fromDate."--".$toDate;

        $query = DB::table('purchase_order_headers')
                            ->join('purchase_order_item_lists', 'purchase_order_headers.id', '=', 'purchase_order_item_lists.purchase_order_header_id')
                            ->join('regions', 'purchase_order_headers.region_id', '=', 'regions.id')
                            ->join('territories', 'purchase_order_headers.territory_id', '=', 'territories.id')
                            ->join('users', 'purchase_order_headers.user_id', '=', 'users.id')
                            ->leftJoin('invoices', 'purchase_order_headers.id', '=', 'invoices.purchase_order_header_id')
                            ->groupBy('purchase_order_headers.id');

                            $query->select(
                                'purchase_order_headers.id',
                                'purchase_order_headers.po_date', 
                                'purchase_order_headers.po_number', 
                                'purchase_order_item_lists.total_price', 
                                'regions.region_name', 
                                'territories.territory_name', 
                                'users.name',
                                DB::raw('SUM(purchase_order_item_lists.total_price) as total_amount'),
                                DB::raw("DATE_FORMAT(purchase_order_headers.updated_at, '%r') as timeAmPm")
                            );

                            $query->where('invoices.purchase_order_header_id', '=', null);

                            if(!empty($region)) {

                                $query->where('regions.id', '=', $region);

                            }

                            if(!empty($territory)) {

                                $query->where('territories.id', '=', $territory);

                            }

                            if(!empty($territory)) {

                                $query->where('territories.id', '=', $territory);

                            }

                            if(!empty($poNumber)) {

                                $query->where('purchase_order_headers.id', '=', $poNumber);

                            }

                            if(!empty($fromDate) && !empty($toDate)) {

                                $query->whereBetween('purchase_order_headers.po_date', [$fromDate, $toDate]);

                            }

                            

        $result = $query->get();

        return json_encode($result);

    }

    public function convertInv(Request $request) {
        
        $checkBoxArray = $request->checkbox;

        if(isset($checkBoxArray) && is_array($checkBoxArray)) {

            $invoice_code = $this->generateInvoiceCode();

            $po_array = [];

            foreach($checkBoxArray as $checkBox) {
    
                $invoice_obj = new Invoice();
                $invoice_obj->invoice_code = $invoice_code;
                $invoice_obj->purchase_order_header_id = $checkBox;
                $invoice_obj->save();

                $po = $invoice_obj->purchaseOrderHeader->po_number;
                array_push($po_array, $po);

                $po_list = implode(', ', $po_array);
    
            }

            return redirect()->route('purchaseOrder.index')->with('success_status', 'These PO(s) converted to invoice '.$po_list);

        }else {
            
            return redirect()->route('purchaseOrder.index')->with('warning_status','Please Check at least one checkbox');

        }

    }

    public function generateInvoiceCode() {

        $max_id_result = DB::select('SELECT MAX(id) as id FROM invoices');
        $current_max_id = $max_id_result[0]->id;
        $auto_generated_max_id = DB::select("SELECT id, LPAD(id,5,'0') as Num FROM invoices WHERE id = '$current_max_id'");
        // dd(count($auto_generated_max_id));
        if(count($auto_generated_max_id) == 0) {

            $concat_id = 'INV-00001';

        }else {

            $incremented_id = str_pad(intval($auto_generated_max_id[0]->Num) + 1, strlen($auto_generated_max_id[0]->Num), '0', STR_PAD_LEFT);
            $concat_id = 'INV-'.$incremented_id;

        }

        return $concat_id;

    }

    
}
