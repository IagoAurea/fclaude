<?php

namespace Modules\Tutorship\Entities;

use Illuminate\Database\Eloquent\Model;

class TutorshipTypeTranslation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tutorship_type_translations';

    /**
     * The foreign associated with the translation table.
     *
     * @var string
     */
    protected $translationForeignKey = 'tutorship_type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
