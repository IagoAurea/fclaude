<?php

namespace Modules\Package\Repositories;

use Modules\Package\Repositories\Interfaces\PackageRepositoryInterface;
use Modules\Package\Entities\Package;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;

class PackageRepository extends ModelRepository implements PackageRepositoryInterface
{
    /** 
     * @var object
     */
    protected $model;

    public function __construct(Package $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Return package with subpackage and price
     */
    public function findPackageWithPrice($dataFilter)
    {
        return $this->model
            ->with([
                'subpackages' => function ($subpackage) use ($dataFilter) {
                    $subpackage->where('code', sprintf('%s_%s', $dataFilter['type'], $dataFilter['subpackage']));
                    $subpackage->with([
                        'image',
                        'prices' => function ($price) use ($dataFilter) {
                            $price->where('min_licenses', '<=', $dataFilter['licenses'])
                                ->where('max_licenses', '>=', $dataFilter['licenses']);
                        }
                    ]);
                }
            ])
            ->where('code', $dataFilter['type'])
            ->first();
    }

    /**
     * @return array Returns an array of Package objects
     */
    public function findAllTranslated()
    {
        $query = $this->model
            ->withTranslation(app()->getLocale())
            ->with([
                'subpackages' => function ($query) {
                    $query->withTranslation(app()->getLocale());
                    $query->select(['id', 'code', 'package_id']);
                    $query->with([
                        'attributes' => function ($qry) {
                            $qry->withTranslation(app()->getLocale());
                        }
                    ]);
                    $query->with([
                        'prices' => function ($elm) {
                            $elm->select(['id', 'subpackage_id', 'code', 'name', 'min_licenses', 'max_licenses', 'month', 'year']);
                            $elm->orderBy('min_licenses');
                        }
                    ]);
                    $query->with(['image']);
                }
            ])
            ->get();

        return $query;
    }

    public function findAllWithAttributesTranslated()
    {
        $query = $this->model
            ->withTranslation(app()->getLocale())
            ->with(['attributes' => function($query) {
                $query->withTranslation(app()->getLocale());
                // $query->select(['id','code','package_id']);
               /*  $query->with(['attributes' => function($qry) {
                    $qry->withTranslation(app()->getLocale());
                }]); */
            }])
            ->get();
        
        return $query;
    }

}