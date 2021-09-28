<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->string('setting_group')->default('general');
            $table->boolean('is_premium_feature')->default(true);
            $table->boolean('is_developer_feature')->default(true);
            $table->boolean('is_scopeable_to_group')->default(false);
            $table->boolean('is_scopeable_to_project')->default(false);
            $table->boolean('is_scopeable_to_self')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_permissions');
    }
}
