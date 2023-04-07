<?php

namespace Lumis\LeaveApplication\Console;

use Illuminate\Console\Command;
use Lumis\LeaveApplication\Jobs\EndDateReminder;

class RemindEndDateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:remind-end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind about leave end date.';

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
        EndDateReminder::dispatch();
    }

}
