<?php

namespace Modules\Training\Repositories;

use App\Services\ModelRepository;
use Modules\Training\Entities\SubContentSession;
use Modules\Training\Repositories\Interfaces\SubContentSessionRepositoryInterface;

class SubContentSessionRepository extends ModelRepository implements SubContentSessionRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'sub_content_sessions';

    /**
     * @var string
    */
    protected $tableTranslations = 'sub_content_session_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'sub_content_session_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(SubContentSession $model)
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
     * Public function to retrieve the subcontent by content
     * 
     * @return Collection 
     */

    public function listByContent($code){

        $locale = app()->getLocale();
        
        $subContents = $this->model
            ->whereHas('content_exercise', function ($query) use($code){
                $query->where('code',$code);
            })
            ->withTranslation($locale)
            ->get();
        
        return $subContents;
    }
}