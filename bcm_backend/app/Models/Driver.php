<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $driver_first_name
 * @property string $driver_last_name
 * @property TruckStatus[] $truckStatuses
 */
class Driver extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     *   primary key
     */
    protected $table = 'driver';

    /**
     * @var array
     *  list of non-id columns
     */
    protected $fillable = ['driver_first_name', 'driver_last_name'];

    /**
     * @var bool
     * disable timestamps for purpose of assignment
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function truckStatuses()
    {
        return $this->hasOne('App\Models\TruckStatus');
    }
}
