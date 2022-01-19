<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_data')->insert([
            'user_id' => 1,
            'first_name' => 'Michael',
            'last_name' => 'CallPhone',
            'dob' => '1995-06-07 00:00:00',
            'address' => 'Katampe district',
            'state_id' => 2648,
            'city_id' => 30699,
            'country_id' => 30,
            'avatar' => '',
        ]);
    }
}
