<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Region;
use App\Models\Zone;

class RegionController extends Controller
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
        $allRegions = Region::all();
        return view('region.indexRegion')->with('allRegions', $allRegions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allZones = Zone::all();
        $concat_id = $this->generateRegionCode();
        return view('region.createRegion')->with('allZones', $allZones)->with('concat_id', $concat_id);
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
            'zone' => 'required',
            'regionCode' => 'required',
            'regionName' => 'required'
        ]);

        $RegionCode = $this->generateRegionCode();

        Region::create([
            'region_code' => $RegionCode,
            'region_name' => $request->input('regionName'),
            'zone_id' => $request->input('zone')
        ]);

        return redirect()->route('region.index')->with('success_status','Region Creadted');
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
        $allZones = Zone::all();
        $region = Region::where('id', $id)->first();
        return view('region.editRegion')->with('allZones', $allZones)->with('region', $region);
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
        $validated = $request->validate([
            'zone' => 'required',
            'regionCode' => 'required',
            'regionName' => 'required'
        ]);

        $RegionCode = $this->generateRegionCode();

        Region::where('id', $id)->update([
            'region_name' => $request->input('regionName'),
            'zone_id' => $request->input('zone')
        ]);

        return redirect()->route('region.index')->with('success_status','Region Updated');
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

    public function generateRegionCode() {

        $max_id_result = DB::select('SELECT MAX(id) as id FROM regions');
        $current_max_id = $max_id_result[0]->id;
        $auto_generated_max_id = DB::select("SELECT id, LPAD(id,5,'0') as Num FROM regions WHERE id = '$current_max_id'");
        // dd(count($auto_generated_max_id));
        if(count($auto_generated_max_id) == 0) {

            $concat_id = 'R-00001';

        }else {

            $incremented_id = str_pad(intval($auto_generated_max_id[0]->Num) + 1, strlen($auto_generated_max_id[0]->Num), '0', STR_PAD_LEFT);
            $concat_id = 'R-'.$incremented_id;

        }

        return $concat_id;

    }
}
