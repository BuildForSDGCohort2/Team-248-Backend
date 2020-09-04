<?php

namespace App\Repositories;

use App\Contracts\RepositoryInterface;

class BaseRepository implements RepositoryInterface
{
    // model property on class instances
    protected $model;

    /**
     * Get all instances of model
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * create a new record in the database
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * create or updated record from the database
     * @param array $attributes
     * @param array $values
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * update record in the database
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $record = $this->findOrFail($id);
        return $record->update($data);
    }

    /**
     * remove record from the database
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * find or return exception if not found
     * @param $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Eager load database relationships
     * @param $relations
     * @return mixed
     */
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     * @return mixed
     */
    public function findWhere(array $where)
    {
        $condition = '=';
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $value) = $value;
            }
            $this->model = $this->model->where($field, $condition, $value);
        }
        return $this;
    }

    /**
     * get data paginated
     * @param $page_size
     * @return mixed
     */
    public function paginate($pageSize)
    {
        return $this->model->paginate($pageSize);
    }

    /**
     * remove record from the database
     * @param $column
     * @param array $values
     * @return mixed
     */
    public function deleteWhere(array $where)
    {
        return $this->findWhere($where)->model->delete();
    }

    public function first()
    {
        return $this->model->first();
    }
}
