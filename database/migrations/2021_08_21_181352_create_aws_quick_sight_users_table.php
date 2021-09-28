<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsQuickSightUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_quick_sight_users', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);

            $table->boolean('active')->nullable()->comment('true || false');
            $table->string('arn')->nullable()->comment('<string>');
            $table->string('custom_permissions_name')->nullable()->comment('<string>');
            $table->string('email')->comment('<string>');
            $table->string('external_login_federation_provider_type')->nullable()->comment('<string>');
            $table->string('external_login_federation_provider_url')->nullable()->comment('<string>');
            $table->string('external_login_id')->nullable()->comment('<string>');
            $table->string('identity_type')->nullable()->comment('IAM|QUICKSIGHT');
            $table->string('principal_id')->nullable()->comment('<string>');
            $table->string('role')->nullable()->comment('ADMIN|AUTHOR|READER|RESTRICTED_AUTHOR|RESTRICTED_READER');
            $table->string('user_name')->nullable()->comment('<string>');

            $table->timestamp('updated_at')->nullable();

            $table->unique([
                'owner_id',
                'region',
                'email'
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
        Schema::dropIfExists('aws_quick_sight_users');
    }
}
