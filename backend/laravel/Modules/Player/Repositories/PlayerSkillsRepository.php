<?php

namespace Modules\Player\Repositories;

use App\Services\ModelRepository;
use Modules\Player\Entities\PlayerSkills;
use Modules\Player\Repositories\Interfaces\PlayerSkillsRepositoryInterface;

class PlayerSkillsRepository extends ModelRepository implements PlayerSkillsRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'player_skills';

    /**
     * @var object
    */
    protected $model;

    public function __construct(PlayerSkills $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }


    /**
     * @param int $player_id
     * 
     */
    public function findSkillsByPlayer($player_id)
    {
        $relations = $this->getModelRelations();

        $skills = $this->model 
            ->where('player_id',$player_id)
            ->with($relations)
            ->get();
        
        $skills->makeHidden('player_id');
        $skills->makeHidden('skills_id');
        $skills->makeHidden('punctuation_id');

        return $skills;
    }

        /**
     * Private function to retrieve needed model relations in order to not to repeat
     * the same code on every query sent
     * 
     * @return Array
     */

    private function getModelRelations () 
    {
        $locale = app()->getLocale();

        return [
            'punctuation' => function ($query) use ($locale) {
                $query->select('punctuations.id','punctuations.value','punctuations.color')
                ->withTranslation($locale);
            },
            'skills' => function ($query) use ($locale) {
                $query->select('skills.id')
                ->withTranslation($locale);
            }
        ];
    }
}