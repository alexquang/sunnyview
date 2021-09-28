<?php

use App\Models\AuthUser;
use App\Models\Company;
use App\Models\Invoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDownloadHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_download_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Invoice::class); // this is to track the related invoice that was downloaded

            $table->string('ym')->index();
            $table->string('file_name');
            $table->string('file_type', 3);
            $table->foreignIdFor(AuthUser::class, 'downloaded_by');
            $table->ipAddress('downloaded_from', 64);
            $table->timestamp('downloaded_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_download_histories');
    }
}
