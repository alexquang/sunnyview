<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsSecurityGroupPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_security_group_permissions', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);
            $table->string('group_id', 64);

            $table->string('from_port')->nullable()->comment('<integer>');
            $table->string('ip_protocol')->nullable()->comment('<string>');
            $table->json('ip_ranges')->nullable()->comment('[ [<CidrIp>, <Description>], ...]');
            $table->json('ipv_6_ranges')->nullable()->comment('[ [<CidrIpv6>, <Description>], ...]]');
            $table->string('to_port')->nullable()->comment('<integer>');

            $table->timestamp('updated_at')->nullable();

            $table->index([
                'owner_id',
                'region',
                'group_id',
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
        Schema::dropIfExists('aws_security_group_permissions');
    }
}
