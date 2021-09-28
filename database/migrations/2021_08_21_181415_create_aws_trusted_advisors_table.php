<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsTrustedAdvisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_trusted_advisors', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);

            $table->double('estimated_monthly_savings')->nullable()->comment('<float>');
            $table->double('estimated_percent_monthly_savings')->nullable()->comment('<float>');
            $table->string('check_id', 64)->comment('<string>');
            $table->integer('resources_flagged')->nullable()->comment('<integer>');
            $table->integer('resources_ignored')->nullable()->comment('<integer>');
            $table->integer('resources_processed')->nullable()->comment('<integer>');
            $table->integer('resources_suppressed')->nullable()->comment('<integer>');
            $table->string('status')->nullable()->comment('<string>');
            $table->string('timestamp')->nullable()->comment('<string>');

            $table->timestamp('updated_at')->nullable();

            $table->unique([
                'owner_id',
                'region',
                'check_id',
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
        Schema::dropIfExists('aws_trusted_advisors');
    }
}
