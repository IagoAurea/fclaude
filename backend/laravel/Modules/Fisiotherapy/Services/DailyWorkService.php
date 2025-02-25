<?php

namespace Modules\Fisiotherapy\Services;

use Exception;
use Illuminate\Http\Response;
use App\Traits\ResponseTrait;
use Modules\Fisiotherapy\Repositories\Interfaces\FileRepositoryInterface;
use Modules\Fisiotherapy\Repositories\Interfaces\DailyWorkRepositoryInterface;

class DailyWorkService
{
    use ResponseTrait;

    /**
     * @var object $dailyWorkRepository
     */
    protected $dailyWorkRepository;

    /**
     * @var object $fileRepository
     */
    protected $fileRepository;

    /**
     * Create a new service instance
     */
    public function __construct(
        DailyWorkRepositoryInterface $dailyWorkRepository,
        FileRepositoryInterface $fileRepository
    ) {
        $this->dailyWorkRepository = $dailyWorkRepository;
        $this->fileRepository = $fileRepository;
    }

    /**
     * Returns the list of all files related to the player
     * 
     * @return Array
     */
    public function dailyWorkList($fileId)
    {
        $file = $this->fileRepository->findOneBy([
            'id' => $fileId
        ]);

        if (!$file) {
            throw new Exception('File not found', Response::HTTP_NOT_FOUND);
        }

        return [
            'file_id' => $file->id,
            'title' => $file->title,
            'daily_works' => $file->dailyWorks ?: []
        ];
    }

    /**
     * Stores a new file row in the database
     * 
     * @return void
     */
    public function store($requestData, $fileId)
    {
        try {
            $requestData['file_id'] = $fileId;

            return $this->dailyWorkRepository->create($requestData);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieves information about specific file
     * 
     * @return object
     */
    public function find($workId)
    {
        try {
            $work = $this->dailyWorkRepository->findOneBy([
                'id' => $workId
            ]);

            if (!$work) {
                throw new Exception('Daily Work not found', Response::HTTP_NOT_FOUND);
            }

            $work->file;

            return $work;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Updates information about a file
     * 
     * @return object
     */
    public function update($requestData, $workId)
    {
        try {
            $work = $this->dailyWorkRepository->findOneBy([
                'id' => $workId
            ]);

            if (!$work) {
                throw new Exception('Daily Work not found', Response::HTTP_NOT_FOUND);
            }

            return $this->dailyWorkRepository->update($requestData, $work);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Deletes a file information from database
     * 
     * @return boolean
     */
    public function destroy($workId)
    {
        try {
            $work = $this->dailyWorkRepository->findOneBy([
                'id' => $workId
            ]);

            if (!$work) {
                throw new Exception('Daily Work not found', Response::HTTP_NOT_FOUND);
            }

            $this->dailyWorkRepository->delete($work->id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
