<?php namespace App\Repositories;

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
     * create or get first of record from the database
     * @param array $attributes
     * @param array $values
     * @return mixed
     */
    public function firstOrCreate(array $attributes, array $values = []){
        return $this->model->firstOrCreate($attributes, $values);
    }

    /**
     * create or updated record from the database
     * @param array $attributes
     * @param array $values
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = []){
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
        $record = $this->find($id);
        return $record->update($data);
    }

    /**
     * save related table into the database
     * @param array $data
     */
    public function saveMany(array $data)
    {
        foreach ($data as $model_data){
            $this->model->updateOrCreate($model_data['attributes'], $model_data['values']);
        }
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
     * remove record from the database
     * @param $column
     * @param array $values
     * @return mixed
     */
    public function deleteManyNotIn($column, array $values)
    {
        return $this->model->whereNotIn($column, $values)->destroy();
    }

    /**
     * show the record with the given id
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
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
     * Get the associated model
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the associated model
     * @param $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
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
     * find record using column name and value
     * @param $attribute
     * @param $value
     * @param string $expression
     * @param string[] $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $expression = "=", $columns = array('*')) {
        return $this->model->where($attribute, $expression, $value)->first($columns);
    }

    /**
     * find record using column name and value
     * @param $attribute
     * @param $value
     * @param string $expression
     * @param string[] $columns
     * @return mixed
     */
    public function findByAll($attribute, $value, $expression = "=", $columns = array('*')) {
        return $this->model->where($attribute, $expression, $value)->get($columns);
    }

    /**
     * preform where condition
     * @param $attribute
     * @param $value
     * @param string $expression
     * @return mixed
     */
    public function filterWith($attribute, $value, $expression = "="){
        $this->model = $this->model->where($attribute, $expression, $value);
        return $this;
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     * @return mixed
     */
    public function findWhere(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
        return $this;
    }

    /**
     * get data paginated
     * @param $page_size
     * @return mixed
     */
    public function paginate($page_size) {
        return $this->model->paginate($page_size);
    }

    /**
     * get data paginated including the trashed data
     * @param $page_size
     * @return mixed
     */
    public function paginateWithTrashed($page_size) {
        return $this->model->withTrashed()->paginate($page_size);
    }

    /**
     * Select the first record from the database
     * @return mixed
     */
    public function first()
    {
        return $this->model->first();
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

    // update the existing model that came from the model binding
    public function updateExistingModel($attrs)
    {
        return $this->model->update($attrs);
    }

    // delete the existing model that came from the model binding
    public function deleteExistingModel()
    {
        return $this->model->delete();
    }
}
