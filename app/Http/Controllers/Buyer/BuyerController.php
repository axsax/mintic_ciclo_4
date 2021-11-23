<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\User;
use Illuminate\Http\Request;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $match =['role' =>'1'];
        $buyers = User::where($match)->get();
        //$buyers = Buyer::has('transactions')->get();
        if($buyers){
            return $this->showAll($buyers);
        }else{
            return $this->errorResponse('No existe compradores',400);
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
        $match =['_id' =>$id, 'role' =>'1'];
        $buyers = User::where($match)->get()->first();
        //$buyers = Buyer::has('transactions')->get();
        if($buyers){
            return $this->showOne($buyers);
        }else{
            return $this->errorResponse('No existe el comprador',400);
        }
    }

}
