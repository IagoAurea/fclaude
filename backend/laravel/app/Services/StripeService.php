<?php

namespace App\Services;

use Exception;
use Stripe\Stripe;
use Stripe\StripeClient;
use App\Traits\ResponseTrait;

class StripeService
{
    use ResponseTrait;

    /**
     * @var object
     */
    protected $stripe;
    
    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

      /**
     * Get retrieve subscription
     * @param string $subscription
     * @return array
     */
    public function retrieveSubscription($subscription)
    {
        try {
            return $this->stripe->subscriptions->retrieve(
                $subscription,
                []
            );

        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Confirm a payment intent
     * @param array $payment_intent_id
     * @param array $payment_method_id
     * @return array
     */
    public function confirmPaymentIntent($payment_intent_id, $payment_method_id)
    {
        try {
            return $this->stripe->paymentIntents->confirm($payment_intent_id, [
                'payment_method' => $payment_method_id
            ]);
        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
    
    /**
     * Create a payment intent
     * @param array $dataPayment
     * @return array
     */
    public function paymentIntents($dataPayment)
    {
        $dataPayment['currency'] = config('services.stripe.currency');
        $dataPayment['confirm'] = true;

        try {
            return $this->createCallStripe('paymentIntents', $dataPayment);
        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Pay an Invoice Items
     * @param string $invoice
     * @return array
     */
    public function payInvoice($invoice)
    {
        try {
            return $this->stripe->invoices->pay($invoice);
        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
    
    /**
     * Create a new Invoice
     * @param array $dataInvoice
     * @return array
     */
    public function createInvoice($dataInvoice)
    {
        try {
            return $this->createCallStripe('invoices', $dataInvoice);
        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Add Invoice Items
     * @param array $dataInvoiceItem
     * @return array
     */
    public function addInvoiceItems($dataInvoiceItem)
    {
        $dataInvoiceItem['currency'] = config('services.stripe.currency');

        try {
            return $this->createCallStripe('invoiceItems', $dataInvoiceItem);
        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
    
    /**
     * Create a new user subscription
     * @param array $dataSubscription
     * @return array
     */
    public function createSubscription($dataSubscription)
    {
        $dataSubscription['trial_period_days'] = config('api.trial_days');

        try {
            return $this->createCallStripe('subscriptions', $dataSubscription);
        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
    * Save a user's payment credential
    * @param array $dataSetup
    * @return array
    */
    public function createSetupIntent($dataSetup)
    {
        $dataSetup['confirm'] = true;

        try {
            return $this->createCallStripe('setupIntents', $dataSetup);

        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Create a product stripe
     * @param array $dataProduct
     * @return array
     */
    public function createProduct($dataProduct)
    {
        try {
            return $this->createCallStripe('products', $dataProduct);
            
        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Create a plan stripe
     * @param array $dataPlan
     * @return array
     */
    public function createPlan($dataPlan)
    {
        try {
            return $this->createCallStripe('plans', $dataPlan);
            
        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Get retrieve product
     * @param string $product
     * @return array
     */
    public function retrieveProduct($product)
    {
        try {
            return $this->stripe->products->retrieve(
                $product,[]
            );

        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Get all plans stripe
     * @return array
     */
    public function allPlans()
    {
        try {
            $plansraw = $this->stripe->plans->all();

            $plans = $plansraw->data;
        
            foreach($plans as $plan) {
                $prod = $this->stripe->retrieveProduct($plan->product);
                $plan->product = $prod;
            }

            return $plans;

        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
    
    /**
     * Create method payment with data send or data default
     * @param array $dataMethodPayment
     * @return array
     */
    public function createMethodPayment($dataMethodPayment = [])
    {
        try {
            $dataDefault = [
                'type' => 'card',
                'card' => [
                    'number' => '4242424242424242',
                    'exp_month' => 5,
                    'exp_year' => 2022,
                    'cvc' => '314',
               ]
            ];

            (count($dataMethodPayment) > 0) ? $dataMethod = $dataMethodPayment : $dataMethod = $dataDefault;

            return $this->createCallStripe('paymentMethods', $dataMethod);
        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Call functions stripe
     * @param string $method
     * @param array $dataStripe
     * @return array
     */
    protected function createCallStripe($method, $dataStripe)
    {
        return $this->stripe->$method->create($dataStripe);
    }
}