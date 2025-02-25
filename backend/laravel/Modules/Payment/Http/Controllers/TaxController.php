<?php

namespace Modules\Payment\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Payment\Http\Requests\StoreTaxRequest;
use Modules\Payment\Http\Requests\UpdateTaxRequest;
use Modules\Payment\Repositories\Interfaces\TaxRepositoryInterface;

class TaxController extends BaseController
{
    /**
     * @var $taxRepository
     */
    protected $taxRepository;

    public function __construct(
        TaxRepositoryInterface $taxRepository
    )
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * Display a listing of taxes.
     * @return Response
     */
    public function index()
    {
        $taxes = $this->taxRepository->findAll();

        return $this->sendResponse($taxes, 'List Taxes');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(StoreTaxRequest $request)
    {
        try {
            $taxCreate = [
                'type' => $request->type,
                'value' => $request->value
            ];

            $tax = $this->taxRepository->create($taxCreate);

            return $this->sendResponse($tax, 'Tax stored', Response::HTTP_CREATED);
        } 
        catch (Exception $exception) {
            return $this->sendError('Error by creating', $exception->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $tax = $this->taxRepository->find($id);

            return $this->sendResponse($tax, 'Tax information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Tax', $exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateTaxRequest $request, $id)
    {
        try {
            $tax = $this->taxRepository->find($id);
            $taxUpdate = [
                'value' => $request->value
            ];
            $updated = $this->taxRepository->update($taxUpdate, $tax);

            return $this->sendResponse($updated, 'Tax data updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating tax', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $return = $this->taxRepository->delete($id) 
                   ?$this->sendResponse(NULL, 'Tax deleted', Response::HTTP_ACCEPTED) 
                   :$this->sendError('Tax Not Existing');
      
            return $return; 
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Tax', $exception->getMessage());
        }
    }
}
