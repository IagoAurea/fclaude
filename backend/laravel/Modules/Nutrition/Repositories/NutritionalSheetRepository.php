<?php

namespace Modules\Nutrition\Repositories;

use Exception;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Nutrition\Entities\NutritionalSheet;
use Modules\Nutrition\Repositories\Interfaces\NutritionalSheetRepositoryInterface;


class NutritionalSheetRepository extends ModelRepository implements NutritionalSheetRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'nutritional_sheets';

    /**
     * @var object
     */
    protected $model;

    public function __construct(
        NutritionalSheet $model
    ) {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Public function to make the insert in the Nutritional File model and its relationships
     * 
     * @return Object
     */

    public function createNutritionalSheet($request)
    {
        DB::beginTransaction();
        try {
            $nutritionalSheet = $this->create($request->except('supplements', 'diets', 'athlete_activity'));

            $nutritionalSheet->supplements()->sync($request->supplements);
            $nutritionalSheet->diets()->sync($request->diets);

            $athleteActivity = $request->athlete_activity;
            $athleteActivity['nutritional_sheet_id'] = $nutritionalSheet->id;

            $nutritionalSheet->athleteActivity()->create($athleteActivity);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }
        return $nutritionalSheet;
    }

    /**
     * Public function to retrieve the Nutritional Sheet by id
     *
     * @return Object
     */

    public function findNutricionalSheetById($id)
    {
        $relations = $this->getModelRelations();

        $nutritionalSheet = $this->model
            ->with($relations)
            ->where('id', $id)
            ->first();

        if (!$nutritionalSheet) {
            throw new Exception("Nutritional Sheet not found");
        }

        $nutritionalSheet->diets->makeHidden('pivot');
        $nutritionalSheet->supplements->makeHidden('pivot');
        $nutritionalSheet->player->makeHidden('laterality');

        return $nutritionalSheet;
    }

    /**
     * Public function to retrieve the Nutritional Sheet by PlayerId 
     * 
     * @return Object
     */

    public function findNutricionalSheetByPlayerId($player_id)
    {
        $relations = $this->getModelRelations();

        return $this->model
            ->with($relations)
            ->where('player_id', $player_id)
            ->get();
    }

    /**
     * Private function to retrieve needed model relations in order to not to repeat
     * the same code on every query sent
     * 
     * @return Array
     */
    private function getModelRelations()
    {
        $locale = app()->getLocale();

        return [
            'player' => function ($query) {
                $query->select(
                    'players.id', 'players.full_name', 'players.team_id', 'players.image_id',
                    'players.position_id', 'players.shirt_number', 'players.height', 'players.weight',
                    'players.gender_id', 'players.date_birth'
                    )
                    ->with([
                        'team' => function ($query) {
                            $query->select(
                                'teams.id', 'teams.name', 'teams.category', 'teams.modality_id',
                                'teams.image_id', 'teams.color'
                            );
                        }, 'weight_controls' => function ($query) {
                            $query->select('weight_controls.player_id', 'weight_controls.weight', 'created_at as date')
                                ->latest()
                                ->first();
                        },
                    ]);
            },
            'supplements' => function ($query) use ($locale) {
                $query->select('supplements.id')
                    ->withTranslation($locale);
            },
            'diets' => function ($query) use ($locale) {
                $query->select(
                    'diets.id'
                )->withTranslation($locale);
            },
        ];
    }
}
