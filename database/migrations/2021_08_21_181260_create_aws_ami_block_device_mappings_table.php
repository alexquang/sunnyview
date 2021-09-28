<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsAmiBlockDeviceMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_ami_block_device_mappings', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);
            $table->string('image_id', 64);

            $table->string('device_name', 64)->comment('<string>');
            $table->boolean('ebs_delete_on_termination')->nullable()->comment('true || false');
            $table->boolean('ebs_encrypted')->nullable()->comment('true || false');
            $table->integer('ebs_iops')->nullable()->comment('<integer>');
            $table->string('ebs_kms_key_id')->nullable()->comment('<string>');
            $table->string('ebs_outpost_arn')->nullable()->comment('<string>');
            $table->string('ebs_snapshot_id')->nullable()->comment('<string>');
            $table->integer('ebs_throughput')->nullable()->comment('<integer>');
            $table->integer('ebs_volume_size')->nullable()->comment('<integer>');
            $table->string('ebs_volume_type')->nullable()->comment('standard|io1|io2|gp2|sc1|st1|gp3');
            $table->string('no_device')->nullable()->comment('<string>');
            $table->string('virtual_name')->nullable()->comment('<string>');

            $table->timestamp('updated_at')->nullable();;

            $table->unique([
                'owner_id',
                'region',
                'image_id',
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
        Schema::dropIfExists('aws_ami_block_device_mappings');
    }
}
