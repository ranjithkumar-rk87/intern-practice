<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Pincode;
class DeliveryController extends Controller
{
    public function check(Request $request, Product $product)
    {
        $request->validate([
            'pincode' => 'required|digits:6'
        ]);

        $pincode = Pincode::where('pincode', $request->pincode)
                          ->where('is_active', 1)
                          ->first();

        if ($pincode) {
            return back()->with(
                'success',
                " Delivery available in {$pincode->city}. Expected delivery in 3–5 days."
            );
        }

        return back()->with(
            'error',
            ' Delivery not available to this pincode'
        );
    }
}
