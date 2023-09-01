<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            [
                'module_id' => '1',
                'name' => 'show module',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '1',
                'name' => 'create module',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '1',
                'name' => 'edit module',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '1',
                'name' => 'view module',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '1',
                'name' => 'delete module',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '2',
                'name' => 'show permission',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '2',
                'name' => 'create permission',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '2',
                'name' => 'edit permission',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '2',
                'name' => 'view permission',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '2',
                'name' => 'delete permission',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '3',
                'name' => 'show role',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '3',
                'name' => 'create role',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '3',
                'name' => 'edit role',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '3',
                'name' => 'view role',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '3',
                'name' => 'delete role',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '4',
                'name' => 'show user',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '4',
                'name' => 'create user',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '4',
                'name' => 'edit user',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '4',
                'name' => 'view user',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '4',
                'name' => 'delete user',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '5',
                'name' => 'show vendor',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '5',
                'name' => 'create vendor',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '5',
                'name' => 'edit vendor',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '5',
                'name' => 'view vendor',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '5',
                'name' => 'delete vendor',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '6',
                'name' => 'show field',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '6',
                'name' => 'create field',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '6',
                'name' => 'edit field',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '6',
                'name' => 'view field',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '6',
                'name' => 'delete field',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '7',
                'name' => 'show upc',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '7',
                'name' => 'create upc',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '7',
                'name' => 'edit upc',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '7',
                'name' => 'view upc',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '7',
                'name' => 'delete upc',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '7',
                'name' => 'import upc',
                'type' => 'other',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '8',
                'name' => 'show material',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '8',
                'name' => 'create material',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '8',
                'name' => 'edit material',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '8',
                'name' => 'view material',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '8',
                'name' => 'delete material',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '9',
                'name' => 'show part',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '9',
                'name' => 'create part',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '9',
                'name' => 'edit part',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '9',
                'name' => 'view part',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '9',
                'name' => 'delete part',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '10',
                'name' => 'show inventory',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '10',
                'name' => 'create inventory',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '10',
                'name' => 'edit inventory',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '10',
                'name' => 'view inventory',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '10',
                'name' => 'delete inventory',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '11',
                'name' => 'show bin',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '11',
                'name' => 'create bin',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '11',
                'name' => 'edit bin',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '11',
                'name' => 'view bin',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '11',
                'name' => 'delete bin',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '11',
                'name' => 'print label',
                'type' => 'other',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '12',
                'name' => 'show shopify account',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '12',
                'name' => 'create shopify account',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '12',
                'name' => 'edit shopify account',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '12',
                'name' => 'view shopify account',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '12',
                'name' => 'delete shopify account',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '13',
                'name' => 'show rate',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '14',
                'name' => 'show production',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '15',
                'name' => 'show location group',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '15',
                'name' => 'create location group',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '15',
                'name' => 'edit location group',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '15',
                'name' => 'view location group',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '15',
                'name' => 'delete location group',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '16',
                'name' => 'show location',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '16',
                'name' => 'create location',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '16',
                'name' => 'edit location',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '16',
                'name' => 'view location',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '16',
                'name' => 'delete location',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '17',
                'name' => 'show currency',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '17',
                'name' => 'create currency',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '17',
                'name' => 'edit currency',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '17',
                'name' => 'view currency',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '17',
                'name' => 'delete currency',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '18',
                'name' => 'show storage setting',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '18',
                'name' => 'update storage setting',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '19',
                'name' => 'show web images',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '20',
                'name' => 'show result pool',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '20',
                'name' => 'create result pool',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '20',
                'name' => 'edit result pool',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '20',
                'name' => 'view result pool',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '20',
                'name' => 'delete result pool',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '21',
                'name' => 'show virtual part',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '21',
                'name' => 'create virtual part',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '21',
                'name' => 'edit virtual part',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '21',
                'name' => 'view virtual part',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '21',
                'name' => 'delete virtual part',
                'type' => 'delete',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '22',
                'name' => 'show transfer order',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '22',
                'name' => 'create transfer order',
                'type' => 'create',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '22',
                'name' => 'edit transfer order',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '22',
                'name' => 'view transfer order',
                'type' => 'view',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '23',
                'name' => 'show audit log',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '24',
                'name' => 'show system log',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '25',
                'name' => 'show credit check',  /*It will allow user to show credit status of company and  to show the credit limit of company */
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '25',
                'name' => 'edit credit check', /*It will allow user to change  credit status of company and  to change the credit limit of company */
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '26',
                'name' => 'show markup setting',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '26',
                'name' => 'edit markup setting',
                'type' => 'edit',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '27',
                'name' => 'show account logs',
                'type' => 'show',
                'guard_name' => 'web'
            ],
            [
                'module_id' => '28',
                'name' => 'show Picking Search',
                'type' => 'show',
                'guard_name' => 'web'
            ]
        ];

        // Store Permission in DB
        foreach ($permission as $item) {
            Permission::create($item);
        }
    }
}
