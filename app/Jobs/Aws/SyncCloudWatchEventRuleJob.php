<?php

namespace App\Jobs\Aws;

use App\Models\AwsCloudWatchEventRule;

class SyncCloudWatchEventRuleJob extends SyncJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->regions as $region) {
            $client = $this->aws()->createCloudWatchEvents(['region' => $region]);

            $params = [];
            try {
                AwsCloudWatchEventRule::where([
                    'region' => $region,
                    'owner_id' => $this->account->account_id,
                ])->delete();

                do {
                    $result = $client->listRules($params);

                    $this->import($region, $result->get('Rules') ?: []);
                    
                    $params['NextToken'] = $result->get('NextToken');
                } while ($params['NextToken']);
            } catch (\Throwable $th) {
                echo $th->getMessage() . PHP_EOL;
            }
        }
    }

    // Import data
    private function import($region, array $rules)
    {
        $ruleItems = [];

        $current = now();
        
        foreach ($rules as $rule) {
            $ruleItem = [
                'owner_id' => $this->account->account_id,
                'region' => $region,

                'arn' => \Arr::get($rule, 'Arn'),
                'description' => \Arr::get($rule, 'Description'),
                'event_bus_name' => \Arr::get($rule, 'EventBusName'),
                'event_pattern' => \Arr::get($rule, 'EventPattern'),
                'managed_by' => \Arr::get($rule, 'ManagedBy'),
                'name' => \Arr::get($rule, 'Name'),
                'role_arn' => \Arr::get($rule, 'RoleArn'),
                'schedule_expression' => \Arr::get($rule, 'ScheduleExpression'),
                'state' => \Arr::get($rule, 'State'),
                'updated_at' => $current,
            ];

            $ruleItems[] = $ruleItem;
        }

        AwsCloudWatchEventRule::insert($ruleItems);
    }
}
