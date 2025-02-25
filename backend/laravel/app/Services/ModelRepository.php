<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ModelRepository
{
    /**
     * @var object
     */
    protected $_model;

    /**
     * @var array
     */
    protected $relations;

    public function __construct(Model $model, array $relations = [])
    {
        $this->_model = $model;
        $this->relations = $relations;
    }

    /**
     * Create an object model.
     *
     * @param array $data
     *
     * @return object the object create
     *
     */
    public function create(array $data)
    {
        return $this->_model->create($data);
    }

    /**
     * Finds an item and if case it does not exists, it creates it from same searching criteria
     *
     * @param array $criteria
     * @return object
     */
    public function findOrCreate(array $criteria)
    {
        $item = $this->findOneBy($criteria);

        if (!$item) {
            return $this->create($criteria);
        }

        return $item;
    }

    /**
     * Create or Update an object model.
     *
     * @param array $data
     *
     * @return object the object create
     *
     */
    public function updateOrCreate(array $data, array $dataUpdate = [])
    {
        return $this->_model->updateOrCreate($data, $dataUpdate);
    }

    /**
     * Update an object model.
     *
     * @param array $dataUpdate
     * @param int|array|object $component
     * @param boolean $allRegister
     * @return bool the object update
     *
     */
    public function update(array $dataUpdate, $component, $allRegister = false)
    {
        if (is_numeric($component)) {
            return $this->_model->where($component)->update($dataUpdate);
        }

        if (is_array($component) && $allRegister) {
            return $this->_model->where($component)->update($dataUpdate);
        }

        if (is_array($component)) {
            return $this->_model->where($component)->first()->update($dataUpdate);
        }

        return $component->update($dataUpdate);
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
        $object = $this->find($id);

        if ($object) {
            return $object->delete();
        }

        return false;
    }

    /**
     * Force Delete an object model.
     *
     * @param Array $criteria
     * @return void
     *
     */
    public function forceDelete(array $criteria)
    {
        $model = $this->_model->where($criteria)->first();

        if ($model) {
            $model->forceDelete();
        }
    }

    /**
     * Delete bulk of items depending on some given conditions
     *
     * @param Array $criteria
     * @return Boolean|NULL
     */
    public function bulkDelete(array $criteria)
    {
        return $this->_model->where($criteria)->delete();
    }

    /**
     * Finds models paginate a set of criteria.
     *
     * @param int   $numberPaginate
     * @param array $criteria
     *
     * @return array The objects.
     *
     */
    public function paginate(int $numberPagination, array $criteria)
    {
        $query = $this->_model;

        if (count($this->relations) > 0) {
            $query = $query->with($this->relations);
        }

        return $query->where($criteria)->paginate($numberPagination);
    }

    /**
     * Finds models by a set of criteria.
     *
     * @param array $criteria
     * @param array $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array The objects.
     *
     */
    public function findBy(array $criteria, array $orderBy = [], $limit = null, $offset = null)
    {
        $query = $this->_model;

        if (!empty($this->relations)) {
            $query = $query->with($this->relations);
        }

        if (count($orderBy) > 0) {
            foreach ($orderBy as $key => $value) {
                $query = $query->orderBy($key, $value);
            }
        }

        if (isset($offset)) {
            $query = $query->offset($offset);
        }

        if ($limit !== null) {
            $query = $query->limit($limit);
        }

        return $query->where($criteria)->get();
    }

    /**
     * Finds all models in the repository.
     * @return array The models.
     */

    public function findAll()
    {
        return $this->findBy([]);
    }

    /**
     * Finds a single model by a set of criteria.
     *
     * @param array      $criteria
     * @return object|null The entity instance or NULL if the entity can not be found.
     *
     */

    public function findOneBy(array $criteria, array $fields = [])
    {
        $query = $this->_model;

        if (count($fields) > 0) {
            $query = $query->select($fields);
        }

        if (!empty($this->relations)) {
            $query = $query->with($this->relations);
        }

        return $query->where($criteria)->first();
    }

    /**
     * Finds an model by its primary key / identifier.
     *
     * @param mixed    $id          The identifier.
     * @return object|null The model instance or NULL if the model can not be found.
     */
    public function find($id)
    {
        $query = $this->_model;

        if (!empty($this->relations)) {
            $query = $query->with($this->relations);
        }

        return $query->find($id);
    }

    /**
     * Finds all models by translation in the repository.
     * @param string $table
     * @param string $tableTranslations
     * @param string $fieldAssociate
     * @return Collection The models.
     */
    public function findAllByLocale($table, $tableTranslations, $fieldAssociate, $fields = ['name'], $where = [])
    {
        $translationFields = collect($fields)->map(function ($field) use ($tableTranslations) {
            return $tableTranslations . '.' . $field;
        })->toArray();

        $query = DB::table($table)
            ->select($table . '.*', ...$translationFields)
            ->join($tableTranslations, $table . '.id', '=', $tableTranslations . '.' . $fieldAssociate)
            ->where($tableTranslations . '.locale', app()->getLocale());

        if(count($where) > 0) {
            $query = $query->where($where);
        }

        return $query->get();
    }

    /**
     * Search model depending params on the array given
     *
     * @param string $columnName Is the name of the column to make the query on
     * @param array $items Is the array of items (permission names in this case) to be searched
     * @return collection objects found
     */
    public function findIn($columnName, array $items = [])
    {
        return $this->_model
            ->whereIn($columnName, $items)
            ->get();
    }

    /**
     * Searchs a model with multiple orWhere clausules sent in an array
     *
     * NOTE: both conditionals arrays must have it complete expresion implemented by
     * [0] => column_name
     * [1] => operator
     * [3] => value
     *
     * EXAMPLE: $firstCondition = ['name', '=', 'foo'];
     *          $subConditions = [
     *              ['age', '>', 20],
     *              ['section', '=', 'B'],
     *          ];
     *
     * @param array $firstCondition Array of first main condition
     * @param array $subConditions Array of secondary set of conditions
     * @return array objects found
     */
    public function findOrWhere(array $firstCondition, array $subConditions)
    {
        return $this->_model
            ->where($firstCondition)
            ->orWhere(function ($query) use ($subConditions) {
                foreach ($subConditions as $subCondition) {
                    $query->where($subCondition);
                }
            })
            ->get()->first();
    }

    /**
     * Search model depending params on the array given
     *
     * @param string $columnName Is the name of the column to make the query on
     * @param array $items Is the array of items (permission names in this case) to be searched
     * @return collection objects found
     */
    public function findNotIn($columnName, array $items = [])
    {
        return $this->_model
            ->whereNotIn($columnName, $items)
            ->get();
    }

    /**
     * Return array object random
     * @return collection object random
     */
    public function getRandom()
    {
        return $this->_model
            ->inRandomOrder()
            ->get();
    }

    /**
     * Finds models by a set of criteria.
     *
     * @param array $criteria
     * @param int|null   $limit
     *
     * @return array The objects.
     *
     */
    public function deleteByCriteria(array $criteria, $limit = null)
    {
        $query = $this->_model;

        if ($limit !== null) {
            $query = $query->limit($limit);
        }

        return $query->where($criteria)->delete();
    }

    /**
     * Search model depending params on the array given
     *
     * @param string $columnName Is the name of the column to make the query on
     * @param array $items Is the array of items (permission names in this case) to be searched
     * @return collection objects found
     */
    public function deleteIn($columnName, array $items = [])
    {
        return $this->_model
            ->whereIn($columnName, $items)
            ->delete();
    }
}
