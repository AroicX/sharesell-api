<?php

namespace App\Http\Controllers;

use App\Products;
use App\Qoutes;
use App\Supplier;
use App\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    //

    public function index($qoute_id = null)
    {
        $getQoute = Qoutes::where('qoute_id', $qoute_id)
            ->with('Reseller', 'Supplier', 'Product')
            ->first();

        return view('payments.form', ['qoute' => $getQoute]);
    }

    public function create(Request $request)
    {
        $transactionID = $this->random_string(25);
        try {
            $transactions = new Transactions();
            $transactions->transaction_id = $transactionID;
            $transactions->quote_id = $request->quote_id;
            $transactions->reseller_id = $request->reseller_id;
            $transactions->supplier_id = $request->supplier_id;
            $transactions->product_id = $request->product_id;
            $transactions->payment_payload = json_encode($request->payload);
            $transactions->customer_details = json_encode($request->customer_details);
            $transactions->status = 'completed';
            // $transactions->save();

            // return $this->createShipping($transactions);

            return $this->jsonFormat(
                200,
                'success',
                'Payment Successful',
                $transactions
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getQuote(Request $request)
    {
        $product = Products::where('id', $request->product_id)
            ->with('user', 'category')
            ->first();
            


        $data = [
            'origin_country' => 'NIGERIA',
            'origin_state' => $product->state,
            'origin_city' => $product->city,
            'destination_country' => 'NIGERIA',
            'destination_state' => $request->state,
            'destination_city' => $request->city,
            'weight' => $product->product_weight,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://sandbox.staging.sendbox.co/shipping/shipment_delivery_quote',
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

        $qoute_data = json_decode($response);

        return $this->jsonFormat(200, 'success', 'Quote Generated',  $qoute_data);
    }

    public function generatePaymentLink(Request $request)
    {
        $product = Products::where('id', $request->product_id)
            ->with('user', 'category')
            ->first();

        try {
            $qouteID = $this->random_string(25);

            $qoute = new Qoutes();
            $qoute->qoute_id = $qouteID;
            $qoute->reseller_id = auth()->user()->user_id;
            $qoute->supplier_id = $product->user->user_id;
            $qoute->product_id = $request->product_id;
            $qoute->origin_state = $product->state;
            $qoute->origin_city = $product->city;
            $qoute->destination_state = $request->state;
            $qoute->destination_city = $request->city;
            $qoute->delivery_fee = $request?->delivery_fee;
            $qoute->rate_key = $request?->rate_key;
            $qoute->reseller_price = $request?->reseller_price;
            $qoute->total_cost = $request?->total_cost;

            $qoute->save();

            return $this->jsonFormat(200, 'success', 'Link Generated', [
                'url' => env('FRONTEND_URL') . 'checkout/' . $qouteID,
                $qoute,
            ]);
        } catch (\Throwable $th) {
            return $this->jsonFormat(500, 'success', 'Server error', $th);
        }
    }

    public function getQuoteById($quote_id = null)
    {
        $qoute = Qoutes::where('qoute_id',$quote_id)->with('Reseller','Supplier','Product')->first();

        if(!$qoute){
            return $this->jsonFormat(
                400,
                'error',
                'Quote with id '.$quote_id,
                null
            );
        }

        return $this->jsonFormat(
            200,
            'success',
            'Quote Found',
            $qoute
        );
    }



    public function createShipping($transactions)
    {
   


        $quote = Qoutes::where('qoute_id', $transactions->quote_id)
            ->with('Reseller', 'Supplier', 'Product')
            ->first();

            $customer_details = json_decode($transactions->customer_details);



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
        return $response;
    }
}
