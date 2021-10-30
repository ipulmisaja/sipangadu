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
        $this->call([
            RolesPermissionsTableSeeder::class,
            UnitTableSeeder::class,
            PangkatGolonganTableSeeder::class,
            UserTableSeeder::class,
        ]);
    }
}
