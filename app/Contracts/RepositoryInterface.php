<?php namespace App\Contracts;

interface RepositoryInterface
{
    public function all();

    public function create(array $data);

    public function firstOrCreate(array $attributes, array $values = []);

    public function updateOrCreate(array $attributes, array $values = []);

    public function update(array $data, $id);

    public function saveMany(array $data);

    public function delete($id);

    public function find($id);

    public function findOrFail($id);

    public function getModel();

    public function setModel($model);

    public function with($relations);

    public function findBy($attribute, $value, $expression = "=", $columns = array('*'));

    public function findByAll($attribute, $value, $expression = "=", $columns = array('*'));

    public function filterWith($attribute, $value, $expression = "=");

    public function findWhere(array $where);

    public function paginate($page_size);

    public function paginateWithTrashed($page_size);

    public function first();

    public function deleteWhere(array $where);

    public function updateExistingModel($attrs);

    public function deleteExistingModel();
}
