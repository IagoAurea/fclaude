<?php

namespace Modules\Health\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Modules\Health\Repositories\Interfaces\TypeMedicineRepositoryInterface;

class TypeMedicineController extends BaseController
{
    /**
     * @var $medicineRepository
     */
    protected $medicineRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(TypeMedicineRepositoryInterface $medicineRepository)
    {
        $this->medicineRepository = $medicineRepository;
    }

    /**
     * Display a listing of type of medicines.
     * @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/health/type-medicines",
     *      tags={"Health"},
     *      summary="Get medicine types list - Lista de tipos de medicinas",
     *      operationId="list-medicine-types",
     *      description="Returns a list of medicine types - Retorna listado de tiposd e medicinas",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
    */
    public function index()
    {
        $typeMedicines = $this->medicineRepository->findAllTranslated();

        return $this->sendResponse($typeMedicines, 'List Type medicines');
    }
}
