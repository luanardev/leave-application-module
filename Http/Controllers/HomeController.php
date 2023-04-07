<?php

namespace Lumis\LeaveApplication\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Lumis\StaffManagement\Entities\StaffProfile;
use Lumis\StaffManagement\Exceptions\StaffNotFoundException;
use Lumis\LeaveApplication\Entities\LeaveApprover;
use Lumis\LeaveApplication\Entities\LeaveType;
use Lumis\LeaveApplication\Exceptions\LeaveApprovedException;
use Lumis\Organization\Entities\FinancialYear;
use Lumis\Organization\Exceptions\FinancialYearNotFoundException;


class HomeController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     * @throws LeaveApprovedException
     */
    public function index(): Renderable
    {
        $staff = StaffProfile::get();
        $financialYear = FinancialYear::getCurrent();
        $leaveType = LeaveType::getByName('annual leave');

        if (empty($financialYear)) {
            throw new FinancialYearNotFoundException();
        }

        if (empty($staff)) {
            throw new StaffNotFoundException();
        }

        $approver = new LeaveApprover($staff, $financialYear);

        return view('leaveapplication::home')
            ->with(compact('staff', 'financialYear', 'leaveType', 'approver'));

    }


}
