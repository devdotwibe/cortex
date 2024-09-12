<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        DB::table('admins')->truncate();
        DB::table('admins')->insert([
            'name' => 'Admin',
            'email' => 'admin@cortex.com',
            'password' =>  Hash::make("C0rte*"),
        ]);

        $tabs1 = [

            ['tab_id_1' => 'tab1', 'tab_name_1' => 'Tab 1','tab_sort_1' => 1],
            ['tab_id_1' => 'tab2', 'tab_name_1' => 'Tab 2','tab_sort_1' => 2],
            ['tab_id_1' => 'tab3', 'tab_name_1' => 'Tab 3','tab_sort_1' => 3],
            ['tab_id_1' => 'tab4', 'tab_name_1' => 'Tab 4','tab_sort_1' => 4]
        ];

        $tabs2 = [

            ['tab_id_2' => 'sec_tab1', 'tab_name_2' => 'Tab 1','tab_sort_2' => 1],
            ['tab_id_2' => 'sec_tab2', 'tab_name_2' => 'Tab 2','tab_sort_2' => 2],
            ['tab_id_2' => 'sec_tab3', 'tab_name_2' => 'Tab 3','tab_sort_2' => 3],
            ['tab_id_2' => 'sec_tab4', 'tab_name_2' => 'Tab 4','tab_sort_2' => 4]
        ];

        $insertData = [];

        for ($i = 0; $i < count($tabs1); $i++) {
            $insertData[] = [
                'tab_id_1'   => $tabs1[$i]['tab_id_1'],
                'tab_name_1' => $tabs1[$i]['tab_name_1'],
                'tab_sort_1' => $tabs1[$i]['tab_sort_1'],
                'tab_id_2'   => $tabs2[$i]['tab_id_2'],
                'tab_name_2' => $tabs2[$i]['tab_name_2'],
                'tab_sort_2' => $tabs2[$i]['tab_sort_2']
            ];
        }

        DB::table('tab_orders')->truncate();

        DB::table('tab_orders')->insert($insertData);

    }
}
