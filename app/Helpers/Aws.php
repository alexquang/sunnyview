<?php

namespace App\Helpers;

class Aws extends \Aws\Sdk
{
    const DEFAULT_VERSION = 'latest';

    const ROLE_SESSION_NAME = 'sv_switch';

    /**
     * @var \App\Models\AwsAccount
     */
    private $account;

    /**
     * @var array
     */
    private $configs;

    public function __construct(\App\Models\AwsAccount $account = null, array $configs = [])
    {
        // setup shared config by calling parent constructor
        parent::__construct($configs);

        $this->account = $account;

        $this->configs = $configs;
    }

    public function __call($name, array $arguments): \Aws\AwsClientInterface
    {
        if ($name != 'createSts' && strpos($name, 'create') === 0) {
            $arguments = reset($arguments) ?: [];

            if (empty($arguments['region'])) {
                $arguments['region'] = $this->configs['region'] ?? config('aws.default_region');
            }

            if (empty($arguments['version'])) {
                $arguments['version'] = $this->configs['version'] ?? self::DEFAULT_VERSION;
            }

            if (empty($arguments['credentials'])) {
                $arguments['credentials'] = $this->configs['credentials'] ?? $this->getCredentials($arguments['region']);
            }

            return parent::__call($name, [$arguments]);
        }

        return parent::__call($name, $arguments);
    }

    public function test(): bool
    {
        return @!!$this->requestCredentials(config('aws.default_region'));
    }

    private function getCredentials(string $region)
    {
        $cachedCredentialsKey = strtr('aws_assumed_credentials_for_account_@accountId_on_region_@region', [
            '@accountId' => $this->account->account_id,
            '@region' => $region,
        ]);

        return cache()->get($cachedCredentialsKey, function () use ($region, $cachedCredentialsKey) {
            $assumedCredentials = $this->requestCredentials($region);

            $credentials = [
                'key' => \Arr::get($assumedCredentials, 'AccessKeyId'),
                'secret' => \Arr::get($assumedCredentials, 'SecretAccessKey'),
                'token' => \Arr::get($assumedCredentials, 'SessionToken'),
            ];

            cache()->put($cachedCredentialsKey, $credentials, 3600);

            return $credentials;
        });
    }

    private function requestCredentials(string $region): array
    {
        $masterAccount = config('aws.master_account');

        $stsClient = $this->createSts([
            'region' => $region,
            'credentials' =>  [
                'key' => $masterAccount['key'],
                'secret' => $masterAccount['secret'],
            ],
            'version' => self::DEFAULT_VERSION,
        ]);

        $result = $stsClient->assumeRole([
            'RoleArn' => $this->account->generateRoleArn(),
            'RoleSessionName' => self::ROLE_SESSION_NAME,
            'ExternalId' => $this->account->external_id
        ]);

        return $result->get('Credentials') ?: [];
    }
}
