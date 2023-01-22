<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** 
 * database view combining data from Truck, Status and Driver 
 *   tables, as expressed in TruckStatus table
 */
/**
 * @property integer $truck_id
 * @property string $truck_label
 * @property integer $status_id
 * @property string $status_label
 * @property integer $driver_id
 * @property string $driver_first_name
 * @property string $driver_last_name
 * @property string $note
 */

class StatusOverview extends Model
{
   protected $table = 'status_overview';
}
