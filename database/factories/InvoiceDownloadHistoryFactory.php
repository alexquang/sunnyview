<?php

namespace Database\Factories;

use App\Models\AuthUser;
use App\Models\Invoice;
use App\Models\InvoiceDownloadHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceDownloadHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceDownloadHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $invoice = Invoice::factory()->create();

        return [
            'ym' => $invoice->ym,
            'invoice_id' => $invoice->id,
            'file_name' => $this->faker->word(),
            'file_type' => $this->faker->randomElement(['csv', 'pdf']),
            'downloaded_by' => AuthUser::factory(),
            'downloaded_from' => $this->faker->localIpv4(),
            'downloaded_at' => now(),
        ];
    }
}
