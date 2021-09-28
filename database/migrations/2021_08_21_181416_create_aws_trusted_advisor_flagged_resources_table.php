<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsTrustedAdvisorFlaggedResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_trusted_advisor_flagged_resources', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);
            $table->string('check_id', 64);

            $table->boolean('is_suppressed')->nullable()->comment('true || false');
            $table->json('metadata')->nullable()->comment('[<string>, ...]');
            $table->string('flagged_region')->nullable()->comment('<string>');
            $table->string('resource_id', 64)->comment('<string>');
            $table->string('status')->nullable()->comment('<string>');

            $table->timestamp('updated_at')->nullable();

            $table->unique([
                'owner_id',
                'region',
                'check_id',
                'resource_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aws_trusted_advisor_flagged_resources');
    }
}
