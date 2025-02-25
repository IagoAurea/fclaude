<?php

namespace Modules\Exercise\Jobs;

use App\Helpers\Helper;
use App\Traits\ResourceTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Modules\Exercise\Repositories\Interfaces\ExerciseRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class SaveThumbnail3DExerciseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ResourceTrait;

    const PATH_PUBLIC_IMAGE_TMP = '/images/tmp/';

    const NAME_IMAGE_TMP = 'exercise.png';

    /**
     * var $code
     */
    private $code;

    /**
     * var $path
     */
    private $path;

    /**
     * var $pathImageTmp
     */
    private $pathImageTmp;

    /**
     * @var object $exerciseRepository
     */
    protected $exerciseRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $helper
     */
    protected $helper;

    /** @var $optimizerChain */
    protected $optimizerChain;

    /**
     * @var $urlImageDelete
     */
    protected $urlImageDelete;

    /**
     * @var $idImageDelete
     */
    protected $idImageDelete;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($code, $path = null)
    {
        $this->code = $code;
        $this->path = $path;
        $this->exerciseRepository = resolve(ExerciseRepositoryInterface::class);
        $this->resourceRepository = resolve(ResourceRepositoryInterface::class);
        $this->helper = resolve(Helper::class);
        $this->optimizerChain =  OptimizerChainFactory::create();
        $this->pathImageTmp = !is_null($path) ? $path : sprintf('%s%s%s', public_path(), self::PATH_PUBLIC_IMAGE_TMP, self::NAME_IMAGE_TMP);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $exercise = $this->exerciseRepository->findOneBy([
            'code' => $this->code
        ]);

        if (is_null($this->path)) {
            $content = json_decode($exercise['3d'], true);

            if (!$content && !isset($content['thumbnail'])) {
                return true;
            }

            $this->transformBase64toImage($content['thumbnail']);
        }

        $this->optimizerChain->optimize($this->pathImageTmp);

        $dataResource = $this->uploadResource('/exercises/3d', $this->pathImageTmp);

        if ($exercise->image_id) {
            $this->urlImageDelete = $exercise->image->url;
            $this->idImageDelete = $exercise->image_id;
        }

        $resource = $this->resourceRepository->create($dataResource);

        $dataUpdate = [
            'image_id' => $resource->id,
        ];

        if (is_null($this->path)) {
            $content['thumbnail'] = null;

            $dataUpdate['3d'] = json_encode($content);
        }

        $this->exerciseRepository->update($dataUpdate, $exercise);

        $this->deleteImage();

        unlink($this->pathImageTmp);
    }

    /**
     * Function transform base64 to image png
     */
    private function transformBase64toImage($thumbnail)
    {
        /*Old save base64 to image*/
        //file_put_contents($path_tmp, base64_decode($exercise['3d']['thumbnail']));

        /*New save base64 to image*/
        // Obtain the original content (usually binary data)
        $bin = base64_decode($thumbnail);

        // Load GD resource from binary data
        $im = imageCreateFromString($bin);

        imagepng($im, $this->pathImageTmp, 0);
        /*--End new save-----------*/
    }

    /**
     * Delete old image
     */
    private function deleteImage()
    {
        if ($this->urlImageDelete) {
            $this->deleteResource($this->urlImageDelete);
            $this->resourceRepository->delete($this->idImageDelete);
        }
    }
}
