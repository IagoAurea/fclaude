<?php

namespace Modules\Tutorship\Services;

use Modules\Tutorship\Repositories\Interfaces\TutorshipTypeRepositoryInterface;
use Modules\Tutorship\Services\Interfaces\TutorshipTypeServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TutorshipTypeService implements TutorshipTypeServiceInterface
{
     /**
     * @var $tutorshipTypeRepository
     */
    protected $tutorshipTypeRepository;
    /**
     * Instances a new service class
     *
     * @param TutorshipTypeRepositoryInterface $tutorshipTypeRepository
     */
    public function __construct(
        TutorshipTypeRepositoryInterface $tutorshipTypeRepository
    ) {
        $this->tutorshipTypeRepository = $tutorshipTypeRepository;
    }

    /**
     * Returns a list of tutorship types
     */
    public function getListOfTutorshipsTypes()
    {
        return $this->tutorshipTypeRepository->findAllTranslated();
    }

    /**
     * Returns a list of tutorship types
     */
    public function findByIdTranslated($id)
    {
        return $this->tutorshipTypeRepository->findByIdTranslated($id);
    }

    /**
     * Stores a new tutorship type
     */
    public function store($payload)
    {
        return $this->tutorshipTypeRepository->create($payload);
    }

    /**
     * Updates a tutorship type
     */
    /**
     * @OA\Response(
     *      response="tutorshipTypeNotFound",
     *      description="Return when a specific tutorship type is not found.",
     *      @OA\JsonContent(
     *          @OA\Property(property="success", type="string", example="false"),
     *          @OA\Property(property="message", type="string", example="The tutorship type 999 does not exist."),
     *      )
     *  )
     */
    public function update($id, $payload)
    {
        $type = $this->tutorshipTypeRepository->findOneBy(['id' => $id]);

        if (!$type) {
            throw new ModelNotFoundException;
        }

        return $type->update($payload);
    }

    /**
     * Destroys a tutorship type
     */
    public function destroy($id)
    {
        return $this->tutorshipTypeRepository->delete($id);
    }
}
