<?php

namespace Modules\Generality\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Generality\Cache\CountryCache;
use App\Http\Controllers\Rest\BaseController;

class CountryController extends BaseController
{
    /**
     * @var $countryRepository
     */
    protected $countryCache;

    public function __construct(CountryCache $countryCache)
    {
        $this->countryCache = $countryCache;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/countries",
    *       tags={"General"},
    *       summary="Get list Countries - Lista de paises",
    *       operationId="list-countries",
    *       description="Return data list countries - Retorna listado de paises",
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       )
    * )
    */
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $countries = $this->countryCache->findTranslatedByTerm($request->name);

        return $this->sendResponse($countries, 'List Countries');
    }
}
