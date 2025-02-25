<?php

namespace Modules\EffortRecovery\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * @OA\Schema(
 *  title="EffortRecoveryStrategy",
 *  description="Effort Recovery Program Strategy - Estrategia Programa de Recuperacion del Esfuerzo",
 *  @OA\Xml(name="EffortRecoveryStrategy"),
 *  @OA\Property(
 *      title="ID",
 *      property="id",
 *      description="Strategy Identificator - Identificador de Estragegia",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Code",
 *      property="code",
 *      description="Translation code - Codigo de traduccion",
 *      format="string",
 *      example="trans_code"
 *  ),
 * )
 */
class EffortRecoveryStrategy extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'effort_recovery_strategies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
    ];
 
    /**
     * The attributes that are hidden from querying.
     *
     * @var array
     */
    protected $hidden = [
        'translations',
        'pivot',
    ];

    /**
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name',
    ];
 
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
