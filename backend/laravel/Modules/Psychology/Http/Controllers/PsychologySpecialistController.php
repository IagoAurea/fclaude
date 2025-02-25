<?php


namespace Modules\Psychology\Http\Controllers;


use App\Http\Controllers\Rest\BaseController;
use Illuminate\Http\JsonResponse;
use Modules\Psychology\Repositories\Interfaces\PsychologySpecialistRepositoryInterface;

class PsychologySpecialistController extends BaseController
{

    /**
     * Repository
     * @var $psychologySpecialistRepository
     */
    protected $psychologySpecialistRepository;

    /**
     * PsychologySpecialistController constructor.
     * @param PsychologySpecialistRepositoryInterface $psychologySpecialistRepository
     */
    public function __construct(PsychologySpecialistRepositoryInterface $psychologySpecialistRepository)
    {
        $this->psychologySpecialistRepository = $psychologySpecialistRepository;
    }

    /**
     * Get list psychology specialist
     * @return JsonResponse
     */
    public function index()
    {
        return $this->sendResponse($this->psychologySpecialistRepository->findAllTranslated(),
            'List psychology specialist');
    }
}
