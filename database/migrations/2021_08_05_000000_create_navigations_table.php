<?php

use App\Models\AuthUser;
use App\Models\BusinessCode;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('link')->nullable()->unique();
            $table->string('group')->nullable();
            $table->string('parent')->nullable();
            $table->string('position')->default('sidebar'); // sidebar or header
            $table->string('site', 8)->index(); // admin or frontend
            $table->boolean('is_dev_feature')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('navigations');
    }
}
