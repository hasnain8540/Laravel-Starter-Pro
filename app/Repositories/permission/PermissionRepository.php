<?php

namespace App\Repositories\permission;

use App\Models\Module;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionInterface
{
    // model property on class instances
    public $model;

    // Constructor to bind model to repo
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->join('modules','modules.id','=','permissions.module_id')
            ->select('permissions.*','modules.name as module')->get();

    }

    // Get Module List
    public function getModule()
    {
        return Module::get();
    }

    // Store Permission in Database
    public function store(array $data)
    {
        return $this->model->create([

            'module_id' => $data['module'],
            'name' => $data['name'],
            'type' => $data['type']
        ]);
    }

    // Get Permission Detail By ID
    public function getById($id)
    {
        return $this->model->join('modules','modules.id','=','permissions.module_id')
            ->select('permissions.*','modules.name as module')->where('permissions.id','=',$id)->first();
    }

    // Update Permission Data in Database
    public function update(array $data, $id)
    {
        return $this->model->find($id)->update([

            'module_id' => $data['module'],
            'name' => $data['name'],
            'type' => $data['type']
        ]);
    }

    // Get Associated Role Against Permission
    public function associatedRole($id)
    {
        return $this->model->join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')
            ->join('roles','roles.id','=','role_has_permissions.role_id')
            ->select('roles.name as role','permissions.*')->where('permissions.id','=',$id)->get();
    }

    // Destroy Permission in Database
    public function destroy(array $data)
    {
        return $this->model->find($data['permission_id'])->delete();
    }
}
