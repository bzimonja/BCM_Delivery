<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $truck_id
 * @property integer $status_id
 * @property integer $driver_id
 * @property string $note
 * @property Driver $driver
 * @property Truck $truck
 * @property Status $status
 */
class TruckStatus extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'truck_status';

    /**
     * @var array
     */

    /**
     * @var bool 
     * disable timestamps for purpose of assignment
     */
    public $timestamps = false;

    protected $fillable = ['truck_id', 'status_id', 'driver_id', 'note'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo('App\Models\Driver');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function truck()
    {
        return $this->belongsTo('App\Models\Truck');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }
}
