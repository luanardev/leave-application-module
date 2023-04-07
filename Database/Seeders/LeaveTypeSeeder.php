<?php

namespace Lumis\LeaveApplication\Database\Seeders;

use Illuminate\Database\Seeder;
use Lumis\LeaveApplication\Entities\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leaveTypes = [
            ['name' => 'Annual Leave', 'slug' => 'annual_leave', 'period' => 30, 'unit' => 'DAYS'],
            ['name' => 'Study Leave', 'slug' => 'study_leave', 'period' => 5, 'unit' => 'YEARS'],
            ['name' => 'Sabbatical Leave', 'slug' => 'sabbatical_leave', 'period' => 1, 'unit' => 'YEARS'],
            ['name' => 'Leave of Absence', 'slug' => 'leave_of_absence', 'period' => 2, 'unit' => 'YEARS'],
            ['name' => 'Unpaid Leave', 'slug' => 'unpaid_leave', 'period' => 30, 'unit' => 'DAYS'],
            ['name' => 'Maternity Leave', 'slug' => 'maternity_leave', 'period' => 3, 'unit' => 'MONTHS'],
            ['name' => 'Paternity Leave', 'slug' => 'paternity_leave', 'period' => 10, 'unit' => 'DAYS'],
            ['name' => 'Compassionate Leave', 'slug' => 'compassionate_leave', 'period' => 10, 'unit' => 'DAYS']
        ];

        foreach ($leaveTypes as $type) {
            $obj = new LeaveType();
            $obj->name = $type['name'];
            $obj->slug = $type['slug'];
            $obj->period = $type['period'];
            $obj->unit = $type['unit'];
            $obj->save();
        }
    }


}
