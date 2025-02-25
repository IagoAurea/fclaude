<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Stripe\Price;
use Stripe\Stripe;
use Stripe\TaxRate;
use Illuminate\Support\Facades\DB;
use Modules\Package\Repositories\Interfaces\SubpackageRepositoryInterface;

class UpdateStripeConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('', function (Blueprint $table) {
            // Configura tus credenciales de Stripe
            Stripe::setApiKey(config('services.stripe.secret'));

            // Obtén todos los impuestos existentes
            $taxes = DB::table('taxes')->get();

            foreach ($taxes as $tax) {
                // Crea el impuesto en Stripe
                try {
                    $taxRate = TaxRate::create([
                        'display_name' => $tax->name,
                        'percentage' => $tax->value,
                        'inclusive' => $tax->type === 'inclusive', // Ajusta según tu lógica
                        'jurisdiction' => $tax->type_user, // Ajusta según tu lógica
                    ]);

                    // Actualiza el stripe_tax_id en la base de datos
                    DB::table('taxes')
                        ->where('id', $tax->id)
                        ->update(['stripe_tax_id' => $taxRate->id]);

                } catch (\Exception $e) {
                    // Manejo de errores (puedes registrar o manejar según necesites)
                    // \Log::error('Error creando el impuesto en Stripe: ' . $e->getMessage());
                }
            }
            $subpackageRepository = app()->make(SubpackageRepositoryInterface::class);
            $subpackages = $subpackageRepository->findAll();

            foreach ($subpackages as $value) {
                $product = \Stripe\Product::create([
                    'name' => $value->code,
                    'metadata' => [
                        ...$value->toArray()
                    ]
                ]);

                foreach ($value->prices as $price) {
                    $monthPrice = Price::create([
                        'unit_amount' => floatval($price->month) * 100,
                        'currency' => 'usd', // Moneda
                        'product' => $product->id, // ID del producto creado anteriormente
                        'recurring' => [
                            'interval' => 'month', // Intervalo de facturación mensual
                            'interval_count' => 1 // Número de intervalos entre cada facturación
                        ],
                    ]);

                    $yearPrice = Price::create([
                        'unit_amount' => floatval($price->year) * 100, // Precio en centavos (por ejemplo, $200.00)
                        'currency' => 'usd', // Moneda
                        'product' => $product->id, // ID del producto creado anteriormente
                        'recurring' => [
                            'interval' => 'year', // Intervalo de facturación anual
                            'interval_count' => 1 // Número de intervalos entre cada facturación
                        ],
                    ]);

                    $price->update(
                        [
                            'stripe_month_id' => $monthPrice->id,
                            'stripe_year_id' => $yearPrice->id,
                        ]
                    );
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}
