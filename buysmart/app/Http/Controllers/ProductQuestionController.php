<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
class ProductQuestionController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'question' => 'required|string|max:500',
        ]);

        $product->questions()->create([
            'user_id' => auth()->id(),
            'question' => $request->question,
        ]);

        return back()->with('success', 'Your question has been submitted!');
    }
}
