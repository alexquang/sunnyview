<?php

namespace App\Jobs\Aws;

use App\Models\AwsAmi;
use App\Models\AwsAmiBlockDeviceMapping;

class SyncAmiJob extends SyncJob
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
                \DB::transaction(function () use ($client, $region) {
                    AwsAmi::where([
                        'region' => $region,
                        'owner_id' => $this->account->account_id,
                    ])->delete();
                    AwsAmiBlockDeviceMapping::where([
                        'region' => $region,
                        'owner_id' => $this->account->account_id,
                    ])->delete();

                    $result = $client->describeImages([
                        'Owners' => ['self'],
                    ]);

                    $this->import($region, $result->get('Images') ?: []);
                });
            } catch (\Throwable $th) {
                echo $th->getMessage() . PHP_EOL;
            }
        }
    }

    private function import($region, array $images)
    {
        $imageItems = [];
        $blockDeviceMappingItems = [];

        $current = now();

        foreach ($images as $image) {
            $imageItem = [
                'owner_id' => $this->account->account_id,
                'region' => $region,

                'architecture' => \Arr::get($image, 'Architecture'),
                'boot_mode' => \Arr::get($image, 'BootMode'),
                'creation_date' => \Arr::get($image, 'CreationDate'),
                'deprecation_time' => \Arr::get($image, 'DeprecationTime'),
                'description' => \Arr::get($image, 'Description'),
                'ena_support' => \Arr::get($image, 'EnaSupport'),
                'hypervisor' => \Arr::get($image, 'Hypervisor'),
                'image_id' => \Arr::get($image, 'ImageId'),
                'image_location' => \Arr::get($image, 'ImageLocation'),
                'image_owner_alias' => \Arr::get($image, 'ImageOwnerAlias'),
                'image_type' => \Arr::get($image, 'ImageType'),
                'kernel_id' => \Arr::get($image, 'KernelId'),
                'name' => \Arr::get($image, 'Name'),
                'platform' => \Arr::get($image, 'Platform'),
                'platform_details' => \Arr::get($image, 'PlatformDetails'),
                'public' => \Arr::get($image, 'Public'),
                'ramdisk_id' => \Arr::get($image, 'RamdiskId'),
                'root_device_name' => \Arr::get($image, 'RootDeviceName'),
                'root_device_type' => \Arr::get($image, 'RootDeviceType'),
                'sriov_net_support' => \Arr::get($image, 'SriovNetSupport'),
                'state' => \Arr::get($image, 'State'),
                // TODO: need re-test
                'state_code' => \Arr::get($image, 'StateReason.Code'),
                'state_message' => \Arr::get($image, 'StateReason.Message'),
                'usage_operation' => \Arr::get($image, 'UsageOperation'),
                'virtualization_type' => \Arr::get($image, 'VirtualizationType'),

                'updated_at' => $current,
            ];

            $blockDeviceMappings = \Arr::get($image, 'BlockDeviceMappings') ?: [];
            foreach ($blockDeviceMappings as $blockDeviceMapping) {
                $blockDeviceMappingItem = [
                    'owner_id' => $this->account->account_id,
                    'region' => $region,
                    'image_id' => $imageItem['image_id'],

                    'device_name' => \Arr::get($blockDeviceMapping, 'DeviceName'),
                    'ebs_delete_on_termination' => \Arr::get($blockDeviceMapping, 'Ebs.DeleteOnTermination'),
                    'ebs_encrypted' => \Arr::get($blockDeviceMapping, 'Ebs.Encrypted'),
                    'ebs_iops' => \Arr::get($blockDeviceMapping, 'Ebs.Iops'),
                    'ebs_kms_key_id' => \Arr::get($blockDeviceMapping, 'Ebs.KmsKeyId'),
                    'ebs_outpost_arn' => \Arr::get($blockDeviceMapping, 'Ebs.OutpostArn'),
                    'ebs_snapshot_id' => \Arr::get($blockDeviceMapping, 'Ebs.SnapshotId'),
                    'ebs_throughput' => \Arr::get($blockDeviceMapping, 'Ebs.Throughput'),
                    'ebs_volume_size' => \Arr::get($blockDeviceMapping, 'Ebs.VolumeSize'),
                    'ebs_volume_type' => \Arr::get($blockDeviceMapping, 'Ebs.VolumeType'),
                    'no_device' => \Arr::get($blockDeviceMapping, 'NoDevice'),
                    'virtual_name' => \Arr::get($blockDeviceMapping, 'VirtualName'),

                    'updated_at' => $current,
                ];

                $blockDeviceMappingItems[] = $blockDeviceMappingItem;
            }

            $imageItems[] = $imageItem;
        }

        AwsAmi::insert($imageItems);

        AwsAmiBlockDeviceMapping::insert($blockDeviceMappingItems);
    }
}
