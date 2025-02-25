<?php

namespace Modules\Team\Repositories;

use Modules\Team\Repositories\Interfaces\TeamModalityRepositoryInterface;
use Modules\Team\Entities\TeamModality;
use App\Services\ModelRepository;
use App\Traits\TranslationTrait;
use DB;

class TeamModalityRepository extends ModelRepository implements TeamModalityRepositoryInterface
{
     /**
     * @var string
    */
    protected $table = 'team_modality';

    /**
     * @var string
    */
    protected $tableTranslations = 'team_modality_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'team_modality_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(TeamModality $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

    /**
     * @param string $sport
     * @return array Return array sport modalities
     */
    public function findBySportAndTranslated($sport)
    {
        $query = DB::table('team_modality')
            ->select('team_modality.*', 'team_modality_translations.name' )
            ->join($this->tableTranslations,  $this->table . '.id', '=', $this->tableTranslations . '.' . $this->fieldAssociate)
            ->join('sports', 'team_modality.sport_id', '=', 'sports.id')
            ->where('sports.code', $sport)
            ->where($this->tableTranslations. '.locale', app()->getLocale());

        return $query->get();
    }
}