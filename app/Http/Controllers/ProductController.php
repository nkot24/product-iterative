<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        $products = Product::with('tags')->get(); // eager load tags
        return view('products.index', compact('products'));
    }

    // Form to create a new product
    public function create()
    {
        $tags = Tag::all();
        return view('products.create', compact('tags'));
    }

    // Store a new product
   public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'expiration_date' => 'required|date',
            'status' => 'required|in:available,unavailable',
            'tags' => 'array',
        ]);

        $product = Product::create($data);

        // attach selected or newly created tags
        if (!empty($request->tags)) {
            $product->tags()->sync($request->tags);
        }

        return redirect()->route('products.index')
            ->with('success', 'Produkts veiksmīgi izveidots!');
    }


    // Show single product
    public function show(Product $product)
    {
        $product->load('tags'); // eager load tags
        return view('products.show', compact('product'));
    }

    // Form to edit product
    public function edit(Product $product)
    {
        $tags = Tag::all();
        $product->load('tags');
        return view('products.edit', compact('product', 'tags'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'expiration_date' => 'required|date',
            'status' => 'required|in:available,unavailable',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $product->update($request->all());

        // Sync tags
        $product->tags()->sync($request->tags ?? []);

        return redirect()->route('products.index')->with('success', 'Produkts veiksmīgi atjaunināts!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produkts veiksmīgi dzēsts!');
    }

    // Increase quantity via AJAX
    public function increase(Product $product)
    {
        $product->increaseQuantity();

        return response()->json([
            'quantity' => $product->quantity,
            'message' => 'Produkts palielināts par 1 vienību.'
        ]);
    }

    // Decrease quantity via AJAX
    public function decrease(Product $product)
    {
        $product->decreaseQuantity();

        return response()->json([
            'quantity' => $product->quantity,
            'message' => 'Produkts samazināts par 1 vienību.'
        ]);
    }

    // Add tag via AJAX
   public function addTag(Request $request, Product $product = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create or find tag
        $tag = Tag::firstOrCreate(['name' => $request->name]);

        // If product exists (show/edit page), attach it
        if ($product) {
            $product->tags()->syncWithoutDetaching([$tag->id]);
        }

        return response()->json([
            'tag' => $tag,
            'message' => 'Birka saglabāta!'
        ]);
    }




}
