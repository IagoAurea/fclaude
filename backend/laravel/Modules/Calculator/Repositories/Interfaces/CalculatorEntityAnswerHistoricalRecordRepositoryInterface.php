<?php

namespace Modules\Calculator\Repositories\Interfaces;

interface CalculatorEntityAnswerHistoricalRecordRepositoryInterface {
    public function calculateTotal($historyId, $hiddenAnswers);
}