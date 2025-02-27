<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'taxes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'value'
    ];
}