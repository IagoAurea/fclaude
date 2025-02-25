<?php

namespace Modules\Tutorship\Services\Interfaces;

interface TutorshipServiceInterface
{
    /**
     * Returns a list of tutorships by their school center
     */
    public function getListOfTutorshipsBySchoolCenter($school_center_id);

    /**
     * Returns a list of tutorships by their school center
     */
    public function getTutorshipById($id);

    /**
     * Stores a new tutorship
     */
    public function store($school_center_id, $payload);

    /**
     * Update a new tutorship
     */
    public function update($id, $payload);

    /**
     * Destroys a tutorship
     */
    public function destroy($id);
}
