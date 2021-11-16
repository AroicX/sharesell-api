<?php

namespace App\Http\Controllers;

use App\Qoutes;
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
