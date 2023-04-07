<?php

namespace Lumis\LeaveApplication\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Lumis\StaffManagement\Entities\StaffProfile;
use Lumis\StaffManagement\Exceptions\StaffNotFoundException;
use Lumis\LeaveApplication\Entities\Leave;
use Lumis\LeaveApplication\Entities\LeaveApprover;
use Lumis\LeaveApplication\Entities\LeaveType;
use Lumis\LeaveApplication\Entities\StaffLeave;
use Lumis\LeaveApplication\Exceptions\ApprovalNotAllowedException;
use Lumis\LeaveApplication\Exceptions\LeaveApprovedException;
use Lumis\Organization\Entities\FinancialYear;
use Lumis\Organization\Exceptions\FinancialYearNotFoundException;


class LeaveController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     * @throws FinancialYearNotFoundException
     * @throws StaffNotFoundException
     */
    public function index(): Renderable
    {
        $staff = StaffProfile::get();
        $financialYear = FinancialYear::getCurrent();

        if (empty($staff)) {
            throw new StaffNotFoundException();
        }
        if (empty($financialYear)) {
            throw new FinancialYearNotFoundException();
        }

        return view('leaveapplication::applications')->with(compact('staff', 'financialYear'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     * @throws StaffNotFoundException
     */
    public function apply(): Renderable
    {
        $staff = StaffProfile::get();
        if (empty($staff)) {
            throw new StaffNotFoundException();
        }

        $leaveTypes = LeaveType::all();
        return view('leaveapplication::apply')
            ->with(compact('leaveTypes'));
    }

    /**
     * @return Factory|\Illuminate\Foundation\Application|View|Application
     * @throws StaffNotFoundException
     * @throws FinancialYearNotFoundException
     */
    public function pendingReturns(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $staff = StaffProfile::get();
        $financialYear = FinancialYear::getCurrent();
        if (empty($staff)) {
            throw new StaffNotFoundException();
        }
        if (empty($financialYear)) {
            throw new FinancialYearNotFoundException();
        }

        return view('leaveapplication::pending-return')
            ->with(compact('staff', 'financialYear'));
    }

    public function returnBack(Leave $leave)
    {

    }

    /**
     * Show the form for creating a new resource.
     * @param LeaveType $leaveType
     * @return Renderable|RedirectResponse
     * @throws FinancialYearNotFoundException
     * @throws StaffNotFoundException
     */
    public function create(LeaveType $leaveType): Renderable|RedirectResponse
    {
        $staff = StaffProfile::get();
        $financialYear = FinancialYear::getCurrent();

        if (empty($staff)) {
            throw new StaffNotFoundException();
        }
        if (empty($financialYear)) {
            throw new FinancialYearNotFoundException();
        }

        $leave = new StaffLeave($staff, $financialYear, $leaveType);

        // check whether staff already submitted application
        if ($leave->isProcessing()) {
            return back()->with('error', "You already applied for {$leaveType->name}. Please wait until application is processed.");
        }

        // check whether staff is already on leave
        if ($leave->isActive()) {
            return back()->with('error', "You're already on {$leaveType->name}. Please wait until you return.");
        }

        // check whether staff has not returned from leave
        if ($leave->isPendingReturn()) {
            return back()->with('error', "You have not returned from your {$leaveType->name}.");
        }

        // check whether staff has no leave days
        if ($leave->hasNoLeaveDays()) {
            return back()->with('error', "You've used up all your Leave {{$leaveType->unit}} for {$leaveType->name}.");
        }

        // check whether staff has accrued leave days
        if ($leaveType->isAnnualLeave() && $leave->daysAllowed() < 1.0) {
            return back()->with('error', "You do not have accrued Leave Days");
        }

        return view('leaveapplication::create')->with(compact('staff', 'financialYear', 'leaveType'));
    }

    /**
     * Show the form for creating a new resource.
     * @param Leave $leave
     * @return Renderable
     * @throws StaffNotFoundException
     */
    public function edit(Leave $leave): Renderable
    {
        $staff = StaffProfile::get();
        $financialYear = $leave->financialYear;
        $leaveType = $leave->leaveType;

        if (empty($staff)) {
            throw new StaffNotFoundException();
        }

        return view('leaveapplication::create')->with(compact('staff', 'financialYear', 'leaveType'));
    }

    /**
     * Show the specified resource.
     * @param Leave $leave
     * @return Renderable
     * @throws StaffNotFoundException
     */
    public function show(Leave $leave): Renderable
    {
        $staff = StaffProfile::get();
        $financialYear = $leave->financialYear;
        $leaveType = $leave->leaveType;

        if (empty($staff)) {
            throw new StaffNotFoundException();
        }

        return view('leaveapplication::show')->with(compact('leave', 'staff', 'financialYear', 'leaveType'));
    }

    /**
     * Show the specified resource.
     * @param Leave $leave
     * @return Renderable
     * @throws StaffNotFoundException
     * @throws ApprovalNotAllowedException
     * @throws LeaveApprovedException
     */
    public function approve(Leave $leave): Renderable
    {
        $staff = StaffProfile::get();
        $financialYear = $leave->financialYear;
        $leaveType = $leave->leaveType;

        if (empty($staff)) {
            throw new StaffNotFoundException();
        }

        $leaveApprover = new LeaveApprover($staff, $financialYear);

        if (!$staff->isSupervisor() && !$leaveApprover->canApprove($leave)) {
            throw new ApprovalNotAllowedException();
        }
        if ($leave->isApproved() || $leave->isApprovedBy($staff)) {
            throw new LeaveApprovedException();
        }
        return view('leaveapplication::approve')->with(compact('leave', 'staff', 'financialYear', 'leaveType'));
    }

}
