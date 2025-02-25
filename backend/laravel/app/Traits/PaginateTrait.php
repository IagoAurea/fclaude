<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

trait PaginateTrait
{
    /**
     * @var integer
     */
    protected $per_page = 20;
    
    /**
     * @var integer
     */
    protected $page = 1;

    /**
     * Paginate a array
     *
     * @param $data
     * @param $request
     *
     * @return array
     *
     */
    public function paginateWithAllData($data, $request)
    {
        $collection = new Collection($data);

        $currentPage = $request->page ?? $this->page;

        $perPage = $request->per_page ?? $this->per_page;

        $paginate = new LengthAwarePaginator(
            $collection->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $collection->count(),
            $perPage,
            $currentPage,
            [
              'path' => $request->url(),
              'query' => $request->query()
            ]
        );

        return [
            'current_page' => $paginate->currentPage(),
            'data' => $paginate->items(),
            'per_page' => $paginate->perPage(),
            'last_page' => $paginate->lastPage(),
            'path' => $paginate->path(),
            'total' => $paginate->total()
        ];
    }

    /**
     * Paginate from Eloquent 
     * 
     * @param $query
     * @param $request
     * 
     * @return array
     */
    public function paginateEloquentCustom($query, $request)
    {
        $currentPage = $request->page ?? $this->page;

        $perPage = $request->per_page ?? $this->per_page;

        $total = $query->count();

        $result = $query->offset(($currentPage - 1) * $perPage)->limit($perPage)->get();

        return [
            'current_page' => $currentPage,
            'data' => $result,
            'per_page' => $perPage,
            'last_page' => ceil($total/$perPage),
            'path' => $request->url(),
            'total' => $total
        ];
    }

}