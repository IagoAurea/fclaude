<?php

namespace Modules\Player\Repositories;

use App\Services\ModelRepository;
use Modules\Player\Entities\Punctuation;
use Modules\Player\Repositories\Interfaces\PunctuationRepositoryInterface;

class PunctuationRepository extends ModelRepository implements PunctuationRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'punctuations';

    /**
     * @var string
    */
    protected $tableTranslations = 'punctuation_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'punctuation_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(Punctuation $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return injury location translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

    /**
     * Returns rank type according to score with respective translations
     * 
     * @param Int $point
     * @return object
     */
    public function getPunctuationPerfomanceAssessment(Int $point) 
    {
        return $this->model
            ->where('min', '<', $point)
            ->where('max', '>=', $point)
            ->first();
    }
}