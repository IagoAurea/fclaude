<?php

namespace Modules\Club\Entities;

use Illuminate\Database\Eloquent\Model;

class ClubType extends Model
{
    const CLUB_TYPE_SPORT = 1;
    const CLUB_TYPE_ACADEMIC = 2;

    /**
     * Disabled timestamps for not inserting data
     *
     * @var String
     */
    public $timestamps = false;

    /**
     * Name of the table
     *
     * @var String
     */
    protected $table = 'club_types';

    /**
     * List of all fillable properties
     *
     * @var Array
     */
    protected $fillable = [
        'code',
    ];
}
