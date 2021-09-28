<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsCloudWatchEventRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_cloud_watch_event_rules', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);

            $table->string('arn')->nullable()->comment('<string>');
            $table->string('description')->nullable()->comment('<string>');
            $table->string('event_bus_name')->nullable()->comment('<string>');
            $table->string('event_pattern')->nullable()->comment('<string>');
            $table->string('managed_by')->nullable()->comment('<string>');
            $table->string('name')->comment('<string>');
            $table->string('role_arn')->nullable()->comment('<string>');
            $table->string('schedule_expression')->nullable()->comment('<string>');
            $table->string('state')->nullable()->comment('ENABLED|DISABLED');

            $table->timestamp('updated_at')->nullable();;

            $table->unique([
                'owner_id',
                'region',
                'name',
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
        Schema::dropIfExists('aws_cloud_watch_event_rules');
    }
}
