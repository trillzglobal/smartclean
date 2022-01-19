<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wallets')->insert([
            'user_id'=> 1,
            'main_balance'=> 0.00,
            'bonuses'=> 5000.00,
            'referral'=> 0.00,
        ]);
    }
}
