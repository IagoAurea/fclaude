<?php

namespace Modules\EffortRecovery\Services;

use Illuminate\Http\Response;
use App\Traits\ResponseTrait;

// Repositories
use Modules\EffortRecovery\Repositories\Interfaces\WellnessQuestionnaireAnswerTypeRepositoryInterface;
use Modules\EffortRecovery\Repositories\Interfaces\WellnessQuestionnaireAnswerItemRepositoryInterface;

use Exception;

class WellnessQuestionnaireService
{
    use ResponseTrait;

    /**
     * @var object $answerTypeRepository
     */
    protected $answerTypeRepository;

    /**
     * @var object $answerItemRepository
     */
    protected $answerItemRepository;

    /**
     * @var object $historyRepository
     */
    protected $historyRepository;

    /**
     * @var object $answerRepository
     */
    protected $answerRepository;


    /**
     * Create a new service instance
     */
    public function __construct(
        WellnessQuestionnaireAnswerTypeRepositoryInterface $answerTypeRepository,
        WellnessQuestionnaireAnswerItemRepositoryInterface $answerItemRepository
    ) {
        $this->answerTypeRepository = $answerTypeRepository;
        $this->answerItemRepository = $answerItemRepository;
    }

    /**
     * Returns all types of questions
     * 
     * @return array
     */
    public function listTypes()
    {
        return $this->answerTypeRepository->findAllRelated();
    }

    /**
     * Returns all types of questions
     * 
     * @return array
     */
    public function listItems($typeId)
    {
        try {
            $type = $this->answerTypeRepository->findOneBy([
                'id' => $typeId
            ]);

            if (!$type) {
                abort(response()->error('Answer Type Not Found', Response::HTTP_NOT_FOUND));
            }

            return $this->answerItemRepository->findByTypeTranslated($typeId);
        } catch (Exception $exception) {
            abort(response()->error($exception->getMessage(), Response::HTTP_NOT_FOUND));
        }
    }
}
