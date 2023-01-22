<?php

namespace App\Http\Controllers;

use App\Models\TruckStatus;
use Illuminate\Http\Request;
use Log;

class TruckStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $truck_status = new TruckStatus();

        $return_array = Array();
        $results = $truck_status->get();
        foreach ($results as $result)
        {
            array_push($return_array, $result);            
        }

        return  response(json_encode($return_array))->header('Content-Type', 'application/json');    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * When new truck is added, autmatically add new status with its id,
     *   add status 1 (lowest possible) and set driver id  and note to null
     *   (automatic on insert)
     * @param int $truck_id
     * @retrun bool 
     */
    public static function newTruckAdded($truck_id)
    {
        $truck_status = new TruckStatus();

        $truck_status->truck_id = $truck_id;
        $truck_status->status_id = 1;
        $success = true;
        try{
            $truck_status->save();
        }
        catch (\Illuminate\Database\QueryException $except)
        {
            // log the error - could pass back to calling function to notify user
            Log::error($except->getMessage());
            $success = false;
        }
        return $success;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TruckStatus  $truckStatus
     * @return \Illuminate\Http\Response
     */
    public function show(TruckStatus $truckStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TruckStatus  $truckStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TruckStatus $truckStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TruckStatus  $truckStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TruckStatus $truckStatus)
    {
        //
    }
}
