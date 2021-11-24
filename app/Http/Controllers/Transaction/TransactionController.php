<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{




    public function getAllTransactions()
    {
        $transactions = Transaction::all();
        //$buyers = Buyer::has('transactions')->get();
        if($transactions){
            return $this->showAll($transactions);
        }else{
            return $this->errorResponse('No existe Ventas',400);
        }
    }

      /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOneTransaction($id)
    {
        $match =['_id' =>$id];
        $transaction = Transaction::where($match)->get()->first();
        //$buyers = Buyer::has('transactions')->get();
        if($transaction){
            return $this->showOne($transaction);
        }else{
            return $this->errorResponse('No existe venta',400);
        }
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setTransaction()
    {
        //
    }
}
