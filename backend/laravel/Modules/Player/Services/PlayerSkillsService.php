<?php

namespace Modules\Player\Services;

use Exception;
use App\Traits\ResponseTrait;
use Modules\Player\Entities\Player;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerSkillsRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PunctuationRepositoryInterface;

class PlayerSkillsService 
{
    use ResponseTrait;

    /**
     * @var $playerSkillsRepository
     */
    protected $playerSkillsRepository;

    /**
     * @var $playerService
     */
    protected $playerRepository;

    /**  
     * @var $punctuationRepository
     */
   protected $punctuationRepository;

    public function __construct(
        PlayerSkillsRepositoryInterface $playerSkillsRepository,
        PlayerRepositoryInterface $playerRepository,
        PunctuationRepositoryInterface $punctuationRepository
    ) {
        $this->playerSkillsRepository = $playerSkillsRepository;
        $this->playerRepository = $playerRepository;
        $this->punctuationRepository = $punctuationRepository;
    }


    /**
     * Response success
     * @param array $skills
     * @param int $player_id
     * @return array
     */
    public function createOrUpdateSkills($skills, $player_id)
    {     
        $dataResponse = [
            "success" => true,
            "message" => "",
        ];

        $player = $this->playerRepository->find($player_id); 

        if (!$player instanceof Player ) {
          $dataResponse['success'] = false;
          $dataResponse['message'] = "The player not found";
          return $dataResponse ;
        }

        try {

            $result = 0;

            if (!$player->skills->isEmpty()) { 

                $skills_player = $this->playerSkillsRepository->findSkillsByPlayer($player_id); 

                foreach ($skills_player as $skill_player) {
    
                    foreach ( $skills as $skill ) {
    
                        if ($skill_player->skills_id == $skill['skills_id']) {
                            $skill_player->punctuation_id  = $skill['punctuation_id']; 
                            $skill_player->update();

                            $punctuation = $this->punctuationRepository->find($skill['punctuation_id']); 
                            
                            $result = $result + $punctuation->value;
                        }

                    }
                }
            }
            else {

                foreach ( $skills as $skill ) {
                    $skill['player_id'] = $player_id;
                    $skill = $this->playerSkillsRepository->create($skill);
    
                    $result = $result + $skill->punctuation->value;
                } 

            }

            $player->performance_assessment = $result; 
            $player->update();

            $data['skills']= $skills;
            $data['performance_assessment']= $result;

           
            $dataResponse['success'] = true;
            $dataResponse['message'] = "Player assessment Calculation";
            $dataResponse['data']= $data;

            return $dataResponse;

        } catch(Exception $exception) {

            $dataResponse['success'] = false;
            $dataResponse['message'] = $exception->getMessage();
            $dataResponse['data']= null;

            return $this->error($exception->getMessage());

        }

    }

}