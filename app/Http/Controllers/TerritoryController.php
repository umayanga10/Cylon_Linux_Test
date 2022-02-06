<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Region;
use App\Models\Zone;
use App\Models\Territory;

class TerritoryController extends Controller
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
        $allTerritory = Territory::all();
        return view('territory.indexTerritory')->with('allTerritory', $allTerritory);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allZones = Zone::all();
        $allRegions = Region::all();
        $concat_id = $this->generateTerritoryCode();
        return view('territory.createTerritory')->with('allZones', $allZones)->with('allRegions', $allRegions)->with('concat_id', $concat_id);
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
            'region' => 'required',
            'territoryCode' => 'required',
            'territoryName' => 'required'
        ]);

        $TerritoryCode = $this->generateTerritoryCode();

        Territory::create([
            'territory_code' => $TerritoryCode,
            'territory_name' => $request->input('territoryName'),
            'zone_id' => $request->input('zone'),
            'region_id' => $request->input('region')
        ]);

        return redirect()->route('territory.index')->with('success_status','Territory Creadted');
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
        $allRegions = Region::all();
        $territory = Territory::where('id', $id)->first();
        return view('territory.editTerritory')->with('allZones', $allZones)->with('allRegions', $allRegions)->with('territory', $territory);
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
            'region' => 'required',
            'territoryCode' => 'required',
            'territoryName' => 'required'
        ]);

        $TerritoryCode = $this->generateTerritoryCode();

        Territory::where('id', $id)->update([
            'territory_name' => $request->input('territoryName'),
            'zone_id' => $request->input('zone'),
            'region_id' => $request->input('region')
        ]);

        return redirect()->route('territory.index')->with('success_status','Territory Updated');
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

    public function generateTerritoryCode() {

        $max_id_result = DB::select('SELECT MAX(id) as id FROM territories');
        $current_max_id = $max_id_result[0]->id;
        $auto_generated_max_id = DB::select("SELECT id, LPAD(id,5,'0') as Num FROM territories WHERE id = '$current_max_id'");
        // dd(count($auto_generated_max_id));
        if(count($auto_generated_max_id) == 0) {

            $concat_id = 'T-00001';

        }else {

            $incremented_id = str_pad(intval($auto_generated_max_id[0]->Num) + 1, strlen($auto_generated_max_id[0]->Num), '0', STR_PAD_LEFT);
            $concat_id = 'T-'.$incremented_id;

        }

        return $concat_id;

    }
}
