<?php

namespace Modules\Club\Entities;

use Illuminate\Database\Eloquent\Model;

class ClubUserType extends Model
{

    /**
     * Disabled timestamps for not inserting data
     * 
     * @var String
     */
    public $timestamps = false;

    /**
     * Name of related table
     * 
     * @var String
     */
    protected $table = 'club_user_type';


    /**
     * List of all fillable properties
     * 
     * @var Array
     */
    protected $fillable = [
        'name',
        'title'
    ];
}
