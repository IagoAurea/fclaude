<?php

namespace Modules\Competition\Repositories;

use App\Services\ModelRepository;
use Modules\Competition\Entities\TypeModalityMatch;
use Modules\Competition\Repositories\Interfaces\TypeModalityMatchRepositoryInterface;

class TypeModalityMatchRepository extends ModelRepository implements TypeModalityMatchRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(TypeModalityMatch $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function findBySport($sport)
    {
        return $this->model
            ->whereHas('sport', function($query) use($sport) {
                $query->where('code', $sport);
            })
            ->get();
    }
}
