<?php

namespace App\Repositories\role;

use App\Models\Module;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;

class RoleRepository implements RoleInterface
{
    // model property on class instances
    public $model;

    // Constructor to bind model to repo
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all()->sortBy('name');
    }

    // Get Module List
    public function getModule()
    {
        return Module::get();
    }

    // Store Data into Database
    public function store(array $data)
    {
        $role = $this->model->create([

            'name' => $data['name'],
            'guard_name' => 'web'
        ]);

        if(isset($data['permission']))
        {
            $permissions = $data['permission'];
        }else{
            $permissions = [];
        }

        $aleardy_permisssions = DB::table('role_has_permissions')->where('role_id', $role->id)->delete();

        if (!is_null($permissions)) {
            foreach ($permissions as $key => $value) {
                $p = Permission::where('id', $value)->first();
                if (!$role->hasPermissionTo($p)) {
                    $role->givePermissionTo($p);
                }
            }
        }

        return $role;
    }

    // Get Detail By Id
    public function getById($id)
    {
        return $this->model->find($id);
    }

    // Update Role and Permission
    public function update(array $data, $id)
    {
        if(isset($data['permission']))
        {
            $permissions = $data['permission'];
        }else{
            $permissions = [];
        }

        $role = $this->model->find($id);

        $this->model->find($role->id)->update(['name' => $data['name']]);

        $aleardy_permisssions = DB::table('role_has_permissions')->where('role_id', $role->id)->delete();

        if (!is_null($permissions)) {
            foreach ($permissions as $key => $value) {
                $p = Permission::where('id', $value)->first();
                if (!$role->hasPermissionTo($p)) {
                    $role->givePermissionTo($p);
                }
            }
        }

        return $role;
    }

    // Get Attached Permission
    public function attachedPermission($id)
    {
        return $this->model->join('role_has_permissions','role_has_permissions.role_id','=','roles.id')
            ->join('permissions','permissions.id','=','role_has_permissions.permission_id')
            ->select('roles.*','permissions.name as permission')
            ->where('roles.id', '=', $id)->get();
    }

    // Destroy Role Record in Database
    public function destroy(array $data)
    {
        return $this->model->find($data['role_id'])->delete();
    }
}
