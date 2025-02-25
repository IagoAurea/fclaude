<?php

namespace Modules\Tutorship\Http\Controllers;

use Modules\Tutorship\Services\Interfaces\SpecialistReferralServiceInterface;
use Modules\Tutorship\Http\Requests\SpecialistReferralRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Http\Request;

class SpecialistReferralController extends BaseController
{
    /**
     * Service
     * 
     * @var $specialistReferralService
     */
    protected $specialistReferralService;

    /**
     * Instances a new controller class
     * 
     * @param SpecialistReferralServiceInterface $specialistReferralService
     */
    public function __construct(
        SpecialistReferralServiceInterface $specialistReferralService
    ) {
        $this->specialistReferralService = $specialistReferralService;
    }

    /**
     * Display a list of specialist referrals
     * 
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/tutorships/specialist-referrals",
     *      tags={"Specialist Referrals"},
     *      summary="Specialist Referrals Index",
     *      operationId="specialist-referrals-index",
     *      description="Display a list of specialist referrals",
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
        $payload = $this->specialistReferralService->getListOfSpecialistReferrals();

        return $this->sendResponse($payload, 'List of specialist referrals');
    }

    /**
     * Display a specialist referral by a given id
     * 
     * @param int $id
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/tutorships/specialist-referrals/{specialist_referral_id}",
     *      tags={"Specialist Referrals"},
     *      summary="Specialist Referral Show - Details of a given specialist referral",
     *      operationId="specialist-referral-show",
     *      description="Shows the details of a given specialist referral",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/specialist_referral_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/specialistReferralNotFound"
     *      )
     *  )
     */
    public function show($id)
    {
        $payload = $this->specialistReferralService->findByIdTranslated($id);

        if ($payload->count() == 0) {
            return $this->sendError(sprintf('The specialist referral %s does not exist', $id), [], Response::HTTP_NOT_FOUND);
        }

        return $this->sendResponse($payload, sprintf('Specialist referral with the id: %s', $id));
    }

    /**
     * Store a new specialist referral
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/tutorships/specialist-referrals",
     *      tags={"Specialist Referrals"},
     *      summary="Store specialist referrals",
     *      operationId="specialist-referrals-store",
     *      description="Stores a new specialist referral",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/SpecialistReferralRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          ref="#/components/responses/responseCreated"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/unprocessableEntity"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     **/
    public function store(SpecialistReferralRequest $request)
    {
        try {
            $result = $this->specialistReferralService->store($request->all());

            return $this->sendResponse($result, 'Specialist referral successfully created', Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return $this->sendError('There was an error while storing the specialist referral', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a specialist referral
     * 
     * @param Request $request
     * @param int $request
     * @return Response
     */
    /**
     *  @OA\Put(
     *      path="/api/v1/tutorships/specialist-referrals/{specialist_referral_id}",
     *      tags={"Specialist Referrals"},
     *      summary="Updates a specialist referral",
     *      operationId="specialist-referral-update",
     *      description="Updates a specialist referral",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/specialist_referral_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/unprocessableEntity"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/specialistReferralNotFound"
     *      )
     *  )
     **/
    public function update(Request $request, $id)
    {
        try {
            $result = $this->specialistReferralService->update($id, $request->all());

            return $this->sendResponse($result, 'Specialist referral successfully updated', Response::HTTP_CREATED);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(sprintf('The specialist referral %s does not exist', $id), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->sendError('There was an error while updating the specialist referral', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Destory a specialist referral
     * 
     * @param int $specialist_referral_id
     * @return Response
     */
    /**
     *  @OA\Delete(
     *      path="/api/v1/tutorships/specialist-referrals/{specialist_referral_id}",
     *      tags={"Specialist Referrals"},
     *      summary="Destroys a specialist referral",
     *      operationId="specialist-referral-destroy",
     *      description="Deletes a specialist referral",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/specialist_referral_id" ),
     *      @OA\Response(
     *          response=204,
     *          ref="#/components/responses/resourceDeleted"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/unprocessableEntity"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/specialistReferralNotFound"
     *      )
     *  )
     **/
    public function destroy($id)
    {
        $response = $this->specialistReferralService->destroy($id);

        if (!$response) {
            return $this->sendError(sprintf('The specialist referral %s does not exist', $id), [], Response::HTTP_NOT_FOUND);
        }
        return $this->sendResponse($response, 'Specialist referral deleted', Response::HTTP_NO_CONTENT);
    }
}
