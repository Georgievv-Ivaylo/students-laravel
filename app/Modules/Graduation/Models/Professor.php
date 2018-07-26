<?php

namespace app\Modules\Graduation\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'professors';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
