<?php

namespace Lumis\LeaveApplication\Console;

use Illuminate\Console\Command;
use Lumis\LeaveApplication\Jobs\ApprovalReminder;

class RemindApprovalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:remind-approval';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind Pending Approvals.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ApprovalReminder::dispatch();
    }


}
