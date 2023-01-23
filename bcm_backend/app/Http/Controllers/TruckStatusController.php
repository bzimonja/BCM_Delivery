<?php

namespace App\Http\Controllers;
use App\Utils;
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
     * Update the status of a truck.
     *  Since each truck_status is only associated with a single truck, 
     *  truck_id is mandatory, if truck_status id is not provided instead
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $response = array();

        //check that the request is PUT or POST, with a valid non-empty JSON file
        $response = Utils::verifySaveRequest ($request);

        if ($response)
        {
            return response(json_encode($response), 400)->header('Content-Type', 'application/json');
        }

        $parameters = $request->json()->all();
        
        //check that mandatory parameters are set 
        //  and of the appropriate type
        $verify_message = Utils::verifyParametersTruckStatus($parameters, "update");
        if ( $verify_message != null)            
        {
            $response["code"] = 4;
            $response["mesage"] = $verify_message;

            return response(json_encode($response), 400)->header('Content-Type', 'application/json');
        }

        // find the record with corresponding truck status id or truck id
        $truck_status = new TruckStatus;
        if (isset ($parameters["truck_status_id"]))
        {
            $truck_status = $truck_status->where("id", $parameters["truck_status_id"]);
        }
        if (isset ($parameters["truck_id"]))
        {
            $truck_status = $truck_status->where("truck_id", $parameters["truck_id"]);
        }
        $truck_status_to_update = $truck_status->first();   

        // if status can't be found, return an error
        if (!$truck_status_to_update)
        {
            $response["code"] = 5;
            $response["message"] = "Database update failed. Could not find the truck status.";
            return response(json_encode($response), 400)->header('Content-Type', 'application/json');
        }   

        //extract the update 
        foreach ($parameters as $param_name => $param_value)
        {
            // check for the fields we want to update and update the existing entry
            if ($param_name == "note" )
            {
                $truck_status_to_update->note = $param_value;
            }
            if ($param_name == "status_id" )
            {
                $truck_status_to_update->status_id = $param_value;
            }
            if ($param_name == "driver_id" )
            {
                $truck_status_to_update->driver_id = $param_value;
            }
            
        }
        $success = false;
        $db_error_code = "";
        try {
            $success = $truck_status_to_update->save();
        }
        catch (\Illuminate\Database\QueryException $except)
        {
            $db_error_code= $except->getMessage();
        }

        if (!$success)
        {
            $response["code"] = 5;
            $response["message"] = "Database update failed. Database error code ".$db_error_code;
        }
        else
        {
            $response["code"] = 0;
            $response["message"] = "Database update successful.";
        }

        return response(json_encode($response), 400)->header('Content-Type', 'application/json');

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
