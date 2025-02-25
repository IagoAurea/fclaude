<?php

namespace Modules\Player\Repositories;

use App\Services\ModelRepository;
use Modules\Player\Entities\LineupPlayerType;
use Modules\Player\Repositories\Interfaces\LineupPlayerTypeRepositoryInterface;

class LineupPlayerTypeRepository extends ModelRepository implements LineupPlayerTypeRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'lineup_player_types';

    /**
     * @var string
    */
    protected $tableTranslations = 'lineup_player_types_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'lineup_player_type_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(LineupPlayerType $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return types lineup translations
     *
     */
    public function getTypesLineup($sport)
    {
        $lineups = $this->model->withTranslation(app()->getLocale())
            ->where("sport_id", $sport->id)
            ->get();

        $lineups->makeHidden('translations');
        
        return $lineups;
    }
}
