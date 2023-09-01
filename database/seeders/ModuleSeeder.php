<?php

namespace Database\Seeders;

use App\Core\HelperFunction;
use App\Models\Module;
use Illuminate\Database\Seeder;
use PHPUnit\TextUI\Help;
use Yajra\DataTables\Utilities\Helper;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $module = [
            [
                'id' => '1',
                'uid' => HelperFunction::_uid(),
                'name' => 'Module'
            ],
            [
                'id' => '2',
                'uid' => HelperFunction::_uid(),
                'name' => 'Permission'
            ],
            [
                'id' => '3',
                'uid' => HelperFunction::_uid(),
                'name' => 'Role'
            ],
            [
                'id' => '4',
                'uid' => HelperFunction::_uid(),
                'name' => 'User'
            ],
            [
                'id' => '5',
                'uid' => HelperFunction::_uid(),
                'name' => 'Vendor'
            ],
            [
                'id' => '6',
                'uid' => HelperFunction::_uid(),
                'name' => 'Fields'
            ],
            [
                'id' => '7',
                'uid' => HelperFunction::_uid(),
                'name' => 'Upc'
            ],
            [
                'id' => '8',
                'uid' => HelperFunction::_uid(),
                'name' => 'Material'
            ],
            [
                'id' => '9',
                'uid' => HelperFunction::_uid(),
                'name' => 'Part'
            ],
            [
                'id' => '10',
                'uid' => HelperFunction::_uid(),
                'name' => 'Inventory'
            ],
            [
                'id' => '11',
                'uid' => HelperFunction::_uid(),
                'name' => 'Bin'
            ],
            [
                'id' => '12',
                'uid' => HelperFunction::_uid(),
                'name' => 'Shopify Account'
            ],
            [
                'id' => '13',
                'uid' => HelperFunction::_uid(),
                'name' => 'Currency Rate'
            ],
            [
                'id' => '14',
                'uid' => HelperFunction::_uid(),
                'name' => 'Production'
            ],
            [
                'id' => '15',
                'uid' => HelperFunction::_uid(),
                'name' => 'Location Group'
            ],
            [
                'id' => '16',
                'uid' => HelperFunction::_uid(),
                'name' => 'Location'
            ],
            [
                'id' => '17',
                'uid' => HelperFunction::_uid(),
                'name' => 'Currency'
            ],
            [
                'id' => '18',
                'uid' => HelperFunction::_uid(),
                'name' => 'Storage Setting'
            ],
            [
                'id' => '19',
                'uid' => HelperFunction::_uid(),
                'name' => 'Web Images'
            ],
            [
                'id' => '20',
                'uid' => HelperFunction::_uid(),
                'name' => 'Result Pool'
            ],
            [
                'id' => '21',
                'uid' => HelperFunction::_uid(),
                'name' => 'Virtual Part'
            ],
            [
                'id' => '22',
                'uid' => HelperFunction::_uid(),
                'name' => 'Transfer Order'
            ],
            [
                'id' => '23',
                'uid' => HelperFunction::_uid(),
                'name' => 'Audit Log'
            ],
            [
                'id' => '24',
                'uid' => HelperFunction::_uid(),
                'name' => 'System Log'
            ],
            [
                'id' => '25',
                'uid' => HelperFunction::_uid(),
                'name' => 'Allow customer on credit'
            ],
            [
                'id' => '26',
                'uid' => HelperFunction::_uid(),
                'name' => 'Markup Setting'
            ],
            [
                'id' => '27',
                'uid' => HelperFunction::_uid(),
                'name' => 'Account Logs'
            ],
            [
                'id' => '28',
                'uid' => HelperFunction::_uid(),
                'name' => 'Picking Search'
            ],
        ];

        // Store All Module in Database
        foreach ($module as $item) {
            Module::create($item);
        }
    }
}
