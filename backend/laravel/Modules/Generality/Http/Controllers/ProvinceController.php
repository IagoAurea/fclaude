<?php

namespace Modules\Generality\Http\Controllers;

use Modules\Generality\Entities\Country;
use Modules\Generality\Cache\ProvinceCache;
use App\Http\Controllers\Rest\BaseController;

class ProvinceController extends BaseController
{
    /**
     * @var $provinceCache
     */
    protected $provinceCache;

    public function __construct(ProvinceCache $provinceCache)
    {
        $this->provinceCache = $provinceCache;
    }
    
    /**
    * @OA\Get(
    *  path="/api/v1/countries/{country}/provinces",
    *  tags={"General"},
    *  summary="Get list provinces by country - Lista de provincias por pais",
    *  operationId="list-provinces",
    *  description="Return data list provinces by country - Retorna listado de provincias por pais",
    *  @OA\Parameter( ref="#/components/parameters/_locale" ),
    *  @OA\Response(
    *    response=200,
    *    ref="#/components/responses/reponseSuccess"
    *   )
    * )
    */
    /**
     * Display a listing of the resource.
     * @param Country $country
     * @return Response
     */
    public function index(Country $country)
    {
        $provinces = $this->provinceCache->findTranslatedByCountry($country->iso2);

        return $this->sendResponse($provinces, 'List Provinces by country');
    }
}
