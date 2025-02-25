<?php

namespace Modules\Sport\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class SportsTableSeeder extends BaseSeeder
{
  use ResourceTrait;

  /**
   * @var $sportRepository
   */
  protected $sportRepository;

  /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

  public function __construct(
    SportRepositoryInterface $sportRepository,
    ResourceRepositoryInterface $resourceRepository
  )
  {
    $this->sportRepository = $sportRepository;
    $this->resourceRepository = $resourceRepository;
  }

  /**
   * @return void
   */
  protected function createSports(array $elements)
  {
    foreach ($elements as $elm) {
      $sport = $elm['code'];

      $images = [
        'court' => 'court_id',
        'exercise' => 'image_exercise_id',
        $sport => 'image_id'
      ];

      foreach ($images as $image => $key) {
        $params['directory']= "sports/" . $sport;
        $params['name']= $image;

        $elm[$key] = $this->uploadImage($sport, $params);
      }

      $this->sportRepository->create($elm);
    }
  }

  /**
   * Upload image sport associate
   */
  protected function uploadImage($sport, $params)
  {
    $image = $this->getImage($params);

    $dataResource = $this->uploadResource('/sports/' . $sport, $image);

    $resource = $this->resourceRepository->create($dataResource);

    return $resource->id;
  }

  /**
   * @return \Iterator
   */
  private function get()
  {
    yield [
      [
        'es' => [
          'name' => 'Fútbol'
        ],
        'en' => [
          'name' => 'Football'
        ],
        'has_scouting' => true,
        'code' => 'football',
        'model_url' => 'sim3d/01A/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Fútbol sala'
        ],
        'en' => [
          'name' => 'Indoor soccer'
        ],
        'has_scouting' => true,
        'code' => 'indoor_soccer',
        'model_url' => 'sim3d/01B/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Baloncesto'
        ],
        'en' => [
          'name' => 'Basketball'
        ],
        'has_scouting' => true,
        'code' => 'basketball',
        'model_url' => 'sim3d/02/index.html',
        'time_game' => 2
      ],
      [
        'es' => [
          'name' => 'Balonmano'
        ],
        'en' => [
          'name' => 'Handball'
        ],
        'has_scouting' => true,
        'code' => 'handball',
        'model_url' => 'sim3d/03/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Voleibol'
        ],
        'en' => [
          'name' => 'Volleyball'
        ],
        'has_scouting' => true,
        'code' => 'volleyball',
        'model_url' => 'sim3d/04A/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Voley playa'
        ],
        'en' => [
          'name' => 'Beach volleyball'
        ],
        'has_scouting' => true,
        'code' => 'beach_volleyball',
        'model_url' => 'sim3d/04B/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Rugby'
        ],
        'en' => [
          'name' => 'Rugby'
        ],
        'has_scouting' => true,
        'code' => 'rugby',
        'model_url' => 'sim3d/05A/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Fútbol americano'
        ],
        'en' => [
          'name' => 'American soccer'
        ],
        'has_scouting' => true,
        'code' => 'american_soccer',
        'model_url' => 'sim3d/05B/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Béisbol'
        ],
        'en' => [
          'name' => 'Baseball'
        ],
        'has_scouting' => true,
        'code' => 'baseball',
        'model_url' => 'sim3d/06/index.html',
        'time_game' => 5
      ],
      
      [
        'es' => [
          'name' => 'Cricket'
        ],
        'en' => [
          'name' => 'Cricket'
        ],
        'has_scouting' => true,
        'code' => 'cricket',
        'model_url' => 'sim3d/07/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Hockey hierba'
        ],
        'en' => [
          'name' => 'Field hockey'
        ],
        'has_scouting' => true,
        'code' => 'field_hockey',
        'model_url' => 'sim3d/08A/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Hockey patines'
        ],
        'en' => [
          'name' => 'Roller hockey'
        ],
        'has_scouting' => true,
        'code' => 'roller_hockey',
        'model_url' => 'sim3d/08B/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Hockey hielo'
        ],
        'en' => [
          'name' => 'Ice hockey'
        ],
        'has_scouting' => true,
        'code' => 'ice_hockey',
        'model_url' => 'sim3d/08C/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Tenis'
        ],
        'en' => [
          'name' => 'Tennis'
        ],
        'has_scouting' => true,
        'code' => 'tennis',
        'model_url' => 'sim3d/09A/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Pádel'
        ],
        'en' => [
          'name' => 'Padel'
        ],
        'has_scouting' => true,
        'code' => 'padel',
        'model_url' => 'sim3d/09B/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Bádminton'
        ],
        'en' => [
          'name' => 'Badminton'
        ],
        'has_scouting' => true,
        'code' => 'badminton',
        'model_url' => 'sim3d/09C/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Waterpolo'
        ],
        'en' => [
          'name' => 'Waterpolo'
        ],
        'has_scouting' => true,
        'code' => 'waterpolo',
        'model_url' => 'sim3d/11/index.html',
        'time_game' => 5
      ],
      [
        'es' => [
          'name' => 'Natación'
        ],
        'en' => [
          'name' => 'Swimming',
        ],
        'has_scouting' => true,
        'code' => 'swimming',
        'model_url' => 'sim3d/10/index.html',
        'time_game' => 5
      ],

      [
        'es' => [
          'name' => 'Aerobic'
        ],
        'en' => [
          'name' => 'Aerobics'
        ],
        'has_scouting' => false,
        'code' => 'aerobics',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Aikido'
        ],
        'en' => [
          'name' => 'Aikido'
        ],
        'has_scouting' => false,
        'code' => 'aikido',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Ajedrez'
        ],
        'en' => [
          'name' => 'Chess'
        ],
        'has_scouting' => false,
        'code' => 'chess',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Apnea'
        ],
        'en' => [
          'name' => 'Apnea'
        ],
        'has_scouting' => false,
        'code' => 'apnea',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Artes marciales mixtas'
        ],
        'en' => [
          'name' => 'Mixed martial arts'
        ],
        'has_scouting' => false,
        'code' => 'mixed_martial',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Atletismo'
        ],
        'en' => [
          'name' => 'Athletics'
        ],
        'has_scouting' => false,
        'code' => 'athletics',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Atletismo paralímpico'
        ],
        'en' => [
          'name' => 'Paralympic Athletics'
        ],
        'has_scouting' => false,
        'code' => 'paralympic_athletics',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Baile deportivo'
        ],
        'en' => [
          'name' => 'Dance Sport'
        ],
        'has_scouting' => false,
        'code' => 'dance_sport',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Baloncesto en silla de ruedas'
        ],
        'en' => [
          'name' => 'Wheelchair Basketball'
        ],
        'has_scouting' => false,
        'code' => 'wheelchair_basketball',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Bodyboard'
        ],
        'en' => [
          'name' => 'Bodyboard'
        ],
        'has_scouting' => false,
        'code' => 'bodyboard',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Boxeo'
        ],
        'en' => [
          'name' => 'Boxing'
        ],
        'has_scouting' => false,
        'code' => 'boxing',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Bowling'
        ],
        'en' => [
          'name' => 'Bowling'
        ],
        'has_scouting' => false,
        'code' => 'bowling',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Crossfit'
        ],
        'en' => [
          'name' => 'Crossfit'
        ],
        'has_scouting' => false,
        'code' => 'crossfit',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Curling'
        ],
        'en' => [
          'name' => 'Curling'
        ],
        'has_scouting' => false,
        'code' => 'curling',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Ciclismo'
        ],
        'en' => [
          'name' => 'Cycling'
        ],
        'has_scouting' => false,
        'code' => 'cycling',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Danza deportiva'
        ],
        'en' => [
          'name' => 'Sport dance'
        ],
        'has_scouting' => false,
        'code' => 'sport_dance',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Dardos'
        ],
        'en' => [
          'name' => 'Darts'
        ],
        'has_scouting' => false,
        'code' => 'darts',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Duatlon'
        ],
        'en' => [
          'name' => 'Duathlon'
        ],
        'has_scouting' => false,
        'code' => 'duathlon',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Escalada'
        ],
        'en' => [
          'name' => 'Climbing'
        ],
        'has_scouting' => false,
        'code' => 'climbing',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Esgrima'
        ],
        'en' => [
          'name' => 'Fencing'
        ],
        'has_scouting' => false,
        'code' => 'fencing',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Equitación'
        ],
        'en' => [
          'name' => 'Horse riding'
        ],
        'has_scouting' => false,
        'code' => 'horse_riding',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Esquí'
        ],
        'en' => [
          'name' => 'Ski'
        ],
        'has_scouting' => false,
        'code' => 'ski',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Esquí nautico'
        ],
        'en' => [
          'name' => 'Waterskiing'
        ],
        'has_scouting' => false,
        'code' => 'waterskiing',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Floorball'
        ],
        'en' => [
          'name' => 'Floorball'
        ],
        'has_scouting' => false,
        'code' => 'floorball',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Fútbol australiano'
        ],
        'en' => [
          'name' => 'Australian football'
        ],
        'has_scouting' => false,
        'code' => 'australian_football',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Fútbol playa'
        ],
        'en' => [
          'name' => 'Beach Soccer'
        ],
        'has_scouting' => false,
        'code' => 'beach_soccer',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Futvoley'
        ],
        'en' => [
          'name' => 'Futvoley'
        ],
        'has_scouting' => false,
        'code' => 'futvoley',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Goalball'
        ],
        'en' => [
          'name' => 'Goalball'
        ],
        'has_scouting' => false,
        'code' => 'goalball',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Golf'
        ],
        'en' => [
          'name' => 'Golf'
        ],
        'has_scouting' => false,
        'code' => 'golf',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Gimnasia acrobática'
        ],
        'en' => [
          'name' => 'Acrobatic gymnastics'
        ],
        'has_scouting' => false,
        'code' => 'acrobatic_gymnastics',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Gimnasia aeróbica'
        ],
        'en' => [
          'name' => 'Aerobic gymnastics'
        ],
        'has_scouting' => false,
        'code' => 'aerobic_gymnastics',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Gimnasia artística'
        ],
        'en' => [
          'name' => 'Artistic gymnastics'
        ],
        'has_scouting' => false,
        'code' => 'artistic_gymnastics',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Gimansia rítmica'
        ],
        'en' => [
          'name' => 'Rhythmic gymnastics'
        ],
        'has_scouting' => false,
        'code' => 'rhythmic_gymnastics',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Gimnasia en trampolín'
        ],
        'en' => [
          'name' => 'Trampoline gymnastics'
        ],
        'has_scouting' => false,
        'code' => 'trampoline_gymnastics',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Halterofilia'
        ],
        'en' => [
          'name' => 'Weightlifting'
        ],
        'has_scouting' => false,
        'code' => 'weightlifting',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Judo'
        ],
        'en' => [
          'name' => 'Judo'
        ],
        'has_scouting' => false,
        'code' => 'judo',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Jiu-Jitsu'
        ],
        'en' => [
          'name' => 'Jiu Jitsu'
        ],
        'has_scouting' => false,
        'code' => 'jiu_jitsu',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Karate'
        ],
        'en' => [
          'name' => 'Karate'
        ],
        'has_scouting' => false,
        'code' => 'karate',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Kayak'
        ],
        'en' => [
          'name' => 'Kayak'
        ],
        'has_scouting' => false,
        'code' => 'kayak',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Kendo'
        ],
        'en' => [
          'name' => 'Kendo'
        ],
        'has_scouting' => false,
        'code' => 'kendo',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Kickboxing'
        ],
        'en' => [
          'name' => 'Kickboxing'
        ],
        'has_scouting' => false,
        'code' => 'kickboxing',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Kitesurf'
        ],
        'en' => [
          'name' => 'Kitesurf'
        ],
        'has_scouting' => false,
        'code' => 'kitesurf',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Korfbal'
        ],
        'en' => [
          'name' => 'Korfbal'
        ],
        'has_scouting' => false,
        'code' => 'korfbal',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Kung Fu'
        ],
        'en' => [
          'name' => 'Kung Fu'
        ],
        'has_scouting' => false,
        'code' => 'kung_fu',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Lacrosse'
        ],
        'en' => [
          'name' => 'Lacrosse'
        ],
        'has_scouting' => false,
        'code' => 'lacrosse',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Lucha'
        ],
        'en' => [
          'name' => 'Fighting'
        ],
        'has_scouting' => false,
        'code' => 'fighting',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Lucha canaria'
        ],
        'en' => [
          'name' => 'Canarian fight'
        ],
        'has_scouting' => false,
        'code' => 'canarian_fight',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Lucha grecorromana'
        ],
        'en' => [
          'name' => 'Greco-Roman fight'
        ],
        'has_scouting' => false,
        'code' => 'greco_roman_fight',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Lucha libre'
        ],
        'en' => [
          'name' => 'Wrestling'
        ],
        'has_scouting' => false,
        'code' => 'wrestling',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Marcha atlética'
        ],
        'en' => [
          'name' => 'Athletic walk'
        ],
        'has_scouting' => false,
        'code' => 'athletic_walk',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Mhuai Thay'
        ],
        'en' => [
          'name' => 'Mhuai Thay'
        ],
        'has_scouting' => false,
        'code' => 'mhuai_thay',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Motociclismo'
        ],
        'en' => [
          'name' => 'Motorcycling'
        ],
        'has_scouting' => false,
        'code' => 'motorcycling',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Natación sincronizada'
        ],
        'en' => [
          'name' => 'Synchronized swimming'
        ],
        'has_scouting' => false,
        'code' => 'synchronized_swimming',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Natación palalímpica'
        ],
        'en' => [
          'name' => 'Palalympic swimming'
        ],
        'has_scouting' => false,
        'code' => 'palalympic_swimming',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Netball'
        ],
        'en' => [
          'name' => 'Netball'
        ],
        'has_scouting' => false,
        'code' => 'netball',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Orientación'
        ],
        'en' => [
          'name' => 'Orientation'
        ],
        'has_scouting' => false,
        'code' => 'orientation',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Parkour'
        ],
        'en' => [
          'name' => 'Parkour'
        ],
        'has_scouting' => false,
        'code' => 'parkour',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Patinaje'
        ],
        'en' => [
          'name' => 'Skating'
        ],
        'has_scouting' => false,
        'code' => 'skating',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Patinaje artístico'
        ],
        'en' => [
          'name' => 'Figure skating'
        ],
        'has_scouting' => false,
        'code' => 'figure_skating',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Pelota vasca'
        ],
        'en' => [
          'name' => 'Vasca ball'
        ],
        'has_scouting' => false,
        'code' => 'vasca_ball',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Pentatlón moderno'
        ],
        'en' => [
          'name' => 'Modern pentathlon'
        ],
        'has_scouting' => false,
        'code' => 'modern_pentathlon',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Pesca'
        ],
        'en' => [
          'name' => 'Fishing'
        ],
        'has_scouting' => false,
        'code' => 'fishing',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Petanca'
        ],
        'en' => [
          'name' => 'Petanque'
        ],
        'has_scouting' => false,
        'code' => 'petanque',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Piragüismo'
        ],
        'en' => [
          'name' => 'Canoeing'
        ],
        'has_scouting' => false,
        'code' => 'canoeing',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Polo'
        ],
        'en' => [
          'name' => 'Pole'
        ],
        'has_scouting' => false,
        'code' => 'pole',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Pole dance'
        ],
        'en' => [
          'name' => 'Pole dance'
        ],
        'has_scouting' => false,
        'code' => 'pole_dance',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Quidditch'
        ],
        'en' => [
          'name' => 'Quidditch'
        ],
        'has_scouting' => false,
        'code' => 'quidditch',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Remo'
        ],
        'en' => [
          'name' => 'Rowing'
        ],
        'has_scouting' => false,
        'code' => 'rowing',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Savate'
        ],
        'en' => [
          'name' => 'Savate'
        ],
        'has_scouting' => false,
        'code' => 'savate',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Skateboard'
        ],
        'en' => [
          'name' => 'Skateboard'
        ],
        'has_scouting' => false,
        'code' => 'skateboard',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Snowboard'
        ],
        'en' => [
          'name' => 'Snowboard'
        ],
        'has_scouting' => false,
        'code' => 'snowboard',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Softbol'
        ],
        'en' => [
          'name' => 'Softball'
        ],
        'has_scouting' => false,
        'code' => 'softball',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Squash'
        ],
        'en' => [
          'name' => 'Squash'
        ],
        'has_scouting' => false,
        'code' => 'squash',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Sumo'
        ],
        'en' => [
          'name' => 'Sumo'
        ],
        'has_scouting' => false,
        'code' => 'sumo',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Superbikes'
        ],
        'en' => [
          'name' => 'Superbikes'
        ],
        'has_scouting' => false,
        'code' => 'superbikes',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Surf'
        ],
        'en' => [
          'name' => 'Surf'
        ],
        'has_scouting' => false,
        'code' => 'surf',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Tenis de mesa'
        ],
        'en' => [
          'name' => 'Table tennis'
        ],
        'has_scouting' => false,
        'code' => 'table_tennis',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Tiro'
        ],
        'en' => [
          'name' => 'Throw'
        ],
        'has_scouting' => false,
        'code' => 'threw',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Tiro con arco'
        ],
        'en' => [
          'name' => 'Archery'
        ],
        'has_scouting' => false,
        'code' => 'archery',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Tiro deportivo'
        ],
        'en' => [
          'name' => 'Sport Shot'
        ],
        'has_scouting' => false,
        'code' => 'sport_shot',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Triatlón'
        ],
        'en' => [
          'name' => 'Triathlon'
        ],
        'has_scouting' => false,
        'code' => 'triathlon',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Taekwondo'
        ],
        'en' => [
          'name' => 'Taekwondo'
        ],
        'has_scouting' => false,
        'code' => 'taekwondo',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Tchoukball'
        ],
        'en' => [
          'name' => 'Tchoukball'
        ],
        'has_scouting' => false,
        'code' => 'tchoukball',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Trampolín'
        ],
        'en' => [
          'name' => 'Trampoline'
        ],
        'has_scouting' => false,
        'code' => 'trampoline',
        'model_url' => null
      ],

      [
        'es' => [
          'name' => 'Ultimate'
        ],
        'en' => [
          'name' => 'Ultimate'
        ],
        'has_scouting' => false,
        'code' => 'ultimate',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Vela'
        ],
        'en' => [
          'name' => 'Vela'
        ],
        'has_scouting' => false,
        'code' => 'vela',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Voleibol sentado'
        ],
        'en' => [
          'name' => 'Sitting volleyball'
        ],
        'has_scouting' => false,
        'code' => 'sitting_volleyball',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Wakeboarding'
        ],
        'en' => [
          'name' => 'Wakeboarding'
        ],
        'has_scouting' => false,
        'code' => 'wakeboarding',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Windsurf'
        ],
        'en' => [
          'name' => 'Windsurf'
        ],
        'has_scouting' => false,
        'code' => 'windsurf',
        'model_url' => null
      ],
      [
        'es' => [
          'name' => 'Gimnasio'
        ],
        'en' => [
          'name' => 'Gym'
        ],
        'has_scouting' => false,
        'code' => 'fitness',
        'model_url' => 'sim3d/12A/index.html',
        'is_teacher_profile' => true
      ],
      [
        'es' => [
          'name' => 'Pabellón polideportivo'
        ],
        'en' => [
          'name' => 'Sports hall'
        ],
        'has_scouting' => false,
        'code' => 'sports_hall',
        'model_url' => 'sim3d/03/index.html',
        'is_teacher_profile' => true
      ],
      [
        'es' => [
          'name' => 'Pista polideportiva aire libre'
        ],
        'en' => [
          'name' => 'Outdoor sports track'
        ],
        'has_scouting' => false,
        'code' => 'outdoor_sports_track',
        'model_url' => 'sim3d/12B/index.html',
        'is_teacher_profile' => true
      ],

    ];
  }

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->createSports($this->get()->current());
  }
}
