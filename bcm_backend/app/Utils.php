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

        return false;

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
				break;
			}
			default:
			{
				$return_message = "Unknown operation requested.";
			}
		}
		return ($return_message);

	}

	//method to verify input parameters for /api/truck_status entry points
	public static function verifyParametersTruckStatus ($parameters, $action)
	{
		//for the assignment purposes, there are is only one action
		// - upate, to update truck's status, and possibly assign/unassing a driver

		$return_message = null;

		switch ($action)
		{
			case 'update':
			{

				// truck_status table has internal id, which we check for first. 
				//   it is possible to use the truck_id foreign key instead, as 
				//   there is a strick 1:1 relationship between the two.				 
				if (!isset($parameters["truck_status_id"]) || $parameters["truck_status_id"] == null)
				{
					if (!isset($parameters["truck_id"]) || $parameters["truck_id"] == null)
					{
						$return_message = "Truck status id or truck id are required.";
						return ($return_message);
					}
				}

				// at least two parameters are required, such as truck id and status id,
				//  or truck status id and note
				if (sizeof($parameters) < 2)
				{
					$return_message = "Too few parameters provided, at least two are required.";
					return ($return_message);
				}

				// no more than five parameters are supported: truck id, status id,
				//  truck status id, driver id and note
				if (sizeof($parameters) > 5)
				{
					$return_message = "Too many parameters provided";
					return ($return_message);
				}

				if (isset($parameters["truck_status_id"]) && ! is_int($parameters["truck_status_id"]))
				{
					$return_message = "Truck status id must be an integer.";
					return ($return_message);
				}

				if (isset($parameters["truck_id"]) && ! is_int($parameters["truck_id"]))
				{
					$return_message = "Truck id must be an integer.";
					return ($return_message);
				}

				if (isset($parameters["status_id"]) && ! is_int($parameters["status_id"]))
				{
					$return_message = "Status id must be an integer.";
					return ($return_message);
				}

				if (isset($parameters["driver_id"]) && ! is_int($parameters["driver_id"]))
				{
					$return_message = "Driver id must be an integer.";
					return ($return_message);
				}

				if (isset($parameters["note"]) && ! is_string($parameters["note"]))
				{
					$return_message = "Note must be a string.";
					return ($return_message);
				}

				// if we provide truck status id or truck id, one of 
				//   status id, driver id or note must be set
				if (! isset($parameters["status_id"]) && ! isset($parameters["notes"]) 
					&& !isset($parameters["driver_id"]))
				{
					$return_message = "At least one of status_id, driver_id or notes must be set.";
					return($return_message);
				}
				break;
			}
			default:
			{				
				$return_message = "Unknown operation requested.";
				return($return_message);
			}
		}
		return ($return_message);

	}

}

?>