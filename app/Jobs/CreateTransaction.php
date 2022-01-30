<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
// use App\Models\Transactions;
// use App\Transactions;
use App\Qoutes;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $transactions;
    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        
        $quote = Qoutes::where('qoute_id', $this->transactions->quote_id)
        ->with('Reseller', 'Supplier', 'Product')
        ->first();

        $customer_details = json_decode($this->transactions->customer_details);



    $item = [
        'name' => $quote->product->product_name,
        'quantity' => $customer_details->quantity,
        'weight' => $quote->product->product_weight,
        'amount' => $customer_details->amount,
        'value' => $customer_details->quantity,
    ];



    $data = [
        'origin_country' => 'NIGERIA',
        'origin_state' => $quote->supplier->state,
        'origin_name' => $quote->supplier->business_name,
        'origin_street' => $quote->supplier->current_address,
        'origin_city' => $quote->supplier->city,
        'origin_email' => $quote->supplier->getUser->email,
        'origin_phone' => $quote->supplier->getUser->phone,
        'destination_country' => 'NIGERIA',
        "destination_name" => $customer_details->fullname,
        'destination_state' => $customer_details->destination_state,
        'destination_city' => $customer_details->destination_city,
        'destination_street' => $customer_details->address,
        'destination_email' => $customer_details->email,
        'destination_phone' => $customer_details->phone,
        'weight' => $quote->product->product_weight,
        'selected_courier_id' => $customer_details->rate_key,
        'items' => [$item],
        'incoming_option_code' => 'pickup',
        'payment_option_code' => 'prepaid',
    ];

    // return $data;


    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://sandbox.staging.sendbox.co/shipping/shipments',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: ' . env('SENDBOX_KEY'),
        ],
    ]);

    $response = curl_exec($curl);

    curl_close($curl);
    // return $response;
    ob_start();
    var_dump($response);
    error_log(ob_get_clean(), 4);
    }
}
