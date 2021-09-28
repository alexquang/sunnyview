<?php

namespace App\Jobs\Aws;

use App\Models\AwsSecurityGroup;
use App\Models\AwsSecurityGroupPermission;

class SyncSecurityGroupJob extends SyncJob
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

                    $conditions = [
                        'region' => $region,
                        'owner_id' => $this->account->account_id,
                    ];
                    AwsSecurityGroupPermission::where($conditions)->delete();
                    AwsSecurityGroup::where($conditions)->delete();

                    // Get new data from aws
                    $params = [
                        'MaxResults' => 1000,
                    ];
                    do {
                        $result = $client->describeSecurityGroups($params);

                        // TODO: need to test
                        $this->import($region, $result->get('SecurityGroups') ?: []);

                        $params['NextToken'] = $result->get('NextToken');
                    } while ($params['NextToken']);
                });
            } catch (\Throwable $th) {
                echo $th->getMessage() . PHP_EOL;
            }
        }
    }

    private function import($region, array $securityGroups)
    {

        $securityGroupItems = [];
        $securityGroupPermissionItems = [];

        foreach ($securityGroups as $securityGroup) {
            $securityGroupItem = [
                'owner_id' => $this->account->account_id,
                'region' => $region,

                'description' => \Arr::get($securityGroup, 'Description'),
                'group_id' => \Arr::get($securityGroup, 'GroupId'),
                'group_name' => \Arr::get($securityGroup, 'GroupName'),
                'vpc_id' => \Arr::get($securityGroup, 'VpcId'),
            ];
            // aws_security_groups
            $securityGroupItems[] = $securityGroupItem;

            // aws_security_group_permissions
            $securityGroupPermissions = \Arr::get($securityGroup, 'IpPermissions') ?: [];
            foreach ($securityGroupPermissions as $securityGroupPermission) {
                $securityGroupPermissionItem = [
                    'owner_id' => $this->account->account_id,
                    'region' => $region,
                    'group_id' => \Arr::get($securityGroup, 'GroupId'),
                    'from_port' => \Arr::get($securityGroupPermission, 'FromPort'),
                    'ip_protocol' => \Arr::get($securityGroupPermission, 'IpProtocol'),
                    'ip_ranges' => json_encode(\Arr::get($securityGroupPermission, 'IpRanges')),
                    'ipv_6_ranges' => json_encode(\Arr::get($securityGroupPermission, 'Ipv6Ranges')),
                    'to_port' => \Arr::get($securityGroupPermission, 'ToPort'),
                ];
                $securityGroupPermissionItems[] = $securityGroupPermissionItem;
            }
        }

        \DB::table('aws_security_groups')->insert($securityGroupItems);
        \DB::table('aws_security_group_permissions')->insert($securityGroupPermissionItems);
    }
}
