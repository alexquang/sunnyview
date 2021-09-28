<?php

namespace App\Jobs\Aws;

use App\Models\AwsEbsSnapshot;

class SyncEbsSnapshotJob extends SyncJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->regions as $region) {
            $client = $this->aws()->createEc2(['region' => $region]);

            $params = [
                'MaxResults' => 1000,
            ];
            try {
                AwsEbsSnapshot::where([
                    'region' => $region,
                    'owner_id' => $this->account->account_id,
                ])->delete();

                do {
                    $result = $client->describeSnapshots($params);

                    $this->import($region, $result->get('Snapshots') ?: []);

                    $params['NextToken'] = $result->get('NextToken');
                } while ($params['NextToken']);
            } catch (\Throwable $th) {
                echo $th->getMessage() . PHP_EOL;
            }
        }
    }

    private function import($region, array $snapshots)
    {
        $snapshotItems = [];

        $current = now();

        foreach ($snapshots as $snapshot) {
            $snapshotItem = [
                'owner_id' => $this->account->account_id,
                'region' => $region,

                'data_encryption_key_id' => \Arr::get($snapshot, 'DataEncryptionKeyId'),
                'description' => \Arr::get($snapshot, 'Description'),
                'encrypted' => \Arr::get($snapshot, 'Encrypted'),
                'kms_key_id' => \Arr::get($snapshot, 'KmsKeyId'),
                'outpost_arn' => \Arr::get($snapshot, 'OutpostArn'),
                'owner_alias' => \Arr::get($snapshot, 'OwnerAlias'),
                'progress' => \Arr::get($snapshot, 'Progress'),
                'snapshot_id' => \Arr::get($snapshot, 'SnapshotId'),
                'start_time' => \Arr::get($snapshot, 'StartTime'),
                'state' => \Arr::get($snapshot, 'State'),
                'state_message' => \Arr::get($snapshot, 'StateMessage'),
                'volume_id' => \Arr::get($snapshot, 'VolumeId'),
                'volume_size' => \Arr::get($snapshot, 'VolumeSize'),
                'updated_at' => $current,
            ];

            $snapshotItems[] = $snapshotItem;
        }

        AwsEbsSnapshot::insert($snapshotItems);
    }
}
