<?php

namespace Modules\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class CompetenceTranslation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'evaluation_competences_translations';

    /**
     * The foreign associated with the translation table.
     *
     * @var string
     */
    protected $translationForeignKey = 'evaluation_competence_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'acronym'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
