<?php

namespace Lumis\LeaveApplication\Console;

use Illuminate\Console\Command;
use Lumis\LeaveApplication\Jobs\StartLeave;

class StartLeaveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Pending Leaves';

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
        StartLeave::dispatch();
    }


}
