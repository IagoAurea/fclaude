<?php

namespace Modules\Club\Services;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Traits\ResponseTrait;
use App\Traits\PaginateTrait;
use Illuminate\Http\Response;
use Modules\Team\Entities\Team;
use Modules\Club\Entities\Club;
use Modules\User\Entities\User;
use Modules\Club\Entities\ClubInvitation;
use Modules\Activity\Events\ActivityEvent;
use Modules\User\Services\PermissionService;
use Modules\Club\Notifications\ClubInvitationSent;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubUserRepositoryInterface;
use Modules\Staff\Repositories\Interfaces\StaffUserRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubInvitationRepositoryInterface;
use Modules\User\Repositories\Interfaces\ModelPermissionRepositoryInterface;

class ClubInvitationService
{
    use ResponseTrait, PaginateTrait;

    /**
     * @var object
     */
    protected $clubRepository;

    /**
     * @var object
     */
    protected $clubInvitationRepository;

    /**
     * @var object
     */
    protected $clubUserRepository;

    /**
     * @var object
     */
    protected $userRepository;

    /**
     * @var object
     */
    protected $teamRepository;

    /**
     * @var object
     */
    protected $modelPermissionRepository;

    /**
     * @var object
     */
    protected $permissionService;

    /**
     * @var object
     */
    protected $staffUserRepository;

    /**
     * Instances a new service class
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        ClubRepositoryInterface $clubRepository,
        ClubUserRepositoryInterface $clubUserRepository,
        ClubInvitationRepositoryInterface $clubInvitationRepository,
        TeamRepositoryInterface $teamRepository,
        ModelPermissionRepositoryInterface $modelPermissionRepository,
        PermissionService $permissionService,
        StaffUserRepositoryInterface $staffUserRepository
    ) {
        $this->clubRepository = $clubRepository;
        $this->clubInvitationRepository = $clubInvitationRepository;
        $this->clubUserRepository = $clubUserRepository;
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamRepository;
        $this->modelPermissionRepository = $modelPermissionRepository;
        $this->permissionService = $permissionService;
        $this->staffUserRepository = $staffUserRepository;
    }

    public function listPermissions($invitation)
    {
        $permissions = [];

        $club_permissions = $this->modelPermissionRepository
            ->listUserPermissions($invitation->invited_user_id, $invitation->club_id, 'club');

        $team_permissions = $this->modelPermissionRepository
            ->listUserPermissions($invitation->invited_user_id, $invitation->team_id, 'team');


        foreach ($club_permissions as $club) {
            array_push($permissions, $club->permission);
        }

        foreach ($team_permissions as $team) {
            array_push($permissions, $team->permission);
        }

        return $permissions;
    }

    /**
     * Lists all invitations sent on a club item
     *
     * @return array
     */
    public function listInvitations(Club $club, $request)
    {
        $invitations =  $this->clubInvitationRepository->getClubInvitationsById($club->id);

        return $request->page ? $this->paginateWithAllData($invitations, $request) : $invitations;
    }

    /**
     * Response string
     * @param string $filter
     * @param string $value
     * @return string
     */
    public function getFilterList($filter, $value)
    {
        if ($filter == "status") {
            $field = 'email_verified_at';
            if ($value == "not_accepted") {
                $operator = "=";
                $value = null;
            } elseif ($value == "accepted") {
                $operator = "!=";
                $value = null;
            }
        } elseif ($filter == "position") {
            $field = 'position_staff_translations.name';
            $operator = "LIKE";
            $value = '%'.$value.'%';
        } elseif ($filter == "area") {
            $field = 'job_area_translations.name';
            $operator = "LIKE";
            $value = '%'.$value.'%';
        }

        return $filter = [$field, $operator, $value];
    }

    /**
     * Response success
     * @param integer $user_id
     * @param integer $team_id
     * @return string
     */
    public function revokeAllPermissions($user_id, $team_id)
    {
        try {
            $user = $this->userRepository->find($user_id);
            $team  = $this->teamRepository->find($team_id);
    
            foreach ($user->entityPermissions as $permission) {
                $user->manageEntityPermission(
                    $permission->id, $team->id, get_class($team), 'revoke'
                );
            }

            return $this->success('Permissions Revoke');
        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Handles user multiple permission parsing
     *
     * @param integer $user_id
     * @param integer $team_id
     * @param array $permissions
     * @return string
     */
    public function updatePermissions($user_id,$team_id, $permissions)
    {
        try {
            $user = $this->userRepository->find($user_id);
            $team  = $this->teamRepository->find($team_id);
    
            foreach ($user->entityPermissions as $permission_user) {
                if(!in_array($permission_user->name, $permissions)){
                    $user->manageEntityPermission(
                        $permission_user->id, $team->id, get_class($team), 'revoke'
                    );
                }
            }

            $user->assignMultiplePermissions(
                $permissions,
                $team->id,
                get_class($team)
            );

            return $this->success('Permissions Update');

        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Store multiple invitations in database
     *
     * @param array $requestData contains all information sent on payload
     * @param object $user authenticated user that sends the invitation
     */
    public function store($requestData, $user)
    {
        try {
            foreach ($requestData['invited_users'] as $invitedUser) {
                $email = strtolower($invitedUser['email']);

                $code = Str::uuid()->toString();
                
                $teamCollection = collect($invitedUser['teams']);

                foreach ($teamCollection as $team) {
                    // Build the main information used to generate an invitation process
                    $inviteData = [
                        'club_id'            =>  $requestData['club_id'],
                        'team_id'            =>  $team['id'],
                        'inviter_user_id'    =>  $user->id,
                        'invited_user_email' =>  $email,
                        'code'               =>  $code,
                        'permissions'        =>  $team['permissions'],
                    ];

                    // Dispatch a new invitation process
                    $this->processInvitations($inviteData);
                }

                $teamIds = $teamCollection->pluck('id');

                $invitation = [
                    'club_id' =>  $requestData['club_id'],
                    'teams' =>  $teamIds,
                    'code'  =>  $code,
                    'email' =>  $email,
                    'annotation' => $requestData['annotation'] ?? ''
                ];

                $this->sendMail($invitation);
            }
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Updates multiple permissions assignment depending on the invitation data sent
     *
     * @return null
     */
    public function updateMultiplePermissions($requestData, $user)
    {
        try {
            foreach ($requestData['invited_users'] as $invitedUser) {
                $userInvited = $this->userRepository->findOneBy([
                    'email' => $invitedUser['email']
                ]);

                $this->modelPermissionRepository->deleteByCriteria([
                    'model_id' => $userInvited->id,
                    'entity_type' => Club::class,
                    'entity_id' => $requestData['club_id']
                ]);

                foreach ($invitedUser['teams'] as $team) {
                    $this->modelPermissionRepository->deleteByCriteria([
                        'model_id' => $userInvited->id,
                        'entity_type' => Team::class,
                        'entity_id' => $team
                    ]);
                }

                $team = $this->teamRepository->findOneBy(['id' => $team]);

                $club = $this->clubRepository->find($requestData['club_id']);

                $this->setPermissionEntities($invitedUser['permissions_list'], $userInvited, $club, $team);
            }

            return true;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Service made for invitation handling
     * @return void
     */
    public function processInvitations($invitationData)
    {
        // Check if the user exists on the database
        $invitedUser = $this->userRepository->findOrCreate([
            'email' => $invitationData['invited_user_email']
        ]);

        // Make the data for insertion
        $invitationSet = [
            'club_id'   =>  $invitationData['club_id'],
            'team_id'   =>  $invitationData['team_id'],
            'inviter_user_id'   =>  $invitationData['inviter_user_id'],
            'invited_user_id'   =>  $invitedUser->id,
            'invited_user_email' =>  $invitedUser->email,
            'code'  =>  $invitationData['code'],
            'status' => 'pending',
        ];

        // Check if there's an already created invitation for the specific user
        $invitation = $this->clubInvitationRepository->findOneBy([
            'invited_user_email' =>  $invitedUser->email,
            'club_id'   =>  $invitationData['club_id'],
            'team_id'   =>  $invitationData['team_id'],
        ]);

        // Create the invitation in case it does not exists
        if (!$invitation) {
            $invitation = $this->clubInvitationRepository->create($invitationSet);
        }

        // Create Permissions
        $entity = $this->teamRepository->find($invitationSet['team_id']);

        // Retrieve club entity
        $club = $this->clubRepository->find($invitationSet['club_id']);

        //Retrieve if exist user in staff
        $staff = $this->staffUserRepository->findOneBy(['email' => $invitedUser->email]);

        // Relate the user directly to a team staff
        $this->staffUserRepository->findOrCreate([
            'user_id' => $invitedUser->id,
            'email' => $invitedUser->email,
            'full_name' => $staff->full_name ?? $invitedUser->full_name,
            'username' => $staff->username ?? $invitedUser->username,
            'gender_id' => $staff->gender_id ?? $invitedUser->gender_id,
            'image_id' => $staff->image_id ?? $invitedUser->image_id,
            'jobs_area_id' => $staff->jobs_area_id ?? null,
            'position_staff_id' => $staff->position_staff_id ?? null,
            'entity_id' => $entity->id,
            'entity_type' => get_class($entity),
        ]);

        // And also to a club staff
        $this->staffUserRepository->findOrCreate([
            'user_id' => $invitedUser->id,
            'email' => $invitedUser->email,
            'full_name' => $staff->full_name ?? $invitedUser->full_name,
            'username' => $staff->username ?? $invitedUser->username,
            'gender_id' => $staff->gender_id ?? $invitedUser->gender_id,
            'image_id' => $staff->image_id ?? $invitedUser->image_id,
            'jobs_area_id' => $staff->jobs_area_id ?? null,
            'position_staff_id' => $staff->position_staff_id ?? null,
            'entity_id' => $club->id,
            'entity_type' => get_class($club),
        ]);

        if ($invitationData['permissions'] != "") {
            $permissionsClub = array_filter($invitationData['permissions'], function ($permission) {
                return preg_match("/club/i", $permission) && !preg_match("/club_team/i", $permission);
            });

            $permissionsEntity = array_diff($invitationData['permissions'], $permissionsClub);

            $invitedUser->assignMultiplePermissions(
                $permissionsClub,
                $club->id,
                get_class($club)
            );

            $invitedUser->assignMultiplePermissions(
                $permissionsEntity,
                $entity->id,
                get_class($entity)
            );
        }

        // Save the activity event
        // event(new ActivityEvent($invitation->inviter_user, $invitation->club, 'club_invitation_sent'));
    }

    /**
     * Sends an email depending from invitation information
     *
     * @return void
     */
    public function sendMail($invitation)
    {
        // Check if the user exists on the database
        $invitedUser = $this->userRepository->findOneBy([
            'email' => $invitation['email']
        ]);

        $team_text = "";

        if (count($invitation['teams']) > 0 ) {
            $team_text = ", Teams: ";

            foreach ($invitation['teams'] as $team_id) {
                $team = $this->teamRepository->find($team_id);
                $team_text = $team_text . $team->name . ', ';
            }
        }

        $club = $this->clubRepository->find($invitation['club_id']);

        $invitation = [
            'club_name' =>  $club->name,
            // 'teams' =>  $team_text,
            'code'  =>  $invitation['code'],
            'annotation' => $invitation['annotation'] ?? '',
        ];

        // Send a notification to the recently created user
        $invitedUser->notify(new ClubInvitationSent($invitation));
    }

    /**
     * Accepts or rejects an invitation
     * @return bool
     *
     * @OA\Schema(
     *  schema="ClubInvitationHandleResponse",
     *  type="object",
     *  description="Retrieves the result of club invitation handling",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="License successfully handled"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="success", type="boolean", example="true"),
     *      @OA\Property(property="needs_registration", type="boolean", example="false"),
     *      @OA\Property(property="code", type="string", example="string"),
     *      @OA\Property(property="status", type="string", example="string"),
     *  ),
     * )
     */
    public function handle($action, $code)
    {
        $invitations = $this->clubInvitationRepository->findBy([
            'code' => $code
        ]);

        if (!$invitations->count()) {
            throw new Exception('Invitation not found', Response::HTTP_NOT_FOUND);
        }

        $firstInvitation = $invitations->first();

        if ($firstInvitation->accepted_at) {
            throw new Exception(trans('club::messages.invitation_accepted_expired'),
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->userRepository->findOneBy([
            'email' => $firstInvitation->invited_user_email,
        ]);

        if ($action == 'reject') {
            foreach ($invitations as $invite) {
                $this->updateStatusInvitation($invite, ClubInvitation::STATUS_REJECTED);

    
                // Delete the team related staff from table
                $this->staffUserRepository->deleteByCriteria([
                    'user_id' => $firstInvitation->invited_user_id,
                    'email' => $firstInvitation->invited_user_email,
                    'entity_id' => $firstInvitation->team->id,
                    'entity_type' => get_class($firstInvitation->team),
                ]);

                // Delete the club related staff from table
                $this->staffUserRepository->deleteByCriteria([
                    'user_id' => $firstInvitation->invited_user_id,
                    'email' => $firstInvitation->invited_user_email,
                    'entity_id' => $firstInvitation->club->id,
                    'entity_type' => get_class($firstInvitation->club),
                ]);
            }

            return [
                'success' => true,
                'needs_redirection' => false,
                'status' => 'reject',
                'message' => trans('club::messages.invitation_reject'),
                'code' => null
            ];
        }

        if (is_null($user->email_verified_at)) {
            return [
                'success' => false,
                'needs_redirection' => true,
                'status' => 'accept',
                'message' => trans('club::messages.invitation_user_not_register'),
                'code' => $code,
                'email' => $user->email
            ];
        }

        if (!$user->activeSubscriptionByType() || !$user->activeLicenses->count()) {
            return [
                'success' => false,
                'needs_redirection' => false,
                'status' => 'accept',
                'message' => trans('club::messages.invitation_user_not_has_subscription'),
                'code' => $code,
                'email' => $user->email
            ];
        }

        // Process all team invitations
        foreach ($invitations as $invite) {
            $this->updateStatusInvitation($invite, ClubInvitation::STATUS_ACTIVE);

            $staffUser = $this->staffUserRepository->findOneBy([
                'user_id' => $invite->invited_user_id,
                'entity_id' => $invite->team->id,
                'entity_type' => Team::class,
            ]);

            if ($staffUser) {
                $this->staffUserRepository->update([
                    'is_active' =>  true,
                ], $staffUser);
            }
        }

        return [
            'success' => true,
            'needs_redirection' => false,
            'status' => 'accept',
            'message' => trans('club::messages.invitation_accept'),
            'code' => $code,
        ];
    }

    private function updateStatusInvitation($invitation, $status)
    {
        $this->clubInvitationRepository->update([
            'accepted_at' => Carbon::now(),
            'expires_at' => null,
            'status' => $status,
        ], $invitation);
    }

    /**
     * Accepts or rejects an invitation
     * @return bool
     *
     * @OA\Schema(
     *  schema="UserClubInvitationHistory",
     *  type="object",
     *  description="Retrieves the list of user invitations history",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Club invitations history"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="team_id", type="int64", example="1"),
     *          @OA\Property(property="invited_user_email", type="string", example="string"),
     *          @OA\Property(property="status", type="string", example="string"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="accepted_at", type="string", format="datetime", example="2022-01-01 00:00:00"),
     *          @OA\Property(property="created_at", type="string", format="datetime", example="2022-01-01 00:00:00"),
     *          @OA\Property(
     *              property="team",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="name", type="string", example="1"),
     *              @OA\Property(property="image_id", type="int64", example="1"),
     *              @OA\Property(property="image_url", type="string", example="string"),
     *              @OA\Property(property="cover_url", type="string", example="string"),
     *          ),
     *      ),
     *  ),
     * )
     */
    public function userHistory(Club $club, User $user)
    {
        return $this->clubInvitationRepository->userHistory($club, $user);
    }

    private function setPermissionEntities($permissions, $user, $club, $team)
    {
        $permissionsClub = array_filter($permissions, function ($permission) {
            return preg_match("/club/i", $permission) && !preg_match("/club_team/i", $permission);
        });

        $permissionsTeam = array_diff($permissions, $permissionsClub);

        $user->assignMultiplePermissions(
            $permissionsClub,
            $club->id,
            get_class($club)
        );

        $user->assignMultiplePermissions(
            $permissionsTeam,
            $team->id,
            get_class($team)
        );
    }
}
