<?php

namespace Modules\Generality\Entities;

use Modules\Team\Entities\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referee extends Model
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'referees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'country_id',
        'province_id',
        'team_id',
    ];

    /**
     * The attributes that are not showable.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Foreign key with countries
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * Foreign key with provinces
     * @return BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    /**
     * Relation with Team
     * @return BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
