<?php

namespace App\Repositories\role;

interface RoleInterface {

    public function all();

    public function getModule();

    public function store(array $data);

    public function getById($id);

    public function update(array $data, $id);

    public function attachedPermission($id);

    public function destroy(array $data);

}
