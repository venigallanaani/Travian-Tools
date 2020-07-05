<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UnitsSeeder::class);
        //$this->call(serversSeeder::class);
        //$this->call(ArtifactsSeeder::class);
        //$this->call(ItemsSeeder::class);
        $this->call(BuildingsSeeder::class);
    }
}
