<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Traits\UploadTrait;

class ProductController extends Controller
{
    use UploadTrait;

    private $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = auth()->user();

        if (!$user->store()->exists()){
            flash('Você não possui uma loja')->warning();
            return redirect()->route('admin.stores.index');
        }

        $products = $user->store->products()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Category::all(['id', 'name']);
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $store = auth()->user()->store;

        $data['price'] = formatPriceToDatabase($data['price']);

        $product = $store->products()->create($data);

        if(!empty($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }

        if($request->hasFile('photos')){
            $images = $this->imageUpload($request->file('photos'), 'image');
            $product->photos()->createMany($images);
        }

        //flash('Produto criado com sucesso')->success();
        toastr()->success('Produto criado com sucesso.', 'Sucesso', ['toastClass' => 'toastr', 'timeOut' => 3000, 'positionClass' => 'toast-top-full-width', 'opacity' => 5]);
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        $product = $this->product->find($product);

        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        $product = $this->product->findOrFail($product);
        $product->price = formatPriceToFront($product->price);

        $categories = \App\Category::all(['id', 'name']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $product)
    {
        $data = $request->all();

        $product = $this->product->find($product);
        $data['price'] = formatPriceToDatabase($data['price']);

        $product->update($data);
        if(empty($data['categories'])){
            $product->categories()->detach();
        }else{
            $product->categories()->sync($data['categories']);
        }

        if($request->hasFile('photos')){
            $images = $this->imageUpload($request->file('photos'), 'image');
            $product->photos()->createMany($images);
        }

        flash('Produto alterado com sucesso')->success();
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        $product = $this->product->find($product);
        $product->categories()->detach();
        $product->delete();

        flash('Produto Removido com sucesso')->success();
        return redirect()->route('admin.products.index');
    }
}
