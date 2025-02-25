<?php

namespace Modules\Classroom\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      title="Age",
 *      description="The ages that are allowed to be registered within a classroom",
 *      @OA\Xml( name="Age"),
 *      @OA\Property(
 *          title="Range",
 *          property="range",
 *          description="String representing the range of ages",
 *          format="string",
 *          example="8-9 years"
 *      )
 * )
 */
class Age extends Model
{
    use HasFactory;

    protected $table = 'classroom_ages';
    protected $fillable = ['range'];

    protected static function newFactory()
    {
        return \Modules\Classroom\Database\factories\AgeFactory::new();
    }
}
