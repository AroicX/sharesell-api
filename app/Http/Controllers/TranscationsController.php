<?php

namespace App\Http\Controllers;

use App\Products;
use App\Qoutes;
use App\Supplier;
use App\Transcations;
use Illuminate\Http\Request;

class TranscationsController extends Controller
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
            $transactions = new Transcations();
            $transactions->transcation_id = $transactionID;
            $transactions->reseller_id = $request->reseller_id;
            $transactions->supplier_id = $request->supplier_id;
            $transactions->product_id = $request->product_id;
            $transactions->payment_payload = json_encode($request->payload);
            $transactions->status = 'done';
            $transactions->save();

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
                    'url' => env('FRONTEND_URL') . '/checkout/' . $qouteID,
                    $qoute,
                ]);
            } catch (\Throwable $th) {
                return $this->jsonFormat(500, 'success', 'Server error', $th);
            }

      
    }

    public function createShipping($transactions)
    {
        $params = [
            'product_id' => '1',
            'reseller_id' => '0002021',
            'supplier_id' => '0002022',
            'payload' => [
                'reference' => '812894304',
                'trans' => '1291269195',
                'status' => 'success',
                'message' => 'Approved',
                'transaction' => '1291269195',
                'trxref' => '812894304',
                'fullname' => 'Gabriel Okunola',
                'email' => 'Arowosegbe67@gmail.com',
                'phone' => '07016762847',
                'address' => 'No 16 Tunisha Cresent Barnawa kaduna',
                'destination_state' => 'Osun State',
                'destination_city' => 'Odo Otin',
                'qoute_id' => '80S23OLHRCS2X5G9QACTEZSGC',
            ],
        ];

        $getQoute = Qoutes::where('qoute_id', $params->payload->qoute_id)
            ->with('Reseller', 'Supplier', 'Product')
            ->first();

        $item = [
            'name' => $getQoute->product->product_name,
            'quantity' => $params->payload->product_qty,
            'weight' => $getQoute->product->product_weight,
            'amount' => $getQoute->product->product_amount,
            'value' => '120000',
        ];

        $data = [
            'origin_country' => 'NG',
            'origin_state' => $getQoute->supplier->state,
            'origin_street' => $getQoute->supplier->current_address,
            'origin_city' => $getQoute->supplier->city,
            'origin_email' => $getQoute->supplier->user->email,
            'origin_phone' => $getQoute->supplier->user->phone,
            'destination_country' => 'NG',
            'destination_state' => $getQoute->reseller->state,
            'destination_city' => $getQoute->reseller->city,
            'destination_street' => $getQoute->reseller->current_address,
            'destination_email' => $getQoute->reseller->user->email,
            'destination_phone' => $getQoute->reseller->user->email,
            'weight' => $getQoute->product->product_weight,
            'selected_courier_id' => 'Lagos',
            'items' => [json_encode($item)],
            'incoming_option_code' => 'pickup',
            'payment_option_code' => 'prepaid',
            'channel_code' => 'api',
            'pickup_date' => 'Lagos',
            'deliver_priority_code' => 'next_day',
            'callback_url' => 'Lagos',
        ];

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
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: ' . env('SENDBOX_KEY'),
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
