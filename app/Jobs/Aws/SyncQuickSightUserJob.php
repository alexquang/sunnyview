<?php

namespace App\Jobs\Aws;

use App\Models\AwsQuickSightUser;

class SyncQuickSightUserJob extends SyncJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->regions as $region) {
            $client = $this->aws()->createQuickSight([
                'region' => $region,
                'credentials' =>  [
                    'key' => config('aws.master_account.key'),
                    'secret' => config('aws.master_account.secret'),
                ],
            ]);

            try {
                \DB::transaction(function () use ($client, $region) {
                    // Delete old data
                    AwsQuickSightUser::where([
                        'region' => $region,
                        'owner_id' => $this->account->account_id,
                    ])->delete();

                    // Get new data from aws
                    $params = [];
                    do {
                        $result = $client->listUsers([
                            'AwsAccountId' => config('aws.master_account.id'), // REQUIRED
                            'Namespace' => 'default', // REQUIRED
                        ]);

                        // TODO: need to test
                        $this->import($region, $result->get('UserList') ?: []);

                        $params['NextToken'] = $result->get('NextToken');
                    } while ($params['NextToken']);
                });
            } catch (\Throwable $th) {
                echo $th->getMessage() . PHP_EOL;
            }
        }
    }

    private function import($region, array $userList)
    {
        $userItems = [];

        $current = now();

        foreach ($userList as $user) {
            $userItem = [
                'owner_id' => $this->account->account_id,
                'region' => $region,

                'active' => \Arr::get($user, 'Active'),
                'arn' => \Arr::get($user, 'Arn'),
                'custom_permissions_name' => \Arr::get($user, 'CustomPermissionsName'),
                'email' => \Arr::get($user, 'Email'),
                'external_login_federation_provider_type' => \Arr::get($user, 'ExternalLoginFederationProviderType'),
                'external_login_federation_provider_url' => \Arr::get($user, 'ExternalLoginFederationProviderUrl'),
                'external_login_id' => \Arr::get($user, 'ExternalLoginId'),
                'identity_type' => \Arr::get($user, 'IdentityType'),
                'principal_id' => \Arr::get($user, 'PrincipalId'),
                'role' => \Arr::get($user, 'Role'),
                'user_name' => \Arr::get($user, 'UserName'),

                'updated_at' => $current,
            ];

            // aws_quick_sight_users
            $userItems[] = $userItem;
        }

        // Insert to DB
        \DB::table('aws_quick_sight_users')->insert($userItems);
    }
}
