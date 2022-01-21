<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_categories')->insert([
            'category_code'=> 'SCBR01',
            'description'=> 'Bed Room',
            'price'=> 3000.00,
        ]);
        DB::table('room_categories')->insert([
            'category_code'=> 'SCSR01',
            'description'=> 'Sitting Room',
            'price'=> 5000.00,
        ]);
        DB::table('room_categories')->insert([
            'category_code'=> 'SCTB01',
            'description'=> 'Toilet and Bathroom',
            'price'=> 2000.00,
        ]);
        DB::table('room_categories')->insert([
            'category_code'=> 'SCBL01',
            'description'=> 'Bungalow',
            'price'=> 500.00,
        ]);
        DB::table('room_categories')->insert([
            'category_code'=> 'SCDX01',
            'description'=> 'Duplex',
            'price'=> 2000.00,
        ]);
        DB::table('room_categories')->insert([
            'category_code'=> 'SCSB01',
            'description'=> 'Storey Building',
            'price'=> 3000.00,
        ]);
    }
}
