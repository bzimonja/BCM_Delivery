<?php

namespace App\Http\Controllers;

use App\Models\StatusOverview;
use Illuminate\Http\Request;

class StatusOverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $status_overview = new StatusOverview();

        $return_array = Array();
        $results = $status_overview->get();
        foreach ($results as $result)
        {
            array_push($return_array, $result);            
        }

        return  response(json_encode($return_array))->header('Content-Type', 'application/json');
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StatusOverview  $statusOverview
     * @return \Illuminate\Http\Response
     */
    public function show(StatusOverview $statusOverview)
    {
        //
    }

    
}
