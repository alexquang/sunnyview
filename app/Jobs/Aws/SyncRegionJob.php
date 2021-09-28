<?php

namespace App\Jobs\Aws;

class SyncRegionJob extends SyncJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = $this->aws()->createEc2();

        try {
            $result = $client->describeRegions();

            $this->import($result->get('Regions') ?: []);
        } catch (\Throwable $th) {
            echo $th->getMessage() . PHP_EOL;
        }
    }

    private function import(array $regions)
    {
        $regionItems = [];

        foreach ($regions as $region) {
            $regionItem = [
                'owner_id' => $this->account->account_id,
                'region' => \Arr::get($region, 'RegionName'),
            ];

            $regionItems[] = $regionItem;
        }

        \DB::transaction(function () use ($regionItems) {
            \DB::table('aws_regions')->where([
                'owner_id' => $this->account->account_id,
            ])->delete();

            \DB::table('aws_regions')->insert($regionItems);
        });
    }
}
