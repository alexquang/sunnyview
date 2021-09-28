<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsAmisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_amis', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);

            $table->string('architecture')->nullable()->comment('i386|x86_64|arm64');
            $table->string('boot_mode')->nullable()->comment('legacy-bios|uefi');
            $table->string('creation_date')->nullable()->comment('<string>');
            $table->string('deprecation_time')->nullable()->comment('<string>');
            $table->string('description')->nullable()->comment('<string>');
            $table->boolean('ena_support')->nullable()->comment('true || false');
            $table->string('hypervisor')->nullable()->comment('ovm|xen');
            $table->string('image_id', 64)->comment('<string>');
            $table->string('image_location')->nullable()->comment('<string>');
            $table->string('image_owner_alias')->nullable()->comment('<string>');
            $table->string('image_type')->nullable()->comment('machine|kernel|ramdisk');
            $table->string('kernel_id')->nullable()->comment('<string>');
            $table->string('name')->nullable()->comment('<string>');
            $table->string('platform')->nullable()->comment('Windows');
            $table->string('platform_details')->nullable()->comment('<string>');
            $table->boolean('public')->nullable()->comment('true || false');
            $table->string('ramdisk_id')->nullable()->comment('<string>');
            $table->string('root_device_name')->nullable()->comment('<string>');
            $table->string('root_device_type')->nullable()->comment('ebs|instance-store');
            $table->string('sriov_net_support')->nullable()->comment('<string>');
            $table->string('state')->nullable()->comment('pending|available|invalid|deregistered|transient|failed|error');
            $table->string('state_code')->nullable()->comment('<string>');
            $table->string('state_message')->nullable()->comment('<string>');
            $table->string('usage_operation')->nullable()->comment('<string>');
            $table->string('virtualization_type')->nullable()->comment('hvm|paravirtual');

            $table->timestamp('updated_at')->nullable();

            $table->unique([
                'owner_id',
                'region',
                'image_id',
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
        Schema::dropIfExists('aws_amis');
    }
}
