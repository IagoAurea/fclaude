<?php

namespace Modules\Generality\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Generality\Http\Requests\StoreTaxRequest;
use Modules\Generality\Http\Requests\UpdateTaxRequest;
use Modules\Generality\Repositories\Interfaces\TaxRepositoryInterface;
use Exception;

class TaxController extends BaseController
{
    /**
     * @var $taxRepository
     */
    protected $taxRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(TaxRepositoryInterface $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * Display a listing of taxes.
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/taxes",
     *  tags={"General/Tax"},
     *  summary="Get list taxes - Lista de impuestos",
     *  operationId="list-taxes",
     *  security={{"bearerAuth": {} }},
     *  description="Return data list taxes - Retorna listado de impuestos",
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess",
     *  ),
     * )
     */
    public function index()
    {
        $taxes = $this->taxRepository->listAll();
        return $this->sendResponse($taxes, 'List Taxes');
    }

    /**
     * List the tax according to the tax_id. 
     * @param int $tax_id, This is the id value of the row to be queried. In general, the id is obtained from the tax list when you want to consult the data of a particular tax.
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/taxes/{tax_id}",
     *  tags={"General/Tax"},
     *  summary="Get tax by id - Consulta un impuesto dado el id",
     *  operationId="list-tax-id",
     *  security={{"bearerAuth": {} }},
     *  description="List the tax according to the tax_id  - Retorna el impuesto según el id",
     *  @OA\Parameter( ref="#/components/parameters/tax_id" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     * )
     */
    public function showTaxId($tax_id)
    {
        $tax = $this->taxRepository->listId($tax_id);
        return $this->sendResponse($tax, 'Tax Id');
    }

    /**
     * 
     * List the tax according to the location(country/province) and type of the user.
     * @param int $country, its value from the user table
     * @param int $province,its value from the user table, its a optional parameter, if not exist its value default is null.
     * @param boolean $iscompany, its value from the user table. True: self-employed and business, False: individuals.
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/taxes/{is_company}/{country_id}/{province_id?}",
     *  tags={"General/Tax"},
     *  summary="Get tax User's - Lista el impuesto de un usuario",
     *  operationId="list-tax-user",
     *  security={{"bearerAuth": {} }},
     *  description="List the tax according to the location(country/province) and type of the user - Retorna el impuesto según la localidad y tipo del usuario",
     *  @OA\Parameter( ref="#/components/parameters/is_company" ),
     *  @OA\Parameter( ref="#/components/parameters/country_id" ),
     *  @OA\Parameter( ref="#/components/parameters/province_id" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  )
     * )
     */
    public function showTaxUser($is_company, $country_id, $province_id = NULL)
    {
        $parameters = [
            'iscompany' => $is_company,
            'country' => $country_id,
            'province' => $province_id,
        ];

        $taxes = $this->taxRepository->listTaxUser($parameters);

        return $this->sendResponse($taxes, 'Tax User');
    }

    /**
     * Display a listing of taxes actives.
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/taxes/active",
     *  tags={"General/Tax"},
     *  summary="Get list actives taxes - Lista de impuestos activos",
     *  operationId="list-active-taxes",
     *  security={{"bearerAuth": {} }},
     *  description="Return data list actives taxes - Retorna listado de impuestos activos",
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     * )
     */
    public function showTaxesActive()
    {
        $taxes = $this->taxRepository->listActive();
        return $this->sendResponse($taxes, 'List Taxes Active');
    }

    /**
     * Display a listing of taxes no actives.
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/taxes/inactives",
     *  tags={"General/Tax"},
     *  summary="Get list no actives taxes - Lista de impuestos inactivos",
     *  operationId="list-no'actives-taxes",
     *  security={{"bearerAuth": {} }},
     *  description="Return data list no actives taxes - Retorna listado de impuestos no activos",
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     * )
     */
    public function showTaxesNoActive()
    {
        $taxes = $this->taxRepository->listNoActive();
        return $this->sendResponse($taxes, 'List Taxes no active');
    }

    /**
     * Create a new Tax
     * @param StoreTaxRequest $request
     * @return Response
     * 
     * @OA\Post(
     *  path="/api/v1/taxes",
     *  tags={"General/Tax"},
     *  summary="Store a new tax - Almacena un nuevo impuesto",
     *  operationId="store-tax",
     *  security={{"bearerAuth": {} }},
     *  description="Stores a new tax item into the database - Almacena un nuevo impuesto en la base de datos",
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreTaxRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     * )
     */
    public function store(StoreTaxRequest $request)
    {
        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            $stripeTaxRate = \Stripe\TaxRate::create([
                'display_name' => $request->name,
                'description' => $request->description ?? 'Tax rate',
                'jurisdiction' => $request->jurisdiction ?? 'US',
                'percentage' => $request->value,
                'inclusive' => $request->type === 'inclusive',
            ]);

            $taxCreate = [
                'name' => $request->name,
                'value' => $request->value,
                'type' => $request->type,
                'type_user' => $request->type_user,
                'start_date' => date('Y-m-d'),
                'taxable_id' => $request->taxable_id,
                'stripe_tax_id' => $stripeTaxRate->id,
            ];

            $tax = $this->taxRepository->createTax($taxCreate);
            return $this->sendResponse($tax, 'Tax stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating', $exception->getMessage());
        }
    }

    /**
     * Update a Tax
     * @param UpdateTaxRequest $request
     * @param $tax_id, This is the id value of the row to be queried. In general.
     * @return Response
     * 
     * @OA\Put(
     *  path="/api/v1/taxes/{tax_id}",
     *  tags={"General/Tax"},
     *  summary="Update a tax - Modifica un impuesto",
     *  operationId="update-tax",
     *  security={{"bearerAuth": {} }},
     *  description="Return Response - Retorna respuesta",
     *  @OA\Parameter( ref="#/components/parameters/tax_id" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateTaxRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     * )
     */
    public function update($tax_id, UpdateTaxRequest $request)
    {
        $tax = $this->taxRepository->find($tax_id);
        if (!$tax) {
            return $this->sendError("Tax not found", "NOT_FOUND", 404);
        }

        $taxData = $request->all();
        try {
            $taxData = $this->taxRepository->update($taxData, [
                "id" => $tax_id
            ]);
            return $this->sendResponse($taxData, 'Tax updated!');
        } catch (\Exception $e) {
            return $this->sendError('An error has occurred!', $e->getMessage());
        }
    }

    /**
     * Delete a Tax
     * @param $tax_id, This is the id value of the row to be
     * queried. In general, the id is obtained from the tax list 
     * when you want to consult the data of a particular tax.
     * @return Response
     * 
     * @OA\Delete(
     *  path="/api/v1/taxes/{tax_id}",
     *  tags={"General/Tax"},
     *  summary="Delete a tax - Elimina un impuesto",
     *  operationId="delete-tax",
     *  security={{"bearerAuth": {} }},
     *  description="Return Response - Retorna respuesta",
     *  @OA\Parameter( ref="#/components/parameters/tax_id" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     * )
     */
    public function delete($tax_id)
    {
        $tax = $this->taxRepository->find($tax_id);
        if (!$tax) {
            return $this->sendError("Tax not found", "NOT_FOUND", 404);
        }

        try {
            $tax = $this->taxRepository->delete($tax_id);
            
            return $this->sendResponse($tax, 'Tax deleted!', 200);
        } catch (\Exception $e) {
            return $this->sendError("An error has occurred trying to delete a Tax", $e->getMessage());
        }
    }
}
