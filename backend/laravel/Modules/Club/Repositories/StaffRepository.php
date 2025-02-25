<?php

namespace Modules\Club\Repositories;

// Repositories
use App\Services\ModelRepository;

// Interfaces
use Modules\Club\Repositories\Interfaces\StaffRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;

// Entities
use Modules\Club\Entities\Staff;
use Modules\Club\Entities\ClubUser;

// Extra
use Illuminate\Support\Facades\DB;

class StaffRepository extends ModelRepository implements StaffRepositoryInterface
{
        /** 
     * @var object
     */
    protected $model;

    public function __construct(Staff $model, ClubRepositoryInterface $clubRepository)
    {
        $this->model = $model;
        $this->clubRepository = $clubRepository;
        parent::__construct($this->model);
    }

    /**
     * @return Object Returns an existing staff 
     */
    public function getStaffById($id) 
    {
        // Search for the first item that matches 
        $item = $this->model->with(
            'image', 'area', 'working_experiences', 'study_level'
        )->with([
            'clubs'
        ])->find($id);

        if (!$item) {
            throw new \Exception("Staff not found");
        }

        return $item;
    }

    /**
     * @return Array 
     * Returns an array members staff by club
     */
    public function getStaffByClub($club_id, $search, $order) 
    {
        $conditionsWhere[] = ['club_users.club_id', '=', $club_id];
        $conditionsOrWhere = [];

        if(is_null($search)) {
            $order = 'asc';
        }

        if (!is_null($search) && trim($search) != "") {
            $conditionsWhere[] = [DB::raw('LOWER(name)'), 'LIKE', '%' . strtolower($search) . '%'];
        }

        $items = Staff::with([
            'image', 'area', 'working_experiences', 'study_level'
        ])->join(
            'club_users', 'staffs.user_id', '=', 'club_users.user_id'
        )->where(
            'club_users.club_id', $club_id
        )->orWhere(
            $conditionsOrWhere
        )->orderBy(
            'staffs.id', $order
        )->get();

        return $items;
    }
}
