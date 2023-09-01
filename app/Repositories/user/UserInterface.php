<?php

namespace App\Repositories\user;

interface UserInterface {

    public function all();

    public function getRole($ids);

    public function store(array $data);

    public function getById($id);

    public function update(array $data, $id);

    public function destroy(array $data);

    public function getGroup();

    public function getLocation($location);

    public function selectedDestroy(array $data);

    public function userInformation(array $data, $id);

    public function userLocation(array $data, $id);

    public function attachRole(array $data, $id);

    public function detachRole(array $data);

}
