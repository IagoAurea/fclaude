<?php

namespace Modules\Psychology\Repositories;

use App\Services\ModelRepository;
use Modules\Psychology\Entities\PsychologySpecialist;
use Modules\Psychology\Repositories\Interfaces\PsychologySpecialistRepositoryInterface;

class PsychologySpecialistRepository extends ModelRepository implements PsychologySpecialistRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * @var string
     */
    protected $table = 'psychology_specialists';

    /**
     * @var string
     */
    protected $tableTranslations = 'psychology_specialist_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'psychology_specialist_id';

    public function __construct(PsychologySpecialist $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }


}
