<?php

namespace Modules\Competition\Entities;

use Illuminate\Database\Eloquent\Model;

class TestTypeCategoryMatch extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'test_type_categories_match';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'test_category_match_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
