<?php

namespace Lumis\LeaveApplication\Database\Seeders;

use Illuminate\Database\Seeder;
use Lumis\LeaveApplication\Entities\Stage;

class LeaveStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stages = [
            ['level' => 1, 'name' => 'HOD Approval', 'slug' => 'hod_approval', 'description' => 'HOD Approval'],
            ['level' => 2, 'name' => 'Final Approval', 'slug' => 'final_approval', 'description' => 'Final Approval']
        ];

        foreach ($stages as $stage) {
            $obj = new Stage();
            $obj->level = $stage['level'];
            $obj->name = $stage['name'];
            $obj->slug = $stage['slug'];
            $obj->description = $stage['description'];
            $obj->save();
        }


    }

}
