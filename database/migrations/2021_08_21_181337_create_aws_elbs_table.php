<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsElbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_elbs', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);

            $table->json('availability_zones')->nullable()->comment('[<string>, ...]');
            $table->string('canonical_hosted_zone_name')->nullable()->comment('<string>');
            $table->string('canonical_hosted_zone_name_id')->nullable()->comment('<string>');
            $table->dateTime('created_time')->nullable()->comment('<DateTime>');
            $table->string('dns_name')->nullable()->comment('<string>');
            $table->integer('health_check_healthy_threshold')->nullable()->comment('<integer>');
            $table->integer('health_check_interval')->nullable()->comment('<integer>');
            $table->string('health_check_target')->nullable()->comment('<string>');
            $table->integer('health_check_timeout')->nullable()->comment('<integer>');
            $table->integer('health_check_unhealthy_threshold')->nullable()->comment('<integer>');
            $table->json('instances')->nullable()->comment('[<string>, ...]');
            $table->string('load_balancer_name', 64)->comment('<string>');
            $table->string('scheme')->nullable()->comment('<string>');
            $table->json('security_groups')->nullable()->comment('[<string>, ...]');
            $table->string('source_security_group_name')->nullable()->comment('<string>');
            $table->string('source_security_group_owner_alias')->nullable()->comment('<string>');
            $table->json('subnets')->nullable()->comment('[<string>, ...]');
            $table->string('vpc_id')->nullable()->comment('<string>');

            $table->timestamp('updated_at')->nullable();

            $table->unique([
                'owner_id',
                'region',
                'load_balancer_name',
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
        Schema::dropIfExists('aws_elbs');
    }
}
