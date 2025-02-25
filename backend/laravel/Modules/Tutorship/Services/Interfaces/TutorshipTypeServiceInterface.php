<?php

namespace Modules\Tutorship\Services\Interfaces;

interface TutorshipTypeServiceInterface
{
    /**
     * Returns a list of tutorship types
     */
    public function getListOfTutorshipsTypes();
    /**
     * Returns a list of tutorship types
     */
    public function findByIdTranslated($id);
    /**
     * Stores a new tutorship type
     */
    public function store($payload);

    /**
     * Updates a tutorship type
     */
    public function update($id, $payload);

    /**
     * Destroys a tutorship type
     */
    public function destroy($id);
}
