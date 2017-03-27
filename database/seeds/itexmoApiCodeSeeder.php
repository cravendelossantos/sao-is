<?php

use Illuminate\Database\Seeder;


class itexmoApiCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('itexmo_key')->insert(['api_code' => 'Your API Code']);
    }
}
