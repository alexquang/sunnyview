<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsRdsInstanceSecurityGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_rds_instance_security_groups', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);
            $table->string('db_instance_identifier', 64);

            $table->string('db_security_group_name')->comment('<string>');
            $table->string('status')->nullable()->comment('<string>');

            $table->timestamp('updated_at')->nullable();;

            $table->unique([
                'owner_id',
                'region',
                'db_instance_identifier',
                'db_security_group_name',
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
        Schema::dropIfExists('aws_rds_instance_security_groups');
    }
}
