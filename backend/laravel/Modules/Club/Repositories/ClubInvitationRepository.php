<?php

namespace Modules\Club\Repositories;

use Modules\Club\Entities\Club;
use Modules\User\Entities\User;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Club\Entities\ClubInvitation;
use Modules\Club\Repositories\Interfaces\ClubInvitationRepositoryInterface;

class ClubInvitationRepository extends ModelRepository implements ClubInvitationRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(ClubInvitation $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Retrieve all the invitations the club has been made
     *
     * @param Int $clubId Identifier of the club
     *
     * @return array
     */
    public function getInvitationsByClub($clubId) {
        return $this->model->with([
                'club' => function ($query) {
                    $query->select('id', 'name');
                },
                'inviter_user' => function ($query) {
                    $query->select('users.id', 'users.full_name', 'users.email', 'user.image_id');
                },
                'invited_user' => function ($query) {
                    $query->select('users.id', 'users.full_name', 'users.email', 'user.image_id');
                },
                'team' => function ($query) {
                    $query->select('teams.id', 'teams.name');
                }
            ])
            ->where('club_id', $clubId)
            ->get();
    }

    /**
     * Retrieve list user invited by club
     */
    public function getClubInvitationsById($clubId)
    {
        return $this->model
                ->with([
                    'invited_user' => function ($query) {
                        $query->select('users.id', 'users.full_name', 'users.email', 'image_id');
                        $query->with('image');
                    },
                    'team' => function ($query) {
                        $query->select('teams.id', 'teams.name');
                    }
                ])
                ->where('club_id', $clubId)
                ->orderBy('created_at', 'desc')
                ->get();

    }

    /**
     *Retrieve list invitation club by code
     */
    public function getClubInvitationsByCode($clubId)
    {
        $locale = app()->getLocale();

        $base_url = sprintf('%s/', config('resource.url'));

        $query = DB::table('club_invitations')
            ->select(
                'staff_users.full_name AS inviter_user_full_name',
                'club_invitations.invited_user_id',
                'club_invitations.invited_user_email',
                'club_invitations.code',
                'club_invitations.accepted_at',
                'club_invitations.status',
                'club_invitations.deleted_at',
                'staff_users.position_staff_id',
                'staff_users.jobs_area_id',
                'job_area_translations.name AS job_area',
                'position_staff_translations.name AS responsability',
                // DB::raw("(SELECT array_to_json(array_agg(club_invitations.team_id)) AS team_ids)"),
                'teams.name as team_name',
                'clubs.name as club_name',
                DB::raw("
                    (CASE
                        WHEN staff_users.gender_id = 1 THEN 'male'
                        WHEN staff_users.gender_id = 2 THEN 'female'
                        ELSE 'null'
                    END) AS gender
                "),
            )
            ->selectRaw("CONCAT_WS(?, '', resources.url) AS team_image_url", [$base_url])
            ->selectRaw("CONCAT_WS(?, '', resources_user.url) AS user_image_url", [$base_url])
            ->leftjoin('users', 'club_invitations.inviter_user_id', '=', 'users.id')
            ->leftjoin('staff_users', 'club_invitations.invited_user_id', '=', 'staff_users.user_id')
            ->leftjoin('clubs', 'club_invitations.club_id', '=', 'clubs.id')
            ->leftjoin('teams', 'club_invitations.team_id', '=', 'teams.id')
            ->leftjoin('resources', 'teams.image_id', '=', 'resources.id')
            ->leftjoin('resources as resources_user', 'staff_users.image_id', '=', 'resources_user.id')
            ->leftJoin('jobs_area', 'jobs_area.id', '=', 'staff_users.jobs_area_id')
            ->leftJoin('job_area_translations', function ($join) use ($locale) {
                $join->on('job_area_translations.job_area_id', '=', 'jobs_area.id');
                $join->on('job_area_translations.locale', '=', DB::raw("'".$locale."'"));
            })
            ->leftJoin('position_staff', 'position_staff.id', '=', 'staff_users.position_staff_id')
            ->leftJoin('position_staff_translations', function ($join) use ($locale) {
                $join->on('position_staff_translations.position_staff_id', '=', 'position_staff.id');
                $join->on('position_staff_translations.locale', '=', DB::raw("'".$locale."'"));
            })
            ->where('club_invitations.club_id', $clubId)
            ->groupBy(
                'club_invitations.invited_user_id',
                'club_invitations.invited_user_email',
                'club_invitations.accepted_at',
                'club_invitations.status',
                'club_invitations.code',
                'staff_users.position_staff_id',
                'staff_users.jobs_area_id',
                'staff_users.gender_id',
                'staff_users.full_name',
                'club_invitations.created_at',
                'club_invitations.deleted_at',
                'job_area_translations.name',
                'position_staff_translations.name',
                'clubs.name',
                'teams.name',
                'resources.url',
                'resources_user.url'
            )
            ->orderBy('club_invitations.created_at', 'desc')
            ->whereNull('club_invitations.deleted_at');

        return $query->get();
    }

    /**
     * Retrieve all the invitations the club has been made with  the staff information
     *
     * @param Int $clubId Identifier of the club
     *
     * @return array
     */
    public function getInvitationsByClubWithStaff($clubId, $search, $order, $filter)
    {
        $locale = app()->getLocale();

        $conditionsWhere= [];
        $conditionsOrWhere = [];

        if (is_null($order)) {
            $order = 'ASC';
        }

        if (!is_null($search) && trim($search) != "") {
            $conditionsWhere[] = [
                DB::raw('LOWER(job_area_translations.name)'), 'LIKE', '%' . strtolower(rtrim($search)) . '%'
            ];

            $conditionsOrWhere[] = [
                DB::raw('LOWER(position_staff_translations.name)'), 'LIKE', '%'.strtolower(rtrim($search)).'%'
            ];
        }

        if (!is_null($filter)) {
            $conditionsWhere[] = $filter;
        }

          $listOfInvitationsTeamStaff =  DB::table('club_invitations')
            ->select('club_invitations.id as invitation_id', 'users.full_name',
                'club_invitations.invited_user_email','users.id as user_id',
                'job_area_translations.name as job_area','position_staff_translations.name as responsability',
                DB::raw(
                    "(SELECT array_agg(t.name) FROM  team_staff_teams tst left join teams t on t.id  = tst.team_id  where tst.team_staff_id = team_staff.id) as teams"
                ),
                DB::raw(
                    "CASE When users.email_verified_at is null  Then 'not_accepted' ELSE concat('accepted_to_',users.email_verified_at) end as status_invitation"
                    )
            )
            ->leftJoin('team_staff', 'team_staff.user_id', '=', 'club_invitations.invited_user_id')
            ->leftJoin('users', 'users.id', '=', 'club_invitations.invited_user_id')
            ->leftJoin('jobs_area', 'jobs_area.id', '=', 'team_staff.jobs_area_id')
            ->leftJoin('job_area_translations', function ($join) use ($locale)
                {
                    $join->on('job_area_translations.job_area_id', '=', 'jobs_area.id');
                    $join->on('job_area_translations.locale','=',DB::raw("'".$locale."'"));
            
                })
            ->leftJoin('position_staff', 'position_staff.id', '=', 'team_staff.position_staff_id')
            ->leftJoin('position_staff_translations', function ($join) use ($locale)
                {
                    $join->on('position_staff_translations.position_staff_id', '=', 'position_staff.id');
                    $join->on('position_staff_translations.locale','=',DB::raw("'".$locale."'"));
            
                })
            ->whereIn('users.id',
                [DB::raw("select team_staff.user_id from team_staff where team_staff.user_id is not NULL")]
            )
            ->where('club_id', $clubId)
            ->where('club_invitations.deleted_at', null)
            ->where($conditionsWhere)
            ->orWhere($conditionsOrWhere);
            

        $listOfInvitations =  DB::table('club_invitations')
            ->select('club_invitations.id as invitation_id','users.full_name','club_invitations.invited_user_email','users.id as user_id','job_area_translations.name as job_area','position_staff_translations.name as responsability',
                DB::raw("(SELECT  array_agg(teams.name) FROM  teams  WHERE teams.club_id = club_invitations.club_id) as teams"),
                DB::raw("CASE When  users.email_verified_at is null  Then 'not_accepted' ELSE concat('accepted_to_',users.email_verified_at) end as status_invitation")
            )
            ->leftJoin('staffs', 'staffs.user_id', '=', 'club_invitations.invited_user_id')
            ->leftJoin('users', 'users.id', '=', 'club_invitations.invited_user_id')
            ->leftJoin('jobs_area', 'jobs_area.id', '=', 'staffs.jobs_area_id')
            ->leftJoin('job_area_translations', function ($join) use ($locale)
                {
                    $join->on('job_area_translations.job_area_id', '=', 'jobs_area.id');
                    $join->on('job_area_translations.locale', '=', DB::raw("'".$locale."'"));
            
                })
            ->leftJoin('position_staff', 'position_staff.id', '=', 'staffs.position_staff_id')
            ->leftJoin('position_staff_translations', function ($join) use ($locale)
                {
                    $join->on('position_staff_translations.position_staff_id', '=', 'position_staff.id');
                    $join->on('position_staff_translations.locale', '=', DB::raw("'".$locale."'"));
            
                }
            )
            ->whereNotIn('users.id', [
                DB::raw("select team_staff.user_id from team_staff where team_staff.user_id is not NULL")
            ])
            ->where('club_id', $clubId)
            ->where('club_invitations.deleted_at', null)
            ->where($conditionsWhere)
            ->OrWhere($conditionsOrWhere)
            ->union($listOfInvitationsTeamStaff)
            ->orderBy('full_name', $order);
        
        return $listOfInvitations->get();
    }

    public function userHistory(Club $club, User $user)
    {
        $query = $this->model
            ->where('club_id', $club->id)
            ->where('invited_user_id', $user->id)
            ->with('team');

        return $query->get();
    }
}
