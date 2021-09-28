<?php

namespace App\Jobs\Aws;

use App\Models\AwsTrustedAdvisorFlaggedResource;
use App\Models\AwsTrustedAdvisor;

class SyncTrustedAdvisorJob extends SyncJob
{

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // must set the AWS Region to us-east-1
        $client = $this->aws()->createSupport(['region' => 'us-east-1']);
        try {
            $checkResult = $client->describeTrustedAdvisorChecks([
                'language' => 'ja', // REQUIRED (en/ja)
            ]);

            // TODO: need to test
            if ($checkResult instanceof \Aws\Result) {
                $checks = \Arr::get($checkResult, 'checks');
                // Get array checkId
                $checkIds = \Arr::pluck($checks, 'id');
                // Get trusted advisor summaries
                $checkSummariesResult = $client->describeTrustedAdvisorCheckSummaries([
                    'checkIds' => $checkIds,
                ]);

                // Import data to DB
                $this->import($client, 'us-east-1', $checkSummariesResult->get('summaries') ?: []);
            }
        } catch (\Throwable $th) {
            echo $th->getMessage() . PHP_EOL;
        }
    }

    private function import($client, $region, array $trustedAdvisors)
    {
        $trustedAdvisorItems = [];
        $flaggedResourceItems = [];

        foreach ($trustedAdvisors as $trustedAdvisor) {
            $trustedAdvisorItem = [
                'owner_id' => $this->account->account_id,
                'region' => $region,
                'estimated_monthly_savings' => \Arr::get($trustedAdvisor, 'categorySpecificSummary.costOptimizing.estimatedMonthlySavings'),
                'estimated_percent_monthly_savings' => \Arr::get($trustedAdvisor, 'categorySpecificSummary.costOptimizing.estimatedPercentMonthlySavings'),
                'check_id' => \Arr::get($trustedAdvisor, 'checkId'),
                'resources_flagged' => \Arr::get($trustedAdvisor, 'resourcesSummary.resourcesFlagged'),
                'resources_ignored' => \Arr::get($trustedAdvisor, 'resourcesSummary.resourcesIgnored'),
                'resources_processed' => \Arr::get($trustedAdvisor, 'resourcesSummary.resourcesProcessed'),
                'resources_suppressed' => \Arr::get($trustedAdvisor, 'resourcesSummary.resourcesSuppressed'),
                'status' => \Arr::get($trustedAdvisor, 'status'),
                'timestamp' => \Arr::get($trustedAdvisor, 'timestamp'),
            ];

            // aws_trusted_advisors
            $trustedAdvisorItems[] = $trustedAdvisorItem;

            // Get Flagged resource if it has data
            if (\Arr::get($trustedAdvisor, 'hasFlaggedResources') == true) {
                $flaggedResourceResult = $client->describeTrustedAdvisorCheckResult([
                    'checkId' => \Arr::get($trustedAdvisor, 'checkId'), // REQUIRED
                ]);
                $flagResources = \Arr::get($flaggedResourceResult, 'result.flaggedResources');
                foreach ($flagResources as $flagResource) {
                    $flagggedResourceItem = [
                        'owner_id' => $this->account->account_id,
                        'region' => $region,
                        'check_id' => \Arr::get($trustedAdvisor, 'checkId'),
                        'is_suppressed' => \Arr::get($flagResource, 'isSuppressed'),
                        'metadata' => json_encode(\Arr::get($flagResource, 'metadata')),
                        'flagged_region' => \Arr::get($flagResource, 'region'),
                        'resource_id' => \Arr::get($flagResource, 'resourceId'),
                        'status' => \Arr::get($flagResource, 'status'),
                    ];
                    $flaggedResourceItems[] = $flagggedResourceItem;
                }
            }
        }

        \DB::transaction(function () use ($region, $trustedAdvisorItems, $flaggedResourceItems) {
            $condistions = [
                'region' => $region,
                'owner_id' => $this->account->account_id,
            ];
            AwsTrustedAdvisorFlaggedResource::where($condistions)->delete();
            AwsTrustedAdvisor::where($condistions)->delete();

            \DB::table('aws_trusted_advisors')->insert($trustedAdvisorItems);
            \DB::table('aws_trusted_advisor_flagged_resources')->insert($flaggedResourceItems);
        });
    }
}
