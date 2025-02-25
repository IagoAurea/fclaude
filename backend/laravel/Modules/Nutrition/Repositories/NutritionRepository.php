<?php

namespace Modules\Nutrition\Repositories;

use App\Services\ModelRepository;
use Modules\Player\Entities\Player;
use Modules\Nutrition\Entities\NutritionalSheet;
use Modules\Nutrition\Repositories\Interfaces\NutritionRepositoryInterface;

class NutritionRepository extends ModelRepository implements NutritionRepositoryInterface
{
  
    /**
     * @var object
    */
    protected $nutritional_sheet;

    /**
     * @var object
    */
    protected $player;

    public function __construct(
        NutritionalSheet $nutritional_sheet,
        Player $player
    )
    {
        $this->nutritional_sheet = $nutritional_sheet;
        $this->player = $player;

        parent::__construct($this->nutritional_sheet);
        parent::__construct($this->player);
    }


  /**
     * Public function to retrieve the list of players with their
     * detailed information from their nutritional sheet
     *
     * @return Collection
     */
    public function findAllPlayersDetail($teamId)
    {
        $relations = $this->getModelRelations();

        $playersDetail = $this->player
            ->with($relations)
            ->where("team_id", $teamId)
            ->select('image_id', 'full_name', 'id', 'weight', 'gender_id', 'date_birth', 'height')
            ->orderBy('full_name', 'ASC')
            ->get();

        $playersDetail->makeHidden('laterality');
        
        return $playersDetail;
    }

    /**
     * Private function to retrieve needed model relations in order to not to repeat
     * the same code on every query sent
     *
     * @return Array
     */
    private function getModelRelations()
    {
        return [
            'image',
            'nutritional_sheet'=> function ($query){
                $query->select([
                    'player_id', 'id', 'total_energy_expenditure', 'take_diets', 'take_supplements', 'created_at'
                ])->latest();
            },
        ];
    }
  
    

    
}