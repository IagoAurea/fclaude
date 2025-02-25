<?php

namespace Modules\Tutorship\Services;

use Modules\Tutorship\Repositories\Interfaces\SpecialistReferralRepositoryInterface;
use Modules\Tutorship\Services\Interfaces\SpecialistReferralServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SpecialistReferralService implements SpecialistReferralServiceInterface
{
     /**
     * @var $specialistReferralRepository
     */
    protected $specialistReferralRepository;

    /**
     * Instances a new service class
     * 
     * @param SpecialistReferralRepositoryInterface $specialistReferralRepository
     */
    public function __construct(
        SpecialistReferralRepositoryInterface $specialistReferralRepository
    ) {
        $this->specialistReferralRepository = $specialistReferralRepository;
    }

    /**
     * Returns a list of specialist referrals
     */
    public function getListOfSpecialistReferrals()
    {
        return $this->specialistReferralRepository->findAllTranslated();
    }

    /**
     * Returns a list of specialist referrals
     */
    public function findByIdTranslated($id)
    {
        return $this->specialistReferralRepository->findByIdTranslated($id);
    }

    /**
     * Stores a new specialist referral
     */
    public function store($payload)
    {
        return $this->specialistReferralRepository->create($payload);
    }

    /**
     * Updates a specialist referral
     */
    /**
     * @OA\Response(
     *      response="specialistReferralNotFound",
     *      description="Return when a specific specialist referral is not found.",
     *      @OA\JsonContent(
     *          @OA\Property(property="success", type="string", example="false"),
     *          @OA\Property(property="message", type="string", example="The specialist referral 999 does not exist."),
     *      )
     *  )
     */
    public function update($id, $payload)
    {
        $type = $this->specialistReferralRepository->findOneBy(['id' => $id]);

        if (!$type) {
            throw new ModelNotFoundException;
        }

        return $type->update($payload);
    }

    /**
     * Destroys a specialist referral
     */
    public function destroy($id)
    {
        return $this->specialistReferralRepository->delete($id);
    }
}
