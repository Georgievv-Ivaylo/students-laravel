<?php

namespace app\Modules\Graduation\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'students';


    protected $fillable = ['name', 'work_title', 'exam_id', 'degree_id', 'professor_id', 'deleted_on'];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the professor record associated with the user.
     */
    public function professor()
    {
        return $this->hasOne('app\Modules\Graduation\Models\Professor', 'id', 'professor_id');
    }

    public function exam()
    {
    	return $this->hasOne('app\Modules\Graduation\Models\Exam', 'id', 'exam_id');
    }

    public function degree()
    {
    	return $this->hasOne('app\Modules\Graduation\Models\Degree', 'id', 'degree_id');
    }
}
