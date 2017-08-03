<?php

use Illuminate\Database\Seeder;

class PayPalWebProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\CodeFlix\Models\PayPalWebProfile::class, 20)->create();
    }
}
