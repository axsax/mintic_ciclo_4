<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $match =['role' =>'3'];
        $providers = User::where($match)->get();
        //$buyers = Buyer::has('transactions')->get();
        if($providers){
            return $this->showAll($providers);
        }else{
            return $this->errorResponse('No existe proveedores',400);
        }
    }

      /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $match =['_id' =>$id, 'role' =>'3'];
        $provider = User::where($match)->get()->first();
        //$buyers = Buyer::has('transactions')->get();
        if($provider){
            return $this->showOne($provider);
        }else{
            return $this->errorResponse('No existe el proveedor',400);
        }
    }
}
