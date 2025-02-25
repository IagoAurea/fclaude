<?php

namespace Modules\Scouting\Http\Controllers;

use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Scouting\Repositories\Interfaces\ActionRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Rest\BaseController;
use App\Traits\ResourceTrait;
use Illuminate\Http\Request;
use Exception;

class ActionController extends BaseController
{
    use ResourceTrait;

    /**
     * Repository
     *
     * @var $actionRepository
     */
    protected $actionRepository;

    /**
     * Repository
     *
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * Repository
     *
     * @var $sportRepository
     */
    protected $sportRepository;

    /**
     * Instances a new controller class
     *
     * @param ActionRepositoryInterface $actionRepository
     */
    public function __construct(
        ActionRepositoryInterface $actionRepository,
        ResourceRepositoryInterface $resourceRepository,
        SportRepositoryInterface $sportRepository
    ) {
        $this->actionRepository = $actionRepository;
        $this->resourceRepository = $resourceRepository;
        $this->sportRepository = $sportRepository;
    }

    /**
     * @OA\Get(
     *       path="/api/v1/scouting/actions",
     *       tags={"Scouting"},
     *       summary="Display a list of actions availables grouped by sport -
     *       Muestra un listado de acciónes agrupados por deporte",
     *       operationId="scouting-actions",
     *       description="Display a list of actions availables grouped by sport -
     *       Muestra un listado de acciónes agrupados por deporte",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Display a list of actions availables
     * grouped by sport
     *
     * @return Response
     */
    public function index()
    {
        $actions = $this->actionRepository->findAllTranslated()->groupBy('sport_id');

        return $this->sendResponse($actions, 'List of actions');
    }

    /**
     * @OA\Get(
     *       path="/api/v1/scouting/actions/{sport_code}",
     *       tags={"Scouting"},
     *       summary="Display a list of actions availables by sport - Muestra un listado de acciónes por deporte",
     *       operationId="scouting-actions-sport",
     *       description="Display a list of actions availables by sport - Muestra un listado de acciónes por deporte",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/sport_code" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Display a list of actions availables
     * using the sport_id as parameter
     *
     * @param int $sport_id
     * @return Response
     */
    public function show($sport_id)
    {
        $sport = $this
            ->sportRepository
            ->findOneBy([!is_numeric($sport_id) ? 'code' : 'id' => $sport_id]);

        if (!$sport) {
            return $this->sendError(sprintf('There sport_id %s does not exist', $sport_id));
        }

        $actions = $this->actionRepository->findByTranslated([
            'sport_id' => $sport->id,
            'is_total' => false
        ]);

        return $this->sendResponse($actions, sprintf('List of actions of %s', $sport->code));
    }

    /**
     * Store a new action
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $payload = $request->all();

            if ($request->icon) {
                $dataResource = $this->uploadResource('/actions', $request->icon);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $payload['image_id'] = $resource->id;
                }
            }

            $result = $this->actionRepository->create($payload);

            return $this->sendResponse($result, 'Action successfully created', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('There was an error while storing the action',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
