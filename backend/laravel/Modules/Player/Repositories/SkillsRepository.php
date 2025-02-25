<?php

namespace Modules\Player\Repositories;

use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Player\Entities\Skills;
use Modules\Player\Repositories\Interfaces\SkillsRepositoryInterface;

class SkillsRepository extends ModelRepository implements SkillsRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'skills';

    /**
     * @var string
    */
    protected $tableTranslations = 'skills_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'skills_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(Skills $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return injury location translations
     *
     */
    public function findAllWithImage()
    {
        return $this->model 
            ->with('image')
            ->get();
    }

}