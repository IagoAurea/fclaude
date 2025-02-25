<?php

namespace Modules\Staff\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffWorkExperience extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'staff_work_experiences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'occupation',
        'start_date',
        'finish_date',
        'staff_user_id',
    ];

    /**
     * The attributes that must not be shown from querying.
     * 
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
