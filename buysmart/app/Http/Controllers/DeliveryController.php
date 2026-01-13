<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Address;
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
      public function saveAddress(Request $request)
    {
        // Validation
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|digits:6',
        ]);

        // Save address for authenticated user
        $address = auth()->user()->addresses()->create($request->all());

        return response()->json([
            'success' => true,
            'address' => $address,
        ]);
    }

    
}
