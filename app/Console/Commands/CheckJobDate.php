<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckJobDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mess:block';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Block the job if the job is overdate';

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
        Job::where();
    }
}
