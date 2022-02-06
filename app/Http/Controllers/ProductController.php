<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => []]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $concat_id = $this->generateSKUCode();
        return view('product.createProduct')->with('concat_id', $concat_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'skuId' => 'required', 
            'skuCode' => 'required',
            'skuName' => 'required',
            'mrp' => 'required',
            'distributorPrice' => 'required',
            'weightVolume' => 'required',
            'unit' => 'required',
        ]);

        $SKUCode = $this->generateSKUCode();

        Product::create([
            'sku_id' => $SKUCode,
            'sku_code' => $request->input('skuCode'),
            'sku_name' => $request->input('skuName'),
            'MRP' => $request->input('mrp'),
            'distributor_price' => $request->input('distributorPrice'),
            'weightVolume' => $request->input('weightVolume'),
            'unit' => $request->input('unit'),
        ]);

        return redirect()->route('home')->with('success_status','Product Creadted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateSKUCode() {

        $max_id_result = DB::select('SELECT MAX(id) as id FROM products');
        $current_max_id = $max_id_result[0]->id;
        $auto_generated_max_id = DB::select("SELECT id, LPAD(id,5,'0') as Num FROM products WHERE id = '$current_max_id'");
        // dd(count($auto_generated_max_id));
        if(count($auto_generated_max_id) == 0) {

            $concat_id = 'SKU-00001';

        }else {

            $incremented_id = str_pad(intval($auto_generated_max_id[0]->Num) + 1, strlen($auto_generated_max_id[0]->Num), '0', STR_PAD_LEFT);
            $concat_id = 'SKU-'.$incremented_id;

        }

        return $concat_id;

    }
}
