<?php

namespace Modules\Test\Repositories;

use App\Services\ModelRepository;
use Modules\Test\Entities\TestType;
use Modules\Test\Repositories\Interfaces\TestTypeRepositoryInterface;

class TestTypeRepository extends ModelRepository implements TestTypeRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'test_types';

    /**
     * @var string
     */
    protected $tableTranslations = 'test_type_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'test_type_id';

    /**
     * @var object
     */
    protected $model;

    public function __construct(
        TestType $model
    ) {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return test type translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

    /**
     *  Return all with image
     *
     */
    public function findAllImage($filters = [])
    {
        return $this->model
            ->with('image', 'subTypes')
            ->when(isset($filters['classification']), function ($query) use ($filters) {
                if ($filters['classification'] == 'rfd') {
                    $query->where('classification', TestType::CLASSIFICATION_BOTH);
                    return $query->orWhere('classification', TestType::CLASSIFICATION_RFD);
                } elseif ($filters['classification'] == 'test') {
                    return $query->where('classification', TestType::CLASSIFICATION_TEST);
                } else {
                    return $query;
                }
            })
            ->get();
    }
}