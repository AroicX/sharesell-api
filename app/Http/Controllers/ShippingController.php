<?php

namespace App\Http\Controllers;

use App\Qoutes;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function quote(Request $request)
    {
        $qouteID = $this->random_string(25);
        try {
            $qoute = new Qoutes();
            $qoute->qoute_id = $qouteID;
            $qoute->reseller_id = $request->reseller_id;
            $qoute->supplier_id = $request->supplier_id;
            $qoute->product_id = $request->product_id;
            $qoute->origin_state = $request->origin_state;
            $qoute->origin_city = $request->origin_city;
            $qoute->destination_state = $request->destination_state;
            $qoute->destination_city = $request->destination_city;
            $qoute->delivery_fee = $request->delivery_fee;
            $qoute->rate_key = $request->rate_key;
            $qoute->payload = $request->payload;
            $qoute->save();

            return $this->jsonFormat(200, 'success', 'Link Generated', [
                'url' => env('APP_URL') . '/checkout-form/' . $qouteID,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
