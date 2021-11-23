<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends ApiController
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $match =['role' =>'2'];
        $sellers = User::where($match)->get();
        //$buyers = Buyer::has('transactions')->get();
        if($sellers){
            return $this->showAll($sellers);
        }else{
            return $this->errorResponse('No existe los vendedores',400);
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
        $match =['_id' =>$id, 'role' =>'2'];
        $seller = User::where($match)->get()->first();
        //$buyers = Buyer::has('transactions')->get();
        if($seller){
            return $this->showOne($seller);
        }else{
            return $this->errorResponse('No existe el vendedor',400);
        }
    }

}
