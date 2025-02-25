<?php

namespace Modules\Training\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Training\Repositories\Interfaces\TargetSessionRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;

class TargetSessionsTableSeeder extends Seeder
{
   /**
     * @var object
     */
    protected $targetSessionRepository;

    /**
     * @var $sportRepository
     */
    protected $sportRepository;

    public function __construct(
        TargetSessionRepositoryInterface $targetSessionRepository,
        SportRepositoryInterface $sportRepository
    )
    {
        $this->targetSessionRepository = $targetSessionRepository;
        $this->sportRepository = $sportRepository;
    }

    /**
     * @return void
     */
    protected function createTargetSession()
    {
        $sports = $this->sportRepository->findAll();

        foreach ($sports as $sport)
        {
            $targets = $this->typeTargetSession($sport->code);

            foreach ($targets as $target)
            {
                $target['sport_id'] = $sport->id;

                $this->targetSessionRepository->create($target);
            }
        }

    }

    /**
     * @return array
     */
    private function typeTargetSession($sport)
    {
        $type_targets_session = [
            'football' => array_merge($this->targetsSportRepetitive(), $this->targetsFootball()),
            'indoor_soccer' => array_merge($this->targetsSportRepetitive(), $this->targetsIndoorSoccer()),
            'handball' => array_merge($this->targetsSportRepetitive(), $this->targetsHandBall()),
            'basketball' => array_merge($this->targetsSportRepetitive(), $this->targetsBasketball()),
            'volleyball' => array_merge($this->targetsSportRepetitive(), $this->targetsVolleyball()),
            'beach_volleyball' => array_merge($this->targetsSportRepetitive(), $this->targetsBeachVolleyball()),
            'roller_hockey' => array_merge($this->targetsSportRepetitive(), $this->targetsRollerHockey()),
            'field_hockey' => array_merge($this->targetsSportRepetitive(), $this->targetsFieldHockey()),
            'ice_hockey' => array_merge($this->targetsSportRepetitive(), $this->targetsIceHockey()),
            'baseball' => array_merge($this->targetsSportRepetitive(), $this->targetsBaseball()),
            'waterpolo' => array_merge($this->targetsSportRepetitive(), $this->targetsWaterpolo()),
            'american_soccer' => array_merge($this->targetsSportRepetitive(), $this->targetsAmericanSoccer()),
            'tennis' => array_merge($this->targetsSportRepetitive(), $this->targetsTennis()),
            'padel' => array_merge($this->targetsSportRepetitive(), $this->targetsPadel()),
            'badminton' => array_merge($this->targetsSportRepetitive(), $this->targetsBadminton()),
            'swimming' => array_merge($this->targetsSportRepetitive(), $this->targetsSwimming()),
            'rugby' => array_merge($this->targetsSportRepetitive(), $this->targetsRugby()),
            'cricket' => array_merge($this->targetsSportRepetitive(), $this->targetsCricket()),
        ];

        return $type_targets_session[$sport] ?? [];
    }

     /**
     * Retrieve array targets sport football
     */

     private function targetsFootball()
     {
         return [
             [
                 'es' => [
                     'name' => 'Desplazamientos ofensivos'
                 ],
                 'en' => [
                     'name' => 'Offensive displacements'
                 ],
                 'code' => 'offensive_displacements',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Conducción de balón'
                 ],
                 'en' => [
                     'name' => 'Ball driving'
                 ],
                 'code' => 'ball_driving',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Finta'
                 ],
                 'en' => [
                     'name' => 'Feint'
                 ],
                 'code' => 'feint',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Protección de balón'
                 ],
                 'en' => [
                     'name' => 'Shielding the ball'
                 ],
                 'code' => 'shielding_ball',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Pase'
                 ],
                 'en' => [
                     'name' => 'pass'
                 ],
                 'code' => 'Pass',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Control del balón'
                 ],
                 'en' => [
                     'name' => 'Ball control'
                 ],
                 'code' => 'ball_control',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Volea'
                 ],
                 'en' => [
                     'name' => 'Volley'
                 ],
                 'code' => 'volley',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Golpeo de balón'
                 ],
                 'en' => [
                     'name' => 'Ball kick'
                 ],
                 'code' => 'ball_kick',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Tiro'
                 ],
                 'en' => [
                     'name' => 'Shot'
                 ],
                 'code' => 'shot',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => ' Remate de cabeza'
                 ],
                 'en' => [
                     'name' => 'Head kick'
                 ],
                 'code' => 'head_kick',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],    
             [
                 'es' => [
                     'name' => 'Remate de chilena'
                 ],
                 'en' => [
                     'name' => 'Overhead kick'
                 ],
                 'code' => 'Overhead kick',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Tiro libre'
                 ],
                 'en' => [
                     'name' => 'Free kick'
                 ],
                 'code' => 'free_kick',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Penalti'
                 ],
                 'en' => [
                     'name' => 'Penalty kick'
                 ],
                 'code' => 'penalty_kick',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ], 
             [
                 'es' => [
                     'name' => 'Saque de esquina'
                 ],
                 'en' => [
                     'name' => 'Corner kick'
                 ],
                 'code' => 'corner_kick',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Saque de banda'
                 ],
                 'en' => [
                     'name' => 'Throw-in'
                 ],
                 'code' => 'throw_in',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Regate'
                 ],
                 'en' => [
                     'name' => 'Dribbling'
                 ],
                 'code' => 'dribbling',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Posición básica defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive stance'
                 ],
                 'code' => 'defensive_stance',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Desplazamientos defensivos'
                 ],
                 'en' => [
                     'name' => 'Defensive displacements'
                 ],
                 'code' => 'defensive_displacements',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ], 
             [
                 'es' => [
                     'name' => 'Robo de balón'
                 ],
                 'en' => [
                     'name' => 'Steal the ball'
                 ],
                 'code' => 'steal_ball',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ], 
 
             [
                 'es' => [
                     'name' => 'Entrada'
                 ],
                 'en' => [
                     'name' => 'Tackling'
                 ],
                 'code' => 'tackling',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ], 
             [
                 'es' => [
                     'name' => 'Despeje'
                 ],
                 'en' => [
                     'name' => 'Clearance'
                 ],
                 'code' => 'clearance',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ], 
             [
                 'es' => [
                     'name' => 'Carga'
                 ],
                 'en' => [
                     'name' => 'Shoulder barge'
                 ],
                 'code' => 'shoulder_barge',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Posiciones básicas'
                 ],
                 'en' => [
                     'name' => 'Basic stances'
                 ],
                 'code' => 'basic_stances',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Movimientos básicos'
                 ],
                 'en' => [
                     'name' => 'Basic drills'
                 ],
                 'code' => 'basic_drills',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Incorporación'
                 ],
                 'en' => [
                     'name' => 'Get up'
                 ],
                 'code' => 'get_up',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Blocaje sin caida'
                 ],
                 'en' => [
                     'name' => 'Block without fall'
                 ],
                 'code' => 'block_without_fall',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],      
             [
                 'es' => [
                     'name' => 'Blocaje con caida / Estirada'
                 ],
                 'en' => [
                     'name' => 'Block with fall / Dive'
                 ],
                 'code' => 'block_fall_dive',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Blocaje aére'
                 ],
                 'en' => [
                     'name' => 'Aereal_block'
                 ],
                 'code' => 'aereal_block',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Desvío de balón'
                 ],
                 'en' => [
                     'name' => 'Ball deflection'
                 ],
                 'code' => 'ball_deflection',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Prolongación de balón'
                 ],
                 'en' => [
                     'name' => 'Ball extension'
                 ],
                 'code' => 'ball_extension',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Rechace de balón'
                 ],
                 'en' => [
                     'name' => 'Ball rejection'
                 ],
                 'code' => 'ball_rejection',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Saque de portería'
                 ],
                 'en' => [
                     'name' => 'Goal kick'
                 ],
                 'code' => 'goal_kick',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Juego con el pie'
                 ],
                 'en' => [
                     'name' => 'Foot play'
                 ],
                 'code' => 'foot_play',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Parada penalti'
                 ],
                 'en' => [
                     'name' => 'Penalty save'
                 ],
                 'code' => 'penalty_save',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Parada tiro libre'
                 ],
                 'en' => [
                     'name' => 'Free kick save'
                 ],
                 'code' => 'free_kick_save',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Estrategia ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive strategy'
                 ],
                 'code' => 'offensive_strategy',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque organizado'
                 ],
                 'en' => [
                     'name' => 'Organized attack'
                 ],
                 'code' => 'organized_attack',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Contraataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack'
                 ],
                 'code' => 'counter_attack',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque directo'
                 ],
                 'en' => [
                     'name' => 'Direct attack'
                 ],
                 'code' => 'direct_attack',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque combinativo'
                 ],
                 'en' => [
                     'name' => 'Combination attack'
                 ],
                 'code' => 'combination_attack',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical superiority'
                 ],
                 'code' => 'attack_numerical_superiority',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical inferiority'
                 ],
                 'code' => 'attack_numerical_inferiority',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical equality'
                 ],
                 'code' => 'attack_numerical_equality',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-5-4-1'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-5-4-1'
                 ],
                 'code' => 'offensive_system_1541',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-5-3-2'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-5-3-2'
                 ],
                 'code' => 'offensive_system_1532',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-5-2-3'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-5-2-3'
                 ],
                 'code' => 'offensive_system_1523',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4-4-2'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-4-4-2'
                 ],
                 'code' => 'offensive_system_1442',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4-4-1-1'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-4-4-1-1'
                 ],
                 'code' => 'offensive_system_14411',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4-1-4-1'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-4-1-4-1'
                 ],
                 'code' => 'offensive_system_14141',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4-3-2-1'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-4-3-2-1'
                 ],
                 'code' => 'offensive_system_14321',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4-2-3-1'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-4-2-3-1'
                 ],
                 'code' => 'offensive_system_8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4-3-3'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-4-3-3'
                 ],
                 'code' => 'offensive_system_1433',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4-5-1'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-4-5-1'
                 ],
                 'code' => 'offensive_system_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4-2-4'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-4-2-4'
                 ],
                 'code' => 'offensive_system_1424',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-3-5-2'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-3-5-2'
                 ],
                 'code' => 'offensive_system_1352',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-3-4-3'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-3-4-3'
                 ],
                 'code' => 'offensive_system_1343',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Circulación de balón'
                 ],
                 'en' => [
                     'name' => 'Ball circulation'
                 ],
                 'code' => 'ball_circulation',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Movimientos ofensivos sin balón'
                 ],
                 'en' => [
                     'name' => 'Offensive off ball movements'
                 ],
                 'code' => 'offensive_off_ball_movements',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Permuta ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive switching'
                 ],
                 'code' => 'offensive_switching',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Finalización'
                 ],
                 'en' => [
                     'name' => 'Finishing'
                 ],
                 'code' => 'finishing',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Pared (Pase y va)'
                 ],
                 'en' => [
                     'name' => 'Give and go (1-2 pass)'
                 ],
                 'code' => 'finishing',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Desdoblamiento'
                 ],
                 'en' => [
                     'name' => 'Overlap'
                 ],
                 'code' => 'overlap',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Desmarque'
                 ],
                 'en' => [
                     'name' => 'Uncheck'
                 ],
                 'code' => 'uncheck',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Fijación'
                 ],
                 'en' => [
                     'name' => 'Fixing'
                 ],
                 'code' => 'uncheck',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Apoyo ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive supporting play'
                 ],
                 'code' => 'offensive_supporting_play_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Entrelíneas'
                 ],
                 'en' => [
                     'name' => 'Between the lines'
                 ],
                 'code' => 'between_the_lines',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Líneas de pase'
                 ],
                 'en' => [
                     'name' => 'Passing lanes'
                 ],
                 'code' => 'passing_lanes',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],          
             [
                 'es' => [
                     'name' => 'Bloqueo'
                 ],
                 'en' => [
                     'name' => 'Blocking'
                 ],
                 'code' => 'blocking',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],  
             [
                 'es' => [
                     'name' => 'Apertura (inicio ataque)'
                 ],
                 'en' => [
                     'name' => 'Opening (Start of attack)'
                 ],
                 'code' => 'opening',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],  
             [
                 'es' => [
                     'name' => 'Salida de presión'
                 ],
                 'en' => [
                     'name' => 'Playing out of Pressure'
                 ],
                 'code' => 'playing_out_of_pressure',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Flotación ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive flotation'
                 ],
                 'code' => 'offensive_flotation',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Cambio de orientación'
                 ],
                 'en' => [
                     'name' => 'Switch play'
                 ],
                 'code' => 'switch_play_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Finalización'
                 ],
                 'en' => [
                     'name' => 'Finishing'
                 ],
                 'code' => 'finishing_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Espacios libres'
                 ],
                 'en' => [
                     'name' => 'Free spaces'
                 ],
                 'code' => 'free_spaces_1',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Profundidad ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive Depth'
                 ],
                 'code' => 'offensive_depth',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Balón parado'
                 ],
                 'en' => [
                     'name' => 'Set pieces'
                 ],
                 'code' => 'set_pieces',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Situación de fuera de juego'
                 ],
                 'en' => [
                     'name' => 'Offside situation'
                 ],
                 'code' => 'offside_situation',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Salida de balón'
                 ],
                 'en' => [
                     'name' => 'Uncheck'
                 ],
                 'code' => 'set_pieces',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],    
             [
                 'es' => [
                     'name' => 'Superar línea de presión'
                 ],
                 'en' => [
                     'name' => 'Overcome pressure line'
                 ],
                 'code' => 'overcome_pressure_line',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Segunda jugada'
                 ],
                 'en' => [
                     'name' => 'Second play'
                 ],
                 'code' => 'second_play',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Jugar con tercer hombre'
                 ],
                 'en' => [
                     'name' => 'Third man combination play'
                 ],
                 'code' => 'third_man_combination_play',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Penetración'
                 ],
                 'en' => [
                     'name' => 'Penetration'
                 ],
                 'code' => 'Penetration',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Control del partido'
                 ],
                 'en' => [
                     'name' => 'Match control'
                 ],
                 'code' => 'match_control',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Posesión del balón'
                 ],
                 'en' => [
                     'name' => 'Ball possession'
                 ],
                 'code' => 'ball_possession',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Mobilidad'
                 ],
                 'en' => [
                     'name' => 'Mobility'
                 ],
                 'code' => 'mobility',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Cambio de sistema ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive system switching'
                 ],
                 'code' => 'offensive_system_switching',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Espacios libres'
                 ],
                 'en' => [
                     'name' => 'Free spaces'
                 ],
                 'code' => 'free_spaces_3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Organización según toques'
                 ],
                 'en' => [
                     'name' => 'Organization based on touches'
                 ],
                 'code' => 'organization_based_on_touches',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Jugar a 1 toque'
                 ],
                 'en' => [
                     'name' => 'Play 1 touch'
                 ],
                 'code' => 'play_1_touch',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Jugar a 2 toque'
                 ],
                 'en' => [
                     'name' => 'Play 2 touch'
                 ],
                 'code' => 'play_2_touch',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Jugar a 1-2 toque'
                 ],
                 'en' => [
                     'name' => 'Play 1-2 touch'
                 ],
                 'code' => 'play_1_2_touch',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Estrategia defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive strategy'
                 ],
                 'code' => 'defensive_strategy',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa individual'
                 ],
                 'en' => [
                     'name' => 'Individual defense'
                 ],
                 'code' => 'individual_defense',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en zona'
                 ],
                 'en' => [
                     'name' => 'Zone defense'
                 ],
                 'code' => 'zone_defense',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa mixta'
                 ],
                 'en' => [
                     'name' => 'Mixed defense'
                 ],
                 'code' => 'mixed_defense',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cubrir espacios'
                 ],
                 'en' => [
                     'name' => 'Covering spaces'
                 ],
                 'code' => 'covering_spaces',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical superiority'
                 ],
                 'code' => 'defense_numerical_superiority',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical inferiority'
                 ],
                 'code' => 'defense_numerical_inferiority',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Ataque en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical equality'
                 ],
                 'code' => 'defense_numerical_equality',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-5-4-1'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-5-4-1'
                 ],
                 'code' => 'defensive_system_1',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-5-3-2'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-5-3-2'
                 ],
                 'code' => 'defensive_system_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-5-2-3'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-5-2-3'
                 ],
                 'code' => 'defensive_system_3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-4-4-2'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-4-4-2'
                 ],
                 'code' => 'defensive_system_4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-4-4-1-1'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-4-4-1-1'
                 ],
                 'code' => 'defensive_system_5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-4-1-4-1'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-4-1-4-1'
                 ],
                 'code' => 'defensive_system_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-4-3-2-1'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-4-3-2-1'
                 ],
                 'code' => 'defensive_system_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-4-2-3-1'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-4-2-3-1'
                 ],
                 'code' => 'defensive_system_8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-4-3-3'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-4-3-3'
                 ],
                 'code' => 'defensive_system_9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema Defensivo 1-4-5-1'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-4-5-1'
                 ],
                 'code' => 'defensive_system_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema Defensivo 1-4-2-4'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-4-2-4'
                 ],
                 'code' => 'defensive_system_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema Defensivo 1-3-5-2'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-3-5-2'
                 ],
                 'code' => 'defensive_system_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema Defensivo 1-3-4-3'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-3-4-3'
                 ],
                 'code' => 'defensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Posicionamiento defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive positioning'
                 ],
                 'code' => 'defensive_positioning',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Línea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line'
                 ],
                 'code' => 'defensive_line',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa contrataque'
                 ],
                 'en' => [
                     'name' => 'Counter-attack defense'
                 ],
                 'code' => 'counter_attack_defense',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
              
             [
                 'es' => [
                     'name' => 'Temporización defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive temporization'
                 ],
                 'code' => 'defensive_temporization',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ], 
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ], 
             [
                 'es' => [
                     'name' => 'Interceptación'
                 ],
                 'en' => [
                     'name' => 'Interception'
                 ],
                 'code' => 'interception',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ], 
             [
                 'es' => [
                     'name' => 'Ayuda defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive support'
                 ],
                 'code' => 'defensive_support',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],              
             [
                 'es' => [
                     'name' => 'Presión (Pressing)'
                 ],
                 'en' => [
                     'name' => 'Pressure (Pressing)'
                 ],
                 'code' => 'pressure',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ], 
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Covering'
                 ],
                 'code' => 'covering',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ], 
             [
                 'es' => [
                     'name' => 'Orientación respecto al contrario'
                 ],
                 'en' => [
                     'name' => 'Opposite orientation'
                 ],
                 'code' => 'opposite_orientation',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],          
             [
                 'es' => [
                     'name' => 'Marcaje'
                 ],
                 'en' => [
                     'name' => 'Marking'
                 ],
                 'code' => 'marking',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],  
             [
                 'es' => [
                     'name' => 'Basculación'
                 ],
                 'en' => [
                     'name' => 'Tilt shift'
                 ],
                 'code' => 'tilt_shift',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],  
             [
                 'es' => [
                     'name' => 'Profundidad defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive Depth'
                 ],
                 'code' => 'defensive_depth',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ], 
             [
                 'es' => [
                     'name' => 'Intensidad defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive intensity'
                 ],
                 'code' => 'defensive_intensity',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ], 
             [
                 'es' => [
                     'name' => 'Defensa balón parado'
                 ],
                 'en' => [
                     'name' => 'Set pieces defense'
                 ],
                 'code' => 'set_pieces_defense',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Pérdida de balón y recuperación'
                 ],
                 'en' => [
                     'name' => 'Turnover and recovery'
                 ],
                 'code' => 'turnover_and_recovery',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa fuera de juego'
                 ],
                 'en' => [
                     'name' => 'Offside defense'
                 ],
                 'code' => 'offside_defense',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Vigilancia defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive vigilance'
                 ],
                 'code' => 'defensive_vigilance',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Repliegue'
                 ],
                 'en' => [
                     'name' => 'Retreat'
                 ],
                 'code' => 'retreat',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa centros'
                 ],
                 'en' => [
                     'name' => 'Crosses defense'
                 ],
                 'code' => 'crosses_defense',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => ' Cerrar líneas de pase'
                 ],
                 'en' => [
                     'name' => 'Cover passing lanes'
                 ],
                 'code' => 'cover_passing_lanes',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],    
             [
                 'es' => [
                     'name' => 'Cerrar líneas de tiro'
                 ],
                 'en' => [
                     'name' => 'Cover shooting lanes'
                 ],
                 'code' => 'cover_shooting_lanes',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cambio de sistema defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive system switching'
                 ],
                 'code' => 'defensive_system_switching',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Equilibrio linea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line balance'
                 ],
                 'code' => 'defensive_line_balance',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Coverage'
                 ],
                 'code' => 'coverage',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],
             [
                 'es' => [
                     'name' => 'Enfrentamiento 1v1'
                 ],
                 'en' => [
                     'name' => 'Breakaway defense (1v1)'
                 ],
                 'code' => 'breakaway_defense',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],
             [
                 'es' => [
                     'name' => 'Posicionamiento'
                 ],
                 'en' => [
                     'name' => 'Positioning'
                 ],
                 'code' => 'Positioning',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ]
 
         ];
     }
     private function targetsIndoorSoccer()
     {
         return [
             [
                 'es' => [
                     'name' => 'Desplazamientos ofensivos'
                 ],
                 'en' => [
                     'name' => 'Offensive displacements'
                 ],
                 'code' => 'offensive_displacements2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Conducción de balón'
                 ],
                 'en' => [
                     'name' => 'Ball driving'
                 ],
                 'code' => 'ball_driving2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Finta'
                 ],
                 'en' => [
                     'name' => 'Feint'
                 ],
                 'code' => 'feint2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Protección de balón'
                 ],
                 'en' => [
                     'name' => 'Shielding the ball'
                 ],
                 'code' => 'shielding_ball2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Pase'
                 ],
                 'en' => [
                     'name' => 'pass'
                 ],
                 'code' => 'Pass2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Control del balón'
                 ],
                 'en' => [
                     'name' => 'Ball control'
                 ],
                 'code' => 'ball_control2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ], 
             [
                 'es' => [
                     'name' => 'Volea'
                 ],
                 'en' => [
                     'name' => 'Volley'
                 ],
                 'code' => 'volley2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Tiro'
                 ],
                 'en' => [
                     'name' => 'Shot'
                 ],
                 'code' => 'shot2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => ' Remate de cabeza'
                 ],
                 'en' => [
                     'name' => 'Head kick'
                 ],
                 'code' => 'head_kick2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],    
             [
                 'es' => [
                     'name' => 'Remate de chilena'
                 ],
                 'en' => [
                     'name' => 'Overhead kick'
                 ],
                 'code' => 'overhead_kick2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Tiro libre'
                 ],
                 'en' => [
                     'name' => 'Free kick'
                 ],
                 'code' => 'free_kick2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Penalti'
                 ],
                 'en' => [
                     'name' => 'Penalty kick'
                 ],
                 'code' => 'penalty_kick2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ], 
             [
                 'es' => [
                     'name' => 'Doble penalti'
                 ],
                 'en' => [
                     'name' => 'Double penalty'
                 ],
                 'code' => 'double_penalty2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Saque de esquina'
                 ],
                 'en' => [
                     'name' => 'Corner kick'
                 ],
                 'code' => 'corner_kick2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Saque de banda'
                 ],
                 'en' => [
                     'name' => 'Throw-in'
                 ],
                 'code' => 'throw_in2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Regate'
                 ],
                 'en' => [
                     'name' => 'Dribbling'
                 ],
                 'code' => 'dribbling2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Posición básica defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive stance'
                 ],
                 'code' => 'defensive_stance2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Desplazamientos defensivos'
                 ],
                 'en' => [
                     'name' => 'Defensive displacements'
                 ],
                 'code' => 'defensive_displacements2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ], 
             [
                 'es' => [
                     'name' => 'Robo de balón'
                 ],
                 'en' => [
                     'name' => 'Steal the ball'
                 ],
                 'code' => 'steal_ball2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ], 
 
             [
                 'es' => [
                     'name' => 'Entrada'
                 ],
                 'en' => [
                     'name' => 'Tackling'
                 ],
                 'code' => 'tackling2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ], 
             [
                 'es' => [
                     'name' => 'Despeje'
                 ],
                 'en' => [
                     'name' => 'Clearance'
                 ],
                 'code' => 'clearance2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ], 
             [
                 'es' => [
                     'name' => 'Posiciones básicas'
                 ],
                 'en' => [
                     'name' => 'Basic stances'
                 ],
                 'code' => 'basic_stances2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Movimientos básicos'
                 ],
                 'en' => [
                     'name' => 'Basic drills'
                 ],
                 'code' => 'basic_drills2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Incorporación'
                 ],
                 'en' => [
                     'name' => 'Get up'
                 ],
                 'code' => 'get_up2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Blocaje sin caida'
                 ],
                 'en' => [
                     'name' => 'Block without fall'
                 ],
                 'code' => 'block_without_fall2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],      
             [
                 'es' => [
                     'name' => 'Blocaje con caida / Estirada'
                 ],
                 'en' => [
                     'name' => 'Block with fall / Dive'
                 ],
                 'code' => 'block_fall_dive2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Parada con los pies'
                 ],
                 'en' => [
                     'name' => 'Foot save'
                 ],
                 'code' => 'foot_save2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Desvío de balón'
                 ],
                 'en' => [
                     'name' => 'Ball deflection'
                 ],
                 'code' => 'ball_deflection2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Despeje de balón'
                 ],
                 'en' => [
                     'name' => 'Ball clearance / Ball punching'
                 ],
                 'code' => 'ball_clearance2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Rechace de balón'
                 ],
                 'en' => [
                     'name' => 'Ball rejection'
                 ],
                 'code' => 'ball_rejection2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Saque de portería'
                 ],
                 'en' => [
                     'name' => 'Goal kick'
                 ],
                 'code' => 'goal_kick2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Juego con el pie'
                 ],
                 'en' => [
                     'name' => 'Foot play'
                 ],
                 'code' => 'foot_play2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Parada penalti'
                 ],
                 'en' => [
                     'name' => 'Penalty save'
                 ],
                 'code' => 'penalty_save2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Parada doble penalti'
                 ],
                 'en' => [
                     'name' => 'Double penalty save'
                 ],
                 'code' => 'double_penalty_save2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Parada tiro libre'
                 ],
                 'en' => [
                     'name' => 'Free kick save'
                 ],
                 'code' => 'free_kick_save2',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Estrategia ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive strategy'
                 ],
                 'code' => 'offensive_strategy2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque organizado'
                 ],
                 'en' => [
                     'name' => 'Organized attack'
                 ],
                 'code' => 'organized_attack2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Contraataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack'
                 ],
                 'code' => 'counter_attack2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical superiority'
                 ],
                 'code' => 'direAttack_numerical_superiorityct2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical inferiority'
                 ],
                 'code' => 'direAttack_numerical_inferiority2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
              [
                 'es' => [
                     'name' => 'Ataque en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical equality'
                 ],
                 'code' => 'direAttack_numerical_equality2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Situación especial de ataque (Portero-jugador)'
                 ],
                 'en' => [
                     'name' => 'Special Attacking situattion (Power play)'
                 ],
                 'code' => 'special_attacking_situattion2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],             
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-1-2-1 (Rombo)'
                 ],
                 'en' => [
                     'name' => '1-1-2-1 Ofensive system (Rhombus)'
                 ],
                 'code' => '1121_ofensive_rhombus_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-2-2 (Cuadrado)'
                 ],
                 'en' => [
                     'name' => '1-2-2 Ofensive system (Square)'
                 ],
                 'code' => '122_offensive_square_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-1-3 (Triángulo ofensivo)'
                 ],
                 'en' => [
                     'name' => '1-1-3 Ofensive system (Offensive triangle)'
                 ],
                 'code' => '113_offensive_triangle_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-3-1 (Triángulo defensivo)'
                 ],
                 'en' => [
                     'name' => '1-3-1 Ofensive system (Defensive triangle)'
                 ],
                 'code' => '131_offensive_triangle_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-1-1-2 (Embudo / Y)'
                 ],
                 'en' => [
                     'name' => '1-1-1-2 Ofensive system (Funnel / Y)'
                 ],
                 'code' => '1112_offensive_funnel_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-2-1-1 (Embudo invertido)'
                 ],
                 'en' => [
                     'name' => '1-2-1-1 Ofensive system (Inverted funnel)'
                 ],
                 'code' => '1211_offensive_funnel_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4 (Cuatro en línea)'
                 ],
                 'en' => [
                     'name' => '1-4 Offensive system (Four in a row)'
                 ],
                 'code' => '14_offensive_four_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa zonal'
                 ],
                 'en' => [
                     'name' => 'Attack against zone defense'
                 ],
                 'code' => 'attack_against_zone_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa individual'
                 ],
                 'en' => [
                     'name' => 'Attack against individual defense'
                 ],
                 'code' => 'attack_against_individual_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa mixta'
                 ],
                 'en' => [
                     'name' => 'Attack against mixed defense'
                 ],
                 'code' => 'attack_against_mixed_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa presionante'
                 ],
                 'en' => [
                     'name' => 'Attack against pressure defense'
                 ],
                 'code' => 'attack_against_pressure_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Circulación de balón'
                 ],
                 'en' => [
                     'name' => 'Ball circulation'
                 ],
                 'code' => 'ball_circulation2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => ' Rotaciones de ataque'
                 ],
                 'en' => [
                     'name' => 'Attacking rotations'
                 ],
                 'code' => 'attacking_rotations2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Jugar en pareja (Dualidades)'
                 ],
                 'en' => [
                     'name' => 'Playing in pairs'
                 ],
                 'code' => 'playing_in_pairs2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Triángulo ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive triangle'
                 ],
                 'code' => 'offensive_triangle2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Pared (Pase y va)'
                 ],
                 'en' => [
                     'name' => 'Give and go (1-2 pass)'
                 ],
                 'code' => 'give_and_go2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Movimientos ofensivos sin balón'
                 ],
                 'en' => [
                     'name' => 'Offensive off ball movements'
                 ],
                 'code' => 'offensive_off_ball_movements2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Corte'
                 ],
                 'en' => [
                     'name' => 'Cut'
                 ],
                 'code' => 'cut2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Cruce'
                 ],
                 'en' => [
                     'name' => 'Crossing'
                 ],
                 'code' => 'crossing2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Cortina'
                 ],
                 'en' => [
                     'name' => 'curtain'
                 ],
                 'code' => 'curtain2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Pantalla'
                 ],
                 'en' => [
                     'name' => 'Screen'
                 ],
                 'code' => 'screen2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Desdoblamiento'
                 ],
                 'en' => [
                     'name' => 'Overlap'
                 ],
                 'code' => 'overlap2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Desmarque'
                 ],
                 'en' => [
                     'name' => 'Uncheck'
                 ],
                 'code' => 'uncheck2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],  
             [
                 'es' => [
                     'name' => 'Fijación'
                 ],
                 'en' => [
                     'name' => 'Fixing'
                 ],
                 'code' => 'fixing2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],  
             [
                 'es' => [
                     'name' => 'Pase al pivote'
                 ],
                 'en' => [
                     'name' => 'Passing to pivot'
                 ],
                 'code' => 'passing_to_pivot2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Ataque lado fuerte'
                 ],
                 'en' => [
                     'name' => 'Strong side attack'
                 ],
                 'code' => 'strong_side_attack2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Ataque lado débil'
                 ],
                 'en' => [
                     'name' => 'Weak side attack'
                 ],
                 'code' => 'weak_side_attack2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Permuta ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive switching'
                 ],
                 'code' => 'offensive_switching2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Temporización ofensiva'
                 ],
                 'en' => [
                     'name' => 'Ofensive temporization'
                 ],
                 'code' => 'ofensive_temporization2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Vigilancia ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive vigilance'
                 ],
                 'code' => 'offensive_vigilance2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Apoyo ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive supporting play'
                 ],
                 'code' => 'offensive_supporting_play2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Situación de fuera de juego'
                 ],
                 'en' => [
                     'name' => 'Offside situation'
                 ],
                 'code' => 'offside_situation2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Salida de balón'
                 ],
                 'en' => [
                     'name' => 'Uncheck'
                 ],
                 'code' => 'set_pieces2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],    
             [
                 'es' => [
                     'name' => 'Superar línea de presión'
                 ],
                 'en' => [
                     'name' => 'Overcome pressure line'
                 ],
                 'code' => 'overcome_pressure_line2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Segunda jugada'
                 ],
                 'en' => [
                     'name' => 'Second play'
                 ],
                 'code' => 'second_play2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Jugar con tercer hombre'
                 ],
                 'en' => [
                     'name' => 'Third man combination play'
                 ],
                 'code' => 'third_man_combination_play2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Penetración'
                 ],
                 'en' => [
                     'name' => 'Penetration'
                 ],
                 'code' => 'Penetration2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Control del partido'
                 ],
                 'en' => [
                     'name' => 'Match control'
                 ],
                 'code' => 'match_control2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Posesión del balón'
                 ],
                 'en' => [
                     'name' => 'Ball possession'
                 ],
                 'code' => 'ball_possession2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Mobilidad'
                 ],
                 'en' => [
                     'name' => 'Mobility'
                 ],
                 'code' => 'mobility2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Cambio de sistema ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive system switching'
                 ],
                 'code' => 'offensive_system_switching2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Espacios libres'
                 ],
                 'en' => [
                     'name' => 'Free spaces'
                 ],
                 'code' => 'free_spaces2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Amplitud'
                 ],
                 'en' => [
                     'name' => 'Wide play'
                 ],
                 'code' => 'wide_play2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ], 
             [
                 'es' => [
                     'name' => 'Profundidad ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive depth'
                 ],
                 'code' => 'offensive_depth2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Jugadas a balón parado'
                 ],
                 'en' => [
                     'name' => 'Set pieces'
                 ],
                 'code' => 'set_pieces2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ritmo de juego'
                 ],
                 'en' => [
                     'name' => 'Pace of play'
                 ],
                 'code' => 'pace_of_play2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Cambio de sistema ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive system switching'
                 ],
                 'code' => 'offensive_system_switching2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],            
             [
                 'es' => [
                     'name' => 'Transición ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive transition'
                 ],
                 'code' => 'offensive_transition2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],            
             [
                 'es' => [
                     'name' => 'Organización según toques'
                 ],
                 'en' => [
                     'name' => 'Organization based on touches'
                 ],
                 'code' => 'organization_based_touches2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],            
             [
                 'es' => [
                     'name' => 'Jugar a 1 toque'
                 ],
                 'en' => [
                     'name' => 'Play 1 touch'
                 ],
                 'code' => 'play_1_touch2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],            
             [
                 'es' => [
                     'name' => 'Jugar a 2 toque'
                 ],
                 'en' => [
                     'name' => 'Play 2 touches'
                 ],
                 'code' => 'play_2_touch2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Jugar a 1-2 toques'
                 ],
                 'en' => [
                     'name' => 'Play 1-2 touches'
                 ],
                 'code' => 'play_12_touch2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Estrategia defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive strategy'
                 ],
                 'code' => 'defensive_strategy2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa individual'
                 ],
                 'en' => [
                     'name' => 'Individual defense'
                 ],
                 'code' => 'individual_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en zona'
                 ],
                 'en' => [
                     'name' => 'Zone defense'
                 ],
                 'code' => 'zone_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa mixta'
                 ],
                 'en' => [
                     'name' => 'Mixed defense'
                 ],
                 'code' => 'mixed_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa cambiante'
                 ],
                 'en' => [
                     'name' => 'Switching defense2'
                 ],
                 'code' => 'switching_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical superiority'
                 ],
                 'code' => 'defense_numerical_superiority2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical inferiority'
                 ],
                 'code' => 'defense_numerical_inferiority2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Ataque en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical equality_3'
                 ],
                 'code' => 'defense_numerical_equality2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa portero-jugador (6v5)'
                 ],
                 'en' => [
                     'name' => 'Power play (6v5) defense'
                 ],
                 'code' => 'power_play_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-1-2-1 (Rombo)'
                 ],
                 'en' => [
                     'name' => '1-1-2-1 Defensive system (Rhombus)'
                 ],
                 'code' => '1121_defensive_system_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-2-2 (Cuadrado)'
                 ],
                 'en' => [
                     'name' => '1-2-2 Defensive system (Square)'
                 ],
                 'code' => '122_defensive_system_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-1-3 (Triángulo ofensivo)'
                 ],
                 'en' => [
                     'name' => '1-1-3 Defensive system (Offensive triangle)'
                 ],
                 'code' => '113_defensive_system_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-1-3 (Triángulo defensivo)'
                 ],
                 'en' => [
                     'name' => '1-1-3 Defensive system (Defensive triangle)'
                 ],
                 'code' => '113_defensive_system_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-1-1-2 (Embudo / Y)'
                 ],
                 'en' => [
                     'name' => '1-1-1-2 Defensive system (Funnel / Y)'
                 ],
                 'code' => '1112_defensive_system_2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Posicionamiento defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive positioning'
                 ],
                 'code' => 'defensive_positioning2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Línea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line'
                 ],
                 'code' => 'defensive_line2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa contrataque'
                 ],
                 'en' => [
                     'name' => 'Counter-attack defense'
                 ],
                 'code' => 'counter_attack_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa pivote'
                 ],
                 'en' => [
                     'name' => 'Pivot defense'
                 ],
                 'code' => 'pivot_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Rotaciones defensivas'
                 ],
                 'en' => [
                     'name' => 'Defensive rotations'
                 ],
                 'code' => 'defensive_rotations2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Triángulo defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive triangle'
                 ],
                 'code' => 'defensive_triangle2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Temporización defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive temporization'
                 ],
                 'code' => 'defensive_temporization2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Vigilancia defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive vigilance'
                 ],
                 'code' => 'defensive_vigilance2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Ayuda defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive support'
                 ],
                 'code' => 'defensive_support2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Recuperación de balón'
                 ],
                 'en' => [
                     'name' => 'Ball recovery'
                 ],
                 'code' => 'ball_recovery2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Interceptación'
                 ],
                 'en' => [
                     'name' => 'Interception'
                 ],
                 'code' => 'interception2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cambio de oponente'
                 ],
                 'en' => [
                     'name' => 'Opponent change'
                 ],
                 'code' => 'opponent_change2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Presión (Pressing)'
                 ],
                 'en' => [
                     'name' => 'Pressure (Pressing)'
                 ],
                 'code' => 'pressure2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Covering'
                 ],
                 'code' => 'covering2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Orientación respecto al contrario'
                 ],
                 'en' => [
                     'name' => 'Opposite orientation'
                 ],
                 'code' => 'opposite_orientation2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Marcaje'
                 ],
                 'en' => [
                     'name' => 'Marking'
                 ],
                 'code' => 'marking2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Par defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive pair'
                 ],
                 'code' => 'defensive_pair2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Permuta defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive switching (change of position)'
                 ],
                 'code' => 'defensive_switching2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Flotación defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive flotation'
                 ],
                 'code' => 'defensive_flotation2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Deslizamiento'
                 ],
                 'en' => [
                     'name' => 'Sliding'
                 ],
                 'code' => 'sliding2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Basculación'
                 ],
                 'en' => [
                     'name' => 'Tilt shift'
                 ],
                 'code' => 'tilt_shift2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],  
             [
                 'es' => [
                     'name' => 'Profundidad defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive Depth'
                 ],
                 'code' => 'defensive_depth2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ], 
             [
                 'es' => [
                     'name' => 'Intensidad defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive intensity'
                 ],
                 'code' => 'defensive_intensity2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ], 
             [
                 'es' => [
                     'name' => 'Pérdida de balón y recuperación'
                 ],
                 'en' => [
                     'name' => 'Turnover and recovery'
                 ],
                 'code' => 'turnover_and_recovery2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa jugadas a balón parado'
                 ],
                 'en' => [
                     'name' => 'Set pieces defense'
                 ],
                 'code' => 'set_pieces_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => ' Cerrar líneas de pase'
                 ],
                 'en' => [
                     'name' => 'Cover passing lanes'
                 ],
                 'code' => 'cover_passing_lanes2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],    
             [
                 'es' => [
                     'name' => 'Cerrar líneas de tiro'
                 ],
                 'en' => [
                     'name' => 'Cover shooting lanes'
                 ],
                 'code' => 'cover_shooting_lanes2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cambio de sistema defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive system switching'
                 ],
                 'code' => 'defensive_system_switching2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cubrir espacios'
                 ],
                 'en' => [
                     'name' => 'Covering spaces'
                 ],
                 'code' => 'covering_spaces2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa lado débil'
                 ],
                 'en' => [
                     'name' => 'Weak side defense'
                 ],
                 'code' => 'weak_side_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa lado fuerte'
                 ],
                 'en' => [
                     'name' => 'Strong side defense'
                 ],
                 'code' => 'strong_side_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Transición defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive transition'
                 ],
                 'code' => 'defensive_transition2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Equilibrio linea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line balance'
                 ],
                 'code' => 'defensive_line_balance2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Coverage'
                 ],
                 'code' => 'coverage2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],
             [
                 'es' => [
                     'name' => 'Enfrentamiento 1v1'
                 ],
                 'en' => [
                     'name' => 'Breakaway defense (1v1)'
                 ],
                 'code' => 'breakaway_defense2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],
             [
                 'es' => [
                     'name' => 'Posicionamiento'
                 ],
                 'en' => [
                     'name' => 'Positioning'
                 ],
                 'code' => 'Positioning2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
            ],
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing2',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],
 
         ];
     }
     private function targetsHandBall()
     {
         return [
             [
                 'es' => [
                     'name' => 'Trabajo de pies en ataque'
                 ],
                 'en' => [
                     'name' => 'Attacking footwork'
                 ],
                 'code' => 'attacking_footwork3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Desplazamientos ofensivos'
                 ],
                 'en' => [
                     'name' => 'Offensive displacements'
                 ],
                 'code' => 'offensive_displacements3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Bote y manejo de balón'
                 ],
                 'en' => [
                     'name' => 'Bounce and ball handling'
                 ],
                 'code' => 'bounce_ball_handling3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Finta'
                 ],
                 'en' => [
                     'name' => 'Feint'
                 ],
                 'code' => 'feint3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Pase'
                 ],
                 'en' => [
                     'name' => 'pass'
                 ],
                 'code' => 'Pass3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],  
             [
                 'es' => [
                     'name' => 'Recepción'
                 ],
                 'en' => [
                     'name' => 'Catch'
                 ],
                 'code' => 'catch_3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ], 
             [
                 'es' => [
                     'name' => 'Tiro'
                 ],
                 'en' => [
                     'name' => 'Shot'
                 ],
                 'code' => 'shot3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Tiro en apoyo'
                 ],
                 'en' => [
                     'name' => 'Standing shot'
                 ],
                 'code' => 'standing_shot3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Tiro en salto'
                 ],
                 'en' => [
                     'name' => 'Jump shot'
                 ],
                 'code' => 'jump_shot3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => '6 metros'
                 ],
                 'en' => [
                     'name' => '6 meters'
                 ],
                 'code' => '6_meters3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],    
             [
                 'es' => [
                     'name' => '7 metros (Penalty)'
                 ],
                 'en' => [
                     'name' => '7 meters (Penalty)'
                 ],
                 'code' => '7_meters_penalty3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => '9 metros (Golpe franco)'
                 ],
                 'en' => [
                     'name' => '9 meters (Free throw)'
                 ],
                 'code' => '9_meters_free3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Posición básica defensiva'
                 ],
                 'en' => [
                     'name' => 'Basic defensive stance'
                 ],
                 'code' => 'defensive_stance3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Trabajo de pies defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive footwork'
                 ],
                 'code' => 'defensive_footwork3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Desplazamientos defensivos'
                 ],
                 'en' => [
                     'name' => 'Defensive displacements'
                 ],
                 'code' => 'defensive_displacements3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Robo de balón (Desposesión)'
                 ],
                 'en' => [
                     'name' => 'Steal the ball (Dispossession)'
                 ],
                 'code' => 'steal_the_ball3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Blocaje de tiro'
                 ],
                 'en' => [
                     'name' => 'Blocking shot'
                 ],
                 'code' => 'blocking_shot3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Control del oponente '
                 ],
                 'en' => [
                     'name' => 'Opponent control'
                 ],
                 'code' => 'opponent_control3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Posiciones básicas'
                 ],
                 'en' => [
                     'name' => 'Basic stances'
                 ],
                 'code' => 'basic_stances3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Movimientos básicos'
                 ],
                 'en' => [
                     'name' => 'Basic drills'
                 ],
                 'code' => 'basic_drills3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Incorporación'
                 ],
                 'en' => [
                     'name' => 'Get up'
                 ],
                 'code' => 'get_up3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Parada con la mano'
                 ],
                 'en' => [
                     'name' => 'Hand save'
                 ],
                 'code' => 'hand_save3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Parada con la pierna'
                 ],
                 'en' => [
                     'name' => 'Leg save'
                 ],
                 'code' => 'leg_save3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Parada pie-mano'
                 ],
                 'en' => [
                     'name' => 'Hand-leg saves'
                 ],
                 'code' => 'hand_leg_saves3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Parada en alto'
                 ],
                 'en' => [
                     'name' => 'Jump save'
                 ],
                 'code' => 'jump_save3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Desvío de balón'
                 ],
                 'en' => [
                     'name' => 'Ball deflection'
                 ],
                 'code' => 'ball_deflection3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Rechace de balón'
                 ],
                 'en' => [
                     'name' => 'Ball rejection'
                 ],
                 'code' => 'ball_rejection3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Parada penalti'
                 ],
                 'en' => [
                     'name' => 'Penalty save'
                 ],
                 'code' => 'penalty_save3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Saque de portería'
                 ],
                 'en' => [
                     'name' => 'Goal kick'
                 ],
                 'code' => 'goal_kick3',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],
             [
                 'es' => [
                     'name' => 'Estrategia ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive strategy'
                 ],
                 'code' => 'offensive_strategy3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical superiority'
                 ],
                 'code' => 'direAttack_numerical_superiorityct3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical inferiority'
                 ],
                 'code' => 'direAttack_numerical_inferiority3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical equality'
                 ],
                 'code' => 'direAttack_numerical_equality3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque organizado'
                 ],
                 'en' => [
                     'name' => 'Organized attack'
                 ],
                 'code' => 'organized_attack3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Contraataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack'
                 ],
                 'code' => 'counter_attack3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Contraataque 1ª oleada'
                 ],
                 'en' => [
                     'name' => 'Fastbreak 1st wave'
                 ],
                 'code' => 'fastbreak_1st_wave3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Contraataque 2ª oleada'
                 ],
                 'en' => [
                     'name' => 'Fastbreak 2nd wave'
                 ],
                 'code' => 'fastbreak_2nd_wave3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Contraataque 3ª oleada'
                 ],
                 'en' => [
                     'name' => 'Fastbreak 3rd wave'
                 ],
                 'code' => 'fastbreak_3rd_wave3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 2-4'
                 ],
                 'en' => [
                     'name' => 'Offensive system 2-4'
                 ],
                 'code' => 'offensive_system_2-4_3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 3-3'
                 ],
                 'en' => [
                     'name' => 'Offensive system 3-3'
                 ],
                 'code' => 'offensive_system_3-3_3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 6-0'
                 ],
                 'en' => [
                     'name' => 'Offensive system 6-0'
                 ],
                 'code' => 'offensive_system_6-0_3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 5-1'
                 ],
                 'en' => [
                     'name' => 'Offensive system 5-1'
                 ],
                 'code' => 'offensive_system_5-1_3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa 6-0'
                 ],
                 'en' => [
                     'name' => 'Attack against 6-0 defense'
                 ],
                 'code' => 'attack_against_6-0_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa 5-1'
                 ],
                 'en' => [
                     'name' => 'Attack against 5-1 defense'
                 ],
                 'code' => 'attack_against_5-1_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa 4-2'
                 ],
                 'en' => [
                     'name' => 'Attack against 4-2 defense'
                 ],
                 'code' => 'attack_against_4-2_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa 3-3'
                 ],
                 'en' => [
                     'name' => 'Attack against 3-3 defense'
                 ],
                 'code' => 'ttack_against_3-3_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa 3-2-1'
                 ],
                 'en' => [
                     'name' => 'Attack against 3-2-1 defense'
                 ],
                 'code' => 'attack_against_3-2-1_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa individual'
                 ],
                 'en' => [
                     'name' => 'Attack against individual defense'
                 ],
                 'code' => 'attack_against_individual_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa mixta'
                 ],
                 'en' => [
                     'name' => 'Attack against combined defense'
                 ],
                 'code' => 'attack_against_combined_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Circulación de balón'
                 ],
                 'en' => [
                     'name' => ' Ball Circulation'
                 ],
                 'code' => ' ball_circulation3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Circulación de jugadores'
                 ],
                 'en' => [
                     'name' => 'Player circulation'
                 ],
                 'code' => 'player_circulation3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Pase y va'
                 ],
                 'en' => [
                     'name' => 'Give and go'
                 ],
                 'code' => 'give_and_go3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Penetraciones sucesivas'
                 ],
                 'en' => [
                     'name' => 'Successive penetrations'
                 ],
                 'code' => 'successive_penetrations3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Cruce'
                 ],
                 'en' => [
                     'name' => 'Crossing'
                 ],
                 'code' => 'crossing3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Cortina'
                 ],
                 'en' => [
                     'name' => 'Curtain'
                 ],
                 'code' => 'curtain3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Pantalla'
                 ],
                 'en' => [
                     'name' => 'Screen'
                 ],
                 'code' => 'screen3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo'
                 ],
                 'en' => [
                     'name' => 'Block'
                 ],
                 'code' => 'block3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Corte'
                 ],
                 'en' => [
                     'name' => 'Cut'
                 ],
                 'code' => 'cut3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Desmarque'
                 ],
                 'en' => [
                     'name' => 'Uncheck'
                 ],
                 'code' => 'uncheck3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Amplitud'
                 ],
                 'en' => [
                     'name' => 'Wide play'
                 ],
                 'code' => 'wide_play3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Profundidad'
                 ],
                 'en' => [
                     'name' => 'Offensive'
                 ],
                 'code' => 'offensive3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Fly'
                 ],
                 'en' => [
                     'name' => 'Fly'
                 ],
                 'code' => 'fly3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Permuta ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive switching'
                 ],
                 'code' => 'offensive_switching3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Espacios libres'
                 ],
                 'en' => [
                     'name' => 'Creating space'
                 ],
                 'code' => 'creating_space3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Fijación'
                 ],
                 'en' => [
                     'name' => 'Fixing'
                 ],
                 'code' => 'f¡ixing3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Líneas de pase'
                 ],
                 'en' => [
                     'name' => 'Passing lanes'
                 ],
                 'code' => 'passing_lanes3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Cambio de sistema ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive system switching'
                 ],
                 'code' => 'offensive_system_switching3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Apoyo ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive supporting play '
                 ],
                 'code' => 'offensive_supporting_play 3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo'
                 ],
                 'en' => [
                     'name' => 'Blocking'
                 ],
                 'code' => 'blocking3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Desdoblamiento'
                 ],
                 'en' => [
                     'name' => 'Overlap'
                 ],
                 'code' => 'overlap3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ritmo de juego'
                 ],
                 'en' => [
                     'name' => 'Pace of play '
                 ],
                 'code' => 'pace_of_play3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque lado fuerte'
                 ],
                 'en' => [
                     'name' => 'Strong side attack'
                 ],
                 'code' => 'strong_side_attack3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque lado débil'
                 ],
                 'en' => [
                     'name' => 'Weak side attack'
                 ],
                 'code' => 'weak_side_attack3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Transición ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive transition'
                 ],
                 'code' => 'offensive_transition3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Estrategia defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive strategy'
                 ],
                 'code' => 'defensive_strategy3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa individual'
                 ],
                 'en' => [
                     'name' => 'Individual defense '
                 ],
                 'code' => 'individual_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en zona'
                 ],
                 'en' => [
                     'name' => 'Zone defense'
                 ],
                 'code' => 'zone_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa mixta'
                 ],
                 'en' => [
                     'name' => 'Mixed defense '
                 ],
                 'code' => 'mixed_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa presionante'
                 ],
                 'en' => [
                     'name' => 'Pressure defense'
                 ],
                 'code' => 'pressure_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical superiority'
                 ],
                 'code' => 'defense-in_numerical-superiority3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical inferiority'
                 ],
                 'code' => 'defense_in_numerical_inferiority3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical equality'
                 ],
                 'code' => 'defense_in_numerical_equality3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 6-0'
                 ],
                 'en' => [
                     'name' => '6-0 Defensive system'
                 ],
                 'code' => '6-0_defensive_system3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 5-1'
                 ],
                 'en' => [
                     'name' => '5-1 Defensive system'
                 ],
                 'code' => '5-1_defensive_system3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 4-2'
                 ],
                 'en' => [
                     'name' => '4-2 Defensive system '
                 ],
                 'code' => '4-2_defensive_system3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 3-3'
                 ],
                 'en' => [
                     'name' => '3-3 Defensive system'
                 ],
                 'code' => '3-3_defensive_system3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sistema defensivo 3-2-1'
                 ],
                 'en' => [
                     'name' => '3-2-1 Defensive system'
                 ],
                 'code' => '3-2-1_defensive_system3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa ante ataque 2-4'
                 ],
                 'en' => [
                     'name' => 'Defense against attack 2-4'
                 ],
                 'code' => 'defense_against_attack_2-4_3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa ante ataque 3-3'
                 ],
                 'en' => [
                     'name' => 'Defense against attack 3-3'
                 ],
                 'code' => 'defense_against_attack_3-3_3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Línea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line'
                 ],
                 'code' => 'defensive_line3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa contrataque'
                 ],
                 'en' => [
                     'name' => 'Counter-attack defense '
                 ],
                 'code' => 'counter-attack_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa pivote'
                 ],
                 'en' => [
                     'name' => 'Pivot defense'
                 ],
                 'code' => 'pivot_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Contrabloqueo'
                 ],
                 'en' => [
                     'name' => 'Unblocking'
                 ],
                 'code' => 'unblocking3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Marcaje'
                 ],
                 'en' => [
                     'name' => 'Marking'
                 ],
                 'code' => 'marking3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Ayuda defensiva'
                 ],
                 'en' => [
                     'name' => 'Help defense'
                 ],
                 'code' => 'help_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Interceptación'
                 ],
                 'en' => [
                     'name' => 'Interception'
                 ],
                 'code' => 'interception3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cambio de oponente'
                 ],
                 'en' => [
                     'name' => 'Opponent change'
                 ],
                 'code' => 'opponent_change3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Covering'
                 ],
                 'code' => 'covering3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Disuación'
                 ],
                 'en' => [
                     'name' => 'Deterrence'
                 ],
                 'code' => 'deterrence3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Acoso'
                 ],
                 'en' => [
                     'name' => 'Pressure on attacker'
                 ],
                 'code' => 'pressure_on_attacker3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa oponente con balón'
                 ],
                 'en' => [
                     'name' => 'Opponent defense with the ball'
                 ],
                 'code' => 'opponent_defense_with_the_ball3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa oponente sin balón'
                 ],
                 'en' => [
                     'name' => 'Opponent defense without the ball'
                 ],
                 'code' => 'opponent_defense_without_the_ball3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa ante pase y va'
                 ],
                 'en' => [
                     'name' => 'Give and go defense'
                 ],
                 'code' => 'give_and_go_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa ante golpe franco'
                 ],
                 'en' => [
                     'name' => 'Free throw defense'
                 ],
                 'code' => 'free_throw_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa ante Fly'
                 ],
                 'en' => [
                     'name' => 'Fly defense'
                 ],
                 'code' => 'fly_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Basculación'
                 ],
                 'en' => [
                     'name' => 'Tilt shift'
                 ],
                 'code' => 'tilt_shift3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Intensidad defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive intensity'
                 ],
                 'code' => 'defensive_intensity3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cambio de sistema defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive system switching'
                 ],
                 'code' => 'defensive_system_switching3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Flotación Defensive'
                 ],
                 'en' => [
                     'name' => 'System switching'
                 ],
                 'code' => 'system_switching3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Permuta defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive switching'
                 ],
                 'code' => 'defensive_switching3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Deslizamiento'
                 ],
                 'en' => [
                     'name' => 'Sliding'
                 ],
                 'code' => 'sliding3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Ataque al impar'
                 ],
                 'en' => [
                     'name' => 'Odd attack'
                 ],
                 'code' => 'odd_attack3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Colaboración defensa-portero'
                 ],
                 'en' => [
                     'name' => 'Defense-goalkeeper collaboration'
                 ],
                 'code' => 'defense-goalkeeper_collaboration3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Doblaje'
                 ],
                 'en' => [
                     'name' => 'Doubling'
                 ],
                 'code' => 'doubling3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Barrera dinámica'
                 ],
                 'en' => [
                     'name' => 'Dynamic wall'
                 ],
                 'code' => 'dynamic_wall3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cerrar líneas de tiro'
                 ],
                 'en' => [
                     'name' => 'Cover shooting lanes'
                 ],
                 'code' => 'cover_shooting_lanes3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cerrar líneas de pase'
                 ],
                 'en' => [
                     'name' => 'Cover passing lanes'
                 ],
                 'code' => 'cover_passing_lanes3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa lado débil'
                 ],
                 'en' => [
                     'name' => 'Weak side defense'
                 ],
                 'code' => 'weak_side_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa lado fuerte'
                 ],
                 'en' => [
                     'name' => 'Strong side defense'
                 ],
                 'code' => 'strong_side_defense3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Transición defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive transition'
                 ],
                 'code' => 'defensive_transition3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Pérdida de balón y recuperación'
                 ],
                 'en' => [
                     'name' => 'Turnover and recovery'
                 ],
                 'code' => 'turnover_and_recovery3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Equilibrio linea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line balance'
                 ],
                 'code' => 'defensive_line_balance3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Coverage'
                 ],
                 'code' => 'coverage3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],
             [
                 'es' => [
                     'name' => 'Enfrentamiento 1v1'
                 ],
                 'en' => [
                     'name' => 'Breakaway defense 1v1'
                 ],
                 'code' => 'breakaway_defense_1v1_3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],
             [
                 'es' => [
                     'name' => 'Posicionamiento'
                 ],
                 'en' => [
                     'name' => 'Positioning'
                 ],
                 'code' => 'positioning3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing3',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ]
         ];
     }
     private function targetsBasketball()
     {
         return [
             [
                 'es' => [
                     'name' => 'Posición de triple amenaza'
                 ],
                 'en' => [
                     'name' => 'Triple-threat position'
                 ],
                 'code' => 'triple-threat_position4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Trabajo de pies en ataque'
                 ],
                 'en' => [
                     'name' => 'Attacking footwork'
                 ],
                 'code' => 'attacking_footwork4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Desplazamientos ofensivos'
                 ],
                 'en' => [
                     'name' => 'Offensive displacements'
                 ],
                 'code' => 'offensive_displacements4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Bote y manejo de balón'
                 ],
                 'en' => [
                     'name' => 'Bounce and ball handling'
                 ],
                 'code' => 'bounce_and_ball_handling4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Finta'
                 ],
                 'en' => [
                     'name' => 'Fake'
                 ],
                 'code' => 'fake4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Pase'
                 ],
                 'en' => [
                     'name' => 'Pass'
                 ],
                 'code' => 'pass4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Recepción'
                 ],
                 'en' => [
                     'name' => 'Catch'
                 ],
                 'code' => 'catch4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Entrada a canasta'
                 ],
                 'en' => [
                     'name' => 'Layup'
                 ],
                 'code' => 'layup4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Shot'
                 ],
                 'code' => 'shot4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento posicional'
                 ],
                 'en' => [
                     'name' => 'Set shot'
                 ],
                 'code' => 'set_shot4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento en salto'
                 ],
                 'en' => [
                     'name' => 'Jump shot'
                 ],
                 'code' => 'jump_shot4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Tiro libre'
                 ],
                 'en' => [
                     'name' => 'Free throw'
                 ],
                 'code' => 'free_throw4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Mate'
                 ],
                 'en' => [
                     'name' => 'Dunk'
                 ],
                 'code' => 'dunk4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Alley-oop'
                 ],
                 'en' => [
                     'name' => 'Alley-oop'
                 ],
                 'code' => 'alley-oop4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Posición básica defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive stance '
                 ],
                 'code' => 'defensive_stance4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Trabajo de pies defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive footwork'
                 ],
                 'code' => 'defensive_footwork4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Desplazamientos defensivos'
                 ],
                 'en' => [
                     'name' => 'Defensive displacements'
                 ],
                 'code' => 'defensive_displacements4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Defensa jugador con balón'
                 ],
                 'en' => [
                     'name' => 'Opponent defense with the ball'
                 ],
                 'code' => 'opponent_defense_with_the_ball4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Defensa jugador sin balón'
                 ],
                 'en' => [
                     'name' => 'Opponent defense without the ball'
                 ],
                 'code' => 'opponent_defense_without_the_ball4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Robo de balón'
                 ],
                 'en' => [
                     'name' => 'Steal the ball'
                 ],
                 'code' => 'steal_the_ball4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Tapón'
                 ],
                 'en' => [
                     'name' => 'Blocking shot'
                 ],
                 'code' => 'blocking_shot4',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Estrategia ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive strategy'
                 ],
                 'code' => 'offensive_strategy4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa zonal'
                 ],
                 'en' => [
                     'name' => 'Attack against zone defense'
                 ],
                 'code' => 'attack_against_zone_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa individual'
                 ],
                 'en' => [
                     'name' => 'Attack against individual defense'
                 ],
                 'code' => 'attack_against_individual_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa mixta'
                 ],
                 'en' => [
                     'name' => 'Attack against mixed defense'
                 ],
                 'code' => 'attack_against_mixed_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque contra defensa presionante'
                 ],
                 'en' => [
                     'name' => 'Attack against pressure defense'
                 ],
                 'code' => 'attack_against_pressure_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical superiority'
                 ],
                 'code' => 'attack_in_numerical_superiority4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical inferiority'
                 ],
                 'code' => 'attack_in_numerical_inferiority4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical equality'
                 ],
                 'code' => 'attack_in_numerical_equality4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Movimientos ofensivos sin balón'
                 ],
                 'en' => [
                     'name' => 'Offensive off ball movements'
                 ],
                 'code' => 'offensive_off_ball_movements4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Circulación de balón'
                 ],
                 'en' => [
                     'name' => 'Ball circulation'
                 ],
                 'code' => 'ball_circulation4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Jugada de banda y fondo'
                 ],
                 'en' => [
                     'name' => 'Inbound play'
                 ],
                 'code' => 'inbound play4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Inversión de balón'
                 ],
                 'en' => [
                     'name' => 'Reverse the ball'
                 ],
                 'code' => 'reverse_the_ball4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Pase dentro fuera'
                 ],
                 'en' => [
                     'name' => 'Inside-out pass'
                 ],
                 'code' => 'inside-out_pass4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Penetración'
                 ],
                 'en' => [
                     'name' => 'Penetration'
                 ],
                 'code' => 'penetration4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Pase y va'
                 ],
                 'en' => [
                     'name' => 'Give and go'
                 ],
                 'code' => 'give_and_go4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Contraataque'
                 ],
                 'en' => [
                     'name' => 'Fast break'
                 ],
                 'code' => 'fast_break4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Pick and roll'
                 ],
                 'en' => [
                     'name' => 'Pick and roll'
                 ],
                 'code' => 'pick_and_roll4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Puerta atrás'
                 ],
                 'en' => [
                     'name' => 'Black door cut'
                 ],
                 'code' => 'black_door_cut4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Pantalla cruzada'
                 ],
                 'en' => [
                     'name' => 'Cross screen'
                 ],
                 'code' => 'cross_screen4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Desmarque'
                 ],
                 'en' => [
                     'name' => 'Uncheck'
                 ],
                 'code' => 'uncheck4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Corte'
                 ],
                 'en' => [
                     'name' => 'Cut'
                 ],
                 'code' => 'cut4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Llegar jugando'
                 ],
                 'en' => [
                     'name' => 'Get playing'
                 ],
                 'code' => 'get_playing4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Construcción playbook'
                 ],
                 'en' => [
                     'name' => 'Playbook construction'
                 ],
                 'code' => 'playbook_construction4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ocupación del espacio'
                 ],
                 'en' => [
                     'name' => 'Spacing'
                 ],
                 'code' => 'spacing4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Situación especial'
                 ],
                 'en' => [
                     'name' => 'Special situation'
                 ],
                 'code' => 'special_situation4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo / Pantalla'
                 ],
                 'en' => [
                     'name' => 'Screen'
                 ],
                 'code' => 'screen4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Postear'
                 ],
                 'en' => [
                     'name' => 'Post up'
                 ],
                 'code' => 'post_up4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Cambio de sistema ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive system switching'
                 ],
                 'code' => 'offensive_system_switching4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Rebote ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive rebound'
                 ],
                 'code' => 'offensive_rebound4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo rebote defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive rebound block'
                 ],
                 'code' => 'defensive_rebound_block4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Transición ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive transition'
                 ],
                 'code' => 'offensive_transition4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Finta ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive feint'
                 ],
                 'code' => 'offensive_feint4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Estrategia defensiva '
                 ],
                 'en' => [
                     'name' => 'Defensive strategy'
                 ],
                 'code' => 'defensive_strategy4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en zona'
                 ],
                 'en' => [
                     'name' => 'Zone defense'
                 ],
                 'code' => 'zone_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa presionante'
                 ],
                 'en' => [
                     'name' => 'Pressure defense'
                 ],
                 'code' => 'pressure_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa individual'
                 ],
                 'en' => [
                     'name' => 'Individual defense'
                 ],
                 'code' => 'individual_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa mixta'
                 ],
                 'en' => [
                     'name' => 'Mixed defense '
                 ],
                 'code' => 'mixed_defense 4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en toda la pista'
                 ],
                 'en' => [
                     'name' => 'Full-court defense'
                 ],
                 'code' => 'full-court_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical superiority'
                 ],
                 'code' => 'defense_in_numerical_superiority4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical inferiority'
                 ],
                 'code' => 'defense_in_numerical_inferiority4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical equality'
                 ],
                 'code' => 'defense_in_numerical_equality4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Movimientos defensivos'
                 ],
                 'en' => [
                     'name' => 'Defensive movements'
                 ],
                 'code' => 'defensive_movements4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Balance defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive balance'
                 ],
                 'code' => 'defensive_balance4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Ayuda defensiva'
                 ],
                 'en' => [
                     'name' => 'Help defense'
                 ],
                 'code' => 'help_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Forzar tiradores fuera de posición'
                 ],
                 'en' => [
                     'name' => 'Forcing shooters out of position'
                 ],
                 'code' => 'forcing_shooters_out_of_position4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Proteger la canasta'
                 ],
                 'en' => [
                     'name' => 'Protecting the basket'
                 ],
                 'code' => 'protecting_the_basket4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Sacar una falta de ataque'
                 ],
                 'en' => [
                     'name' => 'Taking a charge'
                 ],
                 'code' => 'taking_a_charge4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Limitar oportunidades de contraataque'
                 ],
                 'en' => [
                     'name' => 'Limiting fast break opportunities'
                 ],
                 'code' => 'limiting_fast_break_opportunities4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Atrapando el balón'
                 ],
                 'en' => [
                     'name' => 'Trapping the ball'
                 ],
                 'code' => 'trapping_the_ball4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defender línea de pase'
                 ],
                 'en' => [
                     'name' => 'Defending the pass'
                 ],
                 'code' => 'defending_the_pass4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defender Pick and roll'
                 ],
                 'en' => [
                     'name' => 'Defending Pick and roll'
                 ],
                 'code' => 'defending_Pick_and_roll4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defender pase y va'
                 ],
                 'en' => [
                     'name' => 'Defending give and go'
                 ],
                 'code' => 'Defending give and go4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defender puerta de atrás'
                 ],
                 'en' => [
                     'name' => 'Defending black door cut'
                 ],
                 'code' => 'Defending_blac_door_cut4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defender corte'
                 ],
                 'en' => [
                     'name' => 'Defending cut'
                 ],
                 'code' => 'defending_cut4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cambiar asignación defensiva'
                 ],
                 'en' => [
                     'name' => 'Switching on a screen'
                 ],
                 'code' => 'switching_on_a_screen4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Pasar bloqueo'
                 ],
                 'en' => [
                     'name' => 'Fighting through screen'
                 ],
                 'code' => 'fighting_through_screen4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Dos contra uno al poste'
                 ],
                 'en' => [
                     'name' => 'Double teaming post'
                 ],
                 'code' => 'double_teaming_post4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Interceptación'
                 ],
                 'en' => [
                     'name' => 'Interception'
                 ],
                 'code' => 'interception4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa bloqueo'
                 ],
                 'en' => [
                     'name' => 'Screen defense'
                 ],
                 'code' => 'screen_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa del poste'
                 ],
                 'en' => [
                     'name' => 'Post defense'
                 ],
                 'code' => 'post_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa lado débil'
                 ],
                 'en' => [
                     'name' => 'Weak side defense'
                 ],
                 'code' => 'weak_side_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa lado fuerte'
                 ],
                 'en' => [
                     'name' => 'Strong side defense'
                 ],
                 'code' => 'strong_side_defense4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Rebote defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive rebound'
                 ],
                 'code' => 'defensive_rebound4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Transición defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive transition'
                 ],
                 'code' => 'defensive_transition4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Finta defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive feint'
                 ],
                 'code' => 'defensive_feint4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Pérdida de balón y recuperación'
                 ],
                 'en' => [
                     'name' => 'Turnover and recovery'
                 ],
                 'code' => 'turnover_and_recovery4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Trabajo por puestos'
                 ],
                 'en' => [
                     'name' => 'Position specific training'
                 ],
                 'code' => 'position_specific_training4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing4',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ]
         ];
     }
     private function targetsVolleyball()
     {
         return [
             [
                 'es' => [
                     'name' => 'Saque'
                 ],
                 'en' => [
                     'name' => 'Serve'
                 ],
                 'code' => 'serve5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Saque de abajo'
                 ],
                 'en' => [
                     'name' => 'Underhand serve'
                 ],
                 'code' => 'underhand_serve5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Saque de arriba'
                 ],
                 'en' => [
                     'name' => 'Overhand serve'
                 ],
                 'code' => 'overhand_serve5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Saque con salto'
                 ],
                 'en' => [
                     'name' => 'Jump serve'
                 ],
                 'code' => 'jump_serve5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Saque flotante'
                 ],
                 'en' => [
                     'name' => 'Float serve'
                 ],
                 'code' => 'float_serve5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Golpeo de antebrazo'
                 ],
                 'en' => [
                     'name' => 'Forearm pass'
                 ],
                 'code' => 'forearm_pass5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Golpeo de dedos'
                 ],
                 'en' => [
                     'name' => 'Overhead pass'
                 ],
                 'code' => 'overhead_pass5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Colocación'
                 ],
                 'en' => [
                     'name' => 'Set'
                 ],
                 'code' => 'set5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Remate'
                 ],
                 'en' => [
                     'name' => 'Spike'
                 ],
                 'code' => 'spike5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Ataque rápido'
                 ],
                 'en' => [
                     'name' => 'Quick attack'
                 ],
                 'code' => 'quick_attack5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Ataque deslizante'
                 ],
                 'en' => [
                     'name' => 'Slide attack'
                 ],
                 'code' => 'slide_attack5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Posición de espera defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive ready position'
                 ],
                 'code' => 'defensive_ready_position5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Recepción saque'
                 ],
                 'en' => [
                     'name' => 'Serve receive'
                 ],
                 'code' => 'serve_receive5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Caída abajo'
                 ],
                 'en' => [
                     'name' => 'Dig'
                 ],
                 'code' => 'dig5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Caída arriba'
                 ],
                 'en' => [
                     'name' => 'Overhead dig'
                 ],
                 'code' => 'overhead_dig5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Caída de emergencia'
                 ],
                 'en' => [
                     'name' => 'Collapse dig'
                 ],
                 'code' => 'collapse_dig5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo'
                 ],
                 'en' => [
                     'name' => 'Blocking'
                 ],
                 'code' => 'blocking5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Avance'
                 ],
                 'en' => [
                     'name' => 'Run-through'
                 ],
                 'code' => 'run-through5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => ''
                 ],
                 'en' => [
                     'name' => ''
                 ],
                 'code' => '5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Rodamiento'
                 ],
                 'en' => [
                     'name' => 'Barrel roll'
                 ],
                 'code' => 'barrel_roll5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Cubrir al rematador'
                 ],
                 'en' => [
                     'name' => 'Covering the hitter'
                 ],
                 'code' => 'covering_the_hitter5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Salir de la red'
                 ],
                 'en' => [
                     'name' => 'Dig out of the net'
                 ],
                 'code' => 'dig_out_of_the_net5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Plancha'
                 ],
                 'en' => [
                     'name' => 'Pancake'
                 ],
                 'code' => 'pancake5',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Táctica equipo ofensiva'
                 ],
                 'en' => [
                     'name' => 'Team offensive tactic'
                 ],
                 'code' => 'team_offensive_tactic5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Táctica individual ofensiva'
                 ],
                 'en' => [
                     'name' => 'Individual offensive tactic'
                 ],
                 'code' => 'individual_offensive_tactic5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Saque agresivo'
                 ],
                 'en' => [
                     'name' => 'Agressive serve'
                 ],
                 'code' => 'agressive_serve5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Recepción saque'
                 ],
                 'en' => [
                     'name' => 'Serve reception'
                 ],
                 'code' => 'serve_reception5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Finta'
                 ],
                 'en' => [
                     'name' => 'Feint'
                 ],
                 'code' => 'feint5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Remate primera fila'
                 ],
                 'en' => [
                     'name' => 'Front-row Spike'
                 ],
                 'code' => 'front-row_spike5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Remate segunda fila'
                 ],
                 'en' => [
                     'name' => 'Second-row Spike'
                 ],
                 'code' => 'second-row_spike5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Variación del ataque'
                 ],
                 'en' => [
                     'name' => 'Attack variation'
                 ],
                 'code' => 'attack_variation5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Golpear contra el bloqueo'
                 ],
                 'en' => [
                     'name' => 'Hitting off the block'
                 ],
                 'code' => 'hitting_off_the_block5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Colocación rápida'
                 ],
                 'en' => [
                     'name' => 'Quick set'
                 ],
                 'code' => 'quick_set5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Atacar segundo balón'
                 ],
                 'en' => [
                     'name' => 'Second ball attack'
                 ],
                 'code' => 'second_ball_attack5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Construcción jugada'
                 ],
                 'en' => [
                     'name' => 'Playbook construction'
                 ],
                 'code' => 'playbook_construction5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Táctica equipo defensiva'
                 ],
                 'en' => [
                     'name' => 'Team defensive tactic'
                 ],
                 'code' => 'team_defensive_tactic5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Táctica individual defensiva'
                 ],
                 'en' => [
                     'name' => 'Individual defensive tactic'
                 ],
                 'code' => 'individual_defensive_tactic5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Posicionamiento defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive positioning'
                 ],
                 'code' => 'defensive_positioning5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Lectura del atacante'
                 ],
                 'en' => [
                     'name' => 'Attacker reading'
                 ],
                 'code' => 'attacker_reading5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa ataque deslizante'
                 ],
                 'en' => [
                     'name' => 'Slide attack defense'
                 ],
                 'code' => 'slide_attack_defense5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa remate primera fila'
                 ],
                 'en' => [
                     'name' => 'First-row spike defense'
                 ],
                 'code' => 'first-row_spike_defense5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa remate segunda fila'
                 ],
                 'en' => [
                     'name' => 'Second-row spike defense'
                 ],
                 'code' => 'second-row_spike_defense5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Estrategias de bloqueo'
                 ],
                 'en' => [
                     'name' => 'Blocking strategies'
                 ],
                 'code' => 'blocking_strategies5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Usar al libero'
                 ],
                 'en' => [
                     'name' => 'Using a libero'
                 ],
                 'code' => 'using_a_libero5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa ataque rápido'
                 ],
                 'en' => [
                     'name' => 'Quick attack defense'
                 ],
                 'code' => 'quick_attack_defense5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa balón libre del oponente'
                 ],
                 'en' => [
                     'name' => 'Free ball opponente defense'
                 ],
                 'code' => 'free_ball_opponente_defense5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Perseguir el balón'
                 ],
                 'en' => [
                     'name' => 'Chase down a ball'
                 ],
                 'code' => 'chase_down_a_ball5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cambio de sistema defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive system switching'
                 ],
                 'code' => 'defensive_system_switching5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing5',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ]
         ];
     }
     private function targetsBeachVolleyball()
     {
         return [
            [
                 'es' => [
                     'name' => 'Saque'
                 ],
                 'en' => [
                     'name' => 'Serve'
                 ],
                 'code' => 'serve6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Saque de abajo'
                 ],
                 'en' => [
                     'name' => 'Underhand serve'
                 ],
                 'code' => 'underhand_serve6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Saque de arriba'
                 ],
                 'en' => [
                     'name' => 'Overhand serve'
                 ],
                 'code' => 'overhand_serve6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Saque con salto'
                 ],
                 'en' => [
                     'name' => 'Jump serve'
                 ],
                 'code' => 'jump_serve6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Saque flotante'
                 ],
                 'en' => [
                     'name' => 'Float serve'
                 ],
                 'code' => 'float_serve6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Golpeo de antebrazo'
                 ],
                 'en' => [
                     'name' => 'Forearm pass'
                 ],
                 'code' => 'forearm_pass6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Golpeo de dedos'
                 ],
                 'en' => [
                     'name' => 'Overhead pass'
                 ],
                 'code' => 'overhead_pass6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Colocación'
                 ],
                 'en' => [
                     'name' => 'Set'
                 ],
                 'code' => 'set6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Remate'
                 ],
                 'en' => [
                     'name' => 'Spike'
                 ],
                 'code' => 'spike6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Ataque rápido'
                 ],
                 'en' => [
                     'name' => 'Quick attack'
                 ],
                 'code' => 'quick_attack6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],            
             [
                 'es' => [
                     'name' => 'Posición de espera defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive ready position'
                 ],
                 'code' => 'defensive_ready_position6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Recepción saque'
                 ],
                 'en' => [
                     'name' => 'Serve receive'
                 ],
                 'code' => 'serve_receive6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],           
             [
                 'es' => [
                     'name' => 'Caída abajo'
                 ],
                 'en' => [
                     'name' => 'Dig'
                 ],
                 'code' => 'dig6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Caída arriba'
                 ],
                 'en' => [
                     'name' => 'Overhead dig'
                 ],
                 'code' => 'overhead_dig6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Caída de emergencia'
                 ],
                 'en' => [
                     'name' => 'Collapse dig'
                 ],
                 'code' => 'collapse_dig6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ], 
             [
                 'es' => [
                     'name' => 'Bloqueo'
                 ],
                 'en' => [
                     'name' => 'Blocking'
                 ],
                 'code' => 'blocking6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Avance'
                 ],
                 'en' => [
                     'name' => 'Run-through'
                 ],
                 'code' => 'run-through6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Rodamiento'
                 ],
                 'en' => [
                     'name' => 'Barrel roll'
                 ],
                 'code' => 'barrel_roll6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Cubrir al rematador'
                 ],
                 'en' => [
                     'name' => 'Covering the hitter'
                 ],
                 'code' => 'covering_the_hitter6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Salir de la red'
                 ],
                 'en' => [
                     'name' => 'Dig out of the net'
                 ],
                 'code' => 'Dig_out_of_the_net6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ], 
             [
                 'es' => [
                     'name' => 'Plancha'
                 ],
                 'en' => [
                     'name' => 'Pancake'
                 ],
                 'code' => 'pancake6',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],       
             [
                 'es' => [
                     'name' => 'Táctica equipo ofensiva'
                 ],
                 'en' => [
                     'name' => 'Team offensive tactic'
                 ],
                 'code' => 'team_offensive_tactic6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],       
             [
                 'es' => [
                     'name' => 'Táctica individual ofensiva'
                 ],
                 'en' => [
                     'name' => 'Individual offensive tactic'
                 ],
                 'code' => 'individual_offensive_tactic6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],       
             [
                 'es' => [
                     'name' => 'Saque agresivo'
                 ],
                 'en' => [
                     'name' => 'Agressive serve'
                 ],
                 'code' => 'agressive_serve6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],       
             [
                 'es' => [
                     'name' => 'Recepción saque'
                 ],
                 'en' => [
                     'name' => 'Serve reception'
                 ],
                 'code' => 'serve_reception6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Finta'
                 ],
                 'en' => [
                     'name' => 'Feint'
                 ],
                 'code' => 'feint6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Variación del ataque'
                 ],
                 'en' => [
                     'name' => 'Attack variation'
                 ],
                 'code' => 'attack_variation6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Golpear contra el bloqueo'
                 ],
                 'en' => [
                     'name' => 'Hitting off the block'
                 ],
                 'code' => 'hitting_off_the_block6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Colocación rápida'
                 ],
                 'en' => [
                     'name' => 'Quick set'
                 ],
                 'code' => 'quick_set6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],       
             [
                 'es' => [
                     'name' => 'Atacar segundo balón'
                 ],
                 'en' => [
                     'name' => 'Second ball attack'
                 ],
                 'code' => 'second_ball_attack6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],       
             [
                 'es' => [
                     'name' => 'Construcción jugada'
                 ],
                 'en' => [
                     'name' => 'Playbook construction'
                 ],
                 'code' => 'playbook_construction6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],       
             [
                 'es' => [
                     'name' => 'Táctica equipo defensiva'
                 ],
                 'en' => [
                     'name' => 'Team defensive tactic'
                 ],
                 'code' => 'team_defensive_tactic6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],       
             [
                 'es' => [
                     'name' => 'Táctica individual defensiva'
                 ],
                 'en' => [
                     'name' => 'Individual defensive tactic'
                 ],
                 'code' => 'individual_defensive_tactic6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],       
             [
                 'es' => [
                     'name' => 'Posicionamiento defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive positioning'
                 ],
                 'code' => 'defensive_positioning6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],       
             [
                 'es' => [
                     'name' => 'Lectura del atacante'
                 ],
                 'en' => [
                     'name' => 'Attacker reading'
                 ],
                 'code' => 'attacker_reading6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],       
             [
                 'es' => [
                     'name' => 'Defensa remate'
                 ],
                 'en' => [
                     'name' => 'Spike defense'
                 ],
                 'code' => 'spike_defense6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],       
             [
                 'es' => [
                     'name' => 'Estrategias de bloqueo'
                 ],
                 'en' => [
                     'name' => 'Blocking strategies'
                 ],
                 'code' => 'blocking_strategies6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],       
             [
                 'es' => [
                     'name' => 'Defensa ataque rápido'
                 ],
                 'en' => [
                     'name' => 'Quick attack defense'
                 ],
                 'code' => 'quick_attack_defense6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa balón libre del oponente'
                 ],
                 'en' => [
                     'name' => 'Free ball opponente defense'
                 ],
                 'code' => 'free_ball_opponente_defense6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Perseguir el balón'
                 ],
                 'en' => [
                     'name' => 'Chase down a ball'
                 ],
                 'code' => 'chase_down_a_ball6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing6',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],
         ];
     }
     private function targetsRugby()
     {
         return [
             [
                 'es' => [
                     'name' => 'Posición ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive stance'
                 ],
                 'code' => 'offensive_stance_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Desplazamientos ofensivos'
                 ],
                 'en' => [
                     'name' => 'Offensive displacements'
                 ],
                 'code' => 'offensive_displacements_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Manejo del balón'
                 ],
                 'en' => [
                     'name' => 'Ball handling'
                 ],
                 'code' => 'ball_handling_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Finta'
                 ],
                 'en' => [
                     'name' => 'Fake'
                 ],
                 'code' => 'fake_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Throw'
                 ],
                 'code' => 'throw_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Captura lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Throw catching'
                 ],
                 'code' => 'throw_catching_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Protección del pase'
                 ],
                 'en' => [
                     'name' => 'Pass protection'
                 ],
                 'code' => 'pass_protection_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Carrera ruta intermedia'
                 ],
                 'en' => [
                     'name' => 'Intermediate route run'
                 ],
                 'code' => 'intermediate_route_run_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Carrera ruta profunda'
                 ],
                 'en' => [
                     'name' => 'Deep route run'
                 ],
                 'code' => 'deep_route_run_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Escape receptor'
                 ],
                 'en' => [
                     'name' => 'Receiver release'
                 ],
                 'code' => 'receiver_release_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo'
                 ],
                 'en' => [
                     'name' => 'Block'
                 ],
                 'code' => 'block_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Captura patada inicial'
                 ],
                 'en' => [
                     'name' => 'Kickoff catching'
                 ],
                 'code' => 'kickoff_catching_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Captura patada de despeje'
                 ],
                 'en' => [
                     'name' => 'Punt catching'
                 ],
                 'code' => 'punt_catching_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Pase'
                 ],
                 'en' => [
                     'name' => 'Pass'
                 ],
                 'code' => 'pass_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Pase largo'
                 ],
                 'en' => [
                     'name' => 'Long pass'
                 ],
                 'code' => 'long_pass_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Pase corto'
                 ],
                 'en' => [
                     'name' => 'Short pass'
                 ],
                 'code' => 'short_pass_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Golpeo de balón'
                 ],
                 'en' => [
                     'name' => 'Ball kick'
                 ],
                 'code' => 'ball_kick_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Recogida de balón'
                 ],
                 'en' => [
                     'name' => 'Pick up the ball'
                 ],
                 'code' => 'pick_up_the_ball_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Golpeo a bote pronto (Drop kick)'
                 ],
                 'en' => [
                     'name' => 'Drop kick'
                 ],
                 'code' => 'drop_kick_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Patada de conversión'
                 ],
                 'en' => [
                     'name' => 'Conversion kick'
                 ],
                 'code' => 'conversion_kick_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Posición defensiva'
                 ],
                 'en' => [
                     'name' => 'Defense stance'
                 ],
                 'code' => 'defense_stance_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Desplazamientos defensivos'
                 ],
                 'en' => [
                     'name' => 'Defense displacements'
                 ],
                 'code' => 'defense_displacements_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Placaje'
                 ],
                 'en' => [
                     'name' => 'Tackling'
                 ],
                 'code' => 'tackling_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Placaje campo abierto'
                 ],
                 'en' => [
                     'name' => 'Open-field tackling'
                 ],
                 'code' => 'open-field_tackling_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Defensa bloqueo'
                 ],
                 'en' => [
                     'name' => 'Block defense'
                 ],
                 'code' => 'block_defense_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Defensa bloqueo 2 contra 1'
                 ],
                 'en' => [
                     'name' => 'Double-team block defense'
                 ],
                 'code' => 'double-team_block_defense_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Patada inicial (Kickoff)'
                 ],
                 'en' => [
                     'name' => 'Kickoff'
                 ],
                 'code' => 'kickoff_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Patada de despeje (Punt)'
                 ],
                 'en' => [
                     'name' => 'Punt'
                 ],
                 'code' => 'punt_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo de tiro'
                 ],
                 'en' => [
                     'name' => 'Blocking Kick'
                 ],
                 'code' => 'blocking_kick_7',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],
             [
                 'es' => [
                     'name' => 'Formación ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive formation'
                 ],
                 'code' => 'offensive_formation_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Cambio formación ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive formation switching'
                 ],
                 'code' => 'offensive_formation_switching_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Posicionamiento ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive positioning'
                 ],
                 'code' => 'offensive_positioning_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Jugada de carrera'
                 ],
                 'en' => [
                     'name' => 'Running play (Rush)'
                 ],
                 'code' => 'running_play_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Jugada de pase'
                 ],
                 'en' => [
                     'name' => 'Passing play'
                 ],
                 'code' => 'passing_play_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Estrategia ofensiva específica'
                 ],
                 'en' => [
                     'name' => 'Specific offensive strategy'
                 ],
                 'code' => 'specific_offensive_strategy_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Construcción jugada'
                 ],
                 'en' => [
                     'name' => 'Playbook construction'
                 ],
                 'code' => 'playbook_construction_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Delanteros'
                 ],
                 'en' => [
                     'name' => 'Forwards'
                 ],
                 'code' => 'forwards_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Primera línea'
                 ],
                 'en' => [
                     'name' => 'First row'
                 ],
                 'code' => 'first_row_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Segunda línea'
                 ],
                 'en' => [
                     'name' => 'Second row'
                 ],
                 'code' => 'second_row_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Tercera línea'
                 ],
                 'en' => [
                     'name' => 'Third row'
                 ],
                 'code' => 'third_row_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Sistema de llamadas'
                 ],
                 'en' => [
                     'name' => 'Play calling system'
                 ],
                 'code' => 'play_calling_system_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Opción Pasar-Correr'
                 ],
                 'en' => [
                     'name' => 'Pass-Run option'
                 ],
                 'code' => 'pass-run_option_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Corriendo a la brecha'
                 ],
                 'en' => [
                     'name' => 'Running to the gap'
                 ],
                 'code' => 'running_to_the_gap_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Corriendo hacia la luz'
                 ],
                 'en' => [
                     'name' => 'Running to daylight'
                 ],
                 'code' => 'running_to_daylight_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ajuste de ruta'
                 ],
                 'en' => [
                     'name' => 'Route adjustment'
                 ],
                 'code' => 'route_adjustment_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Evadir tackleadores'
                 ],
                 'en' => [
                     'name' => 'Evading tacklers'
                 ],
                 'code' => 'evading_tacklers_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Levantar Blitz'
                 ],
                 'en' => [
                     'name' => 'Picking up Blitz'
                 ],
                 'code' => 'picking_up_blitz_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Levantar Drift'
                 ],
                 'en' => [
                     'name' => 'Picking up Drift'
                 ],
                 'code' => 'picking_up_drift_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Lucha'
                 ],
                 'en' => [
                     'name' => 'Scramble'
                 ],
                 'code' => 'scramble_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo combinado'
                 ],
                 'en' => [
                     'name' => 'Block combination'
                 ],
                 'code' => 'block_combination_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Protección pase'
                 ],
                 'en' => [
                     'name' => 'Pass protection'
                 ],
                 'code' => 'pass_protection_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical superiority'
                 ],
                 'code' => 'attack_in_numerical_superiority_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical inferiority'
                 ],
                 'code' => 'attack_in_numerical_inferiority_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ataque en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical equality'
                 ],
                 'code' => 'attack_in_numerical_equality_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Mantener la continuidad'
                 ],
                 'en' => [
                     'name' => 'Maintain continuity'
                 ],
                 'code' => 'maintain_continuity_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Avanzar en ataque'
                 ],
                 'en' => [
                     'name' => 'Go forward in attack'
                 ],
                 'code' => 'go_forward_in_attack_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ganar la posesión'
                 ],
                 'en' => [
                     'name' => 'Gain Possession'
                 ],
                 'code' => 'gain_possession_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ayuda ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive support'
                 ],
                 'code' => 'offensive_support_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Presión ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive pressure'
                 ],
                 'code' => 'offensive_pressure_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Anotación'
                 ],
                 'en' => [
                     'name' => 'Scoring'
                 ],
                 'code' => 'scoring_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque retaguardia'
                 ],
                 'en' => [
                     'name' => 'Back line attack'
                 ],
                 'code' => 'back_line_attack_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Ocupación espacio ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive Spacing'
                 ],
                 'code' => 'offensive_spacing_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
            [
                 'es' => [
                     'name' => 'Crear espacio'
                 ],
                 'en' => [
                     'name' => 'Create space'
                 ],
                 'code' => 'create_space_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],
             [
                 'es' => [
                     'name' => 'Formación defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive formation'
                 ],
                 'code' => 'defensive_formation_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cambio formación defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive formation switching'
                 ],
                 'code' => 'defensive_formation_switching_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Posicionamiento defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive positioning'
                 ],
                 'code' => 'defensive_positioning_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa pase'
                 ],
                 'en' => [
                     'name' => 'Pass defense'
                 ],
                 'code' => 'pass_defense_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa carrera'
                 ],
                 'en' => [
                     'name' => 'Run defense'
                 ],
                 'code' => 'run_defense_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Estrategia defensiva específica'
                 ],
                 'en' => [
                     'name' => 'Specific defensive strategy'
                 ],
                 'code' => 'specific_defensive_strategy_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cobertura hombre-a-hombre'
                 ],
                 'en' => [
                     'name' => 'Man-to-man coverage'
                 ],
                 'code' => 'man-to-man_coverage_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cobertura zonal'
                 ],
                 'en' => [
                     'name' => 'Zone coverage'
                 ],
                 'code' => 'zone_coverage_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa Drift'
                 ],
                 'en' => [
                     'name' => 'Drift defense'
                 ],
                 'code' => 'drift_defense_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa fuera a dentro'
                 ],
                 'en' => [
                     'name' => 'Out to in defense'
                 ],
                 'code' => 'out_to_in_defense_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa Arrowhead'
                 ],
                 'en' => [
                     'name' => 'Arrowhead defense'
                 ],
                 'code' => 'arrowhead_defense_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa Blitz'
                 ],
                 'en' => [
                     'name' => 'Blitz defense'
                 ],
                 'code' => 'blitz_defense_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Jugada trampa (Trap)'
                 ],
                 'en' => [
                     'name' => 'Trap play'
                 ],
                 'code' => 'trap_play_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensas'
                 ],
                 'en' => [
                     'name' => 'Backs'
                 ],
                 'code' => 'backs_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Desbloqueo'
                 ],
                 'en' => [
                     'name' => 'Unblocked'
                 ],
                 'code' => 'unblocked_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Ángulos de persecución'
                 ],
                 'en' => [
                     'name' => 'Pursuit angles'
                 ],
                 'code' => 'pursuit_angles_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Control de la brecha'
                 ],
                 'en' => [
                     'name' => 'Gap control'
                 ],
                 'code' => 'gap_control_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Interceptación'
                 ],
                 'en' => [
                     'name' => 'Interception'
                 ],
                 'code' => 'interception_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical superiority'
                 ],
                 'code' => 'defense_in_numerical_superiority_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'defense_in_numerical_inferiority'
                 ],
                 'code' => '_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical equality'
                 ],
                 'code' => 'defense_in_numerical_equality_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa 2 niveles'
                 ],
                 'en' => [
                     'name' => '2 levels defense'
                 ],
                 'code' => '2_levels_defense_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Línea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line'
                 ],
                 'code' => 'defensive_line_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cobertura patada de despeje'
                 ],
                 'en' => [
                     'name' => 'Punt coverage'
                 ],
                 'code' => 'punt_coverage_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Protección patada de despeje'
                 ],
                 'en' => [
                     'name' => 'Punt protection'
                 ],
                 'code' => 'punt_protection_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Cobertura patada inicial'
                 ],
                 'en' => [
                     'name' => 'Kickoff coverage'
                 ],
                 'code' => 'kickoff_coverage_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa retaguardia'
                 ],
                 'en' => [
                     'name' => 'Back line defense'
                 ],
                 'code' => 'back_line_defense_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Cubrir espacio'
                 ],
                 'en' => [
                     'name' => 'Cover space'
                 ],
                 'code' => 'cover_space_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Ocupación espacio defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive spacing'
                 ],
                 'code' => 'defensive_spacing_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Evitar anotación'
                 ],
                 'en' => [
                     'name' => 'Avoid scoring'
                 ],
                 'code' => 'avoid_scoring_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Ayuda defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive support'
                 ],
                 'code' => 'defensive_support_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Presión defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive pressure'
                 ],
                 'code' => 'defensive_pressure_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Recuperar posesión'
                 ],
                 'en' => [
                     'name' => 'Regain possession'
                 ],
                 'code' => 'regain_possession_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Avanzar en defensa'
                 ],
                 'en' => [
                     'name' => 'Go forward in defense'
                 ],
                 'code' => 'go_forward_in_defense_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Defensa contraataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack defense'
                 ],
                 'code' => 'counter_attack_defense_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],
             [
                 'es' => [
                     'name' => 'Saque de banda'
                 ],
                 'en' => [
                     'name' => 'Line-out'
                 ],
                 'code' => 'line-out_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],
             [
                 'es' => [
                     'name' => 'Ruck'
                 ],
                 'en' => [
                     'name' => 'Ruck'
                 ],
                 'code' => 'ruck_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],
             [
                 'es' => [
                     'name' => 'Melé'
                 ],
                 'en' => [
                     'name' => 'Scrum'
                 ],
                 'code' => 'scrum_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],
             [
                 'es' => [
                     'name' => 'Maul'
                 ],
                 'en' => [
                     'name' => 'Maul'
                 ],
                 'code' => 'maul_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],
             [
                 'es' => [
                     'name' => 'Patada inicio'
                 ],
                 'en' => [
                     'name' => 'Start kick'
                 ],
                 'code' => 'start_kick_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing_7',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],
         ];
     }
     private function targetsAmericanSoccer()
     {
         return [
             [
                 'es' => [
                     'name' => 'Posición ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive stance'
                 ],
                 'code' => 'offensive_stance8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ],
             [
                 'es' => [
                     'name' => 'Desplazamientos ofensivos'
                 ],
                 'en' => [
                     'name' => 'Offensive displacements'
                 ],
                 'code' => 'offensive_displacements8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ],  
             [
               
                     'es' => [
                         'name' => 'Manejo del balón'
                     ],
                     'en' => [
                         'name' => 'Ball handling'
                     ],
                     'code' => 'ball_handling8',
                     'content_exercise_id' =>  1,
                     'sub_content_session_id' => 10
             ],
             [
                 'es' => [
                     'name' => 'Finta'
                 ],
                 'en' => [
                     'name' => 'Fake'
                 ],
                 'code' => 'fake8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ],  
             [
                 'es' => [
                     'name' => 'Lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Throw'
                 ],
                 'code' => 'throw8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ],  
             [
                 'es' => [
                     'name' => 'Captura lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Throw catching'
                 ],
                 'code' => 'throw_catching8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ], 
             [
                 'es' => [
                     'name' => 'Intercambio Centro-Quaterback'
                 ],
                 'en' => [
                     'name' => 'Quarterback-center exchange'
                 ],
                 'code' => 'quarterback-center_exchange8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ],
             [
                 'es' => [
                     'name' => 'Pasos Quaterback'
                 ],
                 'en' => [
                     'name' => 'Quarterback drops'
                 ],
                 'code' => 'quarterback_drops8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ],
             [
                 'es' => [
                     'name' => 'Opciones lanzamiento Quaterback'
                 ],
                 'en' => [
                     'name' => 'Quaterback pitch options'
                 ],
                 'code' => 'quaterback_pitch_options8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ],  
             [
                     'es' => [
                         'name' => 'Cruce poco profundo'
                     ],
                     'en' => [
                         'name' => 'Shallow cross'
                     ],
                     'code' => 'shallow_cross8',
                     'content_exercise_id' =>  1,
                     'sub_content_session_id' => 10
             ],
             [
                 'es' => [
                     'name' => 'Carrera ruta intermedia'
                 ],
                 'en' => [
                     'name' => 'Intermediate route run'
                 ],
                 'code' => 'intermediate_route_run8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ],  
             [
                 'es' => [
                     'name' => 'Carrera ruta profunda'
                 ],
                 'en' => [
                     'name' => 'Deep route run'
                 ],
                 'code' => 'deep_route_run8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ],  
             [
                 'es' => [
                     'name' => 'Escape receptor'
                 ],
                 'en' => [
                     'name' => 'Receiver release'
                 ],
                 'code' => 'receiver_release8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ], 
             [
                 'es' => [
                     'name' => 'Bloqueo'
                 ],
                 'en' => [
                     'name' => 'Blocking'
                 ],
                 'code' => 'blocking8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo 2 contra 1'
                 ],
                 'en' => [
                     'name' => 'Double-team block'
                 ],
                 'code' => 'double-team_block8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ],
             [
                 'es' => [
                     'name' => 'Pulling'
                 ],
                 'en' => [
                     'name' => 'Pulling'
                 ],
                 'code' => 'pulling8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 10
             ],  
             [
                     'es' => [
                         'name' => 'Protección del pase'
                     ],
                     'en' => [
                         'name' => 'Pass protection'
                     ],
                     'code' => 'pass_protection8',
                     'content_exercise_id' =>  1,
                     'sub_content_session_id' => 10
             ],
             [
                 'es' => [
                     'name' => 'Posición defensiva'
                 ],
                 'en' => [
                     'name' => 'Defense stance'
                 ],
                 'code' => 'defense_stance8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 11
             ],  
             [
                 'es' => [
                     'name' => 'Desplazamientos defensivos'
                 ],
                 'en' => [
                     'name' => 'Defense displacements'
                 ],
                 'code' => 'defense_displacements8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 11
             ],  
             [
                 'es' => [
                     'name' => 'Placaje'
                 ],
                 'en' => [
                     'name' => 'Tackling'
                 ],
                 'code' => 'tackling8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 11
             ], 
             [
                 'es' => [
                     'name' => 'Defensa bloqueos básicos'
                 ],
                 'en' => [
                     'name' => 'Basic blocks defense'
                 ],
                 'code' => 'basic_blocks_defense8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 11
             ],
             [
                 'es' => [
                     'name' => 'Defensa bloqueo 2 contra 1'
                 ],
                 'en' => [
                     'name' => 'Double-team block defense'
                 ],
                 'code' => 'double-team_block_defense8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 11
             ],
             [
                 'es' => [
                     'name' => 'Derramando bloqueo (Spilling)'
                 ],
                 'en' => [
                     'name' => 'Spilling block'
                 ],
                 'code' => 'spilling_block8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 11
             ],  
             [
                     'es' => [
                         'name' => 'Apretando bloqueo (Squeezing)'
                     ],
                     'en' => [
                         'name' => 'Squeezing block'
                     ],
                     'code' => 'squeezing_block8',
                     'content_exercise_id' =>  1,
                     'sub_content_session_id' => 11
             ],
             [
                 'es' => [
                     'name' => 'Presionar Quaterback (Pass Rush)'
                 ],
                 'en' => [
                     'name' => 'Pass Rush (Quaterback pressure)'
                 ],
                 'code' => 'pass_rush8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 11
             ],  
             [
                 'es' => [
                     'name' => 'Defensa jugada optativa (Feathering)'
                 ],
                 'en' => [
                     'name' => 'Feathering (optional play defense)'
                 ],
                 'code' => 'feathering8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 11
             ],  
             [
                 'es' => [
                     'name' => 'Drop a zona de pase'
                 ],
                 'en' => [
                     'name' => 'Zone pass drop'
                 ],
                 'code' => 'Zone_pass_drop8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 11
             ], 
             [
                 'es' => [
                     'name' => 'Giro veloz'
                 ],
                 'en' => [
                     'name' => 'Speed turn'
                 ],
                 'code' => 'speed_turn8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 11
             ],
             [
                 'es' => [
                     'name' => 'Carga contra Quaterback (Blitz)'
                 ],
                 'en' => [
                     'name' => 'Blitz (Quaterback sack)'
                 ],
                 'code' => 'blitz8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 11
             ],
             [
                 'es' => [
                     'name' => 'Patada inicial (Kickoff)'
                 ],
                 'en' => [
                     'name' => 'Kickoff'
                 ],
                 'code' => 'kickoff8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 12
             ],    
             [
                 'es' => [
                     'name' => 'Patada corta (Onside Kick)'
                 ],
                 'en' => [
                     'name' => 'Onside Kick'
                 ],
                 'code' => 'onside_kick8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 12
             ],        
             [
                 'es' => [
                     'name' => 'Captura patada inicial'
                 ],
                 'en' => [
                     'name' => 'Kickoff catching'
                 ],
                 'code' => 'kickoff_catching8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 12
             ],        
             [
                 'es' => [
                     'name' => 'Gol de campo (Field goal)'
                 ],
                 'en' => [
                     'name' => 'Field goal'
                 ],
                 'code' => 'field_goal8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 12
             ],        
             [
                 'es' => [
                     'name' => 'Patada desde soporte (Place Kick)'
                 ],
                 'en' => [
                     'name' => 'Place Kick'
                 ],
                 'code' => 'place_kick8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 12
             ],        
             [
                 'es' => [
                     'name' => 'Patada de despeje (Punt)'
                 ],
                 'en' => [
                     'name' => 'Punt'
                 ],
                 'code' => 'punt8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 12
             ],        
             [
                 'es' => [
                     'name' => 'Captura patada de despeje'
                 ],
                 'en' => [
                     'name' => 'Punt catching'
                 ],
                 'code' => 'punt_catching8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 12
             ],        
             [
                 'es' => [
                     'name' => 'Pase largo'
                 ],
                 'en' => [
                     'name' => 'Long snap'
                 ],
                 'code' => 'long_snap8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 12
             ],        
             [
                 'es' => [
                     'name' => 'Pase corto'
                 ],
                 'en' => [
                     'name' => 'Short snap'
                 ],
                 'code' => 'short_snap8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 12
             ],        
             [
                 'es' => [
                     'name' => 'Placaje campo abierto'
                 ],
                 'en' => [
                     'name' => 'Open-field tackling'
                 ],
                 'code' => 'open-field_tackling8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 12
             ],        
             [
                 'es' => [
                     'name' => 'Bloqueo de tiro'
                 ],
                 'en' => [
                     'name' => 'Blocking Kick'
                 ],
                 'code' => 'blocking_kick8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 12
             ],        
             [
                 'es' => [
                     'name' => 'Bala (Bullet)'
                 ],
                 'en' => [
                     'name' => 'Bullet'
                 ],
                 'code' => 'bullet8',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 12
             ],      
             [
                 'es' => [
                     'name' => 'Formación ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive formation'
                 ],
                 'code' => 'offensive_formation8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],  
             [
                 'es' => [
                     'name' => 'Cambio formación ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive formation switching'
                 ],
                 'code' => 'offensive_formation_switching8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],  
             [
                 'es' => [
                     'name' => 'Jugada de carrera (Rush)'
                 ],
                 'en' => [
                     'name' => 'Running play (Rush)'
                 ],
                 'code' => 'running_play8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ], 
             [
                 'es' => [
                     'name' => 'Jugada de pase'
                 ],
                 'en' => [
                     'name' => 'Passing play'
                 ],
                 'code' => 'passing_play8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],
             [
                 'es' => [
                     'name' => 'Estrategia ofensiva específica'
                 ],
                 'en' => [
                     'name' => 'Specific offensive strategy'
                 ],
                 'code' => 'specific_offensive_strategy8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],
             [
                 'es' => [
                     'name' => 'Construcción jugada'
                 ],
                 'en' => [
                     'name' => 'Playbook construction'
                 ],
                 'code' => 'playbook_construction8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],  
             [
          
                     'es' => [
                         'name' => 'Linieros '
                     ],
                     'en' => [
                         'name' => 'Linemens'
                     ],
                     'code' => 'linemens8',
                     'content_exercise_id' =>  2,
                     'sub_content_session_id' => 13
             ],
             [
                 'es' => [
                     'name' => 'Defensas'
                 ],
                 'en' => [
                     'name' => 'Backs'
                 ],
                 'code' => 'backs8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],  
             [
                 'es' => [
                     'name' => 'Receptores'
                 ],
                 'en' => [
                     'name' => 'Receivers'
                 ],
                 'code' => 'receivers8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],  
             [
                 'es' => [
                     'name' => 'Sistema de llamadas'
                 ],
                 'en' => [
                     'name' => 'Play calling system'
                 ],
                 'code' => 'play_calling_system8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ], 
             [
                 'es' => [
                     'name' => 'Corriendo a la brecha'
                 ],
                 'en' => [
                     'name' => 'Running to the gap'
                 ],
                 'code' => 'running_to_the_gap8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],
             [
                 'es' => [
                     'name' => 'Corriendo hacia la luz'
                 ],
                 'en' => [
                     'name' => 'Running to daylight'
                 ],
                 'code' => 'running_to_daylight8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],  
             [
                 'es' => [
                     'name' => 'Ajuste de ruta'
                 ],
                 'en' => [
                     'name' => 'Route adjustment'
                 ],
                 'code' => 'route_adjustment8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],  
             [
                 'es' => [
                     'name' => 'Evadir tackleadores'
                 ],
                 'en' => [
                     'name' => 'Evading tacklers'
                 ],
                 'code' => 'evading_tacklers8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ], 
             [
                 'es' => [
                     'name' => 'Levantar Blitz'
                 ],
                 'en' => [
                     'name' => 'Picking up Blitz'
                 ],
                 'code' => 'picking_up_Blitz8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],
             [
                 'es' => [
                     'name' => 'Lucha'
                 ],
                 'en' => [
                     'name' => 'Scramble'
                 ],
                 'code' => 'scramble8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo combinado'
                 ],
                 'en' => [
                     'name' => 'Block combination'
                 ],
                 'code' => 'block_combination8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],  
             [
 
                     'es' => [
                         'name' => 'Opciones lanzamiento Quaterback'
                     ],
                     'en' => [
                         'name' => 'Quaterback Pitching option'
                     ],
                     'code' => 'quaterback_Pitching_option8',
                     'content_exercise_id' =>  2,
                     'sub_content_session_id' => 13
             ],
             [
                 'es' => [
                     'name' => 'Protección pase'
                 ],
                 'en' => [
                     'name' => 'Pass protection'
                 ],
                 'code' => 'pass_protection8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],  
             [
                 'es' => [
                     'name' => 'Opción Pasar-Correr'
                 ],
                 'en' => [
                     'name' => 'Pass-Run option'
                 ],
                 'code' => 'pass-run_option8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],  
             [
                 'es' => [
                     'name' => 'Ataque en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical superiority'
                 ],
                 'code' => 'attack_in_numerical_superiority8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ], 
             [
                 'es' => [
                     'name' => 'Ataque en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical inferiority'
                 ],
                 'code' => 'attack_in_numerical_inferiority8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ],  
             [
                 'es' => [
                     'name' => 'Ataque en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical equality'
                 ],
                 'code' => 'attack_in_numerical_equality8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ], 
             [
                 'es' => [
                     'name' => 'Mantener la continuidad'
                 ],
                 'en' => [
                     'name' => 'Maintain continuity'
                 ],
                 'code' => 'maintain_continuity8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ], 
             [
                 'es' => [
                     'name' => 'Avanzar en ataque'
                 ],
                 'en' => [
                     'name' => 'Go forward in attack'
                 ],
                 'code' => 'go_forward_in_attack8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ], 
             [
                 'es' => [
                     'name' => 'Ganar la posesión'
                 ],
                 'en' => [
                     'name' => 'Gain possession'
                 ],
                 'code' => 'gain_possession8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ], 
             [
                 'es' => [
                     'name' => 'Ayuda ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive support'
                 ],
                 'code' => 'offensive_support8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ], 
             [
                 'es' => [
                     'name' => 'Presión ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive pressure'
                 ],
                 'code' => 'offensive_pressure8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ], 
             [
                 'es' => [
                     'name' => 'Anotación'
                 ],
                 'en' => [
                     'name' => 'Scoring'
                 ],
                 'code' => 'scoring8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 13
             ], 
             [
                 'es' => [
                     'name' => 'Formación defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive formation'
                 ],
                 'code' => 'defensive_formation8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Cambio formación defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive formation switching'
                 ],
                 'code' => 'defensive_formation_switching8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Defensa pase'
                 ],
                 'en' => [
                     'name' => 'Pass defense'
                 ],
                 'code' => 'pass_defense8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Defensa carrera'
                 ],
                 'en' => [
                     'name' => 'Run defense'
                 ],
                 'code' => 'run_defense8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Estrategia defensiva específica'
                 ],
                 'en' => [
                     'name' => 'Specific defensive strategy'
                 ],
                 'code' => 'specific_defensive_strategy8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Cobertura hombre-a-hombre'
                 ],
                 'en' => [
                     'name' => 'Man-to-man coverage'
                 ],
                 'code' => 'man-to-man_coverage8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Cobertura zonal'
                 ],
                 'en' => [
                     'name' => 'Zone coverage'
                 ],
                 'code' => 'zone_coverage8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Cobertura 0'
                 ],
                 'en' => [
                     'name' => 'Cover 0'
                 ],
                 'code' => 'cover_0_8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Cobertura 1'
                 ],
                 'en' => [
                     'name' => 'Cover 1'
                 ],
                 'code' => 'cover_1_8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Cobertura 2'
                 ],
                 'en' => [
                     'name' => 'Cover 2'
                 ],
                 'code' => 'cover_2_8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Cobertura 3'
                 ],
                 'en' => [
                     'name' => 'Cover 3'
                 ],
                 'code' => 'cover_3_8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Cobertura 4'
                 ],
                 'en' => [
                     'name' => 'Cover 4'
                 ],
                 'code' => 'cover_4_8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Cobertura 5'
                 ],
                 'en' => [
                     'name' => 'Cover 5'
                 ],
                 'code' => 'cover_5_8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Cobertura 6'
                 ],
                 'en' => [
                     'name' => 'Cover 6'
                 ],
                 'code' => 'cover_6_8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Blitz'
                 ],
                 'en' => [
                     'name' => 'Blitz'
                 ],
                 'code' => 'blitz8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Jugada trampa (Trap)'
                 ],
                 'en' => [
                     'name' => 'Trap play'
                 ],
                 'code' => 'trap_play8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Defensa 46'
                 ],
                 'en' => [
                     'name' => '46 defense'
                 ],
                 'code' => '46_defense8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Defensa 2 niveles'
                 ],
                 'en' => [
                     'name' => '2 levels defense'
                 ],
                 'code' => '2_levels_defense8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Jugadores línea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive linemans'
                 ],
                 'code' => 'defensive_linemans8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Apoyadores'
                 ],
                 'en' => [
                     'name' => 'Linebackers'
                 ],
                 'code' => 'linebackers8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Backs defensivos'
                 ],
                 'en' => [
                     'name' => 'Defensive backs'
                 ],
                 'code' => 'defensive_backs8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Desbloqueo'
                 ],
                 'en' => [
                     'name' => 'Unblocked'
                 ],
                 'code' => 'unblocked8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Situación yardas largas'
                 ],
                 'en' => [
                     'name' => 'Long yardage situation'
                 ],
                 'code' => 'long_yardage_situation8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Ángulos de persecución'
                 ],
                 'en' => [
                     'name' => 'Pursuit angles'
                 ],
                 'code' => 'pursuit_angles8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Control de la brecha'
                 ],
                 'en' => [
                     'name' => 'Gap control'
                 ],
                 'code' => 'gap_control8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Elegir Spill o Squeeze'
                 ],
                 'en' => [
                     'name' => 'Choosing to Spill or Squeeze'
                 ],
                 'code' => 'choosing_to_spill_or_squeeze8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Defensa opción Quaterback'
                 ],
                 'en' => [
                     'name' => 'Quaterback option defense'
                 ],
                 'code' => 'quaterback_option_defense8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Interceptación'
                 ],
                 'en' => [
                     'name' => 'Interception'
                 ],
                 'code' => 'interception8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Acción de fuerza'
                 ],
                 'en' => [
                     'name' => 'Force action'
                 ],
                 'code' => 'force_action8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Defensa en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical superiority'
                 ],
                 'code' => 'defense_in_numerical_superiority8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Defensa en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical inferiority'
                 ],
                 'code' => 'defense_in_numerical_inferiority8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Defensa en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical equality'
                 ],
                 'code' => 'defense_in_numerical_equality8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Ayuda defensiva'
                 ],
                 'en' => [
                     'name' => 'Help defense'
                 ],
                 'code' => 'help_defense8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Presión defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive pressure'
                 ],
                 'code' => 'defensive_pressure8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Recuperar posesión'
                 ],
                 'en' => [
                     'name' => 'Regain possession'
                 ],
                 'code' => 'regain_possession8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Avanzar en defensa'
                 ],
                 'en' => [
                     'name' => 'Go forward in defense'
                 ],
                 'code' => 'go_forward_in_defense8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Evitar anotación'
                 ],
                 'en' => [
                     'name' => 'Avoid scoring'
                 ],
                 'code' => 'avoid_scoring8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Línea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line'
                 ],
                 'code' => 'defensive_line8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 14
             ], 
             [
                 'es' => [
                     'name' => 'Cobertura patada inicial'
                 ],
                 'en' => [
                     'name' => 'Kickoff coverage'
                 ],
                 'code' => 'kickoff_coverage8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 15
             ], 
             [
                 'es' => [
                     'name' => 'Defensa patada corta'
                 ],
                 'en' => [
                     'name' => 'Onside Kick defense'
                 ],
                 'code' => 'onside_kick_defense8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 15
             ], 
             [
                 'es' => [
                     'name' => 'Protección patada de despeje'
                 ],
                 'en' => [
                     'name' => 'Punt protection'
                 ],
                 'code' => 'punt_protection8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 15
             ], 
             [
                 'es' => [
                     'name' => 'Cobertura patada de despeje'
                 ],
                 'en' => [
                     'name' => 'Punt coverage'
                 ],
                 'code' => 'punt_coverage8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 15
             ], 
             [
                 'es' => [
                     'name' => 'Despejar dentro línea de 40 yardas'
                 ],
                 'en' => [
                     'name' => 'Punting inside 40-yard line'
                 ],
                 'code' => 'punting_inside_40-yard_line8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 15
             ], 
             [
                 'es' => [
                     'name' => 'Retorno pared (Wall)'
                 ],
                 'en' => [
                     'name' => 'Wall return'
                 ],
                 'code' => 'wall_return8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 15
             ], 
             [
                 'es' => [
                     'name' => 'Retorno cuña (Wedge)'
                 ],
                 'en' => [
                     'name' => 'Wedge return'
                 ],
                 'code' => 'wedge_return8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 15
             ], 
             [
                 'es' => [
                     'name' => 'Punto después Touchdown (PAT)'
                 ],
                 'en' => [
                     'name' => 'Point After Touchdown (PAT)'
                 ],
                 'code' => 'point_after_touchdown8',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 15
             ],  
         ];
     }
     private function targetsBaseball()
     {
         return [
             [
                 'es' => [
                     'name' => 'Desplazamientos bateadores'
                 ],
                 'en' => [
                     'name' => 'Batters displacements'
                 ],
                 'code' => 'batters_displacements9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Agarre'
                 ],
                 'en' => [
                     'name' => 'Grip'
                 ],
                 'code' => 'grip9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],  
             [
                 'es' => [
                     'name' => 'Bateo'
                 ],
                 'en' => [
                     'name' => 'Batting'
                 ],
                 'code' => 'batting9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Posición bateo'
                 ],
                 'en' => [
                     'name' => 'Batting stance'
                 ],
                 'code' => 'batting_stance9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],  
             [
                 'es' => [
                     'name' => 'Bateador agarre derecho'
                 ],
                 'en' => [
                     'name' => 'Right handed batter'
                 ],
                 'code' => 'right_handed_batter9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],  
             [
                 'es' => [
                     'name' => 'Bateador agarre izquierdo'
                 ],
                 'en' => [
                     'name' => 'Left handed batter'
                 ],
                 'code' => 'left_handed_batter9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Posición carga bateo'
                 ],
                 'en' => [
                     'name' => 'Batting load position'
                 ],
                 'code' => 'batting_load_position9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],  
             [
                 'es' => [
                     'name' => 'Swing y contacto bateo'
                 ],
                 'en' => [
                     'name' => 'Batting swing and contact'
                 ],
                 'code' => 'batting_swing_and_contact9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Seguimiento bateo'
                 ],
                 'en' => [
                     'name' => 'Batting follow-through'
                 ],
                 'code' => 'batting_follow-through9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],  
             [
                 'es' => [
                     'name' => 'Toque (Bunt)'
                 ],
                 'en' => [
                     'name' => 'Bunt'
                 ],
                 'code' => 'bunt9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],  
             [
                 'es' => [
                     'name' => 'Drag bunt'
                 ],
                 'en' => [
                     'name' => 'Drag bunt'
                 ],
                 'code' => 'drag_bunt9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Sacrifice bunt'
                 ],
                 'en' => [
                     'name' => 'Sacrifice bunt'
                 ],
                 'code' => 'sacrifice_bunt9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],  
             [
                 'es' => [
                     'name' => 'Push bunt'
                 ],
                 'en' => [
                     'name' => 'Push bunt'
                 ],
                 'code' => 'push_bunt9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Squeeze bunt'
                 ],
                 'en' => [
                     'name' => 'Squeeze bunt'
                 ],
                 'code' => 'squeeze_bunt9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],  
             [
                 'es' => [
                     'name' => 'Corrido de bases'
                 ],
                 'en' => [
                     'name' => 'Base running'
                 ],
                 'code' => 'base_running9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],  
             [
                 'es' => [
                     'name' => 'Sencillo'
                 ],
                 'en' => [
                     'name' => 'Hit'
                 ],
                 'code' => 'hit9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Doble'
                 ],
                 'en' => [
                     'name' => 'Double'
                 ],
                 'code' => 'double9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],  
             [
                 'es' => [
                     'name' => 'Triple'
                 ],
                 'en' => [
                     'name' => 'Triple'
                 ],
                 'code' => 'triple9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Home Run'
                 ],
                 'en' => [
                     'name' => 'Home Run'
                 ],
                 'code' => 'home_run9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],  
             [
                 'es' => [
                     'name' => 'Redondeo de bases'
                 ],
                 'en' => [
                     'name' => 'Base rounding'
                 ],
                 'code' => 'base_rounding9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],  
             [
                 'es' => [
                     'name' => 'Robo'
                 ],
                 'en' => [
                     'name' => 'Steal'
                 ],
                 'code' => 'steal9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Robo segunda base'
                 ],
                 'en' => [
                     'name' => 'Second base steal'
                 ],
                 'code' => 'second_base_steal9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Robo tercera base'
                 ],
                 'en' => [
                     'name' => 'Third base steal'
                 ],
                 'code' => 'third_base_steal9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],         
             [
                 'es' => [
                     'name' => 'Deslizamiento pierna doblada'
                 ],
                 'en' => [
                     'name' => 'Bent-leg Slide'
                 ],
                 'code' => 'bent-leg_slide9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Deslizamiento de cabeza'
                 ],
                 'en' => [
                     'name' => 'Headfirst Slide'
                 ],
                 'code' => 'headfirst_slide9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Pisa y corre (Tag up)'
                 ],
                 'en' => [
                     'name' => 'Tag up'
                 ],
                 'code' => 'tag_up9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 16
             ],
             [
                 'es' => [
                     'name' => 'Pitcher'
                 ],
                 'en' => [
                     'name' => 'Pitcher'
                 ],
                 'code' => 'pitcher9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 17
             ],
             [
                 'es' => [
                     'name' => 'Posición pitcher'
                 ],
                 'en' => [
                     'name' => 'Pitcher stance '
                 ],
                 'code' => 'pitcher_stance 9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 17
             ],
             [
                 'es' => [
                     'name' => 'Posición aproximación pitcher'
                 ],
                 'en' => [
                     'name' => 'Pitcher approach position'
                 ],
                 'code' => 'pitcher_approach_position9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 17
             ],
             [
                 'es' => [
                     'name' => 'Posición salida bola pitcher'
                 ],
                 'en' => [
                     'name' => 'Pitcher release position'
                 ],
                 'code' => 'pitcher_release_position9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 17
             ],
             [
                 'es' => [
                     'name' => 'Seguimiento pitch'
                 ],
                 'en' => [
                     'name' => 'Pitch follow-through'
                 ],
                 'code' => 'pitch_follow-through9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 17
             ],
             [
                 'es' => [
                     'name' => 'Mecánica estiramiento pitcher'
                 ],
                 'en' => [
                     'name' => 'Pitcher stretch mechanic'
                 ],
                 'code' => 'pitcher_stretch_mechanic9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 17
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento (Pitch)'
                 ],
                 'en' => [
                     'name' => 'Pitching'
                 ],
                 'code' => 'pitching9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 17
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento bola rápida'
                 ],
                 'en' => [
                     'name' => 'Fastball throwing'
                 ],
                 'code' => 'fastball_throwing9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 17
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento bola curva'
                 ],
                 'en' => [
                     'name' => 'Curveball throwing'
                 ],
                 'code' => 'curveball_throwing9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 17
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento con cambio de velocidad'
                 ],
                 'en' => [
                     'name' => 'Changeup throwing'
                 ],
                 'code' => 'changeup_throwing9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 17
             ],
             [
                 'es' => [
                     'name' => 'Catcher'
                 ],
                 'en' => [
                     'name' => 'Catcher'
                 ],
                 'code' => 'catcher9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 18
             ],
             [
                 'es' => [
                     'name' => 'Posición catcher'
                 ],
                 'en' => [
                     'name' => ' Catcher stance'
                 ],
                 'code' => ' catcher_stance9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 18
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo catcher'
                 ],
                 'en' => [
                     'name' => 'Catcher blocking'
                 ],
                 'code' => 'catcher_blocking9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 18
             ],
             [
                 'es' => [
                     'name' => 'Captura bola catcher'
                 ],
                 'en' => [
                     'name' => 'Catcher ball catching'
                 ],
                 'code' => 'catcher_ball_catching9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 18
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento desde cuclillas'
                 ],
                 'en' => [
                     'name' => 'Throwing from the crouch'
                 ],
                 'code' => 'throwing_from_the_crouch9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 18
             ],
             [
                 'es' => [
                     'name' => 'Desplazamientos jardineros'
                 ],
                 'en' => [
                     'name' => 'Fielders displacements'
                 ],
                 'code' => 'fielders_displacements9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento bola'
                 ],
                 'en' => [
                     'name' => 'Ball throwing'
                 ],
                 'code' => 'ball_throwing9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],
             [
                 'es' => [
                     'name' => 'Captura de bola'
                 ],
                 'en' => [
                     'name' => 'Ball catching'
                 ],
                 'code' => 'ball_catching9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],
             [
                 'es' => [
                     'name' => 'Captura bola rasa'
                 ],
                 'en' => [
                     'name' => 'Ground ball fielding'
                 ],
                 'code' => 'ground_ball_fielding9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],
             [
                 'es' => [
                     'name' => 'Captura bola recta'
                 ],
                 'en' => [
                     'name' => 'Line drive catching'
                 ],
                 'code' => 'line_drive_catching9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],
             [
                 'es' => [
                     'name' => 'Captura bola elavada (Fly)'
                 ],
                 'en' => [
                     'name' => 'Fly ball catching'
                 ],
                 'code' => 'fly_ball_catching9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],
             [
                 'es' => [
                     'name' => 'Doble jugada'
                 ],
                 'en' => [
                     'name' => 'Double play'
                 ],
                 'code' => 'double_play9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],
             [
                 'es' => [
                     'name' => 'Recogida de bola'
                 ],
                 'en' => [
                     'name' => 'Ball pick up'
                 ],
                 'code' => 'ball_pick_up9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],
             [
                 'es' => [
                     'name' => 'Manejo de la bola'
                 ],
                 'en' => [
                     'name' => 'Ball handling'
                 ],
                 'code' => 'ball_handling9',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],
             [
                 'es' => [
                     'name' => 'Lectura pitcher'
                 ],
                 'en' => [
                     'name' => 'Pitcher reading'
                 ],
                 'code' => 'pitcher_reading9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Corrido de bases agresivo'
                 ],
                 'en' => [
                     'name' => 'Aggressive baserunning'
                 ],
                 'code' => 'aggressive_baserunning9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Situación de bateo'
                 ],
                 'en' => [
                     'name' => 'Hitting situation'
                 ],
                 'code' => 'hitting_situation9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Batea y corre'
                 ],
                 'en' => [
                     'name' => 'Hit and run'
                 ],
                 'code' => 'hit_and_run9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Golpeo al campo contrario'
                 ],
                 'en' => [
                     'name' => 'Hit to opposite field'
                 ],
                 'code' => 'hit_to_opposite_field9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Situación de bunt'
                 ],
                 'en' => [
                     'name' => 'Bunt situation'
                 ],
                 'code' => 'bunt_situation9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Situación de robo'
                 ],
                 'en' => [
                     'name' => 'Steal situation'
                 ],
                 'code' => 'steal_situation9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Robo retrasado'
                 ],
                 'en' => [
                     'name' => 'Delayed steal'
                 ],
                 'code' => 'delayed_steal9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Robo doble'
                 ],
                 'en' => [
                     'name' => 'Double steal'
                 ],
                 'code' => 'double_steal9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Primera y tercera jugada'
                 ],
                 'en' => [
                     'name' => 'First and third play'
                 ],
                 'code' => 'first_and_third_play9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Abrir 1B (Lead off 1B)'
                 ],
                 'en' => [
                     'name' => 'Lead off 1B'
                 ],
                 'code' => 'lead_off_1B_9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Abrir 2B (Lead off 2B)'
                 ],
                 'en' => [
                     'name' => 'Lead off 2B'
                 ],
                 'code' => 'lead_off_2B_9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Abrir 3B (Lead off 3B)'
                 ],
                 'en' => [
                     'name' => 'Lead off 3B'
                 ],
                 'code' => 'lead_off_3B_9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Fly de sacrificio'
                 ],
                 'en' => [
                     'name' => 'Sacrifice fly'
                 ],
                 'code' => 'sacrifice_fly9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Enfrentarse cuenta 3-0'
                 ],
                 'en' => [
                     'name' => 'Take on 3-0 count'
                 ],
                 'code' => 'take_on_3-0_count9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Squeeze play'
                 ],
                 'en' => [
                     'name' => 'Squeeze play'
                 ],
                 'code' => 'squeeze_play9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Timing bateo'
                 ],
                 'en' => [
                     'name' => 'Batting timing'
                 ],
                 'code' => 'batting_timing9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 20
             ],
             [
                 'es' => [
                     'name' => 'Elección lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Pitch selection'
                 ],
                 'code' => 'pitch_selection9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 21
             ],
             [
                 'es' => [
                     'name' => 'Ubicación lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Pitching location'
                 ],
                 'code' => 'pitching_location9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 21
             ],       
             [
                 'es' => [
                     'name' => 'Velocidad lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Pitching speed'
                 ],
                 'code' => 'pitching_speed9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 21
             ],       
             [
                 'es' => [
                     'name' => 'Pickoff pitcher'
                 ],
                 'en' => [
                     'name' => 'Pitcher Pickoff'
                 ],
                 'code' => 'pitcher_Pickoff9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 21
             ],       
             [
                 'es' => [
                     'name' => 'Pitch descontrolado'
                 ],
                 'en' => [
                     'name' => 'Wild Pitch'
                 ],
                 'code' => 'wild_pitch9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 21
             ],       
             [
                 'es' => [
                     'name' => 'Timing lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Pitch timing'
                 ],
                 'code' => 'pitch_timing9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 21
             ],       
             [
                 'es' => [
                     'name' => 'Pickoff catcher'
                 ],
                 'en' => [
                     'name' => 'Catcher Pickoff'
                 ],
                 'code' => 'catcher_pickoff9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 22
             ],       
             [
                 'es' => [
                     'name' => 'Posicionamiento catcher'
                 ],
                 'en' => [
                     'name' => 'Catcher positioning'
                 ],
                 'code' => 'catcher_positioning9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 22
             ],       
             [
                 'es' => [
                     'name' => 'Timing catcher'
                 ],
                 'en' => [
                     'name' => 'Catcher timing'
                 ],
                 'code' => 'catcher_timing9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 22
             ],       
             [
                 'es' => [
                     'name' => 'Posicionamiento jardineros'
                 ],
                 'en' => [
                     'name' => 'Fielding positioning'
                 ],
                 'code' => 'fielding_positioning9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Jugador cuadro (Infield)'
                 ],
                 'en' => [
                     'name' => 'Infield'
                 ],
                 'code' => 'infield9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Jardinero (Outfield)'
                 ],
                 'en' => [
                     'name' => 'Outfield'
                 ],
                 'code' => 'outfield9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Respaldo defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive backup'
                 ],
                 'code' => 'defensive-backup9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Doble jugada'
                 ],
                 'en' => [
                     'name' => 'Double play'
                 ],
                 'code' => 'double_play9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Coverage'
                 ],
                 'code' => 'coverage9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Cobertura bunt'
                 ],
                 'en' => [
                     'name' => 'Bunt coverage'
                 ],
                 'code' => 'bunt_coverage9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Cobertura área'
                 ],
                 'en' => [
                     'name' => 'Area coverage'
                 ],
                 'code' => 'area_coverage9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Cobertura robo'
                 ],
                 'en' => [
                     'name' => 'Steal coverage'
                 ],
                 'code' => 'steal_coverage9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Cobertura doble robo'
                 ],
                 'en' => [
                     'name' => 'Double steal coverage'
                 ],
                 'code' => 'double_steal_coverage9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Relevo'
                 ],
                 'en' => [
                     'name' => 'Relay'
                 ],
                 'code' => 'relay9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Corte'
                 ],
                 'en' => [
                     'name' => 'Cutoff'
                 ],
                 'code' => 'cutoff9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Forzar jugada'
                 ],
                 'en' => [
                     'name' => 'Force play'
                 ],
                 'code' => 'force_play9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Rundowns (Pickle)'
                 ],
                 'en' => [
                     'name' => 'Rundowns (Pickle)'
                 ],
                 'code' => 'rundowns9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Profundidad normal'
                 ],
                 'en' => [
                     'name' => 'Normal depth'
                 ],
                 'code' => 'normal_depth9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Profundidad juego doble'
                 ],
                 'en' => [
                     'name' => 'Double play depth'
                 ],
                 'code' => 'double_play_depth9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Dentro infield'
                 ],
                 'en' => [
                     'name' => 'Infield in'
                 ],
                 'code' => 'infield_in9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Sin dobles'
                 ],
                 'en' => [
                     'name' => 'No doubles'
                 ],
                 'code' => 'no_doubles9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Bases vacias'
                 ],
                 'en' => [
                     'name' => 'Bases empty'
                 ],
                 'code' => 'bases_empty9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Corredor en 1B'
                 ],
                 'en' => [
                     'name' => 'Runner at 1B'
                 ],
                 'code' => 'runner_at_1B_9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Corredor en 1B y 2B'
                 ],
                 'en' => [
                     'name' => 'Runner at 1B and 2B'
                 ],
                 'code' => 'runner_at_1B_and_2B_9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Corredor en 1B y 3B'
                 ],
                 'en' => [
                     'name' => 'Runner at 1B and 3B'
                 ],
                 'code' => 'runner_at_1B_and_3B_9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
             [
                 'es' => [
                     'name' => 'Bases cargadas'
                 ],
                 'en' => [
                     'name' => 'Bases loaded'
                 ],
                 'code' => 'bases_loaded9',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
         ];
     }
     private function targetsCricket()
     {
         return [
             [
                 'es' => [
                     'name' => 'Desplazamientos bateadores'
                 ],
                 'en' => [
                     'name' => 'Batters displacements'
                 ],
                 'code' => 'batters_displacements_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],
             [
                 'es' => [
                     'name' => 'Agarre'
                 ],
                 'en' => [
                     'name' => 'Grip'
                 ],
                 'code' => 'grip_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],
             [
                 'es' => [
                     'name' => 'Posición de bateo'
                 ],
                 'en' => [
                     'name' => 'Batting stance'
                 ],
                 'code' => 'batting_stance_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],         
             [
                 'es' => [
                     'name' => 'Bateador agarre derecho'
                 ],
                 'en' => [
                     'name' => 'Right handed batman'
                 ],
                 'code' => 'right_handed_batman_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],
             [
                 'es' => [
                     'name' => 'Bateador agarre izquierdo'
                 ],
                 'en' => [
                     'name' => 'Left handed batman'
                 ],
                 'code' => 'left_handed_batman_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],
             [
                 'es' => [
                     'name' => 'Bateo'
                 ],
                 'en' => [
                     'name' => 'Batting '
                 ],
                 'code' => 'batting _10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],         
             [
                 'es' => [
                     'name' => 'Elevación bate (Backlift)'
                 ],
                 'en' => [
                     'name' => ' Backlift'
                 ],
                 'code' => 'backlift_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],
             [
                 'es' => [
                     'name' => 'Movimiento bateo (Swing)'
                 ],
                 'en' => [
                     'name' => 'Bat swing'
                 ],
                 'code' => 'bat_swing_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],
             [
                 'es' => [
                     'name' => 'Seguimiento bateo'
                 ],
                 'en' => [
                     'name' => 'Batting follow-through'
                 ],
                 'code' => 'batting_follow-through_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],         
             [
                 'es' => [
                     'name' => 'Golpes pie trasero'
                 ],
                 'en' => [
                     'name' => 'Back foot strokes'
                 ],
                 'code' => 'back_foot_strokes_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],
             [
                 'es' => [
                     'name' => 'Golpes pie delantero'
                 ],
                 'en' => [
                     'name' => 'Front foot strokes'
                 ],
                 'code' => 'front_foot_strokes_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],
             [
                 'es' => [
                     'name' => 'Carrera entre wickets'
                 ],
                 'en' => [
                     'name' => 'Running between wickets'
                 ],
                 'code' => 'running_between_wickets_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],         
             [
                 'es' => [
                     'name' => 'Deslizamientos (carreras rápidas)'
                 ],
                 'en' => [
                     'name' => 'Sliding (quick runs)'
                 ],
                 'code' => 'sliding_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 24
             ],
             [
                 'es' => [
                     'name' => 'Bowler'
                 ],
                 'en' => [
                     'name' => 'Bowler'
                 ],
                 'code' => 'bowler_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 25
             ],
             [
                 'es' => [
                     'name' => 'Posición bowler'
                 ],
                 'en' => [
                     'name' => 'Bowler stance'
                 ],
                 'code' => 'bowler_stance_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 25
             ],         
             [
                 'es' => [
                     'name' => 'Acción bowler'
                 ],
                 'en' => [
                     'name' => 'Bowling action'
                 ],
                 'code' => 'bowling_action_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 25
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento (Bowl)'
                 ],
                 'en' => [
                     'name' => 'Bowling'
                 ],
                 'code' => 'bowling_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 25
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento por encima de la cabeza'
                 ],
                 'en' => [
                     'name' => 'Bowling around the head'
                 ],
                 'code' => 'bowling_around_the_head_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 25
             ],         
             [
                 'es' => [
                     'name' => 'Lanzamiento lateral'
                 ],
                 'en' => [
                     'name' => 'Sidearm bowling'
                 ],
                 'code' => 'sidearm_bowling_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 25
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento 3/4 brazo'
                 ],
                 'en' => [
                     'name' => '3/4 arm bowling'
                 ],
                 'code' => '3/4_arm_bowling_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 25
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento rápido'
                 ],
                 'en' => [
                     'name' => 'Fast bowling'
                 ],
                 'code' => 'fast_bowling_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 25
             ],         
             [
                 'es' => [
                     'name' => 'Lanzamiento ritmo medio'
                 ],
                 'en' => [
                     'name' => 'Medium pace bowling'
                 ],
                 'code' => 'medium_pace_bowling_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 25
             ],
             [
                 'es' => [
                     'name' => 'Lanzamiento giratorio'
                 ],
                 'en' => [
                     'name' => 'Spin bowling'
                 ],
                 'code' => 'spin_bowling_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 25
             ],         
             [
                 'es' => [
                     'name' => 'Lanzamiento a wickets'
                 ],
                 'en' => [
                     'name' => ' Bowling at the wickets'
                 ],
                 'code' => 'bowling_at_the_wickets_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 25
             ],
             [
                 'es' => [
                     'name' => 'Wicket-keeper'
                 ],
                 'en' => [
                     'name' => 'Wicket-keeper'
                 ],
                 'code' => 'wicket-keeper_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 26
             ],         
             [
                 'es' => [
                     'name' => 'Posición wicket-keeper'
                 ],
                 'en' => [
                     'name' => 'Wicket-keeper stance'
                 ],
                 'code' => 'wicket-keeper_stance_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 26
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo wicket-keeper'
                 ],
                 'en' => [
                     'name' => 'Wicket-keeper blocking'
                 ],
                 'code' => 'wicket-keeper_blocking_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 26
             ],         
             [
                 'es' => [
                     'name' => 'Captura bola wicket-keeper'
                 ],
                 'en' => [
                     'name' => 'Wicket-keeper ball catching'
                 ],
                 'code' => 'wicket-keeper_ball_catching_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 26
             ],
             [
                 'es' => [
                     'name' => 'Captura agarre inverso'
                 ],
                 'en' => [
                     'name' => 'Reverse catching grip'
                 ],
                 'code' => 'reverse_catching_grip_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 26
             ],         
             [
                 'es' => [
                     'name' => 'Captura agarre ortodoxo'
                 ],
                 'en' => [
                     'name' => 'Orthodox catching grip'
                 ],
                 'code' => 'orthodox_catching_grip_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 26
             ],         
             [
                 'es' => [
                     'name' => 'Lanzamiento desde cuclillas'
                 ],
                 'en' => [
                     'name' => 'Throwing from the crouch'
                 ],
                 'code' => 'throwing_from_the_crouch_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 26
             ],           
             [
                 'es' => [
                     'name' => 'Desplazamientos jardineros'
                 ],
                 'en' => [
                     'name' => 'Fielders displacements'
                 ],
                 'code' => 'fielders_displacements_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],         
             [
                 'es' => [
                     'name' => 'Lanzamiento bola'
                 ],
                 'en' => [
                     'name' => 'Ball throwing'
                 ],
                 'code' => 'ball_throwing_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],         
             [
                 'es' => [
                     'name' => 'Captura de bola'
                 ],
                 'en' => [
                     'name' => 'Ball catching'
                 ],
                 'code' => 'ball_catching_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],         
             [
                 'es' => [
                     'name' => 'Captura bola rasa'
                 ],
                 'en' => [
                     'name' => 'Ground ball fielding'
                 ],
                 'code' => 'ground_ball_fielding_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],         
             [
                 'es' => [
                     'name' => 'Captura bola recta'
                 ],
                 'en' => [
                     'name' => 'Line drive catching'
                 ],
                 'code' => 'line_drive_catching_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],         
             [
                 'es' => [
                     'name' => 'Captura bola elavada'
                 ],
                 'en' => [
                     'name' => 'High ball catching'
                 ],
                 'code' => 'high_ball_catching_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],         
             [
                 'es' => [
                     'name' => 'Recogida de bola'
                 ],
                 'en' => [
                     'name' => 'Ball pick up'
                 ],
                 'code' => 'ball_pick_up_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],         
             [
                 'es' => [
                     'name' => 'Manejo de la bola'
                 ],
                 'en' => [
                     'name' => 'Ball handling'
                 ],
                 'code' => 'ball_handling_10',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 19
             ],                
             [
                 'es' => [
                     'name' => 'Lectura bowler'
                 ],
                 'en' => [
                     'name' => 'Bowler reading'
                 ],
                 'code' => 'bowler_reading_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],         
             [
                 'es' => [
                     'name' => 'Situación de bateo'
                 ],
                 'en' => [
                     'name' => 'Batting situation'
                 ],
                 'code' => 'batting_situation_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],           
             [
                 'es' => [
                     'name' => 'Batea y corre'
                 ],
                 'en' => [
                     'name' => 'Hit and run'
                 ],
                 'code' => 'hit_and_run_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],         
             [
                 'es' => [
                     'name' => 'Golpeo al campo contrario'
                 ],
                 'en' => [
                     'name' => 'Hit to opposite field'
                 ],
                 'code' => 'hit_to_opposite_field_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],         
             [
                 'es' => [
                     'name' => 'Bateo drive (recto)'
                 ],
                 'en' => [
                     'name' => 'Drive batting (straight)'
                 ],
                 'code' => 'drive_batting_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],           
             [
                 'es' => [
                     'name' => 'Bateo on drive'
                 ],
                 'en' => [
                     'name' => 'On drive batting'
                 ],
                 'code' => 'on_drive_batting_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],         
             [
                 'es' => [
                     'name' => 'Bateo off drive'
                 ],
                 'en' => [
                     'name' => 'Off drive batting '
                 ],
                 'code' => 'off_drive_batting_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],         
             [
                 'es' => [
                     'name' => 'Bateo cover drive'
                 ],
                 'en' => [
                     'name' => 'Cover drive batting'
                 ],
                 'code' => 'cover_drive_batting_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],           
             [
                 'es' => [
                     'name' => 'Bateo square cut'
                 ],
                 'en' => [
                     'name' => 'Square cut batting'
                 ],
                 'code' => 'square_cut_batting_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],         
             [
                 'es' => [
                     'name' => 'Bateo late cut'
                 ],
                 'en' => [
                     'name' => 'Late cut batting'
                 ],
                 'code' => 'late_cut_batting_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],         
             [
                 'es' => [
                     'name' => 'Bateo midwicket (Tirón)'
                 ],
                 'en' => [
                     'name' => 'Midwicket batting (Pull)'
                 ],
                 'code' => 'midwicket_batting_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],           
             [
                 'es' => [
                     'name' => 'Bateo square leg (Gancho)'
                 ],
                 'en' => [
                     'name' => 'Square leg batting (Hook)'
                 ],
                 'code' => 'square_leg_batting_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],         
             [
                 'es' => [
                     'name' => 'Bateo fine leg (Ojeada)'
                 ],
                 'en' => [
                     'name' => '  Fine leg batting (Glance)'
                 ],
                 'code' => 'fine_leg_batting_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],         
             [
                 'es' => [
                     'name' => 'Timing bateo'
                 ],
                 'en' => [
                     'name' => 'Batting timing'
                 ],
                 'code' => 'batting_timing_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 27
             ],         
             [
                 'es' => [
                     'name' => 'Elección lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Bowling selection'
                 ],
                 'code' => 'bowling_selection_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],           
             [
                 'es' => [
                     'name' => 'Ubicación lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Bowling location'
                 ],
                 'code' => 'bowling_location_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],         
             [
                 'es' => [
                     'name' => 'Velocidad lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Bowling speed '
                 ],
                 'code' => 'bowling_speed_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],         
             [
                 'es' => [
                     'name' => 'Pickoff bowler'
                 ],
                 'en' => [
                     'name' => 'Bowler Pickoff'
                 ],
                 'code' => 'bowler_Pickoff_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],         
             [
                 'es' => [
                     'name' => 'Bote off break'
                 ],
                 'en' => [
                     'name' => 'Off break bounce'
                 ],
                 'code' => 'off_break_bounce_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],           
             [
                 'es' => [
                     'name' => 'Bote leg break'
                 ],
                 'en' => [
                     'name' => 'Leg break bounce'
                 ],
                 'code' => 'leg_break_bounce_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],         
             [
                 'es' => [
                     'name' => 'Inswing (bola curva)'
                 ],
                 'en' => [
                     'name' => 'Inswing (curve ball)'
                 ],
                 'code' => 'inswing_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],         
             [
                 'es' => [
                     'name' => 'Outswing (bola deslizante)'
                 ],
                 'en' => [
                     'name' => 'Outswing (slider ball)'
                 ],
                 'code' => 'outswing_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],           
             [
                 'es' => [
                     'name' => 'Lanzamiento corto (salto largo)'
                 ],
                 'en' => [
                     'name' => 'Short bowling (Long hop)'
                 ],
                 'code' => 'short_bowling_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],         
             [
                 'es' => [
                     'name' => 'Lanzamiento sobre base'
                 ],
                 'en' => [
                     'name' => 'Over-pitch bowling'
                 ],
                 'code' => 'over-pitch_bowling_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],         
             [
                 'es' => [
                     'name' => 'Lanzamiento buena distancia'
                 ],
                 'en' => [
                     'name' => 'Good length bowling'
                 ],
                 'code' => 'good_length_bowling_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],         
             [
                 'es' => [
                     'name' => 'Lanzamiento largo'
                 ],
                 'en' => [
                     'name' => 'Long bowling (Full toss)'
                 ],
                 'code' => 'long_bowling_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],           
             [
                 'es' => [
                     'name' => 'Timing lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Bowling timing'
                 ],
                 'code' => 'bowling_timing_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 28
             ],         
             [
                 'es' => [
                     'name' => 'Pickoff receptor'
                 ],
                 'en' => [
                     'name' => 'Wicket-keeper pickoff'
                 ],
                 'code' => 'wicket-keeper_pickoff_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 29
             ],         
             [
                 'es' => [
                     'name' => 'Posicionamiento receptor'
                 ],
                 'en' => [
                     'name' => 'Wicket-keeper positioning'
                 ],
                 'code' => 'wicket-keeper_positioning_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 29
             ],         
             [
                 'es' => [
                     'name' => 'Timing receptor'
                 ],
                 'en' => [
                     'name' => 'Wicket-keeper timing'
                 ],
                 'code' => 'wicket-keeper_timing_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 29
             ],           
             [
                 'es' => [
                     'name' => 'Posicionamiento jardineros'
                 ],
                 'en' => [
                     'name' => 'Fielding positioning'
                 ],
                 'code' => 'fielding_positioning_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Infield'
                 ],
                 'en' => [
                     'name' => 'Infield'
                 ],
                 'code' => 'infield_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Midfield'
                 ],
                 'en' => [
                     'name' => 'Midfield'
                 ],
                 'code' => 'midfield_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Outfield'
                 ],
                 'en' => [
                     'name' => 'Outfield'
                 ],
                 'code' => 'outfield_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Respaldo defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive backup'
                 ],
                 'code' => 'defensive_backup_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Coverage'
                 ],
                 'code' => 'coverage_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Forzar jugada'
                 ],
                 'en' => [
                     'name' => 'Force play'
                 ],
                 'code' => 'force_play_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Rundowns (Pickle)'
                 ],
                 'en' => [
                     'name' => 'Rundowns (Pickle)'
                 ],
                 'code' => 'rundowns_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Wicketkeeper'
                 ],
                 'en' => [
                     'name' => 'Wicketkeeper'
                 ],
                 'code' => 'wicketkeeper_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Slip'
                 ],
                 'en' => [
                     'name' => 'Slip'
                 ],
                 'code' => 'slip_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Gully'
                 ],
                 'en' => [
                     'name' => 'Gully'
                 ],
                 'code' => 'gully_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Point'
                 ],
                 'en' => [
                     'name' => 'Point'
                 ],
                 'code' => 'point_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Cover'
                 ],
                 'en' => [
                     'name' => 'Cover'
                 ],
                 'code' => 'cover_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Extra cover'
                 ],
                 'en' => [
                     'name' => 'Extra cover'
                 ],
                 'code' => 'extra_cover_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Mid off'
                 ],
                 'en' => [
                     'name' => 'Mid off'
                 ],
                 'code' => 'mid_off_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Mid on'
                 ],
                 'en' => [
                     'name' => 'Mid on'
                 ],
                 'code' => 'mid_on_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],         
             [
                 'es' => [
                     'name' => 'Square leg'
                 ],
                 'en' => [
                     'name' => 'Square leg'
                 ],
                 'code' => 'square_leg_10',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 23
             ],       
         ];
     }
     private function targetsFieldHockey()
     {
         return [
             [
                 'es' => [
                     'name' => 'Posición ofensiva'
                 ],
                 'en' => [
                     'name' => 'Attacking stance'
                 ],
                 'code' => 'attacking_stance_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Trabajo de pies en ataque'
                 ],
                 'en' => [
                     'name' => 'Attack footwork'
                 ],
                 'code' => 'attack_footwork_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Desplazamientos ofensivos '
                 ],
                 'en' => [
                     'name' => 'Offensive displacements'
                 ],
                 'code' => 'offensive_displacements_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Manejo del stick'
                 ],
                 'en' => [
                     'name' => 'Stick handling'
                 ],
                 'code' => 'stick_handling_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Protección de la bola'
                 ],
                 'en' => [
                     'name' => 'Ball protection'
                 ],
                 'code' => 'ball_protection_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Conducción de bola'
                 ],
                 'en' => [
                     'name' => 'Ball driving'
                 ],
                 'code' => 'ball_driving_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Finta (Dribbling)'
                 ],
                 'en' => [
                     'name' => 'Fake (Dribbling)'
                 ],
                 'code' => 'fake_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Pase'
                 ],
                 'en' => [
                     'name' => 'Pass'
                 ],
                 'code' => 'pass_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Recepción (Control bola)'
                 ],
                 'en' => [
                     'name' => 'Reception (Ball control)'
                 ],
                 'code' => 'reception_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Tiro'
                 ],
                 'en' => [
                     'name' => 'Shot'
                 ],
                 'code' => 'shot_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Tiro libre'
                 ],
                 'en' => [
                     'name' => 'Free hit'
                 ],
                 'code' => 'free_hit_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Penalti stroke (Shoout out)'
                 ],
                 'en' => [
                     'name' => 'Penalty stroke (Shoout out)'
                 ],
                 'code' => 'penalty_stroke_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Posición defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive stance'
                 ],
                 'code' => 'defensive_stance_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Trabajo de pies defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive footwork'
                 ],
                 'code' => 'defensive_footwork_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Desplazamientos defensivos'
                 ],
                 'en' => [
                     'name' => 'Defensive displacements'
                 ],
                 'code' => 'defensive_displacements_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Entrada'
                 ],
                 'en' => [
                     'name' => 'Tackle'
                 ],
                 'code' => 'tackle_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Quite de bola'
                 ],
                 'en' => [
                     'name' => 'Shave'
                 ],
                 'code' => 'shave_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Pinche bola'
                 ],
                 'en' => [
                     'name' => 'Ball deflection'
                 ],
                 'code' => 'ball_deflection_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Bloqueo de tiro'
                 ],
                 'en' => [
                     'name' => 'Blocking shot'
                 ],
                 'code' => 'blocking_shot_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Despeje de la bola'
                 ],
                 'en' => [
                     'name' => 'Ball clearance'
                 ],
                 'code' => 'ball_clearance_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Posiciones básicas'
                 ],
                 'en' => [
                     'name' => 'Basic stances '
                 ],
                 'code' => 'basic_stances_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Movimientos básicos'
                 ],
                 'en' => [
                     'name' => 'Basic drills'
                 ],
                 'code' => 'basic_drills_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Recuperación posición básica'
                 ],
                 'en' => [
                     'name' => 'Recovey to basic stance'
                 ],
                 'code' => 'recovey_to_basic_stance_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Despeje de bola'
                 ],
                 'en' => [
                     'name' => 'Ball clearance'
                 ],
                 'code' => 'ball_clearance_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Entrada deslizante'
                 ],
                 'en' => [
                     'name' => 'Slide tacking'
                 ],
                 'code' => 'slide_tacking_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Parada aérea'
                 ],
                 'en' => [
                     'name' => 'Aereal save'
                 ],
                 'code' => 'aereal_save_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Parada suelo'
                 ],
                 'en' => [
                     'name' => 'Ground save '
                 ],
                 'code' => 'ground_save_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Estirada'
                 ],
                 'en' => [
                     'name' => 'Dive save'
                 ],
                 'code' => 'dive_save_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Parada con el cuerpo'
                 ],
                 'en' => [
                     'name' => 'Body save'
                 ],
                 'code' => 'body_save_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Parada penalti stroke'
                 ],
                 'en' => [
                     'name' => 'Penalty stroke save'
                 ],
                 'code' => 'penalty_stroke_save_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Golpeo de bola'
                 ],
                 'en' => [
                     'name' => 'Ball kick'
                 ],
                 'code' => 'ball_kick_11',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Estrategia ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive strategy'
                 ],
                 'code' => 'offensive_strategy_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque organizado'
                 ],
                 'en' => [
                     'name' => 'Organized attack'
                 ],
                 'code' => 'organized_attack_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Contraataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack'
                 ],
                 'code' => 'counter_attack_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ritmo de juego '
                 ],
                 'en' => [
                     'name' => 'Pace of play'
                 ],
                 'code' => 'pace_of_play_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque en superioridad numérica '
                 ],
                 'en' => [
                     'name' => 'Attack in numerical superiority'
                 ],
                 'code' => 'attack_in_numerical_superiority_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical inferiority'
                 ],
                 'code' => 'attack_in_numerical_inferiority_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical equality'
                 ],
                 'code' => 'attack_in_numerical_equality_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Penalti corner'
                 ],
                 'en' => [
                     'name' => 'Penalty corner'
                 ],
                 'code' => 'penalty_corner_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Shoot out (1vPortero)'
                 ],
                 'en' => [
                     'name' => 'Shoot out (1vGoalkeeper)'
                 ],
                 'code' => 'shoot_out_(1vgoalkeeper)_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-5-3-2'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-5-3-2'
                 ],
                 'code' => 'offensive_system_1-5-3-2_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-5-2-3'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-5-2-3'
                 ],
                 'code' => 'offensive_system_1-5-2-3_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-5-4-1'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-5-4-1'
                 ],
                 'code' => 'offensive_system_1-5-4-1_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4-4-2'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-4-4-2'
                 ],
                 'code' => 'offensive_system_1-4-4-2_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4-3-3'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-4-3-3'
                 ],
                 'code' => 'offensive_system_1-4-3-3_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4-2-4'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-4-2-4'
                 ],
                 'code' => 'offensive_system_1-4-2-4_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-3-4-3'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-3-4-3'
                 ],
                 'code' => 'offensive_system_1-3-4-3_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-3-3-4'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-3-3-4'
                 ],
                 'code' => 'offensive_system_1-3-3-4_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-3-3-3-1'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-3-3-3-1'
                 ],
                 'code' => 'offensive_system_1-3-3-3-1_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Circulación de la bola'
                 ],
                 'en' => [
                     'name' => 'Ball circulation'
                 ],
                 'code' => 'ball_circulation_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Circulación de jugadores'
                 ],
                 'en' => [
                     'name' => 'Player circulation '
                 ],
                 'code' => 'player_circulation__11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Construcción jugada'
                 ],
                 'en' => [
                     'name' => 'Playboy construction'
                 ],
                 'code' => 'playbook_construction_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Amplitud'
                 ],
                 'en' => [
                     'name' => 'Wide play'
                 ],
                 'code' => 'wide_play_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Apoyo ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive supporting play'
                 ],
                 'code' => 'offensive_supporting_play_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Desdoblamiento'
                 ],
                 'en' => [
                     'name' => 'Overlap'
                 ],
                 'code' => 'overlap_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Superar línea de presión '
                 ],
                 'en' => [
                     'name' => 'Overcome pressure line'
                 ],
                 'code' => 'overcome_pressure_line_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Mobilidad'
                 ],
                 'en' => [
                     'name' => 'Mobility'
                 ],
                 'code' => 'mobility_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Pase y va'
                 ],
                 'en' => [
                     'name' => 'Give and go'
                 ],
                 'code' => 'give_and_go_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Fijación'
                 ],
                 'en' => [
                     'name' => 'Fixing'
                 ],
                 'code' => 'fixing_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Relevo ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive relay'
                 ],
                 'code' => 'offensive_relay_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Penetrar el círculo'
                 ],
                 'en' => [
                     'name' => 'Circle entry'
                 ],
                 'code' => 'circle_entry_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Finalización'
                 ],
                 'en' => [
                     'name' => 'Finishing'
                 ],
                 'code' => 'finishing_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Cambio de orientación'
                 ],
                 'en' => [
                     'name' => 'Switch play'
                 ],
                 'code' => 'switch_play_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Línea de pase '
                 ],
                 'en' => [
                     'name' => 'Passing line'
                 ],
                 'code' => 'passing_line_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Espacios libres'
                 ],
                 'en' => [
                     'name' => 'Creating space'
                 ],
                 'code' => 'creating_space_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Desmarque'
                 ],
                 'en' => [
                     'name' => 'Uncheck'
                 ],
                 'code' => 'uncheck_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Posesión de la bola'
                 ],
                 'en' => [
                     'name' => 'Ball possession'
                 ],
                 'code' => 'ball_possession_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Zona profunda'
                 ],
                 'en' => [
                     'name' => 'Depth zone'
                 ],
                 'code' => 'depth_zone_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Acción combinada'
                 ],
                 'en' => [
                     'name' => 'Combination play'
                 ],
                 'code' => 'combination_play_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Salida de la bola'
                 ],
                 'en' => [
                     'name' => 'Build up'
                 ],
                 'code' => 'build_up_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Posición de guardia'
                 ],
                 'en' => [
                     'name' => 'Guard position'
                 ],
                 'code' => 'guard_position_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Cambio de sistema ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive system switching'
                 ],
                 'code' => 'offensive_system_switching_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque contra defensa zonal'
                 ],
                 'en' => [
                     'name' => 'Attack against zone defense'
                 ],
                 'code' => 'attack_against_zone_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque contra defensa individual'
                 ],
                 'en' => [
                     'name' => 'Attack against individual defense'
                 ],
                 'code' => 'attack_against_individual_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque contra defensa mixta'
                 ],
                 'en' => [
                     'name' => 'Attack against mixed defense'
                 ],
                 'code' => 'attack_against_mixed_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque contra defensa presionante'
                 ],
                 'en' => [
                     'name' => 'Attack against pressure defense'
                 ],
                 'code' => 'attack_against_pressure_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Transición ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive transition'
                 ],
                 'code' => 'offensive_transition_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Escapada'
                 ],
                 'en' => [
                     'name' => 'Breakaway'
                 ],
                 'code' => 'breakaway_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Estrategia defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive strategy'
                 ],
                 'code' => 'defensive_strategy_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Posicionamiento defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive positioning'
                 ],
                 'code' => 'defensive_positioning_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa individual'
                 ],
                 'en' => [
                     'name' => 'Individual defense'
                 ],
                 'code' => 'individual_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa en zona'
                 ],
                 'en' => [
                     'name' => 'Zone defense'
                 ],
                 'code' => 'zone_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa mixta'
                 ],
                 'en' => [
                     'name' => 'Mixed defense'
                 ],
                 'code' => 'mixed_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical superiority'
                 ],
                 'code' => 'defense_in_numerical_superiority_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical inferiority'
                 ],
                 'code' => 'defense_in_numerical_inferiority_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa en igualdad numérica '
                 ],
                 'en' => [
                     'name' => 'Defense in numerical equality'
                 ],
                 'code' => 'defense_in_numerical_equality_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-5-3-2'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-5-3-2'
                 ],
                 'code' => 'defensive_system_1-5-3-2_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-5-2-3  '
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-5-2-3'
                 ],
                 'code' => 'defensive_system_1-5-2-3_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-5-4-1  '
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-5-4-1'
                 ],
                 'code' => 'defensive_system_1-5-4-1_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-4-4-2'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-4-4-2'
                 ],
                 'code' => 'defensive_system_1-4-4-2_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-4-3-3'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-4-3-3'
                 ],
                 'code' => 'defensive_system_1-4-3-3_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-4-2-4'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-4-2-4'
                 ],
                 'code' => 'defensive_system_1-4-2-4_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-3-4-3'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-3-4-3'
                 ],
                 'code' => 'defensive_system_1-3-4-3_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-3-3-4'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-3-3-4'
                 ],
                 'code' => 'defensive_system_1-3-3-4_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-3-3-3-1'
                 ],
                 'en' => [
                     'name' => 'Defensive system 1-3-3-3-1'
                 ],
                 'code' => 'defensive_system_1-3-3-3-1_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Marcaje'
                 ],
                 'en' => [
                     'name' => 'Marking'
                 ],
                 'code' => 'marking_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Covering'
                 ],
                 'code' => 'covering_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Relevo defensivo '
                 ],
                 'en' => [
                     'name' => 'Defensive relay '
                 ],
                 'code' => 'defensive_relay_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Basculación'
                 ],
                 'en' => [
                     'name' => 'Tilt shift'
                 ],
                 'code' => 'tilt_shift_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Presión'
                 ],
                 'en' => [
                     'name' => 'Pressing'
                 ],
                 'code' => 'pressing_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Carga'
                 ],
                 'en' => [
                     'name' => 'Shoulder barge'
                 ],
                 'code' => 'shoulder_barge_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Interceptación'
                 ],
                 'en' => [
                     'name' => 'Interception'
                 ],
                 'code' => 'interception_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Intensidad defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive intensity'
                 ],
                 'code' => 'defensive_intensity_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa jugadas bola parada'
                 ],
                 'en' => [
                     'name' => 'Set pieces defense'
                 ],
                 'code' => 'set_pieces_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Línea defensiva '
                 ],
                 'en' => [
                     'name' => 'Defensive line'
                 ],
                 'code' => 'defensive_line_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa contrataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack defense'
                 ],
                 'code' => 'counter_attack_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Ayuda defensiva'
                 ],
                 'en' => [
                     'name' => 'Help defense'
                 ],
                 'code' => 'help_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Pérdida y recuperación de bola'
                 ],
                 'en' => [
                     'name' => 'Turnover and ball recovery'
                 ],
                 'code' => 'turnover_and_ball_recovery_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Orientación respecto al contrario'
                 ],
                 'en' => [
                     'name' => 'Opposite orientation'
                 ],
                 'code' => 'opposite_orientation_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Cambio de sistema defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive system switching'
                 ],
                 'code' => 'defensive_system_switching_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Transición defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive transition'
                 ],
                 'code' => 'defensive_transition_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Cubrir espacios'
                 ],
                 'en' => [
                     'name' => 'Covering spaces '
                 ],
                 'code' => 'covering_spaces__11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defender el círculo '
                 ],
                 'en' => [
                     'name' => 'Circle defense'
                 ],
                 'code' => 'circle_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Equilibrio linea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line balance'
                 ],
                 'code' => 'defensive_line_balance_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],     
             [
                 'es' => [
                     'name' => 'Posicionamiento'
                 ],
                 'en' => [
                     'name' => 'Positioning'
                 ],
                 'code' => 'positioning_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],              
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Coverage'
                 ],
                 'code' => 'coverage_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],              
             [
                 'es' => [
                     'name' => 'Defensa shoot out (1v1)'
                 ],
                 'en' => [
                     'name' => 'Shoot out defense (1v1)'
                 ],
                 'code' => 'shoot_out_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],    
             [
                 'es' => [
                     'name' => 'Defensa penalti corner'
                 ],
                 'en' => [
                     'name' => 'Penalty corner defense'
                 ],
                 'code' => 'penalty_corner_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],    
             [
                 'es' => [
                     'name' => 'Defensa escapada (1v1)'
                 ],
                 'en' => [
                     'name' => 'Breakaway defense (1v1)'
                 ],
                 'code' => 'breakaway_defense_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],    
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],    
             [
                 'es' => [
                     'name' => 'Trabajo por puestos'
                 ],
                 'en' => [
                     'name' => 'Position specific training'
                 ],
                 'code' => 'position_specific_training_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],    
             [
                 'es' => [
                     'name' => 'Juego en espacio reducido pequeño'
                 ],
                 'en' => [
                     'name' => 'Small-side game'
                 ],
                 'code' => 'small-side_game_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],    
             [
                 'es' => [
                     'name' => 'Juego en espacio reducido mediano'
                 ],
                 'en' => [
                     'name' => 'Medium-side game'
                 ],
                 'code' => 'medium-side_game_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],    
             [
                 'es' => [
                     'name' => 'Juego en espacio reducido grande'
                 ],
                 'en' => [
                     'name' => 'Large-side game'
                 ],
                 'code' => 'large-side_game_11',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],                                                   
         ];
     }
     private function targetsRollerHockey()
     {
         return [
             [
                 'es' => [
                     'name' => 'Posición ofensiva'
                 ],
                 'en' => [
                     'name' => 'Attacking stance'
                 ],
                 'code' => 'attacking_stance_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Patinaje de ataque'
                 ],
                 'en' => [
                     'name' => 'Attack skating'
                 ],
                 'code' => 'attack_skating_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],               
             [
                 'es' => [
                     'name' => 'Manejo de bola y stick'
                 ],
                 'en' => [
                     'name' => 'Ball and stick handling'
                 ],
                 'code' => 'ball_and_stick_handling_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Protección de la bola'
                 ],
                 'en' => [
                     'name' => 'Ball protection'
                 ],
                 'code' => 'ball_protection_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Conducción de bola'
                 ],
                 'en' => [
                     'name' => 'Ball driving'
                 ],
                 'code' => 'ball_driving_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Finta (Dribbling)'
                 ],
                 'en' => [
                     'name' => 'Fake (Dribbling)'
                 ],
                 'code' => 'fake_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Pase'
                 ],
                 'en' => [
                     'name' => 'Pass'
                 ],
                 'code' => 'pass_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Recepción (parada de la bola)'
                 ],
                 'en' => [
                     'name' => 'Reception (Ball stop)'
                 ],
                 'code' => 'reception_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Tiro'
                 ],
                 'en' => [
                     'name' => 'Shot'
                 ],
                 'code' => 'shot_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Tiro directo'
                 ],
                 'en' => [
                     'name' => 'Free kick'
                 ],
                 'code' => 'free_kick_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Penalti'
                 ],
                 'en' => [
                     'name' => 'Penalty shot'
                 ],
                 'code' => 'penalty_shot_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Posición defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive stance'
                 ],
                 'code' => 'defensive_stance_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Patinaje defensivo '
                 ],
                 'en' => [
                     'name' => 'Defensive skating'
                 ],
                 'code' => 'defensive_skating_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Robo de bola '
                 ],
                 'en' => [
                     'name' => 'Steal the ball'
                 ],
                 'code' => 'steal_the_ball_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Entrada'
                 ],
                 'en' => [
                     'name' => 'Tackle'
                 ],
                 'code' => 'tackle_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Carga legal'
                 ],
                 'en' => [
                     'name' => 'Body checking'
                 ],
                 'code' => 'body_checking_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Desvío de bola'
                 ],
                 'en' => [
                     'name' => 'Ball deflection'
                 ],
                 'code' => 'ball_deflection_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Bloqueo de tiro'
                 ],
                 'en' => [
                     'name' => 'Blocking shot'
                 ],
                 'code' => 'blocking_shot_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Despeje de la bola'
                 ],
                 'en' => [
                     'name' => 'Ball clearance'
                 ],
                 'code' => 'ball_clearance_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],  
             [
                 'es' => [
                     'name' => 'Deslizamiento'
                 ],
                 'en' => [
                     'name' => 'Sliding'
                 ],
                 'code' => 'sliding_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],                 
             [
                 'es' => [
                     'name' => 'Posiciones básicas'
                 ],
                 'en' => [
                     'name' => 'Basic stances '
                 ],
                 'code' => 'basic_stances_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Movimientos básicos'
                 ],
                 'en' => [
                     'name' => 'Basic drills'
                 ],
                 'code' => 'basic_drills_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],     
             [
                 'es' => [
                     'name' => 'Patinaje'
                 ],
                 'en' => [
                     'name' => 'Skating'
                 ],
                 'code' => 'skating_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],               
             [
                 'es' => [
                     'name' => 'Recuperación posición básica'
                 ],
                 'en' => [
                     'name' => 'Recovey to basic stance'
                 ],
                 'code' => 'recovey_to_basic_stance_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Parada deslizante'
                 ],
                 'en' => [
                     'name' => 'Wrap-around save'
                 ],
                 'code' => 'wrap-around_save_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],                  
             [
                 'es' => [
                     'name' => 'Parada aérea'
                 ],
                 'en' => [
                     'name' => 'Aereal save'
                 ],
                 'code' => 'aereal_save_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Parada suelo'
                 ],
                 'en' => [
                     'name' => 'Ground save '
                 ],
                 'code' => 'ground_save_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],                 
             [
                 'es' => [
                     'name' => 'Parada con el cuerpo'
                 ],
                 'en' => [
                     'name' => 'Body save'
                 ],
                 'code' => 'body_save_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Parada penalti'
                 ],
                 'en' => [
                     'name' => 'Penalty shot save'
                 ],
                 'code' => 'penalty_shot_save_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],    
             [
                 'es' => [
                     'name' => 'Parada tiro libre'
                 ],
                 'en' => [
                     'name' => 'Free kick save'
                 ],
                 'code' => 'free kick_save_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],                 
             [
                 'es' => [
                     'name' => 'Golpeo de bola'
                 ],
                 'en' => [
                     'name' => 'Ball kick'
                 ],
                 'code' => 'ball_kick_12',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Estrategia ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive strategy'
                 ],
                 'code' => 'offensive_strategy_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque organizado'
                 ],
                 'en' => [
                     'name' => 'Organized attack'
                 ],
                 'code' => 'organized_attack_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Contraataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack'
                 ],
                 'code' => 'counter_attack_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque directo  '
                 ],
                 'en' => [
                     'name' => 'Direct attack'
                 ],
                 'code' => 'direct_attack_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque en superioridad numérica '
                 ],
                 'en' => [
                     'name' => 'Attack in numerical superiority'
                 ],
                 'code' => 'attack_in_numerical_superiority_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical inferiority'
                 ],
                 'code' => 'attack_in_numerical_inferiority_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical equality'
                 ],
                 'code' => 'attack_in_numerical_equality_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque contra defensa zonal'
                 ],
                 'en' => [
                     'name' => 'Attack against zone defense'
                 ],
                 'code' => 'attack_against_zone_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque contra defensa individual'
                 ],
                 'en' => [
                     'name' => 'Attack against individual defense'
                 ],
                 'code' => 'attack_against_individual_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque contra defensa mixta '
                 ],
                 'en' => [
                     'name' => 'Attack against mixed defense'
                 ],
                 'code' => 'attack_against_mixed_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque contra defensa presionante'
                 ],
                 'en' => [
                     'name' => 'Attack against pressure defense'
                 ],
                 'code' => 'attack_against_pressure_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-1-2-1 (Rombo) '
                 ],
                 'en' => [
                     'name' => ' 1-1-2-1 Offensive system (Rhombus)'
                 ],
                 'code' => '1-1-2-1_offensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-2-2 (Cuadrado)'
                 ],
                 'en' => [
                     'name' => '1-2-2 Ofensive system (Square)'
                 ],
                 'code' => '1-2-2_offensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-1-3 (Triángulo ofensivo)'
                 ],
                 'en' => [
                     'name' => '1-1-3 Ofensive system (Offensive triangle)'
                 ],
                 'code' => '1-1-3_offensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-3-1 (Triángulo defensivo)'
                 ],
                 'en' => [
                     'name' => '1-3-1 Ofensive system (Defensive triangle)'
                 ],
                 'code' => '1-3-1_offensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-1-1-2 (Embudo / Y)'
                 ],
                 'en' => [
                     'name' => '1-1-1-2 Ofensive system (Funnel / Y)'
                 ],
                 'code' => '1-1-1-2_offensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-2-1-1 (Embudo invertido) '
                 ],
                 'en' => [
                     'name' => '1-2-1-1 Ofensive system (Inverted funnel)'
                 ],
                 'code' => '1-2-1-1_offensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4 (Cuatro en línea) '
                 ],
                 'en' => [
                     'name' => '1-4 Offensive system (Four in a row)'
                 ],
                 'code' => '1-4_offensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Fijación'
                 ],
                 'en' => [
                     'name' => 'Fixing'
                 ],
                 'code' => 'fixing_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Bloqueo'
                 ],
                 'en' => [
                     'name' => 'Blocking'
                 ],
                 'code' => 'blocking_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Apoyo ofensivo '
                 ],
                 'en' => [
                     'name' => 'Offensive support'
                 ],
                 'code' => 'offensive_support_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Desmarque'
                 ],
                 'en' => [
                     'name' => 'Uncheck'
                 ],
                 'code' => 'uncheck_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Pase y va '
                 ],
                 'en' => [
                     'name' => 'Give and go'
                 ],
                 'code' => 'give_and_go_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Construcción jugada '
                 ],
                 'en' => [
                     'name' => 'Playbook construction'
                 ],
                 'code' => 'playbook_construction_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Penetración'
                 ],
                 'en' => [
                     'name' => 'Penetration'
                 ],
                 'code' => 'penetration_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Finalización'
                 ],
                 'en' => [
                     'name' => 'Finishing'
                 ],
                 'code' => 'finishing_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Líneas de pase'
                 ],
                 'en' => [
                     'name' => 'Passing lanes'
                 ],
                 'code' => 'passing_lanes_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Estirar la defensa'
                 ],
                 'en' => [
                     'name' => 'Streching the defense'
                 ],
                 'code' => 'streching_the_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Circulación de jugadores en ataque'
                 ],
                 'en' => [
                     'name' => 'Attack player circulation'
                 ],
                 'code' => 'attack_player_circulation_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Superar línea de presión '
                 ],
                 'en' => [
                     'name' => 'Overcome pressure line'
                 ],
                 'code' => 'overcome_pressure_line_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Relevo ofensivo '
                 ],
                 'en' => [
                     'name' => 'Offensive relay'
                 ],
                 'code' => 'offensive_relay_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Cruce'
                 ],
                 'en' => [
                     'name' => 'Crossing'
                 ],
                 'code' => 'crossing_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Pantalla'
                 ],
                 'en' => [
                     'name' => 'Screen'
                 ],
                 'code' => 'screen_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Posesión de la bola '
                 ],
                 'en' => [
                     'name' => 'Ball possession'
                 ],
                 'code' => 'ball_possession_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Acción combinada'
                 ],
                 'en' => [
                     'name' => 'Combination play'
                 ],
                 'code' => 'combination_play_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Escapada'
                 ],
                 'en' => [
                     'name' => 'Breakaway'
                 ],
                 'code' => 'breakaway_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Salida de zona'
                 ],
                 'en' => [
                     'name' => 'Breakout'
                 ],
                 'code' => 'breakout_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque lado fuerte'
                 ],
                 'en' => [
                     'name' => 'Strong side attack'
                 ],
                 'code' => 'strong_side_attack_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque lado débil'
                 ],
                 'en' => [
                     'name' => 'Weak side attack'
                 ],
                 'code' => 'weak_side_attack_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Amplitud'
                 ],
                 'en' => [
                     'name' => 'Wide play'
                 ],
                 'code' => 'wide_play_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Profundidad'
                 ],
                 'en' => [
                     'name' => 'Depth'
                 ],
                 'code' => 'depth_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Aparecer'
                 ],
                 'en' => [
                     'name' => 'Turn-up'
                 ],
                 'code' => 'turn-up_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Entrada de zona'
                 ],
                 'en' => [
                     'name' => 'Zone entry'
                 ],
                 'code' => 'zone_entry_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Zona de remate'
                 ],
                 'en' => [
                     'name' => 'Shotting zone'
                 ],
                 'code' => 'shotting_zone_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Construcción de ataque'
                 ],
                 'en' => [
                     'name' => 'Attack setting up'
                 ],
                 'code' => 'attack_setting_up_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Zona de ayuda'
                 ],
                 'en' => [
                     'name' => 'Support zone'
                 ],
                 'code' => 'support_zone_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Aclarado'
                 ],
                 'en' => [
                     'name' => 'Clean up'
                 ],
                 'code' => 'clean_up_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Espacios libres'
                 ],
                 'en' => [
                     'name' => 'Creating space'
                 ],
                 'code' => 'creating_space_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Transición ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive transition'
                 ],
                 'code' => 'offensive_transition_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Estrategia defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive strategy'
                 ],
                 'code' => 'defensive_strategy_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Posicionamiento defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive positioning'
                 ],
                 'code' => 'defensive_positioning_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa individual'
                 ],
                 'en' => [
                     'name' => 'Individual defense'
                 ],
                 'code' => 'individual_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa presionante'
                 ],
                 'en' => [
                     'name' => 'Pressure defense'
                 ],
                 'code' => 'pressure_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],        
             [
                 'es' => [
                     'name' => 'Defensa en zona'
                 ],
                 'en' => [
                     'name' => 'Zone defense'
                 ],
                 'code' => 'zone_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa mixta'
                 ],
                 'en' => [
                     'name' => 'Mixed defense'
                 ],
                 'code' => 'mixed_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical superiority'
                 ],
                 'code' => 'defense_in_numerical_superiority_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical inferiority'
                 ],
                 'code' => 'defense_in_numerical_inferiority_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa en igualdad numérica '
                 ],
                 'en' => [
                     'name' => 'Defense in numerical equality'
                 ],
                 'code' => 'defense_in_numerical_equality_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-1-2-1 (Rombo) '
                 ],
                 'en' => [
                     'name' => '1-1-2-1 Defensive system (Rhombus)'
                 ],
                 'code' => '1-1-2-1_defensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-2-2 (Cuadrado)'
                 ],
                 'en' => [
                     'name' => '1-2-2 Defensive system (Square)'
                 ],
                 'code' => '1-2-2_defensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-1-3 (Triángulo ofensivo)'
                 ],
                 'en' => [
                     'name' => '1-1-3 Defensive system (Offensive triangle)'
                 ],
                 'code' => '1-1-3_defensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-3-1 (Triángulo defensivo)'
                 ],
                 'en' => [
                     'name' => '1-3-1 Defensive system (Defensive triangle)'
                 ],
                 'code' => '1-3-1_defensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-1-1-2 (Embudo / Y)'
                 ],
                 'en' => [
                     'name' => '1-1-1-2 Defensive system (Funnel / Y)'
                 ],
                 'code' => '1-1-1-2_defensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Sistema defensivo 1-2-1-1 (Embudo invertido)'
                 ],
                 'en' => [
                     'name' => '1-2-1-1 Defensive system (Inverted funnel)'
                 ],
                 'code' => '1-2-1-1_defensive_system_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],               
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Interceptación'
                 ],
                 'en' => [
                     'name' => 'Interception'
                 ],
                 'code' => 'interception_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],  
             [
                 'es' => [
                     'name' => 'Marcaje'
                 ],
                 'en' => [
                     'name' => 'Marking'
                 ],
                 'code' => 'marking_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7 
             ],       
             [
                 'es' => [
                     'name' => 'Cerrar líneas de pase'
                 ],
                 'en' => [
                     'name' => 'Cover passing lanes'
                 ],
                 'code' => 'cover_passing_lanes_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7 
             ],     
             [
                 'es' => [
                     'name' => 'Cerrar líneas de tiro'
                 ],
                 'en' => [
                     'name' => 'Cover shooting lanes'
                 ],
                 'code' => 'cover_shooting_lanes_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7 
             ],     
             [
                 'es' => [
                     'name' => 'Ayuda defensiva '
                 ],
                 'en' => [
                     'name' => 'Defensive support'
                 ],
                 'code' => 'defensive_support_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7 
             ],     
             [
                 'es' => [
                     'name' => 'Disuación'
                 ],
                 'en' => [
                     'name' => 'Deterrence'
                 ],
                 'code' => 'deterrence_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7 
             ],     
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Covering'
                 ],
                 'code' => 'covering_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ], 
             [
                 'es' => [
                     'name' => 'Intensidad defensiva '
                 ],
                 'en' => [
                     'name' => 'Defensive intensity'
                 ],
                 'code' => 'defensive_intensity_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7 
             ],                                 
             [
                 'es' => [
                     'name' => 'Defensa contrataque '
                 ],
                 'en' => [
                     'name' => 'Counter-attack defense'
                 ],
                 'code' => 'counter-attack_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7 
             ],             
             [
                 'es' => [
                     'name' => 'Línea defensiva '
                 ],
                 'en' => [
                     'name' => 'Defensive line'
                 ],
                 'code' => 'defensive_line_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ], 
             [
                 'es' => [
                     'name' => 'Persecución'
                 ],
                 'en' => [
                     'name' => 'Chase'
                 ],
                 'code' => 'chase_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Pérdida y recuperación de bola'
                 ],
                 'en' => [
                     'name' => 'Turnover and ball recovery'
                 ],
                 'code' => 'turnover_and_ball_recovery_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Forzar jugada exterior '
                 ],
                 'en' => [
                     'name' => 'Force outside'
                 ],
                 'code' => 'force_outside_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Defensa del lado fuerte '
                 ],
                 'en' => [
                     'name' => 'Strong side defense'
                 ],
                 'code' => 'strong_side_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Defensa del lado débil '
                 ],
                 'en' => [
                     'name' => 'Weak side defense'
                 ],
                 'code' => 'weak_side_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Orientación respecto al contrario'
                 ],
                 'en' => [
                     'name' => 'Opposite orientation'
                 ],
                 'code' => 'opposite_orientation_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Acosar (Presión jugador)'
                 ],
                 'en' => [
                     'name' => 'Overplay (Player pressure)'
                 ],
                 'code' => 'overplay_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Presión'
                 ],
                 'en' => [
                     'name' => 'Pressure '
                 ],
                 'code' => 'pressure _12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Reagrupamiento defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive reagroupin'
                 ],
                 'code' => 'defensive_reagroupin_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Relevo defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive relay'
                 ],
                 'code' => 'defensive_relay_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Defensa jugadas a balón parado'
                 ],
                 'en' => [
                     'name' => 'Set pieces defense'
                 ],
                 'code' => 'set_pieces_defense_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Cerrar la brecha (hueco)'
                 ],
                 'en' => [
                     'name' => 'Closing the gap'
                 ],
                 'code' => 'closing_the_gap_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Control de la brecha (hueco)'
                 ],
                 'en' => [
                     'name' => 'Gap control'
                 ],
                 'code' => 'gap_control_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Deslizamiento para romper jugadas '
                 ],
                 'en' => [
                     'name' => 'Sliding to break up plays'
                 ],
                 'code' => 'sliding_to_break_up_plays_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Cubrir espacios '
                 ],
                 'en' => [
                     'name' => 'Covering spaces '
                 ],
                 'code' => 'covering_spaces _12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Transición defensiva '
                 ],
                 'en' => [
                     'name' => 'Defensive transition'
                 ],
                 'code' => 'defensive_transition_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],               
             [
                 'es' => [
                     'name' => 'Equilibrio linea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line balance'
                 ],
                 'code' => 'defensive_line_balance_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],     
             [
                 'es' => [
                     'name' => 'Posicionamiento'
                 ],
                 'en' => [
                     'name' => 'Positioning'
                 ],
                 'code' => 'positioning_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],              
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Coverage'
                 ],
                 'code' => 'coverage_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],              
             [
                 'es' => [
                     'name' => 'Escapada (1v1) '
                 ],
                 'en' => [
                     'name' => 'Breakaway (1v1)'
                 ],
                 'code' => 'breakaway_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],    
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing_12',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],    
         ];
     }
     private function targetsIceHockey()
     {
         return [
             [
                 'es' => [
                     'name' => 'Posición ofensiva'
                 ],
                 'en' => [
                     'name' => 'Attacking stance'
                 ],
                 'code' => 'attacking_stance_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Patinaje de ataque'
                 ],
                 'en' => [
                     'name' => 'Attack skating'
                 ],
                 'code' => 'attack_skating_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],               
             [
                 'es' => [
                     'name' => 'Manejo del puck y stick'
                 ],
                 'en' => [
                     'name' => 'Puck and stick handling'
                 ],
                 'code' => 'puck_and_stick_handling_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Protección del puck'
                 ],
                 'en' => [
                     'name' => 'Puck protection'
                 ],
                 'code' => 'puck_protection_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Conducción del puck'
                 ],
                 'en' => [
                     'name' => 'Puck driving'
                 ],
                 'code' => 'puck_driving_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Finta'
                 ],
                 'en' => [
                     'name' => 'Fake'
                 ],
                 'code' => 'fake_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Pase'
                 ],
                 'en' => [
                     'name' => 'Pass'
                 ],
                 'code' => 'pass_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Ccntrol del puck'
                 ],
                 'en' => [
                     'name' => 'Puck control'
                 ],
                 'code' => 'Puck_control_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Tiro'
                 ],
                 'en' => [
                     'name' => 'Shot'
                 ],
                 'code' => 'shot_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],
             [
                 'es' => [
                     'name' => 'Tiro libre (Shoot-out)'
                 ],
                 'en' => [
                     'name' => 'Shoot-out'
                 ],
                 'code' => 'shoot-out_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],          
             [
                 'es' => [
                     'name' => 'Posición defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive stance'
                 ],
                 'code' => 'defensive_stance_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Patinaje defensivo '
                 ],
                 'en' => [
                     'name' => 'Defensive skating'
                 ],
                 'code' => 'defensive_skating_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Robo del puck'
                 ],
                 'en' => [
                     'name' => 'Steal the puck'
                 ],
                 'code' => 'steal_the_puck_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Carga legal'
                 ],
                 'en' => [
                     'name' => 'Body checking'
                 ],
                 'code' => 'body_checking_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Desvío de puck'
                 ],
                 'en' => [
                     'name' => 'Puck deflection'
                 ],
                 'code' => 'puck_deflection_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Bloqueo de tiro'
                 ],
                 'en' => [
                     'name' => 'Blocking shot'
                 ],
                 'code' => 'blocking_shot_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Pinning'
                 ],
                 'en' => [
                     'name' => 'Pinning'
                 ],
                 'code' => 'pinning_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],  
             [
                 'es' => [
                     'name' => 'Despeje del puck'
                 ],
                 'en' => [
                     'name' => 'Puck clearance'
                 ],
                 'code' => 'puck_clearance_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],  
             [
                 'es' => [
                     'name' => 'Deslizamiento'
                 ],
                 'en' => [
                     'name' => 'Sliding'
                 ],
                 'code' => 'sliding_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],   
             [
                 'es' => [
                     'name' => 'Posiciones básicas'
                 ],
                 'en' => [
                     'name' => 'Basic stances '
                 ],
                 'code' => 'basic_stances_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Movimientos básicos'
                 ],
                 'en' => [
                     'name' => 'Basic drills'
                 ],
                 'code' => 'basic_drills_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],     
             [
                 'es' => [
                     'name' => 'Patinaje'
                 ],
                 'en' => [
                     'name' => 'Skating'
                 ],
                 'code' => 'skating_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],               
             [
                 'es' => [
                     'name' => 'Recuperación posición básica'
                 ],
                 'en' => [
                     'name' => 'Recovey to basic stance'
                 ],
                 'code' => 'recovey_to_basic_stance_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Parada deslizante'
                 ],
                 'en' => [
                     'name' => 'Wrap-around save'
                 ],
                 'code' => 'wrap-around_save_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],                  
             [
                 'es' => [
                     'name' => 'Parada aérea'
                 ],
                 'en' => [
                     'name' => 'Aereal save'
                 ],
                 'code' => 'aereal_save_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Parada suelo'
                 ],
                 'en' => [
                     'name' => 'Ground save '
                 ],
                 'code' => 'ground_save_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],                 
             [
                 'es' => [
                     'name' => 'Parada con el cuerpo'
                 ],
                 'en' => [
                     'name' => 'Body save'
                 ],
                 'code' => 'body_save_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],          
             [
                 'es' => [
                     'name' => 'Parada tiro libre'
                 ],
                 'en' => [
                     'name' => 'Free kick save'
                 ],
                 'code' => 'free kick_save_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],                 
             [
                 'es' => [
                     'name' => 'Golpeo del puck'
                 ],
                 'en' => [
                     'name' => ' Puck kick'
                 ],
                 'code' => 'puck_kick_13',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],                     
             [
                 'es' => [
                     'name' => 'Estrategia ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive strategy'
                 ],
                 'code' => 'offensive_strategy_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque organizado'
                 ],
                 'en' => [
                     'name' => 'Organized attack'
                 ],
                 'code' => 'organized_attack_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Contraataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack'
                 ],
                 'code' => 'counter_attack_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque directo  '
                 ],
                 'en' => [
                     'name' => 'Direct attack'
                 ],
                 'code' => 'direct_attack_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque en superioridad numérica '
                 ],
                 'en' => [
                     'name' => 'Attack in numerical superiority'
                 ],
                 'code' => 'attack_in_numerical_superiority_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical inferiority'
                 ],
                 'code' => 'attack_in_numerical_inferiority_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical equality'
                 ],
                 'code' => 'attack_in_numerical_equality_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-1-4 (Trampa conservadora)'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-1-4 (Conservative trap)'
                 ],
                 'code' => 'offensive_system_1-1-4_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-1-2-2 (Presión moderada)'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-1-2-2 (Moderate forecheck)'
                 ],
                 'code' => 'offensive_system_1-1-2-2_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-1-3-1 (Presión agresiva)'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-1-3-1 (Aggresive forecheck)'
                 ],
                 'code' => 'offensive_system_1-1-3-1_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-2-3 (Bloqueo del ala izquierda)'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-2-3 (Left wing lock)'
                 ],
                 'code' => 'offensive_system_1-2-3_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-2-1-2 (Extensión)'
                 ],
                 'en' => [
                     'name' => 'Offensive system 1-2-1-2 (Spread)'
                 ],
                 'code' => 'offensive_system_1-2-1-2_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Volcado'
                 ],
                 'en' => [
                     'name' => 'Dump (Chip)'
                 ],
                 'code' => 'duma_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Volcado y persecución'
                 ],
                 'en' => [
                     'name' => 'Drump and chase'
                 ],
                 'code' => 'drump_and_chase_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Ataque combinado (Rush)'
                 ],
                 'en' => [
                     'name' => 'Attack off the rush '
                 ],
                 'code' => 'attack_off_the_rush_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sobrecarga a paraguas'
                 ],
                 'en' => [
                     'name' => 'Overload to umbrella'
                 ],
                 'code' => 'overload_to_umbrella_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'El Paraguas'
                 ],
                 'en' => [
                     'name' => 'The Umbrella'
                 ],
                 'code' => 'the_umbrella_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'El Diamante'
                 ],
                 'en' => [
                     'name' => 'The Diamond'
                 ],
                 'code' => 'the_diamond_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'La Caja'
                 ],
                 'en' => [
                     'name' => 'The Box'
                 ],
                 'code' => 'the_box_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Cuña (Triángilo +1)'
                 ],
                 'en' => [
                     'name' => 'Wedge (Triangle+1)'
                 ],
                 'code' => 'wedge_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Construcción jugada'
                 ],
                 'en' => [
                     'name' => 'Playbook construction'
                 ],
                 'code' => 'playbook_construction_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Apoyo ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive supporting play'
                 ],
                 'code' => 'offensive_supporting_play_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Desdoblamiento'
                 ],
                 'en' => [
                     'name' => 'Overlap'
                 ],
                 'code' => 'overlap_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Superar línea de presión'
                 ],
                 'en' => [
                     'name' => 'Overcome pressure line'
                 ],
                 'code' => 'overcome_pressure_line_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Pase y va'
                 ],
                 'en' => [
                     'name' => 'Give and go'
                 ],
                 'code' => 'give_and_go_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Fijación'
                 ],
                 'en' => [
                     'name' => 'Fixing'
                 ],
                 'code' => 'fixing_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Relevo ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive relay'
                 ],
                 'code' => 'offensive_relay_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Penetración'
                 ],
                 'en' => [
                     'name' => 'Penetration'
                 ],
                 'code' => 'penetration_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Finalización'
                 ],
                 'en' => [
                     'name' => 'Finishing'
                 ],
                 'code' => 'finishing_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Línea de pase'
                 ],
                 'en' => [
                     'name' => 'Passing line'
                 ],
                 'code' => 'passing_line_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Espacios libres '
                 ],
                 'en' => [
                     'name' => 'Creating space'
                 ],
                 'code' => 'creating_space_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Desmarque'
                 ],
                 'en' => [
                     'name' => 'Uncheck'
                 ],
                 'code' => 'uncheck_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Posesión del puck'
                 ],
                 'en' => [
                     'name' => 'Puck possession'
                 ],
                 'code' => 'puck_possession_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Cycling'
                 ],
                 'en' => [
                     'name' => 'Cycling'
                 ],
                 'code' => 'cycling_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Acción combinada'
                 ],
                 'en' => [
                     'name' => 'Combination play'
                 ],
                 'code' => 'combination_play_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Icing (despeje prohibido)'
                 ],
                 'en' => [
                     'name' => 'Icing'
                 ],
                 'code' => 'icing_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Escapada'
                 ],
                 'en' => [
                     'name' => 'Breakaway'
                 ],
                 'code' => 'breakaway_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Entrada de zona'
                 ],
                 'en' => [
                     'name' => 'Zone entry'
                 ],
                 'code' => 'zone_entry_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Salida de zona'
                 ],
                 'en' => [
                     'name' => 'Breakout '
                 ],
                 'code' => 'breakout _13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Inicio de jugada'
                 ],
                 'en' => [
                     'name' => 'Setting up'
                 ],
                 'code' => 'setting_up_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Estirar la defensa'
                 ],
                 'en' => [
                     'name' => 'Streching the defense'
                 ],
                 'code' => 'streching_the_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Face-off'
                 ],
                 'en' => [
                     'name' => 'Face-off'
                 ],
                 'code' => 'face-off_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Ataque en zona neutral'
                 ],
                 'en' => [
                     'name' => 'Attack in neutral zone'
                 ],
                 'code' => 'attack_in_neutral_zone_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Huelga'
                 ],
                 'en' => [
                     'name' => 'Walkout'
                 ],
                 'code' => 'walkout_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Aparecer'
                 ],
                 'en' => [
                     'name' => 'Turn-up'
                 ],
                 'code' => 'turn-up_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Retraso del ataque'
                 ],
                 'en' => [
                     'name' => 'Attack delaying'
                 ],
                 'code' => 'attack_delaying_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Pantalla'
                 ],
                 'en' => [
                     'name' => 'Screen'
                 ],
                 'code' => 'screen_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Amplitud'
                 ],
                 'en' => [
                     'name' => 'Wide play'
                 ],
                 'code' => 'wide_play_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Profundidad'
                 ],
                 'en' => [
                     'name' => 'Depth'
                 ],
                 'code' => 'depth_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Cruce'
                 ],
                 'en' => [
                     'name' => 'Cross'
                 ],
                 'code' => 'cross_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Circulación de jugadores'
                 ],
                 'en' => [
                     'name' => 'Players circulation'
                 ],
                 'code' => 'players_circulation_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Lectura de juego'
                 ],
                 'en' => [
                     'name' => 'Head on a swivel'
                 ],
                 'code' => 'head_on_a_swivel_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Descarga lateral'
                 ],
                 'en' => [
                     'name' => 'Lateral feed'
                 ],
                 'code' => 'lateral_feed_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Presión ofensiva'
                 ],
                 'en' => [
                     'name' => 'Forechecking (offensive pressure)'
                 ],
                 'code' => 'forechecking_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Velocidad de ataque'
                 ],
                 'en' => [
                     'name' => 'Attack speed'
                 ],
                 'code' => 'attack_speed_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Triángulo de ataque'
                 ],
                 'en' => [
                     'name' => 'Attack triangle'
                 ],
                 'code' => 'attack_triangle_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Ataque lado fuerte'
                 ],
                 'en' => [
                     'name' => 'Strong side attack'
                 ],
                 'code' => 'strong_side_attack_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque lado débil'
                 ],
                 'en' => [
                     'name' => 'Weak side attack'
                 ],
                 'code' => 'weak_side_attack_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Cambio de sistema ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive system switching'
                 ],
                 'code' => 'offensive_system_switching_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque contra defensa zonal'
                 ],
                 'en' => [
                     'name' => 'Attack against zone defense'
                 ],
                 'code' => 'attack_against_zone_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Ataque contra defensa individual '
                 ],
                 'en' => [
                     'name' => 'Attack against individual defense'
                 ],
                 'code' => 'attack_against_individual_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque contra defensa mixta'
                 ],
                 'en' => [
                     'name' => 'Attack against mixed defense'
                 ],
                 'code' => 'attack_against_mixed_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Ataque contra defensa presionante '
                 ],
                 'en' => [
                     'name' => 'Attack against pressure defense'
                 ],
                 'code' => 'attack_against_pressure_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Transición ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive transition'
                 ],
                 'code' => 'offensive_transition_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Reagrupamiento'
                 ],
                 'en' => [
                     'name' => 'Regrouping'
                 ],
                 'code' => 'regrouping_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],    
             [
                 'es' => [
                     'name' => 'Estrategia defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive strategy'
                 ],
                 'code' => 'defensive_strategy_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Posicionamiento defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive positioning'
                 ],
                 'code' => 'defensive_positioning_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa hombre a hombre'
                 ],
                 'en' => [
                     'name' => 'Man-to-man defense'
                 ],
                 'code' => 'man-to-man_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Sobrecarga del lado fuerte'
                 ],
                 'en' => [
                     'name' => 'Strong-side overload'
                 ],
                 'code' => 'strong-side_overload_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa en zona'
                 ],
                 'en' => [
                     'name' => 'Zone defense'
                 ],
                 'code' => 'zone_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Zona de meta'
                 ],
                 'en' => [
                     'name' => 'Net zone'
                 ],
                 'code' => 'net_zone_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Zona de apoyo'
                 ],
                 'en' => [
                     'name' => 'Support zone'
                 ],
                 'code' => 'support_zone_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Zona de golpeo'
                 ],
                 'en' => [
                     'name' => 'Hit zone'
                 ],
                 'code' => 'hit_zone_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa mixta'
                 ],
                 'en' => [
                     'name' => ' Mixed defense'
                 ],
                 'code' => 'mixed_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Defensa en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Power play defense'
                 ],
                 'code' => 'power_play_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Short handed defense'
                 ],
                 'code' => 'short_handed_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Defensa en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical equality'
                 ],
                 'code' => 'defense_in_numerical_equality_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Marcaje'
                 ],
                 'en' => [
                     'name' => 'Marking'
                 ],
                 'code' => 'marking_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Cobertura cercana'
                 ],
                 'en' => [
                     'name' => 'Close coverage'
                 ],
                 'code' => 'close_coverage_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Relevo defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive relay'
                 ],
                 'code' => 'defensive_relay_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Interceptación'
                 ],
                 'en' => [
                     'name' => 'Interception'
                 ],
                 'code' => 'interception_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Intensidad defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive intensity'
                 ],
                 'code' => 'defensive_intensity_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa jugadas a balón parado'
                 ],
                 'en' => [
                     'name' => 'Set pieces defense'
                 ],
                 'code' => 'set_pieces_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Línea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line'
                 ],
                 'code' => 'defensive_line_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa contrataque'
                 ],
                 'en' => [
                     'name' => 'Counter-attack defense '
                 ],
                 'code' => 'counter-attack_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Ayuda defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive support'
                 ],
                 'code' => 'defensive_support_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],                  
             [
                 'es' => [
                     'name' => 'Pérdida y recuperación del puck'
                 ],
                 'en' => [
                     'name' => 'Turnover and puck recovery'
                 ],
                 'code' => 'turnover_and_puck_recovery_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Orientación respecto al contrario'
                 ],
                 'en' => [
                     'name' => 'Opposite orientation'
                 ],
                 'code' => 'opposite_orientation_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Equilibrio defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive balance'
                 ],
                 'code' => 'defensive_balance_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Cerrar la brecha'
                 ],
                 'en' => [
                     'name' => 'Closing the gap'
                 ],
                 'code' => 'closing_the_gap_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Control de la brecha'
                 ],
                 'en' => [
                     'name' => 'Gap control'
                 ],
                 'code' => 'gap_control_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Forzar jugada exterior'
                 ],
                 'en' => [
                     'name' => 'Force outside'
                 ],
                 'code' => 'force_outside_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Acosar (presión a jugador)'
                 ],
                 'en' => [
                     'name' => 'Overplay (pressure to player)'
                 ],
                 'code' => 'overplay_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Presión defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive pressure '
                 ],
                 'code' => 'defensive_pressure_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Reagrupamiento defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive reagroupin (Tapback) '
                 ],
                 'code' => 'defensive_reagroupin_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Defensa del lado fuerte'
                 ],
                 'en' => [
                     'name' => 'Strong side defense'
                 ],
                 'code' => 'strong_side_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa del lado débil'
                 ],
                 'en' => [
                     'name' => 'Weak side defense'
                 ],
                 'code' => 'weak_side_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Deslizamiento para romper jugadas'
                 ],
                 'en' => [
                     'name' => 'Sliding to break up plays'
                 ],
                 'code' => 'sliding_to_break_up_plays_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Persecución'
                 ],
                 'en' => [
                     'name' => 'Chase'
                 ],
                 'code' => 'chase_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Repliegue delanteros (Back checking)'
                 ],
                 'en' => [
                     'name' => 'Back checking'
                 ],
                 'code' => 'back_checking_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Bloqueo fuera del ala'
                 ],
                 'en' => [
                     'name' => 'Off-wing lock'
                 ],
                 'code' => 'off-wing_lock_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Cambio de sistema defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive system switching'
                 ],
                 'code' => 'defensive_system_switching_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Transición defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive transition'
                 ],
                 'code' => 'defensive_transition_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],      
             [
                 'es' => [
                     'name' => 'Equilibrio linea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line balance'
                 ],
                 'code' => 'defensive_line_balance_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],     
             [
                 'es' => [
                     'name' => 'Posicionamiento'
                 ],
                 'en' => [
                     'name' => 'Positioning'
                 ],
                 'code' => 'positioning_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],              
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Coverage'
                 ],
                 'code' => 'coverage_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],              
             [
                 'es' => [
                     'name' => 'Defensa Escapada (1v1)'
                 ],
                 'en' => [
                     'name' => 'Breakaway (1v1)'
                 ],
                 'code' => 'breakaway_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],    
             [
                 'es' => [
                     'name' => 'Defensa shoot out (1v1)'
                 ],
                 'en' => [
                     'name' => 'Shoot out defense (1v1)'
                 ],
                 'code' => 'shoot_out_defense_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],     
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],  
             [
                 'es' => [
                     'name' => 'Patinaje carril izquierdo'
                 ],
                 'en' => [
                     'name' => 'Left skating lane'
                 ],
                 'code' => 'left_skating_lane_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],  
             [
                 'es' => [
                     'name' => 'Patinaje carril derecho'
                 ],
                 'en' => [
                     'name' => 'Right skating lane'
                 ],
                 'code' => 'right_skating_lane_13',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],              
         ];
     }
     private function targetsTennis()
     {
         return [
             [
                 'es' => [
                     'name' => 'Empuñadura'
                 ],
                 'en' => [
                     'name' => 'Grip'
                 ],
                 'code' => 'grip_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Posiciones básicas'
                 ],
                 'en' => [
                     'name' => 'Basic stances'
                 ],
                 'code' => 'basic_stances_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Posición de espera'
                 ],
                 'en' => [
                     'name' => 'Ready position'
                 ],
                 'code' => 'ready_position_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Posición abierta'
                 ],
                 'en' => [
                     'name' => 'Open stance'
                 ],
                 'code' => 'open_stance_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Posición semi-abierta'
                 ],
                 'en' => [
                     'name' => 'Semi-open stance'
                 ],
                 'code' => 'semi-open_stance_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Posición cerrada'
                 ],
                 'en' => [
                     'name' => 'Closed stance'
                 ],
                 'code' => 'closed_stance_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Posición neutral'
                 ],
                 'en' => [
                     'name' => 'Neutral stance (Squared)'
                 ],
                 'code' => 'neutral_stance_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Fases de golpeo'
                 ],
                 'en' => [
                     'name' => 'Stroke phases'
                 ],
                 'code' => 'stroke_phases_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Fase 1 - Preparación'
                 ],
                 'en' => [
                     'name' => 'Phase 1 - Preparation'
                 ],
                 'code' => 'phase_1_-_preparation_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Fase 2 - Aproximación / Impacto'
                 ],
                 'en' => [
                     'name' => 'Phase 2 - Approach / Impact'
                 ],
                 'code' => 'phase_2_-_approach_/_impact_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Fase 3 - Acompañamiento / Terminación'
                 ],
                 'en' => [
                     'name' => 'Phase 3 - Follow-through / Finish'
                 ],
                 'code' => 'phase_3_-_follow-through_/_finish_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Juego de pies'
                 ],
                 'en' => [
                     'name' => 'Footwork'
                 ],
                 'code' => 'footwork_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Pre-reacción'
                 ],
                 'en' => [
                     'name' => 'Pre-reaction '
                 ],
                 'code' => 'pre-reaction_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Reacción inicial'
                 ],
                 'en' => [
                     'name' => 'First reaction '
                 ],
                 'code' => 'first_reaction_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Recuperación de pista'
                 ],
                 'en' => [
                     'name' => 'Court recovery'
                 ],
                 'code' => 'court_recovery_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Desplazamientos hacia la pelota'
                 ],
                 'en' => [
                     'name' => 'Displacements towards the ball'
                 ],
                 'code' => 'displacements_towards_the_ball_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Desplazamientos adelante-atrás'
                 ],
                 'en' => [
                     'name' => 'Forward-backward displacements'
                 ],
                 'code' => 'forward-backward_displacements_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Desplazamientos laterales'
                 ],
                 'en' => [
                     'name' => 'Lateral displacements'
                 ],
                 'code' => 'lateral_displacements_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Desplazamientos diagonales'
                 ],
                 'en' => [
                     'name' => 'Diagonal displacement'
                 ],
                 'code' => 'diagonal_displacement_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Saque'
                 ],
                 'en' => [
                     'name' => 'Serve'
                 ],
                 'code' => 'serve_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Resto'
                 ],
                 'en' => [
                     'name' => 'Return of serve'
                 ],
                 'code' => 'return_of_serve_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Resto de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand return'
                 ],
                 'code' => 'forehand_return_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Resto de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand return'
                 ],
                 'code' => 'backhand_return_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Derecha (Drive)'
                 ],
                 'en' => [
                     'name' => 'Forehand (Drive)'
                 ],
                 'code' => 'forehand_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Revés'
                 ],
                 'en' => [
                     'name' => 'Backhand'
                 ],
                 'code' => 'backhand_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Revés a 1 mano'
                 ],
                 'en' => [
                     'name' => '1 handed backhand'
                 ],
                 'code' => '1_handed_backhand_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Revés a 2 manos'
                 ],
                 'en' => [
                     'name' => '2 handed backhand'
                 ],
                 'code' => '2_handed_backhand_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Golpe de aproximación'
                 ],
                 'en' => [
                     'name' => 'Approach shot'
                 ],
                 'code' => 'approach_shot_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Golpe de aproximación de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand approach shot'
                 ],
                 'code' => 'forehand_approach_shot_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Golpe de aproximación de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand approach shot'
                 ],
                 'code' => 'backhand_approach_shot_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Dejada'
                 ],
                 'en' => [
                     'name' => 'Drop'
                 ],
                 'code' => 'drop_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Dejada de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand drop'
                 ],
                 'code' => 'forehand_drop_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Dejada de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand drop'
                 ],
                 'code' => 'backhand_drop_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Globo'
                 ],
                 'en' => [
                     'name' => 'Lob'
                 ],
                 'code' => 'lob_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Globo de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand Lob'
                 ],
                 'code' => 'forehand_lob_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Globo de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand Lob'
                 ],
                 'code' => 'backhand_lob_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Volea'
                 ],
                 'en' => [
                     'name' => 'Volley'
                 ],
                 'code' => 'volley_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Volea de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand volley'
                 ],
                 'code' => 'forehand_volley_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Volea de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand volley'
                 ],
                 'code' => 'backhand_volley_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Remate'
                 ],
                 'en' => [
                     'name' => 'Smash'
                 ],
                 'code' => 'smash_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Remate de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand smash'
                 ],
                 'code' => 'backhand_smash_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Gran Willy (Tweener)'
                 ],
                 'en' => [
                     'name' => 'Tweener'
                 ],
                 'code' => 'tweener_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Golpe plano'
                 ],
                 'en' => [
                     'name' => 'Flat stroke'
                 ],
                 'code' => 'flat_stroke_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Golpe cortado'
                 ],
                 'en' => [
                     'name' => 'Slice stroke'
                 ],
                 'code' => 'slice_stroke_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Golpe liftado'
                 ],
                 'en' => [
                     'name' => 'Topspin stroke'
                 ],
                 'code' => 'topspin_stroke_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Precisión'
                 ],
                 'en' => [
                     'name' => 'Accuracy'
                 ],
                 'code' => 'accuracy_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Posicionamiento en pista'
                 ],
                 'en' => [
                     'name' => 'Court positioning'
                 ],
                 'code' => 'court_positioning_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Fase de juego ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive phase play'
                 ],
                 'code' => 'offensive_phase_play_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Fase de juego defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive phase play'
                 ],
                 'code' => 'defensive_phase_play_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Fase de juego de transición'
                 ],
                 'en' => [
                     'name' => 'Transition phase play'
                 ],
                 'code' => 'transition_phase_play_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Ritmo de juego'
                 ],
                 'en' => [
                     'name' => 'Pace of play'
                 ],
                 'code' => 'pace_of_play_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Variabilidad de golpeos'
                 ],
                 'en' => [
                     'name' => 'Strokes variability'
                 ],
                 'code' => 'strokes_variability_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Selección de golpeo'
                 ],
                 'en' => [
                     'name' => 'Shot selection'
                 ],
                 'code' => 'shot_selection_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Consistencia'
                 ],
                 'en' => [
                     'name' => 'Consistency'
                 ],
                 'code' => 'consistency_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'LLevar la iniciativa'
                 ],
                 'en' => [
                     'name' => 'Taking the initiative'
                 ],
                 'code' => 'taking_the_initiative_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Jugar al lado débil del rival'
                 ],
                 'en' => [
                     'name' => 'Play rival weak side'
                 ],
                 'code' => 'play_rival_weak_side_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Mover al rival'
                 ],
                 'en' => [
                     'name' => 'Move the opponent'
                 ],
                 'code' => 'move_the_opponent_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Profundidad'
                 ],
                 'en' => [
                     'name' => 'Depht'
                 ],
                 'code' => 'depht_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Dirección de la bola'
                 ],
                 'en' => [
                     'name' => 'Ball direction'
                 ],
                 'code' => 'ball_direction_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Golpeo paralelo'
                 ],
                 'en' => [
                     'name' => 'Down the line stroke '
                 ],
                 'code' => 'down_the_line_stroke_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Golpeo cruzado'
                 ],
                 'en' => [
                     'name' => 'Cross court stroke '
                 ],
                 'code' => 'cross_court_stroke_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Altura de la bola'
                 ],
                 'en' => [
                     'name' => 'Ball height'
                 ],
                 'code' => 'ball_height_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Jugar al porcentaje'
                 ],
                 'en' => [
                     'name' => 'Play percentage'
                 ],
                 'code' => 'play_percentage_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Jugar al contrapié'
                 ],
                 'en' => [
                     'name' => 'Play to the back foot'
                 ],
                 'code' => 'play_to_the_back_foot_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Presionar al rival'
                 ],
                 'en' => [
                     'name' => 'Put pressure on the opponent'
                 ],
                 'code' => 'put_pressure_on_the_opponent_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Cubrir el revés'
                 ],
                 'en' => [
                     'name' => 'Cover the backhand'
                 ],
                 'code' => 'cover_the_backhand_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Derecha invertida'
                 ],
                 'en' => [
                     'name' => 'Forehand in side out'
                 ],
                 'code' => 'forehand_in_side-out_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Atacar bola corta o débil'
                 ],
                 'en' => [
                     'name' => 'Attack short or weak ball'
                 ],
                 'code' => 'attack_short_or_weak_ball_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Atacar pista abierta'
                 ],
                 'en' => [
                     'name' => 'Attack open court'
                 ],
                 'code' => 'attack_open_court_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Atacar ángulo corto'
                 ],
                 'en' => [
                     'name' => 'Attack short angle'
                 ],
                 'code' => 'attack_short_angle_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Situaciones sacando'
                 ],
                 'en' => [
                     'name' => 'Serving situations'
                 ],
                 'code' => 'serving_situations_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Jugada desde saque abierto'
                 ],
                 'en' => [
                     'name' => 'Play from open serve'
                 ],
                 'code' => 'play_from_open_serve_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Jugada desde saque al cuerpo'
                 ],
                 'en' => [
                     'name' => 'Play from body serve'
                 ],
                 'code' => 'play_from_body_serve_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Jugada desde saque a la "T"'
                 ],
                 'en' => [
                     'name' => 'Play from "T" serve'
                 ],
                 'code' => 'play_from_"t"_serve_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Saque y volea'
                 ],
                 'en' => [
                     'name' => 'Serve and volley'
                 ],
                 'code' => 'serve_and_volley_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Saque y quedarse atrás'
                 ],
                 'en' => [
                     'name' => 'Serve and stay back'
                 ],
                 'code' => 'serve_and_stay_back_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Situaciones restando'
                 ],
                 'en' => [
                     'name' => ' Returning the serve situations'
                 ],
                 'code' => 'returning_the_serve_situations_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Bloquear el resto'
                 ],
                 'en' => [
                     'name' => 'Block return'
                 ],
                 'code' => 'block_return_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Subiendo a la red'
                 ],
                 'en' => [
                     'name' => 'Approaching the net'
                 ],
                 'code' => 'approaching_the_net_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Juego en la red '
                 ],
                 'en' => [
                     'name' => 'Net play'
                 ],
                 'code' => 'net_play_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Juego en media pista'
                 ],
                 'en' => [
                     'name' => 'Mid-court play'
                 ],
                 'code' => 'mid-court_play_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Juego en línea de fondo'
                 ],
                 'en' => [
                     'name' => 'Baseline play'
                 ],
                 'code' => 'baseline_play_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Recuperación de globos'
                 ],
                 'en' => [
                     'name' => 'Lob recovery'
                 ],
                 'code' => 'lob_recovery_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Contrataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack'
                 ],
                 'code' => 'counter_attack_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Passing shots'
                 ],
                 'en' => [
                     'name' => 'Passing shots'
                 ],
                 'code' => 'passing_shots_14',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Apuntar al cuerpo o los pies del rival'
                 ],
                 'en' => [
                     'name' => 'Aim at the opponent`s body or feet'
                 ],
                 'code' => 'aim_at_the opponent`s_body_or_feet_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Defensa ángulo corto'
                 ],
                 'en' => [
                     'name' => 'Short angle defense'
                 ],
                 'code' => 'short_angle_defense_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Estrategias dobles'
                 ],
                 'en' => [
                     'name' => 'Doubles strategies'
                 ],
                 'code' => 'doubles_strategies_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],        
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing_14',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],        
         ];
     }
     private function targetsPadel()
     {
         return [
             [
                 'es' => [
                     'name' => 'Empuñadura'
                 ],
                 'en' => [
                     'name' => 'Grip'
                 ],
                 'code' => 'grip_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Posiciones básicas'
                 ],
                 'en' => [
                     'name' => ' Basic stances'
                 ],
                 'code' => 'basic_stances_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Posición de espera'
                 ],
                 'en' => [
                     'name' => 'Ready position'
                 ],
                 'code' => 'ready_position_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Fases de golpeo'
                 ],
                 'en' => [
                     'name' => 'Stroke phases'
                 ],
                 'code' => 'stroke_phases_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Fase 1 - Preparación'
                 ],
                 'en' => [
                     'name' => 'Phase 1 - Preparation'
                 ],
                 'code' => 'phase_1_-_preparation_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Fase 2 - Aproximación / Impacto'
                 ],
                 'en' => [
                     'name' => 'Phase 2 - Approach / Impact'
                 ],
                 'code' => 'phase_2_-_approach_/_impact_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Fase 3 - Acompañamiento / Terminación'
                 ],
                 'en' => [
                     'name' => 'Phase 3 - Follow-through / Finish'
                 ],
                 'code' => 'phase_3_-_follow-through_/_finish_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Juego de pies'
                 ],
                 'en' => [
                     'name' => 'Footwork'
                 ],
                 'code' => 'footwork_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Desplazamientos hacia la pelota'
                 ],
                 'en' => [
                     'name' => 'Displacements towards the ball'
                 ],
                 'code' => 'displacements_towards_the_ball_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Desplazamientos adelante-atrás'
                 ],
                 'en' => [
                     'name' => 'Forward-backward displacements'
                 ],
                 'code' => 'forward-backward_displacements_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Desplazamientos laterales'
                 ],
                 'en' => [
                     'name' => 'Lateral displacements'
                 ],
                 'code' => 'lateral_displacements_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Desplazamientos diagonales'
                 ],
                 'en' => [
                     'name' => 'Diagonal displacement'
                 ],
                 'code' => 'diagonal_displacement_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Saque'
                 ],
                 'en' => [
                     'name' => 'Serve'
                 ],
                 'code' => 'serve_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Resto '
                 ],
                 'en' => [
                     'name' => 'Return of serve'
                 ],
                 'code' => 'return_of_serve_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Resto de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand return '
                 ],
                 'code' => 'forehand_return_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Resto de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand return'
                 ],
                 'code' => 'backhand_return_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand'
                 ],
                 'code' => 'forehand_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Revés'
                 ],
                 'en' => [
                     'name' => 'Backhand'
                 ],
                 'code' => 'backhand_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Revés a una mano'
                 ],
                 'en' => [
                     'name' => 'One handed backhand'
                 ],
                 'code' => 'one_handed_backhand_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Revés a 2 manos'
                 ],
                 'en' => [
                     'name' => 'Two handed backhand'
                 ],
                 'code' => 'two_handed_backhand_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Dejada'
                 ],
                 'en' => [
                     'name' => 'Dropshot'
                 ],
                 'code' => 'dropshot_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Dejada de derecha'
                 ],
                 'en' => [
                     'name' => ' Forehand dropshot'
                 ],
                 'code' => 'forehand_dropshot_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Dejada de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand dropshot'
                 ],
                 'code' => 'backhand_dropshot_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Globo'
                 ],
                 'en' => [
                     'name' => 'Lob'
                 ],
                 'code' => 'lob_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Globo de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand Lob'
                 ],
                 'code' => 'forehand_lob_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Globo de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand Lob'
                 ],
                 'code' => 'backhand_lob_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Golpe de aproximación'
                 ],
                 'en' => [
                     'name' => 'Approach shot'
                 ],
                 'code' => 'approach_shot_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Golpe de aproximación de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand approach shot'
                 ],
                 'code' => 'forehand_approach_shot_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Golpe de aproximación de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand approach shot'
                 ],
                 'code' => 'backhand_approach_shot_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Bandeja'
                 ],
                 'en' => [
                     'name' => 'Bandeja'
                 ],
                 'code' => 'bandeja_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Bandeja de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand bandeja'
                 ],
                 'code' => 'forehand_bandeja_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Bandeja de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand bandeja'
                 ],
                 'code' => 'backhand_bandeja_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'La Víbora'
                 ],
                 'en' => [
                     'name' => 'The Viper'
                 ],
                 'code' => 'the_viper_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'La Víbora de derecha'
                 ],
                 'en' => [
                     'name' => 'The Viper forehand'
                 ],
                 'code' => 'the_viper_forehand_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'La Víbora de revés'
                 ],
                 'en' => [
                     'name' => 'The Viper backhand'
                 ],
                 'code' => 'the_viper_backhand_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Volea'
                 ],
                 'en' => [
                     'name' => 'Volley'
                 ],
                 'code' => 'volley_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Volea de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand volley'
                 ],
                 'code' => 'forehand_volley_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Volea de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand volley'
                 ],
                 'code' => 'backhand_volley_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Remate'
                 ],
                 'en' => [
                     'name' => 'Smash'
                 ],
                 'code' => 'smash_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Remate de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand smash'
                 ],
                 'code' => 'backhand_smash_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Remate X3'
                 ],
                 'en' => [
                     'name' => 'Smash X3'
                 ],
                 'code' => 'smash_x3_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Remate X4'
                 ],
                 'en' => [
                     'name' => 'Smash X4'
                 ],
                 'code' => 'smash_x4_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Remate a la reja (Rulo)'
                 ],
                 'en' => [
                     'name' => 'Topspin smash to fence'
                 ],
                 'code' => 'topspin_smash_to_fence_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Dormilona'
                 ],
                 'en' => [
                     'name' => 'The Sleeper'
                 ],
                 'code' => 'the_sleeper_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'La Chiquita'
                 ],
                 'en' => [
                     'name' => 'The Chiquita'
                 ],
                 'code' => 'the_chiquita_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Salida de pared'
                 ],
                 'en' => [
                     'name' => 'Back of the wall'
                 ],
                 'code' => 'back_of_the_wall_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Salida de pared de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand back of the wall'
                 ],
                 'code' => 'forehand_back_of_the_wall_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Salida de pared de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand back of the wall'
                 ],
                 'code' => 'backhand_back_of_the_wall_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Contrapared'
                 ],
                 'en' => [
                     'name' => 'Back wall boast'
                 ],
                 'code' => 'back_wall_boast_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Contrapared de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand back wall boast'
                 ],
                 'code' => 'forehand_back_wall_boast_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Contrapared de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand back wall boast'
                 ],
                 'code' => 'backhand_back_wall_boast_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Bajada de pared'
                 ],
                 'en' => [
                     'name' => 'Off the back wall'
                 ],
                 'code' => 'off_the_back_wall_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Bajada de pared de derecha'
                 ],
                 'en' => [
                     'name' => 'Off the back wall forehand'
                 ],
                 'code' => 'off_the_back_wall_forehand_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ], 
             [
                 'es' => [
                     'name' => 'Bajada de pared de revés'
                 ],
                 'en' => [
                     'name' => 'Off the back wall backhand  '
                 ],
                 'code' => 'off_the_back_wall_backhand_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Pared lateral'
                 ],
                 'en' => [
                     'name' => 'Side wall'
                 ],
                 'code' => 'side_wall_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Contrapared lateral'
                 ],
                 'en' => [
                     'name' => 'Side wall boast'
                 ],
                 'code' => 'side_wall_boast_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],    
             [
                 'es' => [
                     'name' => 'Doble pared'
                 ],
                 'en' => [
                     'name' => 'Double wall'
                 ],
                 'code' => 'double_wall_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Gran Willy'
                 ],
                 'en' => [
                     'name' => 'Tweener '
                 ],
                 'code' => 'tweener_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],   
             [
                 'es' => [
                     'name' => 'Golpe plano'
                 ],
                 'en' => [
                     'name' => 'Flat stroke'
                 ],
                 'code' => 'flat_stroke_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Golpe cortado'
                 ],
                 'en' => [
                     'name' => 'Slice stroke'
                 ],
                 'code' => 'slice_stroke_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Golpe liftado'
                 ],
                 'en' => [
                     'name' => 'Topspin stroke '
                 ],
                 'code' => 'topspin_stroke_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Precisión'
                 ],
                 'en' => [
                     'name' => 'Accuracy'
                 ],
                 'code' => 'accuracy_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Posicionamiento en la pista'
                 ],
                 'en' => [
                     'name' => 'Court positioning'
                 ],
                 'code' => 'court_positioning_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Moverse en pareja'
                 ],
                 'en' => [
                     'name' => 'Moving as a pair'
                 ],
                 'code' => 'moving_as_a_pair_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Relevos y cambio de posición'
                 ],
                 'en' => [
                     'name' => 'Relays and switching '
                 ],
                 'code' => 'relays_and_switching_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Situaciones sacando'
                 ],
                 'en' => [
                     'name' => 'Serving situations'
                 ],
                 'code' => 'serving_situations_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Situaciones restando'
                 ],
                 'en' => [
                     'name' => 'Returning the serve situations'
                 ],
                 'code' => 'returning_the_serve_situations_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Ganar la red'
                 ],
                 'en' => [
                     'name' => 'Win the net'
                 ],
                 'code' => 'win_the_net_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Recuperación de globos'
                 ],
                 'en' => [
                     'name' => 'Lob recovery'
                 ],
                 'code' => 'lob_recovery_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Defensa remate'
                 ],
                 'en' => [
                     'name' => 'Smash defense'
                 ],
                 'code' => 'smash_defense_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Consistencia'
                 ],
                 'en' => [
                     'name' => 'Consistency '
                 ],
                 'code' => 'consistency_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Zona 1 - Ataque (red)'
                 ],
                 'en' => [
                     'name' => 'Zone 1 - Attack (net)'
                 ],
                 'code' => 'zone_1_-_attack_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Zona 2 - Transición (media pista)'
                 ],
                 'en' => [
                     'name' => 'Zone 2 - Transition (mid-court)'
                 ],
                 'code' => 'zone_2-transition_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Zona 3 - Defensa (fondo de pista y paredes)'
                 ],
                 'en' => [
                     'name' => 'Zone 3 - Defense (baseline and walls)'
                 ],
                 'code' => 'zone_3-defense_15',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Ritmo de juego'
                 ],
                 'en' => [
                     'name' => 'Pace of play '
                 ],
                 'code' => 'pace_of_play_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Dirección de la bola'
                 ],
                 'en' => [
                     'name' => 'Ball direction'
                 ],
                 'code' => 'ball_direction_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Golpeo paralelo'
                 ],
                 'en' => [
                     'name' => 'Down the line stroke (straight) '
                 ],
                 'code' => 'down_the_line_stroke_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Golpeo cruzado'
                 ],
                 'en' => [
                     'name' => 'Cross court stroke (diagonally) '
                 ],
                 'code' => 'cross_court_stroke_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Altura bola'
                 ],
                 'en' => [
                     'name' => 'Ball height'
                 ],
                 'code' => 'ball_height_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'LLevar la iniciativa'
                 ],
                 'en' => [
                     'name' => 'Taking the initiative'
                 ],
                 'code' => 'taking_the_initiative_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Jugar al rival más débil'
                 ],
                 'en' => [
                     'name' => 'Play the weakest opponent'
                 ],
                 'code' => 'play_the_weakest_opponent_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Selección de golpeo'
                 ],
                 'en' => [
                     'name' => 'Shot selection'
                 ],
                 'code' => 'shot_selection_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Mover a los rivales'
                 ],
                 'en' => [
                     'name' => 'Move the opponents'
                 ],
                 'code' => 'move_the_opponents_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Jugar al porcentaje'
                 ],
                 'en' => [
                     'name' => 'Play percentage '
                 ],
                 'code' => 'play_percentage_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Passing shots'
                 ],
                 'en' => [
                     'name' => 'Passing shots'
                 ],
                 'code' => 'passing_shots_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Jugar al contrapié'
                 ],
                 'en' => [
                     'name' => 'Play to the back foot'
                 ],
                 'code' => 'play_to_the_back_foot_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Saque y volea'
                 ],
                 'en' => [
                     'name' => 'Serve and volley'
                 ],
                 'code' => 'serve_and_volley_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Jugar a las esquinas'
                 ],
                 'en' => [
                     'name' => 'Play to corners'
                 ],
                 'code' => 'play_to_corners_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Jugar a los espacios libres'
                 ],
                 'en' => [
                     'name' => 'Play to free spaces'
                 ],
                 'code' => 'play_to_free_spaces_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Jugar a la zona de divorcio'
                 ],
                 'en' => [
                     'name' => 'Play the divorce zone '
                 ],
                 'code' => 'play_the_divorce_zone_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Apuntar al cuerpo o los pies del rival'
                 ],
                 'en' => [
                     'name' => 'Aim at the opponent´s body or feet'
                 ],
                 'code' => 'aim_at_the_opponent´s_body_or_feet_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Covering'
                 ],
                 'code' => 'covering_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Presionar'
                 ],
                 'en' => [
                     'name' => 'Pressure'
                 ],
                 'code' => 'pressure_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Atacar ángulo corto'
                 ],
                 'en' => [
                     'name' => 'Attack short angle'
                 ],
                 'code' => 'attack_short_angle_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Defensa ángulo corto'
                 ],
                 'en' => [
                     'name' => 'Short angle defense'
                 ],
                 'code' => 'short_angle_defense_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Contrataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack'
                 ],
                 'code' => 'counter_attack_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Variabilidad de golpeos '
                 ],
                 'en' => [
                     'name' => 'Strokes variability'
                 ],
                 'code' => 'strokes_variability_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Cubrir el revés (derecha invertida)'
                 ],
                 'en' => [
                     'name' => 'Cover the backhand (forehand in side out)'
                 ],
                 'code' => 'Cover_the_backhand_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Derecha invertida'
                 ],
                 'en' => [
                     'name' => 'Forehand in side out'
                 ],
                 'code' => 'forehand_in_side_out_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing_15',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
         ];
     }
     private function targetsBadminton()
     {
         return [
             [
                 'es' => [
                     'name' => 'Empuñadura'
                 ],
                 'en' => [
                     'name' => 'Grip'
                 ],
                 'code' => 'grip_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Posiciones básicas'
                 ],
                 'en' => [
                     'name' => 'Basic stances'
                 ],
                 'code' => 'basic_stances_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Posición de espera'
                 ],
                 'en' => [
                     'name' => 'Ready position'
                 ],
                 'code' => 'ready_position_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Fases de golpeo'
                 ],
                 'en' => [
                     'name' => 'Stroke phases'
                 ],
                 'code' => 'stroke_phases_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Fase 1 - Preparación'
                 ],
                 'en' => [
                     'name' => 'Phase 1 - Preparation'
                 ],
                 'code' => 'phase_1_-_Preparation_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Fase 2 - Aproximación / Impacto  Phase'
                 ],
                 'en' => [
                     'name' => '2 - Approach / Impact '
                 ],
                 'code' => 'phase_2_-_approach_/_Impact_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Fase 3 - Acompañamiento / Terminación'
                 ],
                 'en' => [
                     'name' => 'Phase 3 - Follow-through / Finish '
                 ],
                 'code' => 'phase_3_-_follow-through_/_finish_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Juego de pies'
                 ],
                 'en' => [
                     'name' => 'Footwork'
                 ],
                 'code' => 'footwork_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Pre-reacción'
                 ],
                 'en' => [
                     'name' => 'Pre-reaction '
                 ],
                 'code' => 'pre-reaction_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Reacción inicial'
                 ],
                 'en' => [
                     'name' => 'First reaction '
                 ],
                 'code' => 'first_reaction_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Recuperación de pista'
                 ],
                 'en' => [
                     'name' => 'Court recovery'
                 ],
                 'code' => 'court_recovery_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Desplazamientos hacia el volante'
                 ],
                 'en' => [
                     'name' => ' Displacements towards the shuttlecock'
                 ],
                 'code' => 'displacements_towards_the_shuttlecock_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Desplazamientos adelante-atrás'
                 ],
                 'en' => [
                     'name' => 'Forward-backward displacements'
                 ],
                 'code' => 'forward-backward_displacements_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Desplazamientos laterales'
                 ],
                 'en' => [
                     'name' => 'Lateral displacements'
                 ],
                 'code' => 'lateral_displacements_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Desplazamientos diagonales'
                 ],
                 'en' => [
                     'name' => 'Diagonal displacement'
                 ],
                 'code' => 'diagonal_displacement_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Saque'
                 ],
                 'en' => [
                     'name' => 'Serve'
                 ],
                 'code' => 'serve_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Saque de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand serve '
                 ],
                 'code' => 'backhand_serve_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Saque de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand serve '
                 ],
                 'code' => 'forehand_serve_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Resto'
                 ],
                 'en' => [
                     'name' => 'Return of serve'
                 ],
                 'code' => 'return_of_serve_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Resto de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand return '
                 ],
                 'code' => 'forehand_return_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Resto de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand return '
                 ],
                 'code' => 'backhand_return_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Drive'
                 ],
                 'en' => [
                     'name' => 'Forehand drive'
                 ],
                 'code' => 'forehand_drive_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Drive de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand drive'
                 ],
                 'code' => 'backhand_drive_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Revés'
                 ],
                 'en' => [
                     'name' => 'Backhand'
                 ],
                 'code' => 'backhand_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Dejada alta'
                 ],
                 'en' => [
                     'name' => 'Drop '
                 ],
                 'code' => 'drop_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Dejada alta de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand drop'
                 ],
                 'code' => 'forehand_drop_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Dejada alta de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand drop '
                 ],
                 'code' => 'backhand_drop_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Dejada en red'
                 ],
                 'en' => [
                     'name' => 'Net drop '
                 ],
                 'code' => 'net_drop_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Dejada en red de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand net drop '
                 ],
                 'code' => 'forehand_net_drop_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Dejada en red de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand net drop '
                 ],
                 'code' => 'backhand_net_drop_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Tiro de empuje'
                 ],
                 'en' => [
                     'name' => 'Push shot'
                 ],
                 'code' => 'push_shot_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Golpe de cepillo'
                 ],
                 'en' => [
                     'name' => 'Net bush shot'
                 ],
                 'code' => 'net_bush_shot_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Despeje'
                 ],
                 'en' => [
                     'name' => 'Clear'
                 ],
                 'code' => 'clear_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Despeje de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand clear'
                 ],
                 'code' => 'forehand_clear_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Despeje de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand clear'
                 ],
                 'code' => 'backhand_clear_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Globo'
                 ],
                 'en' => [
                     'name' => 'Lob'
                 ],
                 'code' => 'lob_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Remate'
                 ],
                 'en' => [
                     'name' => 'Smash'
                 ],
                 'code' => 'smash_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Remate de derecha'
                 ],
                 'en' => [
                     'name' => 'Forehand smash'
                 ],
                 'code' => 'forehand_smash_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Remate de revés'
                 ],
                 'en' => [
                     'name' => 'Backhand smash'
                 ],
                 'code' => 'backhand_smash_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Remate en la red (Kill)'
                 ],
                 'en' => [
                     'name' => 'Net kill'
                 ],
                 'code' => 'net_kill_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Bloqueo en la red'
                 ],
                 'en' => [
                     'name' => ' Net block'
                 ],
                 'code' => 'net_block_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Precisión'
                 ],
                 'en' => [
                     'name' => ' Accuracy'
                 ],
                 'code' => 'accuracy_16',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Posicionamiento en la pista'
                 ],
                 'en' => [
                     'name' => 'Court positioning'
                 ],
                 'code' => 'court_positioning_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Situaciones sacando'
                 ],
                 'en' => [
                     'name' => 'Serving situations'
                 ],
                 'code' => 'serving_situations_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Situaciones restando'
                 ],
                 'en' => [
                     'name' => 'Returning the serve situations'
                 ],
                 'code' => 'returning_the_serve_situations_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Subiendo a la red'
                 ],
                 'en' => [
                     'name' => 'Approaching the net'
                 ],
                 'code' => 'approaching_the_net_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Recuperación de globos'
                 ],
                 'en' => [
                     'name' => 'Lob recovery'
                 ],
                 'code' => 'lob_recovery_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Defensa remate'
                 ],
                 'en' => [
                     'name' => 'Smash defense'
                 ],
                 'code' => 'smash_defense_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Zona 1 - Ataque (red)'
                 ],
                 'en' => [
                     'name' => 'Zone 1 - Attack (net)'
                 ],
                 'code' => 'zone_1_-_attack_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Zona 2 - Transición (media pista)'
                 ],
                 'en' => [
                     'name' => 'Zone 2 - Transition (mid-court)'
                 ],
                 'code' => 'zone_2-transition_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Zona 3 - Defensa (fondo de pista)'
                 ],
                 'en' => [
                     'name' => 'Zone 3 - Defense (baseline)'
                 ],
                 'code' => 'zone_3_-_defense_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Consistencia'
                 ],
                 'en' => [
                     'name' => 'Consistency'
                 ],
                 'code' => 'consistency_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Ritmo de juego'
                 ],
                 'en' => [
                     'name' => 'Pace of play'
                 ],
                 'code' => 'pace_of_play_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'LLevar la iniciativa'
                 ],
                 'en' => [
                     'name' => 'Taking the initiative'
                 ],
                 'code' => 'taking_the_initiative_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Jugar al lado débil del rival'
                 ],
                 'en' => [
                     'name' => 'Play rival weak side'
                 ],
                 'code' => 'play_rival_weak_side_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Dirección del volante'
                 ],
                 'en' => [
                     'name' => 'Shuttlecock direction'
                 ],
                 'code' => 'shuttlecock_direction_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Golpeo paralelo'
                 ],
                 'en' => [
                     'name' => 'Down the line stroke (straight) '
                 ],
                 'code' => 'down_the_line_stroke_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Golpeo cruzado'
                 ],
                 'en' => [
                     'name' => 'Cross court stroke (diagonally) '
                 ],
                 'code' => 'cross_court_stroke_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Mover al rival'
                 ],
                 'en' => [
                     'name' => 'Move the opponent'
                 ],
                 'code' => 'move_the_opponent_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Jugar al porcentaje'
                 ],
                 'en' => [
                     'name' => 'Play percentage'
                 ],
                 'code' => 'play_percentage_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Passing shots'
                 ],
                 'en' => [
                     'name' => 'Passing shots'
                 ],
                 'code' => 'passing_shots_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Ganar la red'
                 ],
                 'en' => [
                     'name' => 'Win the net'
                 ],
                 'code' => 'win_the_net_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Variabilidad de golpeos'
                 ],
                 'en' => [
                     'name' => 'Strokes variability'
                 ],
                 'code' => 'strokes_variability_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Selección de golpeo'
                 ],
                 'en' => [
                     'name' => 'Shot selection'
                 ],
                 'code' => 'shot_selection_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Saque y volea'
                 ],
                 'en' => [
                     'name' => 'Serve and volley'
                 ],
                 'code' => 'serve_and_volley_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Saque y quedarse atrás'
                 ],
                 'en' => [
                     'name' => 'Serve and stay back'
                 ],
                 'code' => 'serve_and_stay_back_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Jugar al contrapié'
                 ],
                 'en' => [
                     'name' => 'Play to the back foot'
                 ],
                 'code' => 'play_to_the_back_foot_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Jugar a las esquinas'
                 ],
                 'en' => [
                     'name' => 'Play to corners'
                 ],
                 'code' => 'play_to_corners_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Altura del volante'
                 ],
                 'en' => [
                     'name' => 'Shuttlecock height'
                 ],
                 'code' => 'shuttlecock_height_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Contrataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack'
                 ],
                 'code' => 'counter_attack_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Estrategias dobles'
                 ],
                 'en' => [
                     'name' => 'Doubles strategies'
                 ],
                 'code' => 'doubles_strategies_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing_16',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
         ];
     }
     private function targetsSwimming()
     {
         return [
             [
                 'es' => [
                     'name' => 'Posición del cuerpo'
                 ],
                 'en' => [
                     'name' => 'Body position'
                 ],
                 'code' => 'body_position_17',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Flotación'
                 ],
                 'en' => [
                     'name' => 'Floating'
                 ],
                 'code' => 'floating_17',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Respiración'
                 ],
                 'en' => [
                     'name' => 'Breathing'
                 ],
                 'code' => 'breathing_1',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Buceo'
                 ],
                 'en' => [
                     'name' => 'Diving'
                 ],
                 'code' => 'diving_17',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Propulsión (patada)'
                 ],
                 'en' => [
                     'name' => 'Propulsion (leg kick)'
                 ],
                 'code' => 'propulsion_17',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Brazada'
                 ],
                 'en' => [
                     'name' => 'Arm action'
                 ],
                 'code' => 'arm_action_1',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Coordinación patada-brazada'
                 ],
                 'en' => [
                     'name' => 'Leg-arm coordination'
                 ],
                 'code' => 'leg-arm_coordination_17',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Rolido (rotación caderas)'
                 ],
                 'en' => [
                     'name' => 'Rotate (hip rotation)'
                 ],
                 'code' => 'rotate_17',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Crol'
                 ],
                 'en' => [
                     'name' => 'Crawl'
                 ],
                 'code' => 'crawl_1',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Espalda'
                 ],
                 'en' => [
                     'name' => 'Backstroke'
                 ],
                 'code' => 'backstroke_17',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Braza'
                 ],
                 'en' => [
                     'name' => 'Breaststroke'
                 ],
                 'code' => 'breaststroke_17',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Mariposa'
                 ],
                 'en' => [
                     'name' => ' Butterfly'
                 ],
                 'code' => 'butterfly_1',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Nado de costado'
                 ],
                 'en' => [
                     'name' => 'Sidestroke'
                 ],
                 'code' => 'sidestroke_17',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Salida'
                 ],
                 'en' => [
                     'name' => 'Start'
                 ],
                 'code' => 'start_17',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Virajes'
                 ],
                 'en' => [
                     'name' => 'Turn'
                 ],
                 'code' => 'turn_1',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Llegada'
                 ],
                 'en' => [
                     'name' => 'Finish'
                 ],
                 'code' => 'finish_17',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Aguas abiertas'
                 ],
                 'en' => [
                     'name' => 'Open waters'
                 ],
                 'code' => 'open_waters_17',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Material de flotación'
                 ],
                 'en' => [
                     'name' => 'Floating material'
                 ],
                 'code' => 'floating_material_1',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Material de propulsión'
                 ],
                 'en' => [
                     'name' => 'Propulsion material '
                 ],
                 'code' => 'propulsion_material_17',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],
             [
                 'es' => [
                     'name' => 'Estrategia de carrera'
                 ],
                 'en' => [
                     'name' => 'Race strategy'
                 ],
                 'code' => 'race_strategy_17',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Dosificación del esfuerzo'
                 ],
                 'en' => [
                     'name' => 'Effort dosage'
                 ],
                 'code' => 'effort_dosage_1',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
             [
                 'es' => [
                     'name' => 'Estrategia específica de competición'
                 ],
                 'en' => [
                     'name' => 'Specific competition strategy'
                 ],
                 'code' => 'specific_competition_strategy_17',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],           
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing_1',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => null
             ],         
         ];
     }
     private function targetsWaterpolo()
     {
         return [
             [
                 'es' => [
                     'name' => 'Habilidades de natación ofensivas'
                 ],
                 'en' => [
                     'name' => 'Offensive swimming skills'
                 ],
                 'code' => 'offensive_swimming_skills_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Manejo del balón'
                 ],
                 'en' => [
                     'name' => 'Ball handling'
                 ],
                 'code' => 'ball_handling_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Nado con balón'
                 ],
                 'en' => [
                     'name' => ' Swim with a ball'
                 ],
                 'code' => 'swim_with_a_ball_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Finta (Dribbling)'
                 ],
                 'en' => [
                     'name' => 'Fake (Dribbling) '
                 ],
                 'code' => 'fake_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Protección de balón'
                 ],
                 'en' => [
                     'name' => 'Ball protection'
                 ],
                 'code' => 'ball_protection_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Recogida de balón (Pick up)'
                 ],
                 'en' => [
                     'name' => 'Ball pick up'
                 ],
                 'code' => 'ball_pick_up_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Pase'
                 ],
                 'en' => [
                     'name' => 'Pass'
                 ],
                 'code' => 'pass_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Recepción'
                 ],
                 'en' => [
                     'name' => 'Catch (Reception)'
                 ],
                 'code' => 'catch_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Lanzamiento'
                 ],
                 'en' => [
                     'name' => 'Shot'
                 ],
                 'code' => 'shot_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],         
             [
                 'es' => [
                     'name' => 'Tiro libre'
                 ],
                 'en' => [
                     'name' => 'Free throw'
                 ],
                 'code' => 'free_throw_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => ' Penalti (5 metros)'
                 ],
                 'en' => [
                     'name' => 'Penalty shot (5 meters)'
                 ],
                 'code' => 'penalty_shot_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 3
             ],           
             [
                 'es' => [
                     'name' => 'Habilidades de natación defensivas'
                 ],
                 'en' => [
                     'name' => 'Defensive swimming skills'
                 ],
                 'code' => 'defensive_swimming_skills_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Robo de balón'
                 ],
                 'en' => [
                     'name' => 'Steal the ball'
                 ],
                 'code' => 'steal_the_ball_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],           
             [
                 'es' => [
                     'name' => 'Blocaje de tiro'
                 ],
                 'en' => [
                     'name' => 'Blocking shot'
                 ],
                 'code' => 'blocking_shot_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],           
             [
                 'es' => [
                     'name' => 'Control del oponente'
                 ],
                 'en' => [
                     'name' => 'Opponent control'
                 ],
                 'code' => 'opponent_control_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 4
             ],         
             [
                 'es' => [
                     'name' => 'Posiciones básicas'
                 ],
                 'en' => [
                     'name' => 'Basic stances '
                 ],
                 'code' => 'basic_stances_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],           
             [
                 'es' => [
                     'name' => 'Habilidades de natación'
                 ],
                 'en' => [
                     'name' => 'Swimming skills '
                 ],
                 'code' => 'swimming_skills_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],           
             [
                 'es' => [
                     'name' => 'Blocaje alto'
                 ],
                 'en' => [
                     'name' => 'High block '
                 ],
                 'code' => 'high_block_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Blocaje bajo'
                 ],
                 'en' => [
                     'name' => 'Low block'
                 ],
                 'code' => 'low_block_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],           
             [
                 'es' => [
                     'name' => 'Desvío de balón'
                 ],
                 'en' => [
                     'name' => 'Ball deflection'
                 ],
                 'code' => 'ball_deflection_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],           
             [
                 'es' => [
                     'name' => 'Parada penalti'
                 ],
                 'en' => [
                     'name' => 'Penalty save'
                 ],
                 'code' => 'penalty_save_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],         
             [
                 'es' => [
                     'name' => 'Saque de portería'
                 ],
                 'en' => [
                     'name' => 'Goal kick'
                 ],
                 'code' => 'goal_kick_18',
                 'content_exercise_id' =>  1,
                 'sub_content_session_id' => 5
             ],           
             [
                 'es' => [
                     'name' => 'Estrategia ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive strategy'
                 ],
                 'code' => 'offensive_strategy_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Ataque organizado (posicional)'
                 ],
                 'en' => [
                     'name' => 'Organized attack (Positional)'
                 ],
                 'code' => 'organized_attack_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Contraataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack (Fast break)'
                 ],
                 'code' => 'counter_attack_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Ataque directo'
                 ],
                 'en' => [
                     'name' => 'Direct attack'
                 ],
                 'code' => 'direct_attack_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Ataque combinativo'
                 ],
                 'en' => [
                     'name' => 'Combination attack'
                 ],
                 'code' => 'combination_attack_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Línea de 2 metros'
                 ],
                 'en' => [
                     'name' => '2 meters line'
                 ],
                 'code' => '2_meters_line_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Zona de 2 metros'
                 ],
                 'en' => [
                     'name' => '2 meters zone'
                 ],
                 'code' => '2_meters_zone_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Línea de 5 metros'
                 ],
                 'en' => [
                     'name' => '5 meters line'
                 ],
                 'code' => '5_meters_line_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Cambio de sistema ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive system switching'
                 ],
                 'code' => 'offensive_system_switching_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Ataque en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical superiority'
                 ],
                 'code' => 'attack_in_numerical_superiority_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Ataque en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical inferiority'
                 ],
                 'code' => 'attack_in_numerical_inferiority_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ataque en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Attack in numerical equality'
                 ],
                 'code' => 'attack_in_numerical_equality_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Juego ofensivo boya (6)'
                 ],
                 'en' => [
                     'name' => 'Hole set (6) offensive game'
                 ],
                 'code' => 'hole_set_(6)_offensive_game_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Juego ofensivo extremos / alas (1-5)'
                 ],
                 'en' => [
                     'name' => 'Wings (1-5) offensive game '
                 ],
                 'code' => 'wings_(1-5)_offensive_game_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Juego ofensivo laterales (2-4)'
                 ],
                 'en' => [
                     'name' => 'Flats (2-4) offensive game'
                 ],
                 'code' => 'flats_(2-4)_offensive_game_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Juego ofensivo central / cubre boya (3)'
                 ],
                 'en' => [
                     'name' => 'Point (3) offensive game'
                 ],
                 'code' => 'point_(3)_offensive_game_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Triángulo ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive triangle'
                 ],
                 'code' => 'offensive_triangle_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-4-2'
                 ],
                 'en' => [
                     'name' => '1-4-2 Ofensive system '
                 ],
                 'code' => '1-4-2_ofensive_system_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Sistema ofensivo 1-3-3'
                 ],
                 'en' => [
                     'name' => '1-3-3 Ofensive system '
                 ],
                 'code' => '1-3-3_ofensive_system_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Ataque 6 sobre 5 (Hombre arriba)'
                 ],
                 'en' => [
                     'name' => 'Attack 6 on 5 (Men up)'
                 ],
                 'code' => 'attack_6_on_5_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Circulación de balón'
                 ],
                 'en' => [
                     'name' => 'Ball circulation'
                 ],
                 'code' => 'ball_circulation_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Movimientos ofensivos sin balón'
                 ],
                 'en' => [
                     'name' => 'Offensive off ball movements'
                 ],
                 'code' => 'offensive_off_ball_movements_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Líneas de pase'
                 ],
                 'en' => [
                     'name' => 'Passing lanes'
                 ],
                 'code' => 'passing_lanes_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Posesión de balón'
                 ],
                 'en' => [
                     'name' => 'Ball possession'
                 ],
                 'code' => 'ball_possession_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Apoyo ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive supporting play '
                 ],
                 'code' => 'offensive_supporting_play_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Permuta ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive switching '
                 ],
                 'code' => 'offensive_switching_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Pase y va'
                 ],
                 'en' => [
                     'name' => 'Give and go'
                 ],
                 'code' => 'give_and_go_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Finalización'
                 ],
                 'en' => [
                     'name' => 'Finishing'
                 ],
                 'code' => 'finishing_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Desmarque'
                 ],
                 'en' => [
                     'name' => 'Uncheck'
                 ],
                 'code' => 'uncheck_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Fijación'
                 ],
                 'en' => [
                     'name' => 'Fixing'
                 ],
                 'code' => 'fixing_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Jugada combinativa'
                 ],
                 'en' => [
                     'name' => 'Combination play'
                 ],
                 'code' => 'combination_play_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Salida de presión'
                 ],
                 'en' => [
                     'name' => 'Playing out of pressure'
                 ],
                 'code' => 'playing_out_of_pressure_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Penetración'
                 ],
                 'en' => [
                     'name' => 'Penetration'
                 ],
                 'code' => 'penetration_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Amplitud'
                 ],
                 'en' => [
                     'name' => 'Wide play '
                 ],
                 'code' => 'wide_play_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Profundidad'
                 ],
                 'en' => [
                     'name' => 'Depth'
                 ],
                 'code' => 'depth_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Ritmo de juego'
                 ],
                 'en' => [
                     'name' => 'Pace of play'
                 ],
                 'code' => 'pace_of_play_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Rebote ofensivo'
                 ],
                 'en' => [
                     'name' => 'Offensive rebound'
                 ],
                 'code' => 'offensive_rebound_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],         
             [
                 'es' => [
                     'name' => 'Transición ofensiva'
                 ],
                 'en' => [
                     'name' => 'Offensive transition'
                 ],
                 'code' => 'offensive_transition_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 6
             ],           
             [
                 'es' => [
                     'name' => 'Estrategia defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive strategy'
                 ],
                 'code' => 'defensive_strategy_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Posicionamiento defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive positioning'
                 ],
                 'code' => 'defensive_positioning_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Defensa individual'
                 ],
                 'en' => [
                     'name' => 'Individual defense'
                 ],
                 'code' => 'individual_defense_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa presionante'
                 ],
                 'en' => [
                     'name' => 'Press defense'
                 ],
                 'code' => 'press_defense_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Defensa mixta'
                 ],
                 'en' => [
                     'name' => 'Mixed defense'
                 ],
                 'code' => 'mixed_defense_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa en zona'
                 ],
                 'en' => [
                     'name' => 'Zone defense'
                 ],
                 'code' => 'zone_defense_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Cobertura M (M Drop)'
                 ],
                 'en' => [
                     'name' => 'M Drop'
                 ],
                 'code' => 'm_drop_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa en superioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical superiority'
                 ],
                 'code' => 'defense_in_numerical_superiority_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Defensa en inferioridad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical inferiority'
                 ],
                 'code' => 'defense_in_numerical_inferiority_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa en igualdad numérica'
                 ],
                 'en' => [
                     'name' => 'Defense in numerical equality'
                 ],
                 'code' => 'defense_in_numerical_equality_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Juego defensivo boya (6)'
                 ],
                 'en' => [
                     'name' => 'Hole set (6) defensive game'
                 ],
                 'code' => 'hole_set_(6)_defensive_game_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Juego defensivo extremos / alas (1-5)'
                 ],
                 'en' => [
                     'name' => 'Wings (1-5) defensive game '
                 ],
                 'code' => 'wings_defensive_game_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Juego defensivo laterales (2-4) '
                 ],
                 'en' => [
                     'name' => 'Flats (2-4) defensive game'
                 ],
                 'code' => 'flats_defensive_game_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Juego defensivo central / cubre boya (3)'
                 ],
                 'en' => [
                     'name' => 'Point (3) defensive game'
                 ],
                 'code' => 'point_defensive_game_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Triángulo defensivo'
                 ],
                 'en' => [
                     'name' => 'Defensive triangle'
                 ],
                 'code' => 'defensive_triangle_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Cerrar líneas de pase'
                 ],
                 'en' => [
                     'name' => 'Cover passing lanes'
                 ],
                 'code' => 'cover_passing_lanes_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Cerrar líneas de tiro'
                 ],
                 'en' => [
                     'name' => 'Cover shooting lanes'
                 ],
                 'code' => 'cover_shooting_lanes_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Anticipación'
                 ],
                 'en' => [
                     'name' => 'Anticipation'
                 ],
                 'code' => 'anticipation_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Interceptación'
                 ],
                 'en' => [
                     'name' => 'Interception'
                 ],
                 'code' => 'interception_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Ayuda defensiva'
                 ],
                 'en' => [
                     'name' => 'Help defense'
                 ],
                 'code' => 'help_defense_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Línea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line'
                 ],
                 'code' => 'defensive_line_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa contrataque'
                 ],
                 'en' => [
                     'name' => 'Counter attack defense '
                 ],
                 'code' => 'counter_attack_defense_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Defensa 6 contra 5 (Men up)'
                 ],
                 'en' => [
                     'name' => '6 on 5 (Men up) defense'
                 ],
                 'code' => '6_on_5_defense_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa zona 2 metros'
                 ],
                 'en' => [
                     'name' => '2 meters zone defense'
                 ],
                 'code' => '2_meters_zone_defense_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Marcaje'
                 ],
                 'en' => [
                     'name' => 'Marking'
                 ],
                 'code' => 'marking_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Cambio de oponente'
                 ],
                 'en' => [
                     'name' => 'Opponent change'
                 ],
                 'code' => 'opponent_change_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Defensa oponente con balón'
                 ],
                 'en' => [
                     'name' => 'Opponent defense with the ball'
                 ],
                 'code' => 'opponent_defense_with_the_ball_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Defensa oponente sin balón'
                 ],
                 'en' => [
                     'name' => 'Opponent defense without the ball'
                 ],
                 'code' => 'opponent_defense_without_the_ball_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Defensa ante pase y va'
                 ],
                 'en' => [
                     'name' => 'Give and go defense'
                 ],
                 'code' => 'give_and_go_defense_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Covering'
                 ],
                 'code' => 'covering_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Repliegue'
                 ],
                 'en' => [
                 ],
                 'code' => 'retreat_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Intensidad defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive intensity'
                 ],
                 'code' => 'defensive_intensity_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Defensa tiro libre'
                 ],
                 'en' => [
                     'name' => 'Free throw defense'
                 ],
                 'code' => 'free_throw_defense_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Colaboración defensa-portero'
                 ],
                 'en' => [
                     'name' => 'Defense-goalkeeper collaboration'
                 ],
                 'code' => 'defense-goalkeeper_collaboration_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Permuta defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive switching '
                 ],
                 'code' => 'defensive_switching_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Recuperación rebote'
                 ],
                 'en' => [
                     'name' => 'Defensive rebound'
                 ],
                 'code' => 'defensive_rebound_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Pérdida de balón y recuperación'
                 ],
                 'en' => [
                     'name' => 'Turnover and recovery'
                 ],
                 'code' => 'turnover_and_recovery_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],         
             [
                 'es' => [
                     'name' => 'Transición defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive transition'
                 ],
                 'code' => 'defensive_transition_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 7
             ],           
             [
                 'es' => [
                     'name' => 'Equilibrio linea defensiva'
                 ],
                 'en' => [
                     'name' => 'Defensive line balance'
                 ],
                 'code' => 'defensive_line_balance_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],         
             [
                 'es' => [
                     'name' => 'Cobertura'
                 ],
                 'en' => [
                     'name' => 'Coverage'
                 ],
                 'code' => 'coverage_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],           
             [
                 'es' => [
                     'name' => 'Situación 1v1'
                 ],
                 'en' => [
                     'name' => '1v1 situation'
                 ],
                 'code' => '1v1_situation_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],         
             [
                 'es' => [
                     'name' => 'Posicionamiento (ángulos de juego)'
                 ],
                 'en' => [
                     'name' => 'Positioning (playing angles)'
                 ],
                 'code' => 'positioning_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 8
             ],           
             [
                 'es' => [
                     'name' => 'Timing'
                 ],
                 'en' => [
                     'name' => 'Timing'
                 ],
                 'code' => 'timing_18',
                 'content_exercise_id' =>  2,
                 'sub_content_session_id' => 9
             ],         
         ];
     }

    /**
     * Retrieve array targets repetitive for all sports
     */
    private function targetsSportRepetitive()
    {
        return [
            [
                'es' => [ 'name' => 'Calentamiento' ],
                'en' => [ 'name' => 'Warm up' ],
                'code' => 'warm_up',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 30,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Movilidad articular' ],
                'en' => [ 'name' => 'Joint mobility' ],
                'code' => 'joint_mobility',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 30,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Coordinación' ],
                'en' => [ 'name' => 'Coordination' ],
                'code' => 'coordination',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 31,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Coordinación dinámica general' ],
                'en' => [ 'name' => 'General dynamic coordination' ],
                'code' => 'dynamic_coordination',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 31,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Coordinación segmentaria' ],
                'en' => [ 'name' => 'Segmental coordination' ],
                'code' => 'segmental_coordination',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 31,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Coordinación ojo-mano' ],
                'en' => [ 'name' => 'Eye-hand coordination' ],
                'code' => 'eye_hand_coordination',
                'content_exercise_id' =>  3,
                'sub_content_session_id' =>31,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Coordinación ojo-pie' ],
                'en' => [ 'name' => 'Eye-foot coordination' ],
                'code' => 'eye_foot_coordination',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 31,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Coordinación ojo-cabeza' ],
                'en' => [ 'name' => 'Eye_head coordination' ],
                'code' => 'eye_head_coordination',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 31,
                'sport_id' =>  1,
            ],    

            [
                'es' => [ 'name' => 'Propiocepción' ],
                'en' => [ 'name' => 'Propioception' ],
                'code' => 'propioception',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 33,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Propiocepción estática estable' ],
                'en' => [ 'name' => 'Stable static Propioception' ],
                'code' => 'stable_static_propioception',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 33,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Propiocepción estática inestable' ],
                'en' => [ 'name' => 'Unstable static Propioception' ],
                'code' => 'unstable_static_propioception',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 33,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Propiocepción dinámica estable' ],
                'en' => [ 'name' => 'Stable dynamic Propioception' ],
                'code' => 'stable_dynamic_propioception',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 33,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Propiocepción dinámica inestable' ],
                'en' => [ 'name' => 'Unstable dynamic Propioception' ],
                'code' => 'unstable_dynamic_propioception',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 33,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Flexibilidad' ],
                'en' => [ 'name' => 'Flexibility' ],
                'code' => 'flexibility',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 34,
                'sport_id' =>  1,
            ],   
            [
                'es' => [ 'name' => 'Flexibilidad estática' ],
                'en' => [ 'name' => 'Static flexibility' ],
                'code' => 'static_flexibility',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 34,
                'sport_id' =>  1,
            ],            
            [
                'es' => [ 'name' => 'Flexibilidad dinámica' ],
                'en' => [ 'name' => 'Dynamic flexibility' ],
                'code' => 'dynamic_flexibility',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 34,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Flexibilidad activa' ],
                'en' => [ 'name' => 'Active flexibility' ],
                'code' => 'active_flexibility',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 34,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Flexibilidad pasiva' ],
                'en' => [ 'name' => 'Pasive flexibility' ],
                'code' => 'pasive_flexibility',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 34,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Flexibilidad general' ],
                'en' => [ 'name' => 'General flexibility' ],
                'code' => 'general_flexibility',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 34,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Flexibilidad específica' ],
                'en' => [ 'name' => 'Specific flexibility' ],
                'code' => 'specific_flexibility',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 34,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Fuerza' ],
                'en' => [ 'name' => 'Strength' ],
                'code' => 'strength',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 35,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Fuerza máxima' ],
                'en' => [ 'name' => 'Maximum strength' ],
                'code' => 'maximum_strength',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 35,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Fuerza resistencia' ],
                'en' => [ 'name' => 'Strength endurance' ],
                'code' => 'strength_endurance',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 35,
                'sport_id' =>  1,
            ],            
            [
                'es' => [ 'name' => 'Fuerza explosiva (Potencia)' ],
                'en' => [ 'name' => 'Explosive strength (Power)' ],
                'code' => 'explosive_strength',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 35,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Fuerza isométrica' ],
                'en' => [ 'name' => 'Isometric strength' ],
                'code' => 'isometric_strength',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 35,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Fuerza isotónica concéntrica' ],
                'en' => [ 'name' => 'Concentric isotonic strength' ],
                'code' => 'concentric_isotonic',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 35,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Fuerza isotónica excéntrica' ],
                'en' => [ 'name' => 'Eccentric isotonic strength' ],
                'code' => 'eccentric_isotonic',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 35,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Fuerza isotónica pliométrica' ],
                'en' => [ 'name' => 'Plyometric isotonic strength' ],
                'code' => 'plyometric_isotonic',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 35,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Fuerza auxotónica' ],
                'en' => [ 'name' => 'Auxotonic strength' ],
                'code' => 'auxotonic',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 35,
                'sport_id' =>  1,
            ],            
            [
                'es' => [ 'name' => 'Resistencia' ],
                'en' => [ 'name' => 'Endurance' ],
                'code' => 'endurance',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 36,
                'sport_id' =>  1,
            ],           
            [
                'es' => [ 'name' => 'Resistencia aeróbica ' ],
                'en' => [ 'name' => 'Aerobic endurance' ],
                'code' => 'aerobic_endurance',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 36,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Resistencia anaeróbica' ],
                'en' => [ 'name' => 'Anaerobic endurance' ],
                'code' => 'anaerobic_endurance',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 36,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Resistencia anaeróbica aláctica' ],
                'en' => [ 'name' => 'Alactic anaerobic endurance' ],
                'code' => 'alactic_anaerobic',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 36,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Resistencia anaeróbica láctica ' ],
                'en' => [ 'name' => 'Lactic anaerobic endurance' ],
                'code' => 'lactic_anaerobic',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 36,
                'sport_id' =>  1,
            ],

            [
                'es' => [ 'name' => 'Velocidad' ],
                'en' => [ 'name' => 'Reaction' ],
                'code' => 'speed',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 37,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Velocidad de reacción' ],
                'en' => [ 'name' => 'Reaction speed' ],
                'code' => 'reaction_speed',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 37,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Velocidad de desplazamiento (Cíclica)' ],
                'en' => [ 'name' => 'Displacement speed (Cyclic)' ],
                'code' => 'displacement_speed',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 37,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Velocidad gestual (Acíclica)' ],
                'en' => [ 'name' => 'Gestural speed (Acyclic)' ],
                'code' => 'gestural_speed',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 37,
                'sport_id' =>  1,
            ],

            [
                'es' => [ 'name' => 'Velocidad de cambio de dirección ' ],
                'en' => [ 'name' => 'Change of direction speed' ],
                'code' => 'change_direction_speed',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 38,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Percepción y toma de decisión' ],
                'en' => [ 'name' => 'Perception and decision making' ],
                'code' => 'perception_decision_making',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 38,
                'sport_id' =>  1,
            ],
           
            [
                'es' => [ 'name' => 'Recuperación' ],
                'en' => [ 'name' => 'Recovery' ],
                'code' => 'recovery',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 40,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Recuperación post esfuerzo' ],
                'en' => [ 'name' => 'Post effort recovery' ],
                'code' => 'post_effort_recovery',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 40,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Técnica de relajación' ],
                'en' => [ 'name' => 'Relaxation techniques' ],
                'code' => 'relaxation_techniques',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 40,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Ejercicio activo con carga' ],
                'en' => [ 'name' => 'Load active exercise' ],
                'code' => 'load_active_exercise',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 40,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Ejercicio activo sin carga' ],
                'en' => [ 'name' => 'No load active exercise' ],
                'code' => 'no_load_active_exercise',
                'content_exercise_id' =>  3,
                'sub_content_session_id' => 40,
                'sport_id' =>  1,
            ],



            
            [
                'es' => [ 'name' => 'Atención' ],
                'en' => [ 'name' => 'Attention' ],
                'code' => 'attention',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Capacidades cognitivas' ],
                'en' => [ 'name' => 'Cognitive abilities' ],
                'code' => 'cognitive_abilities',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Jugador de equipo' ],
                'en' => [ 'name' => 'Team player' ],
                'code' => 'team_player',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Concentración' ],
                'en' => [ 'name' => 'Concentration' ],
                'code' => 'concentration',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Cohesión de grupo' ],
                'en' => [ 'name' => 'Group cohesion' ],
                'code' => 'group_cohesion',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Control de estrés' ],
                'en' => [ 'name' => 'Stress control' ],
                'code' => 'stress_control',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Juego limpio' ],
                'en' => [ 'name' => 'Fair play' ],
                'code' => 'fair_play',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Motivación' ],
                'en' => [ 'name' => 'Motivation' ],
                'code' => 'motivation',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Respeto' ],
                'en' => [ 'name' => 'Respect' ],
                'code' => 'respect',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Sacrificio' ],
                'en' => [ 'name' => 'Sacrifice' ],
                'code' => 'sacrifice',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Seguridad' ],
                'en' => [ 'name' => 'Safety' ],
                'code' => 'safety',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => ' Autoestima' ],
                'en' => [ 'name' => 'Self-esteem' ],
                'code' => 'self_esteem',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Valor riesgo' ],
                'en' => [ 'name' => 'Risk value' ],
                'code' => 'risk_value',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],            
            [
                'es' => [ 'name' => 'Fuerza de Voluntad' ],
                'en' => [ 'name' => 'Willpower' ],
                'code' => 'willpower',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Constancia' ],
                'en' => [ 'name' => 'Constancy' ],
                'code' => 'constancy',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Toma de decisiones' ],
                'en' => [ 'name' => 'Decision making' ],
                'code' => 'decision_making',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Comunicación' ],
                'en' => [ 'name' => 'Communication' ],
                'code' => 'communication',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],
            [
                'es' => [ 'name' => 'Cooperación ' ],
                'en' => [ 'name' => 'Cooperation' ],
                'code' => 'cooperation',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],             
            [
                'es' => [ 'name' => 'Factores emocionales' ],
                'en' => [ 'name' => 'Emotional factors' ],
                'code' => 'emotional_factors',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
            ],       
            [
                'es' => [ 'name' => 'Otro' ],
                'en' => [ 'name' => 'Other' ],
                'code' => 'other',
                'content_exercise_id' =>  4,
                'sport_id' =>  1,
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
        $this->createTargetSession();
    }
}
