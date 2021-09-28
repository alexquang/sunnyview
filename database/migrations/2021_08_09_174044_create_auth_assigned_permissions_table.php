<?php

use App\Models\AuthPermission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthAssignedPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_assigned_permissions', function (Blueprint $table) {
            $table->foreignIdFor(AuthPermission::class);
            $table->morphs('assignable');
            $table->string('assigned_rule')->default('allow');
            $table->string('assigned_scope')->nullable();

            $table->unique([
                'auth_permission_id',
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
        Schema::dropIfExists('auth_assigned_permissions');
    }
}
