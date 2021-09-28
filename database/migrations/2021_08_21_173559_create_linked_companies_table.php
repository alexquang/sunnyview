<?php

use App\Models\AuthUser;
use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkedCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linked_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class);
            $table->foreignIdFor(Company::class, 'linked_company_id');

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
        Schema::dropIfExists('linked_companies');
    }
}
