<?php

namespace app\Modules\Graduation\Models;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'degrees';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
