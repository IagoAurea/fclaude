<?php

namespace Modules\Activity\Services;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Activity\Repositories\Interfaces\ActivityRepositoryInterface;
use Modules\Subscription\Repositories\Interfaces\LicenseRepositoryInterface;

class ActivityService
{
    use ResponseTrait;

    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $clubRepository
     */
    protected $clubRepository;

    /**
     * @var $teamRepository
     */
    protected $teamRepository;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * @var $activityRepository
     */
    protected $activityRepository;
    
    /**
     * @var $licenseRepository
     */
    protected $licenseRepository;

    /**
     * Creates a new service instance
     */
    public function __construct(
        PlayerRepositoryInterface $playerRepository,
        ClubRepositoryInterface $clubRepository,
        TeamRepositoryInterface $teamRepository,
        UserRepositoryInterface $userRepository,
        ActivityRepositoryInterface $activityRepository,
        LicenseRepositoryInterface $licenseRepository

    ) {
        $this->playerRepository = $playerRepository;
        $this->clubRepository = $clubRepository;
        $this->teamRepository = $teamRepository;
        $this->userRepository = $userRepository;
        $this->activityRepository = $activityRepository;
        $this->licenseRepository = $licenseRepository;
    }

    /**
     * Retrieves all the entity activities related to an specific
     * type of class sent by parameter
     *
     * @param String $type = 'user' | 'club' | 'team'
     * @param String|Int $id
     * @return Response
     *
     * @OA\Schema(
     *  schema="ActivityListResponse",
     *  type="object",
     *  description="Returns a list of all entity activities",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="string"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="user_id", type="int64", example="1"),
     *          @OA\Property(property="activity_type_id", type="int64", example="1"),
     *          @OA\Property(property="entity_type", type="string", example="string"),
     *          @OA\Property(property="entity_id", type="int64", example="1"),
     *          @OA\Property(property="secondary_entity_type", type="string", example="string"),
     *          @OA\Property(property="secondary_entity_id", type="int64", example="1"),
     *          @OA\Property(property="date", type="string", format="datetime", example="2022-01-01 00:00:00"),
     *          @OA\Property(
     *              property="activity_type",
     *              type="object",
     *              @OA\Property(
     *                  property="id", type="int64", example="1"
     *              ),
     *              @OA\Property(
     *                  property="code", type="string", example="string"
     *              ),
     *              @OA\Property(
     *                  property="name", type="string", example="string"
     *              ),
     *          ),
     *          @OA\Property(
     *              property="user",
     *              type="object",
     *              @OA\Property(
     *                  property="id", type="int64", example="1"
     *              ),
     *              @OA\Property(
     *                  property="full_name", type="string", example="string"
     *              ),
     *              @OA\Property(
     *                  property="email", type="string", example="string"
     *              ),
     *          ),
     *          @OA\Property(property="entity", type="string", example="object"),
     *          @OA\Property(property="secondary_entity", type="string", example="object"),
     *          @OA\Property(property="third_entity", type="string", example="object"),
     *      ),
     *  ),
     * )
     */
    public function getEntityActivities($request)
    {
        try {
            // If activity mapping is user, then resolve all clubs items activitites
            if ($request->type === 'user') {
                return $this->resolveUserClubActivities($request->id, $request->type_profile);
            }
    
            // Otherwise club or team types could be resolved like this
            $repository = $this->resolveRepository($request->type);
    
            // Do manual entity searching
            $entity = $repository->findOneBy([
                'id' => $request->id
            ]);
    
            // Throw an error in case the entity is not found
            if (!$entity) {
                throw new Exception('Entity could not be found', Response::HTTP_NOT_FOUND);
            }
    
            return $entity->activities;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieves all the entity activities related to an specific
     * type of class sent by parameter
     *
     * @param String $type
     * @param String|Int $id
     * @return Response
     */
    public function getActivitiesByUsersClub($user_id, $skip, $limit)
    {
        $user = $this->userRepository->find($user_id);
        $clubs_id = [];

        foreach ($user->clubs as $club) {
            array_push($clubs_id, $club->id);
        }

        return $this->activityRepository->findAllByUserClubs($clubs_id,$skip,$limit) ;
    }


    /**
     * Resolves the needed repository depending on the type sent
     *
     * @param String $type
     * @return object
     */
    private function resolveRepository($type)
    {
        $repositories = [
            'club' => $this->clubRepository,
            'player' => $this->playerRepository,
            'team'  =>  $this->teamRepository,
            'license' => $this->licenseRepository,
        ];

        return $repositories[$type];
    }

    private function resolveUserClubActivities($id, $type_profile)
    {
        $user = $this->userRepository->findOneBy([
            'id' => $id
        ]);

        $clubIds = $user->clubs->pluck('id');

        return $this->activityRepository->findClubActivities($clubIds, $type_profile);
    }
}
