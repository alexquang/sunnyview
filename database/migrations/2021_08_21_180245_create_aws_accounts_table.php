<?php

use App\Models\AuthUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_id')->comment('costacctid');
            $table->string('account_name')->nullable()->comment('costacctname');
            $table->string('iam_role_name')->nullable();
            // $table->string('iam_role_arn')->nullable();
            $table->string('external_id')->nullable();
            $table->string('s3_bucket_dbr')->nullable();
            $table->string('s3_bucket_cur')->nullable();
            $table->boolean('is_reseller')->default(false);

            $table->foreignIdFor(AuthUser::class, 'created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aws_accounts');
    }
}
