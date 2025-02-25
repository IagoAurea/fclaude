<?php

namespace Modules\Club\Services;

use Exception;
use App\Traits\ResponseTrait;
use App\Traits\ResourceTrait;
use Modules\Club\Cache\ClubCache;
use Illuminate\Support\Facades\Auth;
use Modules\Activity\Events\ActivityEvent;
use Modules\Classroom\Entities\TeacherArea;
use Modules\User\Services\PermissionService;
use Illuminate\Database\Eloquent\Collection;
use Modules\Address\Services\AddressService;
use Modules\Generality\Services\ResourceService;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Alumn\Repositories\Interfaces\AlumnRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubTypeRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\TeacherRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;

class ClubService
{
    const CLUB = 'club';

    use ResponseTrait, ResourceTrait;

    /**
     * @var object
     */
    protected $clubRepository;

    /**
     * @var object
     */
    protected $alumnRepository;

    /**
     * @var object
     */
    protected $clubTypeRepository;

    /**
     * @var object
     */
    protected $matchRepository;

    /**
     * @var object
     */
    protected $resourceRepository;

    /**
     * @var object
     */
    protected $teacherRepository;

    /**
     * @var object
     */
    protected $addressService;

    /**
     * @var object
     */
    protected $resourceService;
    
    /**
     * @var object $permissionService
     */
    protected $permissionService;
    
    /**
     * @var object $clubCache
     */
    protected $clubCache;

    /**
     * Creates a new service instance
     */
    public function __construct(
        ClubRepositoryInterface $clubRepository,
        AlumnRepositoryInterface $alumnRepository,
        ClubTypeRepositoryInterface $clubTypeRepository,
        ResourceRepositoryInterface $resourceRepository,
        AddressService $addressService,
        ResourceService $resourceService,
        CompetitionMatchRepositoryInterface $matchRepository,
        TeacherRepositoryInterface $teacherRepository,
        PermissionService $permissionService,
        ClubCache $clubCache
    ) {
        $this->clubRepository = $clubRepository;
        $this->alumnRepository = $alumnRepository;
        $this->clubTypeRepository = $clubTypeRepository;
        $this->resourceRepository = $resourceRepository;
        $this->addressService = $addressService;
        $this->resourceService = $resourceService;
        $this->matchRepository = $matchRepository;
        $this->teacherRepository = $teacherRepository;
        $this->permissionService = $permissionService;
        $this->clubCache = $clubCache;
    }

    /**
     * Retrieves a list of clubs depending on the user requesting information
     *
     * @return array
     */
    public function index($type = 'sport')
    {
        $user = Auth::user();

        $clubIds = [];

        if ($type == 'sport' && $user->hasPermissionTo('club_list')) {
            $permissions = $this->permissionService->listUserPermissions($user->id);

            foreach ($permissions as $detail) {
                if (is_null($detail['entity']) || $detail['entity']['type'] != self::CLUB) { continue; }

                array_push($clubIds, $detail['entity']['id']);
            }
        }

        try {
            $clubType = $this->clubTypeRepository->findOneBy([
                'code' => $type
            ]);

            $clubs = $this->clubCache->findUserClubs($user->id, $type, $clubType->id, $clubIds);

            foreach ($clubs as $club) {
                $club->owner;
                $club->users_count;
                $club->address;
                $club->users;
                $club->academicYears;
            }

            return $clubs;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Stores a new club item inside the database
     *
     * @return object|array
     */
    public function store($user, $clubData, $addressData, $type = 'sport')
    {
        try {
            if (isset($clubData['image']) && $clubData['image'] != '') {
                $dataResource = $this->uploadResource('/clubs', $clubData['image']);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $clubData['image_id'] = $resource->id;
                }
            }

            $clubType = $this->clubTypeRepository->findOneBy([
                'code' => $type
            ]);

            $clubData['user_id'] = $user->id;
            $clubData['club_type_id'] = $clubType->id;

            $club = $this->clubRepository->create($clubData);

            $this->addressService->store($addressData, $club);

            $permissionCodes = collect(config('permission.names'))->where('entity_code', 'club')->first()['codes'];

            if ($type == 'sport') {
                $user->assignMultiplePermissions(
                    $permissionCodes,
                    $club->id,
                    get_class($club)
                );
            }

            if ($type == 'academic') {
                $teacherCreationPayload = [
                    'club_id' => $club->id,
                    'teacher_area_id' => TeacherArea::DIRECTIVE_ID,
                    'name' => $user->full_name,
                    'username' => $user->username,
                    'gender_id' => $user->gender,
                    'position_staff_id' => 1,
                    'responsibility' => 'Owner',
                    'department_chief' => true,
                    'class_tutor' => true,
                    'total_courses' => 0,
                    'image_id' => $user->image_id
                ];

                $this->teacherRepository->create($teacherCreationPayload);
            }

            $eventType = $type == 'sport' ? 'club_created' : 'school_center_created';

            $typeProfile = $type == 'sport' ? 'sport' : 'teacher';

            event(new ActivityEvent($user, $club, $eventType, null, null, [], $typeProfile));

            $this->clubCache->deleteUserClubs($user->id, $type);

            return $club;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Return information about specific club
     *
     * @return int
     */
    public function show($clubId, $type = 'sport')
    {
        try {
            $club = $this->clubRepository->getClubById($clubId);

            $club->address;
            $club->address->country;
            $club->address->province;

            if ($type == 'academic') {
                $club->academicYears;
            }

            return $club;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Updates information about an specific club
     *
     * @return bool|object
     */
    public function update($clubId, $clubData, $addressData, $type = 'sport')
    {
        try {
            $club = $this->clubRepository->getClubById($clubId);

            $deletableImageId = null;

            if (isset($clubData['image'])) {
                $dataResource = $this->uploadResource('/clubs', $clubData['image']);
                $resource = $this->resourceRepository->create($dataResource);
                $clubData['image_id'] = $resource->id;
                $deletableImageId = $club->image_id;
            }

            // Do the update
            $updated = $this->clubRepository->update($clubData, $club);

            // If the club does not have any address but it comes with some address data
            if (!$club->address && count($addressData) > 0) {
                $this->addressService->store($addressData, $club);
            } elseif (count($addressData) > 0) {
                // Otherwise just do a normal update
                $this->addressService->update($addressData, $club);
            }

            // After updating, delete the old image if exists
            if ($deletableImageId) {
                $this->resourceService->deleteResourceData($deletableImageId);
            }

            $activityType = $type == 'sport' ? 'club_updated' : 'school_center_updated';

            $typeProfile = $type == 'sport' ? 'sport' : 'teacher';

            event(new ActivityEvent(Auth::user(), $club, $activityType, null, null, [], $typeProfile));

            $this->clubCache->deleteUserClubs(Auth::id(), $type);

            return $updated;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Deletes a club
     *
     * @return bool
     */
    public function delete($clubId, $type = 'sport')
    {
        try {
            $club = $this->clubRepository->getClubById($clubId);

            $activityType = $type == 'sport' ? 'club_deleted' : 'school_center_updated';

            $typeProfile = $type == 'sport' ? 'sport' : 'teacher';

            event(new ActivityEvent(Auth::user(), $club, $activityType, null, null, [], $typeProfile));

            $this->clubRepository->delete($clubId);

            $this->clubCache->deleteUserClubs(Auth::id(), $type);

            return true;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieves a list of alumns related to the club as an school center
     *
     * @return array|object
     */
    public function getSchoolCenterAlumns($club)
    {
        return $this->alumnRepository->listAlumns($club);
    }

    /**
     * Retrieves all information about a team's matches regardless of competition
     * @return StaffUser
     *
     * @OA\Schema(
     *  schema="ClubTeamsMatchesListResponse",
     *  type="object",
     *  description="List all club's teams matches",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Team match list"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(
     *          property="recent",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="competition_id", type="int64", example="1"),
     *              @OA\Property(property="competition_rival_team_id", type="int64", example="1"),
     *              @OA\Property(property="club_id", type="int64", example="1"),
     *              @OA\Property(property="team_id", type="int64", example="1"),
     *              @OA\Property(property="referee_id", type="int64", example="1"),
     *              @OA\Property(property="weather_id", type="int64", example="1"),
     *              @OA\Property(property="location", type="string", example="string"),
     *              @OA\Property(property="competition_name", type="string", example="string"),
     *              @OA\Property(property="competition_url_image", type="string", example="string"),
     *              @OA\Property(property="match_situation", type="string", example="string"),
     *              @OA\Property(property="start_at", type="string", format="date-time", example="2022-01-01 00:00:00"),
     *              @OA\Property(
     *                  property="weather",
     *                  type="object",
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="code", type="string", example="string"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *              ),
     *              @OA\Property(
     *                  property="competition_rival_team",
     *                  type="object",
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="rival_team", type="string", example="string"),
     *                  @OA\Property(property="image_id", type="int64", example="1"),
     *                  @OA\Property(property="url_image", type="string", example="string"),
     *              ),
     *              @OA\Property(
     *                  property="referee",
     *                  type="object",
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *                  @OA\Property(property="country_id", type="int64", example="1"),
     *                  @OA\Property(property="province_id", type="int64", example="1"),
     *                  @OA\Property(property="sport_id", type="int64", example="1"),
     *              ),
     *          ),
     *      ),
     *      @OA\Property(
     *          property="next",
     *          type="string",
     *          example="Same array structure as 'recent' property",
     *      ),
     *  ),
     * )
     */
    public function getAllTeamsMatches($club)
    {
        $recentMatches = $this->matchRepository->findAllClubTeamsMatches($club, 'recent');
        
        $nextMatches = $this->matchRepository->findAllClubTeamsMatches($club, 'next');

        return [
            'recent' => $recentMatches,
            'next' => $nextMatches
        ];
    }

    /**
     * Retrieve array id clubs of users
     * @param $users
     *
     * @return array
     */
    public function listClubsUsers($users)
    {
        foreach ($users as $user) {
            $clubsDetail = $this->clubRepository->findBy([
                'club_type_id' => 1,
                'user_id' => $user
            ]);
            
            $clubs = new Collection();

            foreach ($clubsDetail as $clubDetail) {
                $clubDetail->teams;
                $clubDetail->teams->makeHidden([
                    'color', 'slug', 'season_id', 'season', 'sport_id', 'sport', 'type_id', 'type', 'image_id', 'image',
                    'cover_id', 'cover', 'modality_id', 'created_at', 'deleted_at'
                ]);
                $clubDetail->makeHidden(['users']);
                
            }

            $clubs = $clubs->merge($clubsDetail);
        }

        return $clubs;
    }

    /**
     * It returns the owner of a club.
     *
     * @param club_id the id of the club
     *
     * @return The owner of the club.
     */
    public function ownerClub($club_id)
    {
        $club = $this->clubRepository->findOneBy([
            'id' => $club_id,
        ]);

        return $club->owner;
    }
}
