<?php

namespace Modules\Fisiotherapy\Services;

use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;

// Repositories
use Modules\Fisiotherapy\Repositories\Interfaces\FileRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;

class FileService
{
    use ResponseTrait;

    /**
     * @var object $fileRepository
     */
    protected $fileRepository;

    /**
     * @var object $playerRepository
     */
    protected $playerRepository;

    /**
     * Create a new service instance
     */
    public function __construct(
        FileRepositoryInterface $fileRepository,
        PlayerRepositoryInterface $playerRepository
    ) {
        $this->fileRepository = $fileRepository;
        $this->playerRepository = $playerRepository;
    }

    /**
     * Returns the list of all files related to the player
     * 
     * @return Array
     */
    public function fileList($playerId)
    {
        $player = $this->playerRepository->findOneBy([
            'id' => $playerId
        ]);

        return [
            'id' => $player->id,
            'team_id' => $player->team_id,
            'full_name' => $player->full_name,
            'files' => $player->files
        ];
    }

    /**
     * Stores a new file row in the database
     * 
     * @return void
     */
    public function store($requestData, $playerId)
    {
        try {

            $requestData['player_id'] = $playerId;
            $requestData['start_date'] = Carbon::now()->toDateTimeString();

            $file = $this->fileRepository->create($requestData);

            return $file;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieves information about specific file
     * 
     * @return object
     */
    public function find($fileId)
    {
        try {
            $file = $this->fileRepository->findOneBy([
                'id' => $fileId
            ]);

            if (!$file) {
                throw new Exception('File not found', Response::HTTP_NOT_FOUND);
            }

            $file->player;
            $file->player->team;
            $file->player->team->club;
            $file->player->setAppends([]);

            $file->teamStaff;

            return $file;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Updates information about a file
     * 
     * @return object
     */
    public function update($requestData, $fileId)
    {
        try {
            $file = $this->fileRepository->findOneBy([
                'id' => $fileId
            ]);

            if (!$file) {
                throw new Exception('File not found', Response::HTTP_NOT_FOUND);
            }

            // Checks if has_ended boolean value has been sent
            $hasEnded = isset($requestData['has_ended']) ? $requestData['has_ended'] : false;

            // In case has_ended is true, sets the current timestamp as the discharging date
            $requestData['discharge_date'] = $hasEnded ? Carbon::now()->toDateTimeString() : null;

            return $this->fileRepository->update($requestData, $file);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Deletes a file information from database
     * 
     * @return boolean
     */
    public function destroy($fileId)
    {
        try {
            $file = $this->fileRepository->findOneBy([
                'id' => $fileId
            ]);

            if (!$file) {
                throw new Exception('File not found', Response::HTTP_NOT_FOUND);
            }

            $this->fileRepository->delete($file->id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
