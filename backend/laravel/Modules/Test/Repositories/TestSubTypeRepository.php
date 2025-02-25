<?php

namespace Modules\Test\Repositories;

use App\Services\ModelRepository;
use Modules\Test\Entities\TestSubType;
use Modules\Test\Repositories\Interfaces\TestSubTypeRepositoryInterface;

class TestSubTypeRepository extends ModelRepository implements TestSubTypeRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'test_sub_types';

    /**
     * @var string
    */
    protected $tableTranslations = 'test_sub_type_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'test_sub_type_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        TestSubType $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return Question type translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

    /**
     *  Return Question type translations
     *
     */
    public function findAllImage()
    {
        $locale = app()->getLocale();

        $listSubType = $this->model
                        ->withTranslation($locale)
                        ->with('image')
                        ->get();

        $listSubType->makeHidden('translations');

        return  $listSubType;
    }

}