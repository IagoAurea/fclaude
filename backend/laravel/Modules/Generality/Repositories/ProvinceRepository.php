<?php

namespace Modules\Generality\Repositories;

use Modules\Generality\Repositories\Interfaces\ProvinceRepositoryInterface;
use Modules\Generality\Entities\Province;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;

class ProvinceRepository extends ModelRepository implements ProvinceRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    public function __construct(Province $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * @param string $country
     * @return array Returns an array of provinces of country
     */
    public function findByCountryAndTranslated($country)
    {
        $query = DB::table('provinces')
                ->select('provinces.*', 'province_translations.name' )
                ->join('province_translations', 'provinces.id', '=', 'province_translations.province_id')
                ->join('countries', 'provinces.country_id', '=', 'countries.id')
                ->where('countries.iso2', $country)
                ->where('province_translations.locale', app()->getLocale())
                ->orderBy('province_translations.name')
                ->get();
        
        return $query;

    }

}