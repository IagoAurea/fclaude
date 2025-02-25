<?php

namespace Modules\Team\Database\Seeders;

use Faker\Factory;
use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Team\Entities\Team;
use Illuminate\Support\Facades\File;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Modules\Team\Repositories\Interfaces\TeamTypeRepositoryInterface;
use Modules\User\Repositories\Interfaces\PermissionRepositoryInterface;
use Modules\Team\Repositories\Interfaces\TeamModalityRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\SeasonRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class TeamsTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var object
     */
    protected $teamRepository;

    /**
     * @var object
     */
    protected $teamTypeRepository;

    /**
     * @var object
     */
    protected $teamModalityRepository;

    /**
     * @var object
     */
    protected $clubRepository;

    /**
     * @var object
     */
    protected $seasonRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $sportRepository
     */
    protected $sportRepository;

    /**
     * @var $permissionRepository
     */
    protected $permissionRepository;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * @var object
     */
    protected $faker;

    public function __construct(
        TeamRepositoryInterface $teamRepository,
        TeamTypeRepositoryInterface $teamTypeRepository,
        TeamModalityRepositoryInterface $teamModalityRepository,
        ClubRepositoryInterface $clubRepository,
        SeasonRepositoryInterface $seasonRepository,
        ResourceRepositoryInterface $resourceRepository,
        SportRepositoryInterface $sportRepository,
        PermissionRepositoryInterface $permissionRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->teamRepository = $teamRepository;
        $this->teamTypeRepository = $teamTypeRepository;
        $this->teamModalityRepository = $teamModalityRepository;
        $this->clubRepository = $clubRepository;
        $this->seasonRepository = $seasonRepository;
        $this->resourceRepository = $resourceRepository;
        $this->sportRepository = $sportRepository;
        $this->permissionRepository = $permissionRepository;
        $this->userRepository = $userRepository;
        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    protected function createTeam(array $elements)
    {
        foreach ($elements as $element) {
            $clubs = $this->clubRepository->findByOwner($element);

            foreach ($clubs as $club) {
                $sports = $this->sportRepository->findByScouting(true);

                $team_permissions = $this->permissionRepository->findIn('entity_code',
                    [
                        'team', 'competition', 'competition_match', 'scouting', 'player', 'exercise', 'session_exercise',
                        'test', 'injury_prevention', 'injury_rfd', 'fisiotherapy', 'effort_recovery', 'nutrition', 'psychology'
                    ]
                );
                
                foreach ($sports as $sport) {
                    $image = $this->getImageRandom('rand');

                    $season = $this->seasonRepository->findOneBy(['start' => now()->format('Y')]);

                    $type = $this->teamTypeRepository->getRandom()->first();
                    
                    $dataResource = $this->uploadResource('/clubs/teams', $image);

                    $resource = $this->resourceRepository->create($dataResource);

                    $dataTeam = [
                        'name' => 'Team ' . ' - ' . ucfirst($sport->name),
                        'category' => 'Category ' . ucfirst($this->faker->name),
                        'color' => $this->faker->hexcolor,
                        'image_id' => $resource->id,
                        'type_id' => $type->id,
                        'season_id' => $season->id,
                        'gender_id' => $this->faker->randomElement([Team::GENDER_MIXED, Team::GENDER_MALE, Team::GENDER_FEMALE]),
                        'sport_id' => $sport->id,
                        'club_id' => $club->id,
                        'user_id' => $club->user_id
                    ];

                    $modalities = $this->teamModalityRepository->findBy(['id' => $sport->id]);

                    if (count($modalities) > 0) {
                        $modality = $modalities->shuffle()->first();

                        $dataTeam['modality_id'] = $modality->id;
                    }

                    $team = $this->teamRepository->create($dataTeam);

                    $user = $this->userRepository->findOneBy(['id' => $club->user_id]);

                    foreach ($team_permissions as $team_permission) {
                        $user->manageEntityPermission($team_permission->id, $team->id, get_class($team), 'assign');
                    }
                }
            }
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'user_55sy6csdmp@gmail.com'
            ],
            [
                'teach_mod7ra6j3q@gmail.com'
            ],
            [
                'cliente@fisicalcoach.com'
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTeam($this->get()->current());
    }
}
