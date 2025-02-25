<?php

namespace  Modules\Nutrition\Repositories\Interfaces;

interface NutritionalSheetRepositoryInterface
{
    public function createNutritionalSheet($request);
    public function findNutricionalSheetById($id);
    public function findNutricionalSheetByPlayerId($id);
}
