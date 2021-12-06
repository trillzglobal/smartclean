<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'email'=>"trillzglobal@gmail.com",
            'password'=>Hash::make("michael123"),
            'phone_number'=>"2349032878128",
            'status'=>true]);
    }
}
