<?php

namespace App\Jobs\Aws;

class SyncVpcsJob extends SyncJob
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

                    // Delete old data
                    \DB::table('aws_vpcs')->where([
                        'region' => $region,
                        'owner_id' => $this->account->account_id,
                    ])->delete();

                    // Get new data from aws
                    $params = [
                        'MaxResults' => 500,
                    ];
                    do {
                        $result = $client->describeVpcs($params);

                        if ($result instanceof \Aws\Result) {
                            $vpcs = $result->get('Vpcs');
                            $params['NextToken'] = $result->get('NextToken');
                            // TODO: need to test
                            // Insert new data to DB
                            $this->import($region, $vpcs);
                        }
                    } while ($params['NextToken']);
                });
            } catch (\Throwable $th) {
                echo $th->getMessage() . PHP_EOL;
            }
        }
    }

    private function import($region, array $vpcs)
    {

        $vpcsItems = [];

        foreach ($vpcs as $item) {
            $vpcsItem = [
                'owner_id' => $this->account->account_id,
                'region' => $region,

                'cidr_block' => \Arr::get($item, 'CidrBlock'),
                'dhcp_options_id' => \Arr::get($item, 'DhcpOptionsId'),
                'instance_tenancy' => \Arr::get($item, 'InstanceTenancy'),
                'is_default' => \Arr::get($item, 'IsDefault'),
                'state' => \Arr::get($item, 'State'),
                'vpc_id' => \Arr::get($item, 'VpcId'),
            ];
            // aws_vpcs
            $vpcsItems[] = $vpcsItem;
        }

        \DB::table('aws_vpcs')->insert($vpcsItems);
    }
}
