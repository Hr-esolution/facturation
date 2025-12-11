<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('user_id', auth()->id())->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'categorie' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix_unitaire' => 'required|numeric|min:0',
            'taxe' => 'nullable|numeric|min:0|max:100',
            'unite' => 'nullable|string|max:50',
            'reference' => 'nullable|string|max:255',
            'code_barre' => 'nullable|string|max:255',
            'stock' => 'nullable|integer|min:0',
            'actif' => 'boolean',
        ]);

        Product::create(array_merge($request->all(), ['user_id' => auth()->id()]));

        return redirect()->route('products.index')->with('success', 'Produit créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // Authorization: user can only view their own products
        if ($product->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // Authorization: user can only edit their own products
        if ($product->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // Authorization: user can only update their own products
        if ($product->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        
        $request->validate([
            'categorie' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix_unitaire' => 'required|numeric|min:0',
            'taxe' => 'nullable|numeric|min:0|max:100',
            'unite' => 'nullable|string|max:50',
            'reference' => 'nullable|string|max:255',
            'code_barre' => 'nullable|string|max:255',
            'stock' => 'nullable|integer|min:0',
            'actif' => 'boolean',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Authorization: user can only delete their own products
        if ($product->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès.');
    }
}