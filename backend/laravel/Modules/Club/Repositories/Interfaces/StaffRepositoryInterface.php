<?php

namespace Modules\Club\Repositories\Interfaces;

interface StaffRepositoryInterface
{

    public function getStaffById($id);
    
    public function getStaffByClub($club_id,$search,$order);

}