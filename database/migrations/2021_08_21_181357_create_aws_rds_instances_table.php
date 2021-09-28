<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsRdsInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_rds_instances', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);

            $table->boolean('activity_stream_engine_native_audit_fields_included')->nullable()->comment('true || false');
            $table->string('activity_stream_kinesis_stream_name')->nullable()->comment('<string>');
            $table->string('activity_stream_kms_key_id')->nullable()->comment('<string>');
            $table->string('activity_stream_mode')->nullable()->comment('sync|async');
            $table->string('activity_stream_status')->nullable()->comment('stopped|starting|started|stopping');
            $table->integer('allocated_storage')->nullable()->comment('<integer>');
            $table->boolean('auto_minor_version_upgrade')->nullable()->comment('true || false');
            $table->dateTime('automatic_restart_time')->nullable()->comment('<DateTime>');
            $table->string('availability_zone')->nullable()->comment('<string>');
            $table->string('aws_backup_recovery_point_arn')->nullable()->comment('<string>');
            $table->integer('backup_retention_period')->nullable()->comment('<integer>');
            $table->string('ca_certificate_identifier')->nullable()->comment('<string>');
            $table->string('character_set_name')->nullable()->comment('<string>');
            $table->boolean('copy_tags_to_snapshot')->nullable()->comment('true || false');
            $table->boolean('customer_owned_ip_enabled')->nullable()->comment('true || false');
            $table->string('db_cluster_identifier')->nullable()->comment('<string>');
            $table->string('db_instance_arn')->nullable()->comment('<string>');
            $table->string('db_instance_class')->nullable()->comment('<string>');
            $table->string('db_instance_identifier', 64)->comment('<string>');
            $table->string('db_instance_status')->nullable()->comment('<string>');
            $table->string('db_name')->nullable()->comment('<string>');
            $table->string('db_subnet_group_arn')->nullable()->comment('<string>');
            $table->string('db_subnet_group_description')->nullable()->comment('<string>');
            $table->string('db_subnet_group_name')->nullable()->comment('<string>');
            $table->string('db_subnet_group_status')->nullable()->comment('<string>');
            $table->string('db_subnet_group_vpc_id')->nullable()->comment('<string>');
            $table->integer('db_instance_port')->nullable()->comment('<integer>');
            $table->string('dbi_resource_id')->nullable()->comment('<string>');
            $table->boolean('deletion_protection')->nullable()->comment('true || false');
            $table->json('enabled_cloudwatch_logs_exports')->nullable()->comment('[<string>, ...]');
            $table->string('endpoint_address')->nullable()->comment('<string>');
            $table->string('endpoint_hosted_zone_id')->nullable()->comment('<string>');
            $table->integer('endpoint_port')->nullable()->comment('<integer>');
            $table->string('engine')->nullable()->comment('<string>');
            $table->string('engine_version')->nullable()->comment('<string>');
            $table->string('enhanced_monitoring_resource_arn')->nullable()->comment('<string>');
            $table->boolean('iam_database_authentication_enabled')->nullable()->comment('true || false');
            $table->dateTime('instance_create_time')->nullable()->comment('<DateTime>');
            $table->integer('iops')->nullable()->comment('<integer>');
            $table->string('kms_key_id')->nullable()->comment('<string>');
            $table->dateTime('latest_restorable_time')->nullable()->comment('<DateTime>');
            $table->string('license_model')->nullable()->comment('<string>');
            $table->string('listener_endpoint_address')->nullable()->comment('<string>');
            $table->string('listener_endpoint_hosted_zone_id')->nullable()->comment('<string>');
            $table->integer('listener_endpoint_port')->nullable()->comment('<integer>');
            $table->string('master_username')->nullable()->comment('<string>');
            $table->integer('max_allocated_storage')->nullable()->comment('<integer>');
            $table->integer('monitoring_interval')->nullable()->comment('<integer>');
            $table->string('monitoring_role_arn')->nullable()->comment('<string>');
            $table->boolean('multi_az')->nullable()->comment('true || false');
            $table->string('nchar_character_set_name')->nullable()->comment('<string>');
            $table->boolean('performance_insights_enabled')->nullable()->comment('true || false');
            $table->string('performance_insights_kms_key_id')->nullable()->comment('<string>');
            $table->integer('performance_insights_retention_period')->nullable()->comment('<integer>');
            $table->string('preferred_backup_window')->nullable()->comment('<string>');
            $table->string('preferred_maintenance_window')->nullable()->comment('<string>');
            $table->integer('promotion_tier')->nullable()->comment('<integer>');
            $table->boolean('publicly_accessible')->nullable()->comment('true || false');
            $table->json('read_replica_db_cluster_identifiers')->nullable()->comment('[<string>, ...]');
            $table->json('read_replica_db_instance_identifiers')->nullable()->comment('[<string>, ...]');
            $table->string('read_replica_source_db_instance_identifier')->nullable()->comment('<string>');
            $table->string('replica_mode')->nullable()->comment('open-read-only|mounted');
            $table->string('secondary_availability_zone')->nullable()->comment('<string>');
            $table->boolean('storage_encrypted')->nullable()->comment('true || false');
            $table->string('storage_type')->nullable()->comment('<string>');
            $table->string('tde_credential_arn')->nullable()->comment('<string>');
            $table->string('timezone')->nullable()->comment('<string>');

            $table->timestamp('updated_at')->nullable();;

            $table->unique([
                'owner_id',
                'region',
                'db_instance_identifier',
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
        Schema::dropIfExists('aws_rds_instances');
    }
}
