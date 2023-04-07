<?php

namespace Lumis\LeaveApplication\Console;

use Illuminate\Console\Command;
use Lumis\LeaveApplication\Jobs\ReturnBackReminder;

class RemindReturnBackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:remind-return';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind staff who have not returned.';

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
        ReturnBackReminder::dispatch();
    }


}
