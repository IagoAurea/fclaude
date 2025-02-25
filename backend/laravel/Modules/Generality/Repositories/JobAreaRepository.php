<?php

namespace Modules\Generality\Repositories;

use Modules\Generality\Repositories\Interfaces\JobAreaRepositoryInterface;
use Modules\Generality\Entities\JobArea;
use App\Services\ModelRepository;

class JobAreaRepository extends ModelRepository implements JobAreaRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    /** 
     * @var string
     */
    protected $table = 'jobs_area';

    /** 
     * @var string
     */
    protected $tableTranslations = 'job_area_translations';
    
    /** 
     * @var string
     */
    protected $fieldAssociate = 'job_area_id';

    public function __construct(JobArea $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Retrieves all job areas with positions
     *  
     * @OA\Schema(
     * schema="ListJobAreasResponse",
     * type="object",
     * description="Returns the list of classroom exercises",
     * @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="List of classroom exercises"),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="name", type="string", example="string"),
     *          @OA\Property(
     *              property="positions",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="jobs_area_id", type="int64", example="1"),
     *                  @OA\Property(property="code", type="string", example="string"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *              ),
     *          ),
     *      ),
     *  ),
     * )
     */
    public function findAllTranslated()
    {
        return $this->model->with('positions')->get();
    }
}
