<?php

namespace Modules\Generality\Repositories;

use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;
use Modules\Generality\Entities\Country;
use App\Services\ModelRepository;

class CountryRepository extends ModelRepository implements CountryRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    public function __construct(Country $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * @param string $locale
     * @param string|null $term
     * @return array Returns an array of Package objects
     */
    public function findTranslatedByTerm($term = null)
    {
        $query = $this->model->orderByTranslation('name')->withTranslation(app()->getLocale());
        
        if($term) {
            $query->whereTranslationLike('name', '%' . strtolower($term) . '%', app()->getLocale());
        }

        return $query->get();
    }
}