<?php

namespace App\Repositories\module;

use App\Models\Module;

class ModuleRespository implements ModuleInterface {

    // model property on class instances
    public $model;

    // Constructor to bind model to repo
    public function __construct(Module $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all()->sortBy('name');
    }

    // Store Data into Database
    public function store(array $data)
    {
        return $this->model->create([

            'name' => $data['name']
        ]);
    }

    // Get Detail by ID
    public function getById($id)
    {
        return $this->model->find($id);
    }

    // Update Data in Database
    public function update(array $data, $id)
    {
        return $this->model->find($id)->update(['name' => $data['name']]);
    }

    // Destroy Data in Database
    public function destroy(array $data)
    {
        return $this->model->find($data['module_id'])->delete();
    }
}
