<?php

//class that contains various utility functions 

namespace App;

use Illuminate\Http\Request;
use Log;

class Utils 
{
	//method to verify that api insert and update inputs are well-formed JSON provided via
	// PUT or POST request
	public static function verifySaveRequest(Request $request)
	{
		/** Reject non-POST, non-PUT requests.
         *  This could be done by specifying allowed request types in api.php,
         *    but this way we can generate a consistent JSON error message
         */
        $method = strtolower($request->method()); 

        if ($method != 'post' && $method !='put')
        {
            $response["code"] = 1;
            $response["message"] = "Add/update entry point requires a POST or PUT request. ". $method. " provided.";
            return response(json_encode($response), 400)->header('Content-Type', 'application/json');
        }
            
        //reject an empty request    
        if (sizeof($request->all()) == 0)
        {
            $response["code"] = 2;
            $response["message"] = "Add/update entry point requires parameters.";
            return response(json_encode($response), 400)->header('Content-Type', 'application/json');
        }

        $parameters = $request->json()->all();
        $error = json_last_error();

        if ($error) {
            //something went bad and Laravel cound't parse the parameters as JSON
            $response["code"] = 3;
            $response["message"] = 'Unable to parse JSON parameters:' . json_last_error_msg();

            return response(json_encode($response), 400)->header('Content-Type', 'application/json');
        }

        return true;

	}
	//method to verify input parameters for /api/truck entry points
	public static function verifyParametersTruck ($parameters, $action)
	{
		//for the assignment purposes, there are is only one action
		// - add, to create a new truck with the provided label

		$return_message = null;

		switch ($action)
		{
			case 'add':
			{

				if (!isset($parameters["truck_label"]) || $parameters["truck_label"] == "")
				{
					$return_message = "Truck label not set";
					return ($return_message);
				}

				if (sizeof($parameters) != 1)
				{
					$return_message = "Too many parameters provided";
					return ($return_message);
				}

				if (! is_string($parameters["truck_label"]))
				{
					$return_message = "Truck label must be a string.";
					return ($return_message);
				}
			}
			default:
			{
				$return_message = "Unknown operation requested.";
			}
		}
		return ($return_message);

	}

}

?>