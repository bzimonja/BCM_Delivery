<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $status_label
 * @property TruckStatus[] $truckStatuses
 */
class Status extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'status';
    /**
     * @var bool
     * disable timestamps for purpose of assignment
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['status_label'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function truckStatuses()
    {
        return $this->hasMany('App\Models\TruckStatus');
    }
}
