<?php

namespace Modules\Tutorship\Services\Interfaces;

interface SpecialistReferralServiceInterface
{
    /**
     * Returns a list of specialist referrals
     */
    public function getListOfSpecialistReferrals();
    /**
     * Returns a list of specialist referrals
     */
    public function findByIdTranslated($id);
    /**
     * Stores a new specialist referral
     */
    public function store($payload);

    /**
     * Updates a specialist referral
     */
    public function update($id, $payload);

    /**
     * Destroys a specialist referral
     */
    public function destroy($id);
}
