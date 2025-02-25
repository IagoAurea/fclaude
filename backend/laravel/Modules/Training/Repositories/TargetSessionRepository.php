<?php

namespace Modules\Training\Repositories;

use App\Services\ModelRepository;
use Modules\Training\Entities\TargetSession;
use Modules\Training\Repositories\Interfaces\TargetSessionRepositoryInterface;

class TargetSessionRepository extends ModelRepository implements TargetSessionRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'target_sessions';

    /**
     * @var string
    */
    protected $tableTranslations = 'target_session_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'target_session_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(TargetSession $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return diet translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

    /**
     * Public function to retrieve the targets by content
     * 
     * @return Collection 
     */

    public function findAllByContent($content_exercise_code, $sport_code)
    {
        $locale = app()->getLocale();

        $targets = $this->model
            ->select('id','content_exercise_id','sport_id')
            ->whereHas('content_exercise', function ($query) use($content_exercise_code){
                $query->where('code', $content_exercise_code);
            })
            ->whereHas('sport', function ($query) use($sport_code){
                $query->where('code', $sport_code);
            })
            ->withTranslation($locale)
            ->get();
        
        return $targets;
    }

    /**
     * Public function to retrieve the targets by sub content
     *
     * @return Collection
     */

    public function findAllBySubContent($sub_content_session_code, $sport_code)
    {
        $locale = app()->getLocale();

        $targets = $this->model
            ->select('id','sub_content_session_id','sport_id')
            ->whereHas('sub_content_session', function ($query) use($sub_content_session_code){
                $query->where('code', $sub_content_session_code);
            })
            ->whereHas('sport', function ($query) use($sport_code){
                $query->where('code', $sport_code);
            })
            ->withTranslation($locale)
            ->get();
        
        return $targets;
    }
}