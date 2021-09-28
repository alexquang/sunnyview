<?php

use App\Models\AwsAccount;
use App\Models\AwsEbs2Volume;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsEbsVolumeAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_ebs_volume_attachments', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);
            $table->string('volume_id', 64);

            $table->dateTime('attach_time')->nullable()->comment('<DateTime>');
            $table->boolean('delete_on_termination')->nullable()->comment('true || false');
            $table->string('device')->nullable()->comment('<string>');
            $table->string('instance_id', 64)->comment('<string>');
            $table->string('state')->nullable()->comment('attaching|attached|detaching|detached|busy');

            $table->timestamp('updated_at')->nullable();;

            // one ebs-volume can ben attached to multiple ec2-instances
            $table->unique([
                'owner_id',
                'region',
                'volume_id',
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
        Schema::dropIfExists('aws_ebs_volume_attachments');
    }
}
