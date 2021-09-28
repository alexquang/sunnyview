<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsEbsSnapshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_ebs_snapshots', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);

            $table->string('data_encryption_key_id')->nullable()->comment('<string>');
            $table->string('description')->nullable()->comment('<string>');
            $table->boolean('encrypted')->nullable()->comment('true || false');
            $table->string('kms_key_id')->nullable()->comment('<string>');
            $table->string('outpost_arn')->nullable()->comment('<string>');
            $table->string('owner_alias')->nullable()->comment('<string>');
            $table->string('progress')->nullable()->comment('<string>');
            $table->string('snapshot_id', 64)->comment('<string>');
            $table->dateTime('start_time')->nullable()->comment('<DateTime>');
            $table->string('state')->nullable()->comment('pending|completed|error');
            $table->string('state_message')->nullable()->comment('<string>');
            $table->string('volume_id')->nullable()->comment('<string>');
            $table->integer('volume_size')->nullable()->comment('<integer>');

            $table->timestamp('updated_at')->nullable();;

            $table->unique([
                'owner_id',
                'region',
                'snapshot_id',
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
        Schema::dropIfExists('aws_ebs_snapshots');
    }
}
