<?php

namespace Modules\Package\Repositories\Interfaces;

interface PackageRepositoryInterface
{
    public function findPackageWithPrice($dataFilter);
}