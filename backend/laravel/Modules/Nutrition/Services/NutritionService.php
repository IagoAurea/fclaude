<?php


namespace Modules\Nutrition\Services;

use Exception;
use Illuminate\Http\Response;
use Modules\User\Entities\User;
use App\Traits\TranslationTrait;
use Modules\Player\Entities\Player;
use Modules\Club\Entities\ClubType;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Nutrition\Repositories\Interfaces\NutritionalSheetRepositoryInterface;


class NutritionService
{
  use TranslationTrait;

    const FACTORSMALE      = [664.73, 13.751, 5.0033, 6.55];
    const FACTORSFEMALE    = [665.51, 9.463, 4.8496, 4.6756];
    const FACTORSACTIVITY  = [1.2, 1.375, 1.55, 1.725, 1.9];

    /**
     * @var $playerService
     */
    protected $playerRepository;

     /**
     * @var $nutritionalSheetRepository
     */
    protected $nutritionalSheetRepository;

     /**
     * @var object $clubRepository
     */
    protected $clubRepository;

    public function __construct(
      PlayerRepositoryInterface $playerRepository,
      NutritionalSheetRepositoryInterface $nutritionalSheetRepository,
      ClubRepositoryInterface $clubRepository
    )
    {
      $this->playerRepository = $playerRepository;
      $this->nutritionalSheetRepository = $nutritionalSheetRepository;
      $this->clubRepository = $clubRepository;
    }

     /**
     * Retrieve all nutritional sheets create by players
     */
    public function allNutritionalSheetsByUser($user_id)
    {
        $clubs = $this->clubRepository->findUserClubs($user_id, ClubType::CLUB_TYPE_SPORT, [], ['teams.players']);

        $clubs->makeHidden(['users']);

        $total_nutritional_sheets = $clubs->map(function ($club) {
            $club->teams->makeHidden(['sport', 'season', 'type']);

            return $club->teams->map(function ($team) {
                return $team->players->map(function ($player) {
                    $player->tests = $this->nutritionalSheetRepository->findBy([
                      'player_id' => $player->id
                    ]);

                    return $player->tests->count();
                })->sum();
            })->sum();
        })->sum();

        return [
            'clubs' => $clubs,
            'total_nutritional_sheets' => $total_nutritional_sheets ?? 0
        ];
    }

    /**
     * Calculate the Athlete Activity .
     * @param array $hoursActivities
     * @param int $player
     * @return Response
     */

    public function athleteActivityCalculation($hoursActivities, $player)
    {
      $dataResponse = [
        "success" => true,
        "data" => "",
      ];

      $data_activity['basalEnergyExpenditure'] = 0;
      $data_activity['ActivityFactor'] = 0;
      $data_activity['totalEnergyExpenditure'] = 0;

      $basalEnergyExpenditure = $this->basalEnergyExpenditure($player);

      if (!$basalEnergyExpenditure['success']) {
          return $basalEnergyExpenditure;
      }

      $data_activity['basalEnergyExpenditure'] = $basalEnergyExpenditure['data'];

      $activityFactor= $this->activityFactor($hoursActivities);

      if (!$activityFactor['success']) {
        return $activityFactor;
      }

      $data_activity['ActivityFactor'] = $activityFactor['data'];

      $data_activity['totalEnergyExpenditure'] = round($basalEnergyExpenditure['data'] *  $activityFactor['data'], 1);

      $dataResponse['success'] = true;
      $dataResponse['message'] = "Athlete activity Calculation";
      $dataResponse['data'] = $data_activity;

      return $dataResponse;
    }

    /**
     * Calculate the Basal Energy Expenditure.
     * @param int $player_id
     * @return Response
     */
      
    public function basalEnergyExpenditure($player_id)
    {
      $player = $this->playerRepository->find($player_id);

      if (!$player instanceof Player) {
        $dataResponse['success'] = false;
        $dataResponse['message'] = "The player not found";
        return $dataResponse ;
      }

      $factors = [
        User::GENDER_MALE      => NutritionService::FACTORSMALE,
        User::GENDER_FEMALE    => NutritionService::FACTORSFEMALE,
        User::GENDER_UNDEFINED => NutritionService::FACTORSMALE,
      ];

      $player_gender  =  $player->gender_id ??
        abort(response()->error($this->translator('player_not_gender'), Response::HTTP_UNPROCESSABLE_ENTITY));
      $player_weight  =  $player->weight ??
        abort(response()->error($this->translator('player_not_weight'), Response::HTTP_UNPROCESSABLE_ENTITY));
      $player_age     =  $player->age ??
        abort(response()->error($this->translator('player_not_birthday'), Response::HTTP_UNPROCESSABLE_ENTITY));
      $palyer_height  =  $player->height ??
        abort(response()->error($this->translator('player_not_height'), Response::HTTP_UNPROCESSABLE_ENTITY));

      $basalEnergyCalculation = round(
        $factors[$player_gender][0] +
        ($factors[$player_gender][1] * $player_weight) +
        ($factors[$player_gender][2] * $palyer_height) -
        ($factors[$player_gender][3] * $player_age),
      1);

      $dataResponse['success'] = true;
      $dataResponse['message'] = "Basal energy calculation";
      $dataResponse['data'] = $basalEnergyCalculation;

      return $dataResponse ;
    }

    /**
     * Calculate the Activity Factor.
     * @param array $hoursActivities
     * @return Response
     */

    public function activityFactor($hoursActivities)
    {
      $fields = ['repose', 'very_light', 'light', 'moderate', 'intense'];

      foreach ($fields as $value) {
        if (!$hoursActivities[$value]) {
          $hoursActivities[$value] = 0;
        }
      }

      try {
        $activityFactor = round((
          ($hoursActivities['repose']      * NutritionService::FACTORSACTIVITY[0]) +
          ($hoursActivities['very_light']  * NutritionService::FACTORSACTIVITY[1]) +
          ($hoursActivities['light']       * NutritionService::FACTORSACTIVITY[2]) +
          ($hoursActivities['moderate']    * NutritionService::FACTORSACTIVITY[3]) +
          ($hoursActivities['intense']     * NutritionService::FACTORSACTIVITY[4])
        ) / 24, 2);

        $dataResponse['success'] = true;
        $dataResponse['message'] = "Activity factor calculation";
        $dataResponse['data'] = $activityFactor;

        return $dataResponse;
      } catch (Exception $exception) {
        $dataResponse['success'] = false;
        $dataResponse['message'] = $exception->getMessage();
        return $dataResponse ;
      }
    }

    public function nutricionalSheetByPlayer($player_id)
    {
      $nutricionalSheet = $this->nutritionalSheetRepository->findNutricionalSheetByPlayerId($player_id);

      $nutricionalSheet->map(function ($register) use ($player_id) {
        $basalEnergyExpenditure = $this->basalEnergyExpenditure($player_id);

        $register['basal_energy_expenditure'] = $basalEnergyExpenditure['data'] ?? 0;

        return $register;
      });

      return $nutricionalSheet;
    }

  }
