<?php

namespace Modules\Alumn\Repositories;

use App\Services\ModelRepository;
use Modules\Alumn\Entities\Alumn;
use Modules\Alumn\Repositories\Interfaces\AlumnRepositoryInterface;

class AlumnRepository extends ModelRepository implements AlumnRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(Alumn $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Lists alumns from a requested school center
     */
    public function listAlumns($club)
    {
        return $this->model->select(
            'alumns.*',
            'resources.id AS alumn_image_id',
            'resources.url AS alumn_image',
        )
        ->leftJoin('resources', 'alumns.image_id', '=', 'resources.id')
        ->join('classrooms', 'classrooms.id', '=', 'alumns.classroom_id')
        ->join('clubs', 'clubs.id', '=', 'classrooms.club_id')
        ->where('clubs.id', $club->id)
        ->get();
    }
}
