<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends ApiController
{




    public function getAllTransactions()
    {
        $match = ['branch'=>Auth::user()->branch];
        $transactions = Transaction::where($match)->get();
        //$buyers = Buyer::has('transactions')->get();
        if($transactions){
            return $this->showAll($transactions);
        }else{
            return $this->errorResponse('No existe Ventas',400);
        }
    }
    public function getAllTransactionsOfAllBranches()
    {
        $transactions = Transaction::get();
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
         {
        "cabecera":{
            "iva":"19",
            "total_price":"20000",
            "buyer_id":"619d5689100c000042002174"
        },
        "detalle":[{
            "quantity":"2",
            "product_id":"619d90f1dc180000ba00145b"
        },{
            "quantity":"3",
            "product_id":"619da72fdc180000ba001461"
        }]
    }
     * @return \Illuminate\Http\Response
     */
    public function setTransaction(Request $request)
    {
        $cabecera =$request->cabecera;
        $detalle = $request->detalle;


        //validaciones
        $buyer=User::find($cabecera['buyer_id']);
        if($buyer){
            for($i=0; $i<count($detalle);$i++){
                $product =Product::find($detalle[$i]['product_id']);
                if(!$product){
                    return $this->errorResponse('El producto no existe', 500);
                }
            }
        }else{
            return $this->errorResponse('El comprador no existe', 500);
        }


        $transaction = new Transaction([
            'iva'     => $cabecera['iva'],
            'total_price'    => $cabecera['total_price'],
            'buyer_id' => $cabecera['buyer_id'],
            'seller_id'    =>Auth::user()->id,
            'branch'    =>Auth::user()->branch,
        ]);
        try {
            $transaction->save();
        } catch (Exception $e) {
            return $this->errorResponse('No se puede crear la transaccion' . $e, 500);
        }
        $transaction_id = $transaction->_id;

        for($i=0; $i<count($detalle);$i++){
            $detail_transactions= new DetailTransaction([
                'quantity'     => $detalle[$i]['quantity'],
                'product_id'    => $detalle[$i]['product_id'],
                'transaction_id' => $transaction_id,
            ]);
            try {
                $detail_transactions->save();
            } catch (Exception $e) {
                return $this->errorResponse('No se puede crear el detalle de la  transaccion' . $e, 500);
            }
        }

        return $this->perfectResponse('Transaccion creada existosamente!', 201);

    }

    public function destroy(Transaction $id)
    {
        $id->delete();
        return $this->perfectResponse('Transaccion eliminada existosamente!', 200);
    }
}
