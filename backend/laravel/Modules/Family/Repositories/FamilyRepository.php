<?php

namespace Modules\Family\Repositories;

use App\Services\ModelRepository;
use Modules\Family\Entities\Family;
use Modules\Family\Repositories\Interfaces\FamilyRepositoryInterface;
use App\Traits\TranslationTrait;

class FamilyRepository extends ModelRepository implements FamilyRepositoryInterface
{
    use TranslationTrait;

    /**
     * @var object
     */
    protected $model;

    public function __construct(Family $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * @return array Returns an array of gender
     */
    public function getMaritalStatusTypes()
    {
        $genders = Family::getMaritalStatusTypes();

        array_walk($genders, function(&$value) {
            $value['code'] = $this->translator('marital_status_' . $value['code']);
        });

        return $genders;
    }
}