<?php

namespace Modules\Test\Database\Seeders;

use App\Services\BaseSeeder;
use Modules\Test\Repositories\Interfaces\UnitRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;
use Modules\Test\Repositories\Interfaces\FormulaRepositoryInterface;
use Modules\Test\Repositories\Interfaces\QuestionRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestFormulaRepositoryInterface;
use Modules\Test\Repositories\Interfaces\FormulaParamRepositoryInterface;
use Modules\Test\Repositories\Interfaces\QuestionResponseRepositoryInterface;

class FormulaTableSeeder extends BaseSeeder
{
    /**
     * @var $testRepository
     */
    protected $testRepository;
    
    /**
     * @var $testFormulaRepository
     */
    protected $testFormulaRepository;

    /**
     * @var $formulaRepository
     */
    protected $formulaRepository;
    
    /**
     * @var $formulaParamRepository
     */
    protected $formulaParamRepository;

    /**
     * @var $unitRepository
     */
    protected $unitRepository;

    /**
     * @var $questionRepository
     */
    protected $questionRepository;
    
    /**
     * @var $questionResponseRepository
     */
    protected $questionResponseRepository;

    /**
     * FormulaTableSeeder constructor.
     */
    public function __construct(
        TestRepositoryInterface $testRepository,
        TestFormulaRepositoryInterface $testFormulaRepository,
        FormulaRepositoryInterface $formulaRepository,
        FormulaParamRepositoryInterface $formulaParamRepository,
        UnitRepositoryInterface $unitRepository,
        QuestionRepositoryInterface $questionRepository,
        QuestionResponseRepositoryInterface $questionResponseRepository
    )
    {
        $this->testRepository = $testRepository;
        $this->testFormulaRepository = $testFormulaRepository;
        $this->formulaRepository = $formulaRepository;
        $this->formulaParamRepository = $formulaParamRepository;
        $this->unitRepository = $unitRepository;
        $this->questionRepository = $questionRepository;
        $this->questionResponseRepository = $questionResponseRepository;
    }

    /**
     * @return void
     */
    protected function createFormulas()
    {
        $filename = "test-formulas.json";

        $elements = $this->getDataJson($filename);

        foreach($elements as $elm) {
            $test = $this->testRepository->findOneBy(['code' => $elm['test_code']]);

            if(!$test) { continue; }

            foreach ($elm['formulas'] as $formula) {
                $unit = $this->unitRepository->findOneBy(['code' => $formula['formula']['unit']]);

                if( !$unit ) { continue; }

                $formula['formula']['unit_id'] = $unit->id;

                unset($formula['formula']['unit']);

                $new_formula = $this->formulaRepository->create($formula['formula']);
                
                $test_formula = $this->testFormulaRepository->create([
                    'test_id' => $test->id,
                    'formula_id' => $new_formula->id
                ]);

                foreach ($formula['params'] as $param) {
                    $param['test_formula_id'] = $test_formula->id;

                    if( isset($param['question']) ) {
                        $question = $this->questionRepository->questionTest($param['question'], $test->id);
                        
                        if( !$question ) { continue; }

                        $question_response = $this->questionResponseRepository->findOneBy(['question_test_id' => $question->tests[0]->pivot->id]);

                        if(!$question_response) { continue; }

                        $param['question_responses_id'] = $question_response->id;
                        
                        unset($param['question']);
                    }

                    $this->formulaParamRepository->create($param);
                }
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createFormulas();
    }
}
