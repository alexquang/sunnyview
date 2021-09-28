<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsVpcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_vpcs', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);

            $table->string('cidr_block')->nullable()->comment('<string>');
            $table->string('dhcp_options_id')->nullable()->comment('<string>');
            $table->string('instance_tenancy')->nullable()->comment('default|dedicated|host');
            $table->boolean('is_default')->nullable()->comment('true || false');
            $table->string('state')->nullable()->comment('pending|available');
            $table->string('vpc_id', 64)->comment('<string>');

            $table->timestamp('updated_at')->nullable();

            $table->unique([
                'owner_id',
                'region',
                'vpc_id',
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
        Schema::dropIfExists('aws_vpcs');
    }
}
