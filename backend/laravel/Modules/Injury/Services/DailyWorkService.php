<?php

namespace Modules\Injury\Services;

use Exception;
use App\Traits\ResponseTrait;
use Modules\Injury\Repositories\Interfaces\DailyWorkRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryRfdRepositoryInterface;



class DailyWorkService 
{
    use ResponseTrait;

    /**
     * @var $dailyWorkRepository
     */
    protected $dailyWorkRepository;

    /**
     * @var $rfdRepository
     */
    protected $rfdRepository;


    public function __construct(
        DailyWorkRepositoryInterface $dailyWorkRepository,
        InjuryRfdRepositoryInterface $rfdRepository
    ) 
    {
        $this->dailyWorkRepository = $dailyWorkRepository;
        $this->rfdRepository = $rfdRepository;
    }

    /**
     * Response success
     * @param int $rfd_id
     * @return array
     */
    public function calculateDailyWork($request)
    {     
        try {

            $rfd = $this->rfdRepository->find($request['injury_rfd_id']);

            if (!$rfd) {
                $dataResponse['success'] = false;
                $dataResponse['message'] = "The rfd not found";
                return $dataResponse ;
            }

            $dataResponse = [
                "success" => true,
                "message" => "",
                "data" => "",
            ];

            $dailyWorks = $rfd->daily_works->take(7); 
            $nums = [];

        
            $request['training_load'] = $request['rpe'] * INTVAL($request['duration']) ;

            array_push($nums, $request['training_load']);

            foreach ($dailyWorks as $dailyWork) {
                array_push($nums, $dailyWork->training_load);
            }

            $request['monotony'] = 0;
            $request['training_strain'] = 0;
            
            if (count($nums) > 1) {
                $request['monotony'] = $this->round($this->calculateMedia($nums) / $this->calculateStandarDeviation($nums),2) ; 
                $request['training_strain'] = $this->round (array_sum($nums) /  $request['monotony'],2); 
            }
       
            $dataResponse['success'] = true;
            $dataResponse['message'] = "Daily calculate";
            $dataResponse['data'] = $request; 

            return    $dataResponse;

        } catch(Exception $exception) {

            $dataResponse['success'] = false;
            $dataResponse['message'] = $exception->getMessage();
            return $dataResponse ;

        }

    }

    private function calculateStandarDeviation($nums)
    {
        $media = $this->calculateMedia($nums); 

        $sum2=0;
        for($i=0;$i<count($nums);$i++){
            $sum2+=($nums[$i]-$media)*($nums[$i]-$media);
        }
        $vari = $sum2/count($nums);
        $sq = sqrt($vari);
        
        if ($sq == 0) $sq = 1; 

        return $sq ; 
    }

    private function calculateMedia ($nums)
    {
        $sum= array_sum($nums);

        $media = $sum/count($nums);

        return $media ; 
    }

    private function round ($numbers, $decimals) {
        $factor = pow(10, $decimals);
        return (round($numbers*$factor)/$factor); 
    }

}