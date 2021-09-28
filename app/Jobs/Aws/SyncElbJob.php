<?php

namespace App\Jobs\Aws;

use App\Models\AwsElbs;

class SyncElbJob extends SyncJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->regions as $region) {
            $client = $this->aws()->createElasticLoadBalancing(['region' => $region]);

            $params = [];
            try {
                AwsElbs::where([
                    'region' => $region,
                    'owner_id' => $this->account->account_id,
                ])->delete();

                do {
                    $result = $client->describeLoadBalancers($params);

                    $this->import($region, $result->get('LoadBalancerDescriptions') ?: []);

                    $params['NextMarker'] = $result->get('NextMarker');
                } while ($params['NextMarker']);
            } catch (\Throwable $th) {
                echo $th->getMessage() . PHP_EOL;
            }
        }
    }

    // Import data
    private function import($region, array $loadBalancerDescriptions)
    {
        $loadBalancerDescriptionItems = [];

        $current = now();

        foreach ($loadBalancerDescriptions as $loadBalancerDescription) {
            $loadBalancerDescriptionItem = [
                'owner_id' => $this->account->account_id,
                'region' => $region,

                'availability_zones' => \Arr::get($loadBalancerDescription, 'AvailabilityZones'),
                'canonical_hosted_zone_name' => \Arr::get($loadBalancerDescription, 'CanonicalHostedZoneName'),
                'canonical_hosted_zone_name_id' => \Arr::get($loadBalancerDescription, 'CanonicalHostedZoneNameID'),
                'created_time' => \Arr::get($loadBalancerDescription, 'CreatedTime'),
                'dns_name' => \Arr::get($loadBalancerDescription, 'DNSName'),
                'health_check_healthy_threshold' => \Arr::get($loadBalancerDescription, 'HealthCheck.HealthyThreshold'),
                'health_check_interval' => \Arr::get($loadBalancerDescription, 'HealthCheck.Interval'),
                'health_check_target' => \Arr::get($loadBalancerDescription, 'HealthCheck.Target'),
                'health_check_timeout' => \Arr::get($loadBalancerDescription, 'HealthCheck.Timeout'),
                'health_check_unhealthy_threshold' => \Arr::get($loadBalancerDescription, 'HealthCheck.UnhealthyThreshold'),
                'instances' => \Arr::get($loadBalancerDescription, 'Instances'),
                'load_balancer_name' => \Arr::get($loadBalancerDescription, 'LoadBalancerName'),
                'scheme' => \Arr::get($loadBalancerDescription, 'Scheme'),
                'security_groups' => \Arr::get($loadBalancerDescription, 'SecurityGroups'),
                'source_security_group_name' => \Arr::get($loadBalancerDescription, 'SourceSecurityGroup.GroupName'),
                'source_security_group_owner_alias' => \Arr::get($loadBalancerDescription, 'SourceSecurityGroup.OwnerAlias'),
                'subnets' => \Arr::get($loadBalancerDescription, 'Subnets'),
                'vpc_id' => \Arr::get($loadBalancerDescription, 'VPCId'),
                'updated_at' => $current,
            ];

            $loadBalancerDescriptionItems[] = $loadBalancerDescriptionItem;
        }

        AwsElbs::insert($loadBalancerDescriptionItems);
    }
}
