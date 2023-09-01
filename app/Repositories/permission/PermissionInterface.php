<?php

namespace App\Repositories\permission;

interface PermissionInterface {

    public function all();

    public function getModule();

    public function store(array $data);

    public function getById($id);

    public function update(array $data, $id);

    public function associatedRole($id);

    public function destroy(array $data);
}
