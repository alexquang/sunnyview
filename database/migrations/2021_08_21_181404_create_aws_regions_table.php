<?php

use App\Models\AwsAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_regions', function (Blueprint $table) {
            $table->foreignIdFor(AwsAccount::class, 'owner_id');
            $table->string('region', 64);

            $table->timestamp('updated_at')->nullable();

            $table->unique([
                'owner_id',
                'region',
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
        Schema::dropIfExists('aws_regions');
    }
}
