<?php

namespace Modules\Evaluation\Repositories;

use Modules\Evaluation\Repositories\Interfaces\CompetenceRepositoryInterface;
use Modules\Evaluation\Entities\Competence;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;

class CompetenceRepository extends ModelRepository implements CompetenceRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'evaluation_competences';

    /**
     * @var string
     */
    protected $tableTranslations = 'evaluation_competences_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'evaluation_competence_id';

    /**
     * @var array
     */
    protected $fieldsToTranslate = ['name', 'acronym'];

    /**
     * Model
     * @var Competence $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param Competence $model
     */
    public function __construct(Competence $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return competences translations
     *
     * @return array
     */
    public function findAllTranslated()
    {
        $translationFields = collect($this->fieldsToTranslate)->map(function ($field) {
            return $this->tableTranslations . '.' . $field;
        })->toArray();

        return DB::table($this->table)
            ->select($this->table . '.*', 'resources.url', ...$translationFields)
            ->join($this->tableTranslations, $this->table . '.id', '=', $this->tableTranslations . '.' . $this->fieldAssociate)
            ->join('resources', $this->table . '.image_id', '=', 'resources.id')
            ->where($this->tableTranslations . '.locale', app()->getLocale())
            ->get();
    }

    /**
     * @param int $id
     * @return array Returns a competence translated to the locale by a given id
     */
    public function findByIdTranslated($id)
    {
        $translationFields = collect($this->fieldsToTranslate)->map(function ($field) {
            return $this->tableTranslations . '.' . $field;
        })->toArray();

        return DB::table($this->table)
            ->select($this->table . '.*', 'resources.url', ...$translationFields)
            ->join($this->tableTranslations, $this->table . '.id', '=', $this->tableTranslations . '.' . $this->fieldAssociate)
            ->join('resources', $this->table . '.image_id', '=', 'resources.id')
            ->where($this->table . '.id', '=', $id)
            ->where($this->tableTranslations . '.locale', app()->getLocale())
            ->get();
    }
}
