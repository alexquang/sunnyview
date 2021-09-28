<?php

use App\Models\AuthUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_codes', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('code');
            $table->integer('name');

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
        Schema::dropIfExists('business_codes');
    }
}
