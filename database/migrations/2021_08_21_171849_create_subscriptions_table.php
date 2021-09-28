<?php

use App\Models\AuthUser;
use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class);

            $table->dateTime('subcribed_at')->nullable();
            $table->string('pricing_plan')->nullable()->comment('free|trial|paid|flat-rate');
            $table->double('pricing_fixed_amount')->nullable()->comment('fixed amount for flat-rate');
            $table->dateTime('canceled_at')->nullable();
            $table->foreignIdFor(AuthUser::class, 'canceled_by')->nullable();
            $table->dateTime('expired_at')->nullable();

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
        Schema::dropIfExists('subscriptions');
    }
}
