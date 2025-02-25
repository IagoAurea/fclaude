<?php

namespace Modules\Generality\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Rest\BaseController;
use Modules\Generality\Repositories\Interfaces\StudyLevelRepositoryInterface;

class StudyLevelController extends BaseController
{
     /**
     * @var $studyLevelRepository
     */
    protected $studyLevelRepository;

    public function __construct(StudyLevelRepositoryInterface $studyLevelRepository)
    {
        $this->studyLevelRepository = $studyLevelRepository;
    }

    /**
     * Display a listing study levels.
     * @return Response
     */
    public function index()
    {
        $levels = $this->studyLevelRepository->findAllTranslated();

        return $this->sendResponse($levels, 'List Study Levels');
    }

    
}
