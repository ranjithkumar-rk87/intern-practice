<?php
namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('index', compact('products'));
    }
     public function search(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255'
        ]);

        $products = Product::where('name', 'like', '%'.$request->search.'%')
            ->orWhere('description', 'like', '%'.$request->search.'%')
            ->latest()
            ->get();

        return view('index', compact('products'));
    }

    public function create()
    {
        return view('admin.createproduct');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->image->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath
        ]);

         return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function show($id)
    {
        //$product = Product::findOrFail($id);
        $product = Product::with('questions.user')->findOrFail($id);

        $relatedProducts = Product::where('category_name', $product->category_name)
                              ->where('id', '!=', $product->id)
                              ->take(4)
                              ->get();
        #return view('user.show', compact('product'));
        return view('user.show', compact('product', 'relatedProducts'));
    }
     public function productList()
    {
        $products = Product::latest()->get();
        return view('admin.productlist', compact('products'));
    }
     public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.editproduct', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock' => $request->stock,
            'image'       => $product->image,
        ]);

        return redirect()->route('admin.products.list')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully');
    }
    public function storeReview(Request $request, $productId)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string|max:1000',
    ]);

    $product = Product::findOrFail($productId);

    $product->reviews()->updateOrCreate(
        ['user_id' => auth()->id()],
        ['rating' => $request->rating, 'review' => $request->review]
    );

    return back()->with('success', 'Your review has been submitted.');
}


    
}
