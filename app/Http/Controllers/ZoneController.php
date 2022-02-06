<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Zone;

class ZoneController extends Controller
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
        $allZones = Zone::all();
        return view('zone.indexZone')->with('allZones', $allZones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $concat_id = $this->ZoneCodeGenerate();
        return view('zone.createZone')->with('concat_id', $concat_id);
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
            'zoneCode' => 'required',
            'zoneLongDescription' => 'required',
            'zoneShortDescription' => 'required'
        ]);

        $ZoneCode = $this->ZoneCodeGenerate();

        Zone::create([
            'zone_code' => $ZoneCode,
            'zone_long_description' => $request->input('zoneLongDescription'),
            'zone_short_description' => $request->input('zoneShortDescription')
        ]);

        return redirect()->route('zone.index')->with('success_status','Zone Creadted');

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
        $zone = Zone::where('id', $id)->first();
        return view('zone.editZone')->with('zone', $zone);
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
            'zoneCode' => 'required',
            'zoneLongDescription' => 'required',
            'zoneShortDescription' => 'required'
        ]);

        Zone::where('id', $id)->update([
            'zone_long_description' => $request->input('zoneLongDescription'),
            'zone_short_description' => $request->input('zoneShortDescription')
        ]);

        return redirect()->route('zone.index')->with('success_status','Zone Updated');
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

    public function ZoneCodeGenerate() {

        $max_id_result = DB::select('SELECT MAX(id) as id FROM zones');
        $current_max_id = $max_id_result[0]->id;
        $auto_generated_max_id = DB::select("SELECT id, LPAD(id,5,'0') as Num FROM zones WHERE id = '$current_max_id'");
        // dd(count($auto_generated_max_id));
        if(count($auto_generated_max_id) == 0) {

            $concat_id = 'Z-00001';

        }else {

            $incremented_id = str_pad(intval($auto_generated_max_id[0]->Num) + 1, strlen($auto_generated_max_id[0]->Num), '0', STR_PAD_LEFT);
            $concat_id = 'Z-'.$incremented_id;

        }

        return $concat_id;

    }
}
