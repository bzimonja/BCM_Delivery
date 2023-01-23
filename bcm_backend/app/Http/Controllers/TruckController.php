<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\TruckStatusController;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trucks = new Truck();

        $return_array = Array();
        $results = $trucks->get();
        foreach ($results as $result)
        {
            array_push($return_array, $result);            
        }

        return  response(json_encode($return_array))->header('Content-Type', 'application/json');
    }

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
     * Add a new truck to the database using parameters provided by a JSON request
     * Parameters are
     *   truck_label: mandatory, name under which track will show in the system
     *      must be a string of 45 characters or fewer, not in database
     * Return response is json in format:
     * { "code": <0 for success, 
     *            1 for error>,
     *   "message": <"success" or explanation of error>}
     */
    public function add(Request $request)
    {
        
        $response = array();

        //check that the request is PUT or POST, with a valid non-empty JSON file
        $response = Utils::verifySaveRequest ($request);

        if ($response)
        {
            return response(json_encode($response), 200)->header('Content-Type', 'application/json');
        }

        $parameters = $request->json()->all();
        //check that mandatory parameters (truck_label in this case) are set 
        //  and of the appropriate type
        $verify_message = Utils::verifyParametersTruck($parameters, "add");
        if ( $verify_message != null)            
        {
            $response["code"] = 4;
            $response["mesage"] = $verify_message;

            return response(json_encode($response), 200)->header('Content-Type', 'application/json');
        }

        //call the database update function and return the success or fail message
        $truck = new Truck;

        $truck->truck_label = $parameters["truck_label"];
        $success = false;
        $db_error_code = "";

        // update may violate constraints
        //   two ways to check, one is to do a query for truck_label,
        //   the other to try update and see what went wrong - this will 
        //   cover any other database exceptions.
        try {
            $success = $truck->save();
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
            //truck should be set with no driver, and default status of 1 (leftmost lane)
            $truck_status_set = TruckStatusController::newTruckAdded($truck->id);
            //$truck_status_set = true;

            if ($truck_status_set)
            {
                $response["code"] = 0;
                $response["message"] = "Insert successful.";
            }
            else
            {
                $truck->delete();
                $response["code"] = 6;
                $response["message"] = "Insert failed due to issue with creating default status.";
            }
        }

        return response(json_encode($response), 200)->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function show(Truck $truck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function edit(Truck $truck)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Truck $truck)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function destroy(Truck $truck)
    {
        //
    }
}
