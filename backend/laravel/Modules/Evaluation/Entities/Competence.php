<?php

namespace Modules\Evaluation\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Generality\Entities\Resource;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'evaluation_competences';

    /**
     * The relationships that needs to be attached
     *
     * @var array
     */
    protected $with = [
        'image',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_id',
    ];

    /**
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name', 'acronym'
    ];

    /**
     * List of hidden properties of the model
     * 
     * @var Array
     */
    protected $hidden = [
        'translations',
        'created_at',
        'updated_at'
    ];

    /**
     * The foreign associated with the translation table.
     *
     * @var string
     */
    protected $translationForeignKey = 'evaluation_competence_id';

    /**
     * The indicators that belong to the competence.
     * 
     * @return BelongsToMany
     */
    public function indicators()
    {
        return $this->belongsToMany(Indicator::class, 'competence_indicator');
    }

    /**
     * Returns the related image resource object
     *
     * @return Object
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }
}
