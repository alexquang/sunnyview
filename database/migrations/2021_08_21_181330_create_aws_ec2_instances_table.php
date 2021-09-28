<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsEc2InstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_ec2_instances', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);

            $table->string('ami_launch_index')->nullable()->comment('<integer>');
            $table->string('architecture')->nullable()->comment('i386|x86_64|arm64');
            $table->string('boot_mode')->nullable()->comment('legacy-bios|uefi');
            $table->string('client_token')->nullable()->comment('<string>');
            $table->string('cpu_options_core_count')->nullable()->comment('<integer>');
            $table->string('cpu_options_threads_per_core')->nullable()->comment('<integer>');
            $table->string('ebs_optimized')->nullable()->comment('true || false');
            $table->string('ena_support')->nullable()->comment('true || false');
            $table->string('enclave_options_enabled')->nullable()->comment('true || false');
            $table->string('hibernation_options_configured')->nullable()->comment('true || false');
            $table->string('hypervisor')->nullable()->comment('ovm|xen');
            $table->string('iam_instance_profile_arn')->nullable()->comment('<string>');
            $table->string('iam_instance_profile_id')->nullable()->comment('<string>');
            $table->string('image_id')->nullable()->comment('<string>');
            $table->string('instance_id', 64)->comment('<string>');
            $table->string('instance_lifecycle')->nullable()->comment('spot|scheduled');
            $table->string('instance_type')->nullable()->comment('<string>');
            $table->string('kernel_id')->nullable()->comment('<string>');
            $table->string('key_name')->nullable()->comment('<string>');
            $table->string('launch_time')->nullable()->comment('<DateTime>');
            $table->string('metadata_options_http_endpoint')->nullable()->comment('disabled|enabled');
            $table->string('metadata_options_http_put_response_hop_limit')->nullable()->comment('<integer>');
            $table->string('metadata_options_http_tokens')->nullable()->comment('optional|required');
            $table->string('metadata_options_state')->nullable()->comment('pending|applied');
            $table->string('monitoring_state')->nullable()->comment('disabled|disabling|enabled|pending');
            $table->string('outpost_arn')->nullable()->comment('<string>');
            $table->string('placement_affinity')->nullable()->comment('<string>');
            $table->string('placement_availability_zone')->nullable()->comment('<string>');
            $table->string('placement_group_name')->nullable()->comment('<string>');
            $table->string('placement_host_id')->nullable()->comment('<string>');
            $table->string('placement_host_resource_group_arn')->nullable()->comment('<string>');
            $table->string('placement_partition_number')->nullable()->comment('<integer>');
            $table->string('placement_spread_domain')->nullable()->comment('<string>');
            $table->string('placement_tenancy')->nullable()->comment('default|dedicated|host');
            $table->string('platform')->nullable()->comment('Windows');
            $table->string('private_dns_name')->nullable()->comment('<string>');
            $table->string('private_ip_address')->nullable()->comment('<string>');
            $table->string('public_dns_name')->nullable()->comment('<string>');
            $table->string('public_ip_address')->nullable()->comment('<string>');
            $table->string('ramdisk_id')->nullable()->comment('<string>');
            $table->string('root_device_name')->nullable()->comment('<string>');
            $table->string('root_device_type')->nullable()->comment('ebs|instance-store');
            $table->string('source_dest_check')->nullable()->comment('true || false');
            $table->string('spot_instance_request_id')->nullable()->comment('<string>');
            $table->string('sriov_net_support')->nullable()->comment('<string>');
            $table->string('state_code')->nullable()->comment('<integer>');
            $table->string('state_name')->nullable()->comment('pending|running|shutting-down|terminated|stopping|stopped');
            $table->string('state_reason_code')->nullable()->comment('<string>');
            $table->string('state_reason_message')->nullable()->comment('<string>');
            $table->string('state_transition_reason')->nullable()->comment('<string>');
            $table->string('subnet_id')->nullable()->comment('<string>');
            $table->string('virtualization_type')->nullable()->comment('hvm|paravirtual');
            $table->string('vpc_id')->nullable()->comment('<string>');

            $table->timestamp('updated_at')->nullable();;

            $table->unique([
                'owner_id',
                'region',
                'instance_id',
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
        Schema::dropIfExists('aws_ec2_instances');
    }
}
