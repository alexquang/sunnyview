<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $awsAccount = \App\Models\AwsAccount::where('account_id', '431140554363')->firstOrFail();

        $job = new \App\Jobs\Aws\SyncQuickSightUserJob($awsAccount, ['ap-northeast-1']);

        dispatch_sync($job);
    }
}
