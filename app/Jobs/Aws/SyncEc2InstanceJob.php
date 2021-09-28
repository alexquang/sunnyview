<?php

namespace App\Jobs\Aws;

use App\Models\AwsEc2Instance;
use App\Models\AwsEc2InstanceSecurityGroup;

class SyncEc2InstanceJob extends SyncJob
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

                    AwsEc2Instance::where($condition)->delete();
                    AwsEc2InstanceSecurityGroup::where($condition)->delete();
                    AwsEc2InstanceBlockDeviceMappings::where($condition)->delete();
                    
                    $params = [];
                    do {
                        $result = $client->describeInstances($params);

                        $this->import($region, $result->get('Reservations') ?: []);

                        $params['NextToken'] = $result->get('NextToken');
                    } while ($params['NextToken']);
                });
            } catch (\Throwable $th) {
                echo $th->getMessage() . PHP_EOL;
            }
        }
    }

    private function import($region, array $reservations)
    {
        $instancesItems = [];
        $instanceSecurityGroupsItems = [];
        $instanceBlockDeviceMappings = [];

        $current = now();

        foreach ($reservations as $reservation) {
            $instances = \Arr::get($reservation, 'Instances') ?: [];

            foreach ($instances as $instance) {
                $instanceItem = [
                    'owner_id' => $this->account->account_id,
                    'region' => $region,

                    'ami_launch_index' => \Arr::get($instance, 'AmiLaunchIndex'),
                    'architecture' => \Arr::get($instance, 'Architecture'),
                    'boot_mode' => \Arr::get($instance, 'BootMode'),
                    'client_token' => \Arr::get($instance, 'ClientToken'),
                    'cpu_options_core_count' => \Arr::get($instance, 'CpuOptions.CoreCount'),
                    'cpu_options_threads_per_core' => \Arr::get($instance, 'CpuOptions.ThreadsPerCore'),
                    'ebs_optimized' => \Arr::get($instance, 'EbsOptimized'),
                    'ena_support' => \Arr::get($instance, 'EnaSupport'),
                    'enclave_options_enabled' => \Arr::get($instance, 'EnclaveOptions.Enabled'),
                    'hibernation_options_configured' => \Arr::get($instance, 'HibernationOptions.Configured'),
                    'hypervisor' => \Arr::get($instance, 'Instances.Hypervisor'),
                    'iam_instance_profile_arn' => \Arr::get($instance, 'IamInstanceProfile.Arn'),
                    'iam_instance_profile_id' => \Arr::get($instance, 'IamInstanceProfile.Id'),
                    'image_id' => \Arr::get($instance, 'ImageId'),
                    'instance_id' => \Arr::get($instance, 'InstanceId'),
                    'instance_lifecycle' => \Arr::get($instance, 'InstanceLifecycle'),
                    'instance_type' => \Arr::get($instance, 'InstanceType'),
                    'kernel_id' => \Arr::get($instance, 'KernelId'),
                    'key_name' => \Arr::get($instance, 'KeyName'),
                    'launch_time' => \Arr::get($instance, 'LaunchTime'),
                    'metadata_options_http_endpoint' => \Arr::get($instance, 'MetadataOptions.HttpEndpoint'),
                    'metadata_options_http_put_response_hop_limit' => \Arr::get($instance, 'MetadataOptions.HttpPutResponseHopLimit'),
                    'metadata_options_http_tokens' => \Arr::get($instance, 'MetadataOptions.HttpTokens'),
                    'metadata_options_state' => \Arr::get($instance, 'MetadataOptions.State'),
                    'monitoring_state' => \Arr::get($instance, 'Monitoring.State'),
                    'outpost_arn' => \Arr::get($instance, 'OutpostArn'),
                    'placement_affinity' => \Arr::get($instance, 'Placement.Affinity'),
                    'placement_availability_zone' => \Arr::get($instance, 'Placement.AvailabilityZone'),
                    'placement_group_name' => \Arr::get($instance, 'Placement.GroupName'),
                    'placement_host_id' => \Arr::get($instance, 'Placement.HostId'),
                    'placement_host_resource_group_arn' => \Arr::get($instance, 'Placement.HostResourceGroupArn'),
                    'placement_partition_number' => \Arr::get($instance, 'Placement.PartitionNumber'),
                    'placement_spread_domain' => \Arr::get($instance, 'Placement.SpreadDomain'),
                    'placement_tenancy' => \Arr::get($instance, 'Placement.Tenancy'),
                    'platform' => \Arr::get($instance, 'Platform'),
                    'private_dns_name' => \Arr::get($instance, 'PrivateDnsName'),
                    'private_ip_address' => \Arr::get($instance, 'PrivateIpAddress'),
                    'public_dns_name' => \Arr::get($instance, 'PublicDnsName'),
                    'public_ip_address' => \Arr::get($instance, 'PublicIpAddress'),
                    'ramdisk_id' => \Arr::get($instance, 'RamdiskId'),
                    'root_device_name' => \Arr::get($instance, 'RootDeviceName'),
                    'root_device_type' => \Arr::get($instance, 'RootDeviceType'),
                    'source_dest_check' => \Arr::get($instance, 'SourceDestCheck'),
                    'spot_instance_request_id' => \Arr::get($instance, 'SpotInstanceRequestId'),
                    'sriov_net_support' => \Arr::get($instance, 'SriovNetSupport'),
                    'state_code' => \Arr::get($instance, 'State.Code'),
                    'state_name' => \Arr::get($instance, 'State.Name'),
                    'state_reason_code' => \Arr::get($instance, 'StateReason.Code'),
                    'state_reason_message' => \Arr::get($instance, 'StateReason.Message'),
                    'state_transition_reason' => \Arr::get($instance, 'StateTransitionReason'),
                    'subnet_id' => \Arr::get($instance, 'SubnetId'),
                    'virtualization_type' => \Arr::get($instance, 'VirtualizationType'),
                    'vpc_id' => \Arr::get($instance, 'VpcId'),
                    'updated_at' => $current,
                ];

                $securityGroups = \Arr::get($instance, 'SecurityGroups') ?: [];
                
                foreach ($securityGroups as $securityGroup) {
                    $instanceSecurityGroupsItem = [
                        'owner_id' => $this->account->account_id,
                        'region' => $region,

                        'instance_id' => \Arr::get($instance, 'InstanceId'),
                        'group_id' => \Arr::get($securityGroup, 'GroupId'),
                        'group_name' => \Arr::get($securityGroup, 'GroupName'),
                        'updated_at' => $current,
                    ];

                    $instanceSecurityGroupsItems[] = $instanceSecurityGroupsItem;
                }

                $blockDeviceMappings = \Arr::get($instance, 'BlockDeviceMappings') ?: [];

                foreach ($blockDeviceMappings as $blockDeviceMapping) {
                    $blockDeviceMappingItem = [
                        'owner_id' => $this->account->account_id,
                        'region' => $region,

                        'instance_id' => \Arr::get($instance, 'InstanceId'),
                        'device_name' => \Arr::get($blockDeviceMapping, 'DeviceName'),
                        'ebs_attach_time' => \Arr::get($blockDeviceMapping, 'Ebs.AttachTime'),
                        'ebs_delete_on_termination' => \Arr::get($blockDeviceMapping, 'Ebs.DeleteOnTermination'),
                        'ebs_status' => \Arr::get($blockDeviceMapping, 'Ebs.Status'),
                        'ebs_volume_id' => \Arr::get($blockDeviceMapping, 'Ebs.VolumeId'),
                        'updated_at' => $current,
                    ];

                    $instanceBlockDeviceMappings[] = $blockDeviceMappingItem;
                }

                $instancesItems[] = $instanceItem;
            }
        }

        AwsEc2Instance::insert($instancesItems);
        AwsEc2InstanceSecurityGroup::insert($instanceSecurityGroupsItems);
        AwsEc2InstanceBlockDeviceMappings::insert($instanceBlockDeviceMappings);
    }
}
