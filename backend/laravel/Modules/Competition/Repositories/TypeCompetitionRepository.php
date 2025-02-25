<?php

namespace Modules\Competition\Repositories;

use App\Services\ModelRepository;
use Modules\Competition\Entities\TypeCompetition;
use Modules\Competition\Repositories\Interfaces\TypeCompetitionRepositoryInterface;

class TypeCompetitionRepository extends ModelRepository implements TypeCompetitionRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * @var string
     */
    protected $table = 'type_competitions';

    /**
     * @var string
     */
    protected $tableTranslations = 'type_competition_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'type_competition_id';

    public function __construct(TypeCompetition $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function findBySport($sport)
    {
        return $this->model
            ->whereHas('sport', function($query) use($sport) {
                $query->where('code', $sport);
            })
            ->orderByTranslation('name')
            ->get();
    }


}
