<?php

namespace Modules\Exercise\Repositories;

use Modules\Exercise\Repositories\Interfaces\ContentExerciseRepositoryInterface;
use Modules\Exercise\Entities\ContentExercise;
use App\Services\ModelRepository;

class ContentExerciseRepository extends ModelRepository implements ContentExerciseRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(ContentExercise $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return translations
     *
     */
    public function findAllTranslated()
    {
        $query = $this->model
                    ->with(['image' => function($query) {
                      $query->select('id','url','size','mime_type');
                    }])
                    ->withTranslation(app()->getLocale())->get();

        $query->makeHidden('image_id');

        return $query;
    }

    /**
     *  Return translations
     *
     */
    public function findAllSubcontentsWithTarget($sport)
    {
        $locale = app()->getLocale();

        $sport_id = $sport->id;

        $query = $this->model
            ->with(['sub_contents' => function ($query) use ($locale, $sport_id) {
                $query->withTranslation($locale);
                $query->with(['targets' => function ($query) use ($sport_id) {
                    $query->where('sport_id', $sport_id);
                }]);
            }])
            ->with(['targets' => function ($query) use ($sport_id) {
                $query->whereNull('sub_content_session_id');
                $query->where('sport_id', $sport_id);
            }])
            ->withTranslation($locale)->get();

        $query->makeHidden('image_id');

        return $query;
    }
}
