<?php

namespace Modules\Package\Services;

use Modules\Package\Repositories\Interfaces\SubpackageRepositoryInterface;

class SubpackageService
{
    /**
     * @var $subpackageRepository
     */
    protected $subpackageRepository;

    public function __construct(
        SubpackageRepositoryInterface $subpackageRepository,
    ) {
        $this->subpackageRepository = $subpackageRepository;
    }

    /**
     * Retrieve detail subpackage with sport
     */
    public function getSubpackageSports($id)
    {
        $subpackage = $this->subpackageRepository->findOneBy([
            'id' => $id
        ]);

        $subpackage->sports;

        return $subpackage;
    }

    /**
     * Retrieve detail subpackage
     */
    public function getSubpackage($id)
    {
        $subpackage = $this->subpackageRepository->findOneBy([
            'id' => $id
        ]);

      

        return $subpackage;
    }

    public function findAll()
    {
        return $this->subpackageRepository->findAll();
    }
}