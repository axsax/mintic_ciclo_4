<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Provider;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends ApiController
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function allProducts()
   {
       $match = ['branch' => Auth::user()->branch];
       $products = Product::where($match)->get();
       //$buyers = Buyer::has('transactions')->get();
       if(!$products->isEmpty() && $products){
           return $this->showAll($products);
       }else{
           return $this->errorResponse('No existe productos',400);
       }
   }
   public function getOneProduct($product){
    $match = ['branch' => Auth::user()->branch, '_id' => $product];
    $product = Product::where($match)->get();
    //$buyers = Buyer::has('transactions')->get();
    if(!$product->isEmpty() && $product){
        return $this->showAll($product);
    }else{
        return $this->errorResponse('No existe producto',400);
    }
   }

   public function allProductsByOwnProvider()
   {
       $match =['provider_id' =>Auth::user()->id];
       $products = Product::where($match)->get();

       //$buyers = Buyer::has('transactions')->get();
       if(!$products->isEmpty() && $products){
           return $this->showAll($products);
       }else{
           return $this->errorResponse('No existe los vendedores',400);
       }
   }

   public function allProductsBySpecificProvider($provider)
   {
       $provider=User::find($provider);
       if($provider){
        $match =['provider_id' =>$provider->id];
        $products = Product::where($match)->get();
        //$buyers = Buyer::has('transactions')->get();
        if(!$products->isEmpty() && $products){
            return $this->showAll($products);
        }else{
            return $this->errorResponse('No existe los productos',400);
        }
       }else{
        return $this->errorResponse('No existe proveedor',400);
    }
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setProduct(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'description'    => 'required|string',
            'iva' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'quantity' => 'required|integer',
            'status' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

            $product = new Product([
                'name'     => $request->name,
                'description'    => $request->description,
                'iva' => $request->iva,
                'quantity'    => $request->quantity,
                'status'=> $request->status,
                'price'=> $request->price,
                'provider_id' => Auth::user()->id ,
                'branch' => Auth::user()->branch ,
            ]);
            try {
                $product->save();
                return $this->perfectResponse('Producto creado existosamente!', 201);
            } catch (Exception $e) {
                return $this->errorResponse('No se puede crear el producto' . $e, 500);
            }
    }

    public function updateProduct(Request $request, $product)
    {
        $product = Product::find($product);
        if($product->provider_id != Auth::user()->id){
            return $this->errorResponse('No se puede actualizar, no es dueño del producto', 500);
        }else{
            $request->validate([
                'name'     => 'string',
                'description'    => 'string',
                'iva' => 'regex:/^\d+(\.\d{1,2})?$/',
                'quantity' => 'integer',
                'status' => 'string',
                'price' => 'regex:/^\d+(\.\d{1,2})?$/',
            ]);
            if ($request->has('name')) {
                $product->name = $request->name;
            }
            if ($request->has('description')) {
                $product->description = $request->description;
            }
            if ($request->has('iva')) {
                $product->iva = $request->iva;
            }
            if ($request->has('quantity')) {
                $product->quantity = $request->quantity;
            }
            if ($request->has('status')) {
                $product->status = $request->status;
            }
            if ($request->has('price')) {
                $product->price = $request->price;
            }
            if (!$product->isDirty()) {
                return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 304);
            }
            try {
                $product->update();
                return $this->perfectResponse('Producto Actualizado', 201);
            } catch (Exception $e) {
                return $this->errorResponse('Error guardando los datos', 500);
            }
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $id)
    {
        $id->delete();
        return $this->perfectResponse('Producto eliminado existosamente!', 200);
    }
}
