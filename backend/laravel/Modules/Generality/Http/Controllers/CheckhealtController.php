<?php

namespace Modules\Generality\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Rest\BaseController;

class CheckhealtController extends BaseController
{
    const OK = 'ok';

    /**
    * @OA\Get(
    *       path="/api/v1/check-healt",
    *       tags={"General"},
    *       summary="Check healt app - Chequea status de aplicacion",
    *       operationId="check-healt",
    *       description="Return check healt status app - Retorna estatus de aplicacion",
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       )
    * )
    */
    /**
     * Retrieve check healt application.
     * @return JsonResponse
     */
    public function index()
    {
        $conectionDb = DB::connection()->getPDO();

        if(!$conectionDb) {
            return $this->sendError('Error check healt', 'Error Check Healt');
        }

        return $this->sendResponse([
            "apiVersion" => config('api.version'),
            "conectionDB" => self::OK
        ], 'Check Healt');
    }
}
