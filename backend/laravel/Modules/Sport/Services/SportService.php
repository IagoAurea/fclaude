<?php

namespace Modules\Sport\Services;

use Modules\Sport\Cache\SportCache;

class SportService
{
    /**
     * @var object $teamCache
     */
    protected $sportCache;

    /**
     * Create a new service instance
     */
    public function __construct(
        SportCache $sportCache
    ) {
        $this->sportCache = $sportCache;
    }

    /**
     * Returns the list of all sports registered in database
     * @return Array
     *
     * @OA\Schema(
     *  schema="SportListResponse",
     *  type="object",
     *  description="Returns the list of all sports in database depending on the optional queryparameter sent",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Sports list"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="name", type="string", example="string"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="model_url", type="string", example="string"),
     *          @OA\Property(property="field_image", type="string", example="string"),
     *          @OA\Property(property="has_scouting", type="boolean", example="true"),
     *      ),
     *  ),
     * )
     */
    public function index($request)
    {
        $filter = [];

        if(isset($request->scouting)) {
            $scouting = $request->scouting == 'true';

            $filter['has_scouting'] = $scouting;
        }

        if($request->sport) {
            $filter['code'] = $request->sport;
        }

        return $this->sportCache->findBy($filter);
    }
}
