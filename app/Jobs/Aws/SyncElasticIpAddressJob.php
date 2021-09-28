<?php

namespace App\Jobs\Aws;

use App\Models\AwsElasticIpAddress;

class SyncElasticIpAddressJob extends SyncJob
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
                AwsElasticIpAddress::where([
                    'region' => $region,
                    'owner_id' => $this->account->account_id,
                ])->delete();

                $result = $client->describeAddresses([]);
                
                $this->import($region, $result->get('Addresses') ?: []);
            } catch (\Throwable $th) {
                echo $th->getMessage() . PHP_EOL;
            }
        }
    }

    private function import($region, array $addresses)
    {
        $addressItems = [];

        $current = now();

        foreach ($addresses as $address) {
            $addressItem = [
                'owner_id' => $this->account->account_id,
                'region' => $region,

                'allocation_id' => \Arr::get($address, 'AllocationId'),
                'association_id' => \Arr::get($address, 'AssociationId'),
                'carrier_ip' => \Arr::get($address, 'CarrierIp'),
                'customer_owned_ip' => \Arr::get($address, 'CustomerOwnedIp'),
                'customer_owned_ipv_4_pool' => \Arr::get($address, 'CustomerOwnedIpv4Pool'),
                'domain' => \Arr::get($address, 'Domain'),
                'instance_id' => \Arr::get($address, 'InstanceId'),
                'network_border_group' => \Arr::get($address, 'NetworkBorderGroup'),
                'network_interface_id' => \Arr::get($address, 'NetworkInterfaceId'),
                'network_interface_owner_id' => \Arr::get($address, 'NetworkInterfaceOwnerId'),
                'private_ip_address' => \Arr::get($address, 'PrivateIpAddress'),
                'public_ip' => \Arr::get($address, 'PublicIp'),
                'public_ipv_4_pool' => \Arr::get($address, 'PublicIpv4Pool'),
                'updated_at' => $current,
            ];

            $addressItems[] = $addressItem;
        }

        AwsElasticIpAddress::insert($addressItems);
    }
}
