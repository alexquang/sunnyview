<?php

namespace Tests\Unit\Models;

use App\Models\AuthUser;
use App\Models\AwsAccount;
use Tests\TestCase;

class AwsAccountTest extends TestCase
{
    public function test_aws_account_can_be_updated_using_custom_primary_key()
    {
        $awsAccount = AwsAccount::factory()->create([
            'deleted_at' => now(),
        ]);

        $awsAccount = AwsAccount::factory()->create([
            'account_id' => $awsAccount->account_id,
        ]);

        $awsAccount->name = 'new-name';

        $this->assertTrue($awsAccount->save());

        $this->assertEquals($awsAccount->fresh()->name, 'new-name');
    }
}
