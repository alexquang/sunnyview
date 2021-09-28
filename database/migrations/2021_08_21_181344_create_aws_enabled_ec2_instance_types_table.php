<?php

use App\Models\AwsAccount;
use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsEnabledEc2InstanceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_enabled_ec2_instance_types', function (Blueprint $table) {
            $table->foreignIdFor(Company::class);
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);
            $table->string('instance_type', 64);

            $table->unique([
                'company_id',
                'owner_id',
                'region',
                'instance_type',
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
        Schema::dropIfExists('aws_enabled_ec2_instance_types');
    }
}
