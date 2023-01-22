<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $truck_label
 * @property TruckStatus[] $truckStatuses
 */
class Truck extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'truck';

    /**
     * @var array
     */
    protected $fillable = ['truck_label'];

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
