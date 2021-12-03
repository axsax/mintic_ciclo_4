<?php

namespace App\Http\Controllers\DetailTransaction;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailTransactionController extends ApiController
{
    public function getDetailOfTransaction($id)
    {
        // $match =['_id' =>$id, 'role' =>'3'];
        // $provider = User::where($match)->get()->first();

        $transaction=Transaction::find($id);

        if(!$transaction){
            return $this->errorResponse('No existe la transaccion',400);
        }else{

            $detail_transactions = DB::table('detail_transactions')
            ->join('products', 'products._id', '=', 'detail_transactions.product_id')
            ->where('detail_transactions.transaction_id',$id)
            ->get();
            //Transaction::select("products.name","detail_transactions.quantity")->join("transactions","detail_transactions.transaction_id","=","transactions.id")->join("products","products.id","=","detail_transactions.product_id")->get();

            dd($detail_transactions);
            //$buyers = Buyer::has('transactions')->get();
            if($detail_transactions){
                return $this->showAll($detail_transactions);
            }else{
                return $this->errorResponse('No existe Detalle para esta transaccions',400);
            }

        }
    }
}
