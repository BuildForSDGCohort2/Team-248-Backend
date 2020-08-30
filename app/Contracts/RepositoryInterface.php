<?php namespace App\Contracts;

interface RepositoryInterface
{
    public function all();

    public function create(array $data);

    public function updateOrCreate(array $attributes, array $values = []);

    public function update(array $data, $id);

    public function delete($id);

    public function findOrFail($id);

    public function with($relations);

    public function findWhere(array $where);

    public function paginate($page_size);
    
    public function deleteWhere(array $where);
}
