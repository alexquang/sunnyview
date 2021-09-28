<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsEbsVolumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_ebs_volumes', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);

            $table->string('availability_zone')->nullable()->comment('<string>');
            $table->dateTime('create_time')->nullable()->comment('<DateTime>');
            $table->boolean('encrypted')->nullable()->comment('true || false');
            $table->string('fast_restored')->nullable()->comment('true || false');
            $table->integer('iops')->nullable()->comment('<integer>');
            $table->string('kms_key_id')->nullable()->comment('<string>');
            $table->boolean('multi_attach_enabled')->nullable()->comment('true || false');
            $table->string('outpost_arn')->nullable()->comment('<string>');
            $table->integer('size')->nullable()->comment('<integer>');
            $table->string('snapshot_id')->nullable()->comment('<string>');
            $table->string('state')->nullable()->comment('creating|available|in-use|deleting|deleted|error');
            $table->integer('throughput')->nullable()->comment('<integer>');
            $table->string('volume_id', 64)->comment('<string>');
            $table->string('volume_type')->nullable()->comment('standard|io1|io2|gp2|sc1|st1|gp3');

            $table->timestamp('updated_at')->nullable();;

            $table->unique([
                'owner_id',
                'region',
                'volume_id',
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
        Schema::dropIfExists('aws_ebs_volumes');
    }
}
