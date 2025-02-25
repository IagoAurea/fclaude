<?php

namespace Modules\Tutorship\Repositories;

use Modules\Tutorship\Repositories\Interfaces\TutorshipTypeRepositoryInterface;
use Modules\Tutorship\Entities\TutorshipType;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;

class TutorshipTypeRepository extends ModelRepository implements TutorshipTypeRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'tutorship_types';

    /**
     * @var string
     */
    protected $tableTranslations = 'tutorship_type_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'tutorship_type_id';

    /**
     * @var array
     */
    protected $fieldsToTranslate = ['name'];

    /**
     * @var object
     */
    protected $model;


    public function __construct(TutorshipType $model)
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
            ->select($this->table . '.*', ...$translationFields)
            ->join($this->tableTranslations, $this->table . '.id', '=', $this->tableTranslations . '.' . $this->fieldAssociate)
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
            ->select($this->table . '.*', ...$translationFields)
            ->join($this->tableTranslations, $this->table . '.id', '=', $this->tableTranslations . '.' . $this->fieldAssociate)
            ->where($this->table . '.id', '=', $id)
            ->where($this->tableTranslations . '.locale', app()->getLocale())
            ->get();
    }

    /**
     * Delete an object model.
     *
     * @param int $id
     * @return bool the object delete
     *
     */
    public function delete($id)
    {
        DB::table($this->tableTranslations)
            ->where($this->tableTranslations . '.' . $this->fieldAssociate, '=', $id)
            ->delete();

        $object = $this->find($id);

        if ($object) {
            return $object->delete();
        }

        return false;
    }
}
