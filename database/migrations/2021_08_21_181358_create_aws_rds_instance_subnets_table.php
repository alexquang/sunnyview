<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsRdsInstanceSubnetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_rds_instance_subnets', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);
            $table->string('db_instance_identifier', 64);

            $table->string('subnet_availability_zone')->nullable()->comment('<string>');
            $table->string('subnet_identifier')->comment('<string>');
            $table->string('subnet_outpost_arn')->nullable()->comment('<string>');
            $table->string('subnet_status')->nullable()->comment('<string>');

            $table->timestamp('updated_at')->nullable();;

            $table->unique([
                'owner_id',
                'region',
                'db_instance_identifier',
                'subnet_identifier',
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
        Schema::dropIfExists('aws_rds_instance_subnets');
    }
}
