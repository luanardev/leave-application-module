<?php

namespace Lumis\LeaveApplication\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LeaveApplicationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            LeaveTypeSeeder::class,
            LeaveStageSeeder::class
        ]);
    }
}
