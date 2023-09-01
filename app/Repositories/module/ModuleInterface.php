<?php

namespace App\Repositories\module;

interface ModuleInterface
{
    public function all();

    public function store(array $data);

    public function getById($id);

    public function update(array $data, $id);

    public function destroy(array $data);

}
