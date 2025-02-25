<?php

namespace Modules\Tutorship\Repositories;

use Modules\Tutorship\Repositories\Interfaces\TutorshipRepositoryInterface;
use Modules\Tutorship\Entities\Tutorship;
use App\Services\ModelRepository;

class TutorshipRepository extends ModelRepository implements TutorshipRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(Tutorship $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function findByAlumn($alumn_id)
    {
        return $this
            ->model
            ->with([
                'tutor',
                'scholarCenter',
                'tutorshipType',
                'specialistReferral',
                'alumn',
                'alumn.image'
            ])
            ->where(['alumn_id' => $alumn_id])
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function getInfoById($id)
    {
        return $this->model
            ->with([
                'tutor',
                'scholarCenter',
                'tutorshipType',
                'specialistReferral',
                'alumn',
                'alumn.image'
            ])
            ->where(['id' => $id])
            ->first();
    }
}
