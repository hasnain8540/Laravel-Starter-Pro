<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->data();

        $permissions = Permission::get();

        foreach ($data as $value) {
            $role = Role::create([
                'name' => $value['name'],
            ]);

            if (!is_null($permissions)) {
                foreach ($permissions as $key => $value) {
                    $p = Permission::where('id', $value->id)->first();
                    $role->givePermissionTo($p);
                }
            }
        }
    }

    public function data()
    {
        return [
            ['name' => 'super admin'],
            ['name' => 'Picking Person'],
        ];
    }
}
