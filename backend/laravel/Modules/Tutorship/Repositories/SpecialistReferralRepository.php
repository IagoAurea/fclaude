<?php

namespace Modules\Tutorship\Repositories;

use Modules\Tutorship\Repositories\Interfaces\SpecialistReferralRepositoryInterface;
use Modules\Tutorship\Entities\SpecialistReferral;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;

class SpecialistReferralRepository extends ModelRepository implements SpecialistReferralRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'specialist_referrals';

    /**
     * @var string
     */
    protected $tableTranslations = 'specialist_referral_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'specialist_referral_id';

    /**
     * @var array
     */
    protected $fieldsToTranslate = ['name'];

    /**
     * @var object
     */
    protected $model;


    public function __construct(SpecialistReferral $model)
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
