<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsEc2InstanceBlockDeviceMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_ec2_instance_block_device_mappings', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);
            $table->string('instance_id', 64);

            $table->string('device_name', 64)->comment('<string>');
            $table->string('ebs_attach_time')->nullable()->comment('<DateTime>');
            $table->string('ebs_delete_on_termination')->nullable()->comment('true || false');
            $table->string('ebs_status')->nullable()->comment('attaching|attached|detaching|detached');
            $table->string('ebs_volume_id')->nullable()->comment('<string>');

            $table->timestamp('updated_at')->nullable();

            $table->unique([
                'owner_id',
                'region',
                'instance_id',
                'device_name',
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
        Schema::dropIfExists('aws_ec2_instance_block_device_mappings');
    }
}
