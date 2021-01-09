<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();

        if (request()->routeIs('transactions')) {
            $cart = \Cookie::get('cart') !== null ? \Cookie::get('cart') : [];
            $total = 0;
            if (! empty($cart)) {
                foreach (json_decode($cart) as $value) {
                    $total += $value[4];
                }
            }
            return view('products.transactions', compact('products', 'cart', 'total'));
        }

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
        $validated = $request->validate([
            'name' => 'required|unique:products|max:48',
            'img' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'price' => 'required',
        ]);

        $validated['price'] = $this->clearRupiah($validated['price']);
        $validated['img'] = $this->upload($validated['img'], 'products');

        Product::create($validated);

        return redirect()->route('products.index')->with('message', 'Berhasil menambahkan menu '.$validated['name']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function saveCart(Request $request)
    {
        $validated = $request->validate([
            'cart' => 'required',
        ]);

        return redirect()->route('transactions')->withCookie(cookie()->forever('cart', $validated['cart'], 450000));
    }

    private function clearRupiah($price)
    {
        $price = preg_replace('/[Rp. ]/', '', $price); // menghilangkan simbol Rp dan '.'
        $price = preg_replace('/,/', '.', $price); // mengganti ',' dengan '.'

        return $price;
    }
}
