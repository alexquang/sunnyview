<?php

use App\Models\AuthUser;
use App\Models\Company;
use App\Models\Group;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable()->index();
            $table->foreignIdFor(Group::class)->nullable()->index();
            $table->string('name')->comment('name');
            $table->string('email')->comment('email');
            $table->string('password')->comment('pass');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable()->comment('email_confirmed');
            $table->integer('login_failed_count')->nullable()->comment('間違い回数')->default(0);
            $table->timestamp('last_logged_in_at')->nullable()->comment('lastlogin');
            $table->timestamp('password_last_changed_at')->nullable()->comment('password_last_changed');
            $table->boolean('is_enabled')->default(true);
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
        Schema::dropIfExists('auth_users');
    }
}
