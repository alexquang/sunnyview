<?php

namespace App\Jobs\Aws;

use App\Models\AwsAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const MAX_RESULTS = 1000;

    /**
     * @var AwsAccount
     */
    protected $account;

    /**
     * @var array
     */
    protected $regions;

    public function __construct(AwsAccount $account, array $regions)
    {
        $this->account = $account;
        $this->regions = $regions;
    }

    protected function aws(array $configs = []): \App\Helpers\Aws
    {
        // request a singleton instance of App\Helpers\Aws class
        return app('aws', [
            'account' => $this->account,
            'configs' => $configs,
        ]);
    }
}
