<?php

use App\Models\AuthUser;
use App\Models\AwsAccount;
use App\Models\BusinessCode;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable();

            $table->string('company_name')->comment('companyname');
            $table->string('department_name')->nullable()->comment('dept');
            $table->string('position_name')->nullable()->comment('position');

            $table->foreignIdFor(BusinessCode::class)->nullable()->comment('jcode');
            $table->string('proposal_number')->nullable()->comment('anid');
            $table->string('person_in_charge')->nullable()->comment('tanto');

            $table->string('contact_name')->nullable()->comment('name');
            $table->string('contact_email')->comment('uid');
            $table->string('contact_phone_number')->nullable()->comment('tel');
            $table->string('contact_address_1')->nullable()->comment('address1');
            $table->string('contact_address_2')->nullable()->comment('address2');
            $table->string('contact_address_3')->nullable()->comment('address3');
            $table->string('contact_postal_code')->nullable()->comment('zip');

            $table->foreignIdFor(AwsAccount::class, 'aws_usage_account_id')->nullable()->comment('costacctid');
            $table->string('aws_reseller_accounts_id', 12)->nullable()->comment('parentacctid');

            $table->string('invoice_title')->nullable()->comment('invoicetitle');
            $table->integer('invoice_issue_date')->nullable()->comment('invoicedate');
            $table->integer('invoice_pay_date')->nullable()->comment('payday');
            // $table->foreignIdFor(InvoiceTemplates::class)->nullable()->comment('invoicetype');
            $table->integer('invoice_format_type')->nullable()->comment('invoicetype');
            $table->decimal('invoice_commission_fee')->nullable()->comment('basecharge');
            $table->decimal('invoice_discount_rate')->nullable()->comment('discountrate');
            $table->string('invoice_delivery_method')->nullable()->comment('howtosend');
            $table->boolean('is_invoice_est_enabled')->default(false)->comment('estdoc');
            $table->boolean('is_invoice_nohin_enabled')->default(false)->comment('nohindoc');

            $table->string('bank_issuer')->nullable()->comment('bankacct');
            $table->string('credit_card_issuer')->nullable()->comment('ccard');
            $table->string('credit_card_number')->nullable()->comment('vcard');

            $table->boolean('is_internal_use')->default(false)->comment('internaluse');
            $table->string('notes')->nullable()->comment('memo');

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
        Schema::dropIfExists('companies');
    }
}
