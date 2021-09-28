<?php

namespace App\Jobs\Aws;

use App\Models\AwsEbsVolume;
use App\Models\AwsEbsVolumeAttachment;

class SyncEbsVolumeAttachmentJob extends SyncJob
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

            try {
                \DB::transaction(function () use ($region, $client) {
                    $condition = [
                        'region' => $region,
                        'owner_id' => $this->account->account_id,
                    ];

                    AwsEbsVolume::where($condition)->delete();
                    AwsEbsVolumeAttachment::where($condition)->delete();
                    
                    $params = [];
                    do {
                        $result = $client->describeVolumes($params);

                        $this->import($region, $result->get('Volumes') ?: []);

                        $params['NextToken'] = $result->get('NextToken');
                    } while ($params['NextToken']);
                });
            } catch (\Throwable $th) {
                echo $th->getMessage() . PHP_EOL;
            }
        }
    }

    private function import($region, array $volumes)
    {
        $volumeItems = [];
        $attachmentItems = [];

        $current = now();

        foreach ($volumes as $volume) {
            $volumeItem = [
                'owner_id' => $this->account->account_id,
                'region' => $region,

                'availability_zone' => \Arr::get($volume, 'AvailabilityZone'),
                'create_time' => \Arr::get($volume, 'CreateTime'),
                'encrypted' => \Arr::get($volume, 'Encrypted'),
                'fast_restored' => \Arr::get($volume, 'FastRestored'),
                'iops' => \Arr::get($volume, 'Iops'),
                'kms_key_id' => \Arr::get($volume, 'KmsKeyId'),
                'multi_attach_enabled' => \Arr::get($volume, 'MultiAttachEnabled'),
                'outpost_arn' => \Arr::get($volume, 'OutpostArn'),
                'size' => \Arr::get($volume, 'Size'),
                'snapshot_id' => \Arr::get($volume, 'SnapshotId'),
                'state' => \Arr::get($volume, 'State'),
                'throughput' => \Arr::get($volume, 'Throughput'),
                'volume_id' => \Arr::get($volume, 'VolumeId'),
                'volume_type' => \Arr::get($volume, 'VolumeType'),
                'updated_at' => $current,
            ];

            $attachments = \Arr::get($volume, 'Attachments') ?: [];
            
            foreach ($attachments as $attachment) {
                $attachmentItem = [
                    'owner_id' => $this->account->account_id,
                    'region' => $region,
                    'volume_id' => $volume['VolumeId'],

                    'attach_time' => \Arr::get($attachment, 'Attachments.AttachTime'),
                    'delete_on_termination' => \Arr::get($attachment, 'Attachments.DeleteOnTermination'),
                    'device' => \Arr::get($attachment, 'Attachments.Device'),
                    'instance_id' => \Arr::get($attachment, 'Attachments.InstanceId'),
                    'state' => \Arr::get($attachment, 'Attachments.State'),
                    'updated_at' => $current,
                ];

                $attachmentItems[] = $attachmentItem;
            }

            $volumeItems[] = $volumeItem;
        }

        AwsEbsVolume::insert($volumeItems);
        AwsEbsVolumeAttachment::insert($attachmentItems);
    }
}
