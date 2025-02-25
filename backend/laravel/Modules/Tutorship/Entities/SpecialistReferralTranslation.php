<?php

namespace Modules\Tutorship\Entities;

use Illuminate\Database\Eloquent\Model;

class SpecialistReferralTranslation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'specialist_referral_translations';

    /**
     * The foreign associated with the translation table.
     *
     * @var string
     */
    protected $translationForeignKey = 'specialist_referral_id';

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
