<?php

namespace Modules\Calculator\Services;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Modules\InjuryPrevention\Entities\InjuryPrevention;
use Modules\Calculator\Repositories\Interfaces\CalculatorItemRepositoryInterface;
use Modules\Calculator\Repositories\Interfaces\CalculatorEntityItemAnswerRepositoryInterface;
use Modules\Calculator\Repositories\Interfaces\CalculatorEntityAnswerHistoricalRecordRepositoryInterface;

class CalculatorItemService 
{
    use ResponseTrait;

    /**
     * @var object $calculatorItemRepository
     */
    protected $calculatorItemRepository;

    /**
     * @var object $calculatorItemAnswerRepository
     */
    protected $calculatorItemAnswerRepository;

    /**
     * @var object $calculatorHistoryRepository
     */
    protected $calculatorHistoryRepository;

    /**
     * Create a new service instance
     */
    public function __construct(
        CalculatorItemRepositoryInterface $calculatorItemRepository,
        CalculatorEntityItemAnswerRepositoryInterface $calculatorItemAnswerRepository,
        CalculatorEntityAnswerHistoricalRecordRepositoryInterface $calculatorHistoryRepository
    ) {
        $this->calculatorItemRepository = $calculatorItemRepository;
        $this->calculatorItemAnswerRepository = $calculatorItemAnswerRepository;
        $this->calculatorHistoryRepository = $calculatorHistoryRepository;
    }

    public function store($requestData)
    {
        try {
            $classType = $this->resolveCalculatorClass($requestData['item_class']);

            $requestData['entity_class'] = $classType;
            $requestData['es'] = [
                'name' => $requestData['es_title'],
            ];

            $requestData['en'] = [
                'name' => $requestData['en_title'],
            ];

            return $this->calculatorItemRepository->create($requestData);
        } catch (Exception $exception) {
            abort(response()->error($exception->getMessage(), Response::HTTP_NOT_FOUND));
        }
    }


    /**
     * Returns the classname depending on the key sent via
     * parameter
     * 
     * @param string $key
     * @return string
     */
    private function resolveCalculatorClass($key)
    {
        $classes = [
            'injury_prevention' => InjuryPrevention::class,
        ];

        return $classes[$key];
    }
}
