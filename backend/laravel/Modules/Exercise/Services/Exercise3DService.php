<?php

namespace Modules\Exercise\Services;

use Exception;
use App\Helpers\Helper;
use App\Traits\ResponseTrait;
use App\Traits\ResourceTrait;
use Illuminate\Http\Response;
use Modules\Exercise\Events\Load3DExerciseEvent;
use Modules\Exercise\Jobs\SaveThumbnail3DExerciseJob;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ExerciseRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ExerciseContentRelationRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ExerciseContentBlockRelationRepositoryInterface;

class Exercise3DService
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var object $teamRepository
     */
    protected $teamRepository;

    /**
     * @var object $exerciseRepository
     */
    protected $exerciseRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $contentRelationRepository
     */
    protected $contentRelationRepository;

    /**
     * @var $contentBlockRelationRepository
     */
    protected $contentBlockRelationRepository;

    /**
     * @var $helper
     */
    protected $helper;

    /**
     * Create a new service instance
     */
    public function __construct(
        TeamRepositoryInterface $teamRepository,
        ExerciseRepositoryInterface $exerciseRepository,
        ResourceRepositoryInterface $resourceRepository,
        ExerciseContentRelationRepositoryInterface $contentRelationRepository,
        ExerciseContentBlockRelationRepositoryInterface $contentBlockRelationRepository,
        Helper $helper
    ) {
        $this->teamRepository = $teamRepository;
        $this->exerciseRepository = $exerciseRepository;
        $this->resourceRepository = $resourceRepository;
        $this->contentRelationRepository = $contentRelationRepository;
        $this->contentBlockRelationRepository = $contentBlockRelationRepository;
        $this->helper = $helper;
    }

    /**
     * Retrieve list materials by exercise
     */
    public function listMaterials($exercise)
    {
        $materials = [];

        $url_images = sprintf('%s/%s/%s', config('resource.url'), 'sim3d', 'objects');

        if (!isset($exercise['3d'])) {
            return $materials;
        }

        $threeD = $exercise['3d'];

        if (!$threeD) {
            return $materials;
        }

        $threeD = json_decode($threeD, true);

        $objetos = $threeD['objetos'];

        if (count($objetos) == 0) {
            return $materials;
        }

        foreach ($objetos as $objeto) {
            $key = array_search($objeto['id'], array_column($materials, 'id'));

            if (is_numeric($key)) {
                $materials[$key]['count'] += 1;
            } else {
                array_push($materials, [
                    'id' => $objeto['id'],
                    'full_url' => sprintf('%s/%s.%s', $url_images, $objeto['id'], 'png'),
                    'name' => trans($objeto['id']),
                    'count' => 1
                ]);
            }
        }

        return $materials;
    }

    /**
     * Store 3D ecercise
     */
    public function store3D($content, $code)
    {
        try {
            $exercise = $this->findExercise($code);

            $dataUpdate = [];

            $dataUpdate['3d'] = $content;

            $update = $this->exerciseRepository->update($dataUpdate, $exercise);

            event(new Load3DExerciseEvent($exercise));

            dispatch(new SaveThumbnail3DExerciseJob($code))->afterResponse();

            return $update;
        } catch (Exception $exception) {
            throw $exception;
        }
    }


    /**
     * Store thumbnail 3D ecercise
     */
    public function storeThumbnail3D($thumbnail, $code)
    {
        try {
            $pathTmp = sprintf('%s/images/tmp/', public_path());
            $nameImage = sprintf('exercise.%s', $thumbnail->getClientOriginalExtension());

            $thumbnail->move($pathTmp, $nameImage);

            dispatch(new SaveThumbnail3DExerciseJob($code, $pathTmp . $nameImage))
                ->delay(now()->addSeconds(8));

            return true;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieve detail 3D exercise
     */
    public function show3D($code)
    {
        try {
            $exercise = $this->findExercise($code);

            return json_decode($exercise['3d']);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Store file 3d exercise
     */
    public function storeFile($file, $code)
    {
        try {
            $exercise = $this->findExercise($code);

            $nameFile = $exercise->code . '.' . $file->getClientOriginalExtension();

            $dataResource = $this->uploadResource('/exercises', $file, $nameFile);

            $resource = $this->resourceRepository->create($dataResource);

            return $this->exerciseRepository->update(['resource_id' => $resource->id], $exercise);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Download file
     */
    public function downloadFile($code)
    {
        try {
            $exercise = $this->findExercise($code);

            if (!$exercise->resource_id) {
                throw new Exception('Exercise does not have file', Response::HTTP_NOT_FOUND);
            }

            $resource = $this->resourceRepository->findOneBy([
                'id' => $exercise->resource_id
            ]);

            $download = $this->downloadResource($resource->url);

            if (!$download) {
                throw new Exception('File not found', Response::HTTP_NOT_FOUND);
            }

            return $download;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieve exercise by code
     */
    private function findExercise($code)
    {
        $exercise = $this->exerciseRepository->findOneBy([
            'code' => $code
        ]);

        if (!$exercise) {
            throw new Exception('Exercise not found', Response::HTTP_NOT_FOUND);
        }

        return $exercise;
    }

    /**
     * Stores and manages internal single content relations for exercise
     *
     * @param int $exerciseId
     * @param int[] $contentIds
     * @param string $action
     * @return void
     */
    private function handleContentRelations($exerciseId, $contentIds, $action = 'create')
    {
        if ($action == 'update') {
            $this->contentRelationRepository->deleteByCriteria([
                'exercise_id' => $exerciseId,
            ]);
        }

        foreach ($contentIds as $contentId) {
            $this->contentRelationRepository->create([
                'exercise_id' => $exerciseId,
                'content_exercise_id' => $contentId,
            ]);
        }
    }

    /**
     * Stores and manages internal single content relations for exercise
     *
     * @param int $exerciseId
     * @param int[] $contentBlockIds
     * @param string $action
     * @return void
     */
    private function handleContentBlockRelations($exerciseId, $contentBlockIds, $action = 'create')
    {
        if ($action == 'update') {
            $this->contentBlockRelationRepository->deleteByCriteria([
                'exercise_id' => $exerciseId,
            ]);
        }

        foreach ($contentBlockIds as $contentId) {
            $this->contentBlockRelationRepository->create([
                'exercise_id' => $exerciseId,
                'exercise_content_block_id' => $contentId,
            ]);
        }
    }
}
