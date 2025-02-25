<?php

namespace Modules\Scouting\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Scouting\Repositories\ActionRepository;
use Modules\Scouting\Database\Seeders\Fixtures\ActionFixturesTrait;

class ActionsTableSeeder extends BaseSeeder
{
    use ResourceTrait;
    use ActionFixturesTrait;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

     /**
     * @var $actionRepository
     */
    protected $actionRepository;
    /**
     * @var object
     */

    public function __construct(
        ResourceRepositoryInterface $resourceRepository,
        ActionRepository $actionRepository
    ) {
        $this->resourceRepository = $resourceRepository;
        $this->actionRepository = $actionRepository;
    }

    /**
     * @return void
     */
    protected function createAction(array $sports)
    {
        foreach ($sports as $sport => $actions) {
            foreach ($actions as $action) {
                $dataResource = $this->uploadResource(sprintf('/scoutings/actions/%s', $sport), $action['image']);
                $resource = $this->resourceRepository->create($dataResource);

                $action_payload = [
                    'es' => [
                        'name' => $action['name_spanish'],
                        'plural' => isset($action['plural_spanish']) ? $action['plural_spanish'] : null,
                    ],
                    'en' => [
                        'name' => isset($action['name_english']) ? $action['name_english'] : $action['name_spanish'],
                        'plural' => isset($action['plural_english']) ? $action['plural_english'] : null,
                    ],
                    'code' => $action['code'],
                    'image_id' => $resource->id,
                    'rival_team_action' => $action['rival_team_action'],
                    'side_effect' => $action['side_effect'],
                    'order' => $action['order'],
                    'sport_id' => $action['sport_id'],
                    'is_total' => isset($action['is_total']) ? $action['is_total'] : false,
                    'calculate_total' => isset($action['calculate_total']) ? json_encode($action['calculate_total']) : null,
                    'custom_params' => isset($action['custom_params']) ? json_encode($action['custom_params']) : null,
                ];

                $this->actionRepository->create($action_payload);
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAction($this->getActions());
    }
}
