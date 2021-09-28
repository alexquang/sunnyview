<?php

use App\Models\AuthRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthAssignedRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_assigned_roles', function (Blueprint $table) {
            $table->foreignIdFor(AuthRole::class);
            $table->morphs('assignable');

            $table->unique([
                'auth_role_id',
                'assignable_type',
                'assignable_id',
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
        Schema::dropIfExists('auth_assigned_roles');
    }
}
