<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsElasticIpAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_elastic_ip_addresses', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);

            $table->string('allocation_id')->nullable()->comment('<string>');
            $table->string('association_id')->nullable()->comment('<string>');
            $table->string('carrier_ip')->nullable()->comment('<string>');
            $table->string('customer_owned_ip')->nullable()->comment('<string>');
            $table->string('customer_owned_ipv_4_pool')->nullable()->comment('<string>');
            $table->string('domain')->nullable()->comment('vpc|standard');
            $table->string('instance_id')->nullable()->comment('<string>');
            $table->string('network_border_group')->nullable()->comment('<string>');
            $table->string('network_interface_id')->nullable()->comment('<string>');
            $table->string('network_interface_owner_id')->nullable()->comment('<string>');
            $table->string('private_ip_address')->nullable()->comment('<string>');
            $table->string('public_ip', 64)->comment('<string>');
            $table->string('public_ipv_4_pool')->nullable()->comment('<string>');

            $table->timestamp('updated_at')->nullable();

            $table->unique([
                'owner_id',
                'region',
                'public_ip',
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
        Schema::dropIfExists('aws_elastic_ip_addresses');
    }
}
