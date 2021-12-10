<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $match =['role' =>'3', 'branch'=>Auth::user()->branch];
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
    public function getOne($id)
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
    public function update(Request $request, $user)
    {
        $user = User::find($user);
        // if ((Auth::user()->admin === User::user_not_admin) && (Auth::user()->id != $user->id)) {
        //     return $this->errorResponse('No se puede actualizar, no eres admin', 401);
        // } else {
        //     if (((Auth::user()->admin === ($user->admin))==User::user_admin) && (Auth::user()->id != $user->id)) {
        //         return $this->errorResponse('No se puede actualizar, un administrador no puede actualizar otro administrador', 418);
        //     } else {
                $reglas = [
                    'admin' => 'in:' . User::user_admin . ',' . User::user_not_admin,
                ];
                $this->validate($request, $reglas);

                if ($request->has('admin')) {
                    $user->admin = $request->admin;
                }
                if ($request->has('name')) {
                    $user->name = $request->name;
                }
                if ($request->has('phone')) {
                    $user->phone = $request->phone;
                }
                if ($request->has('address')) {
                    $user->address = $request->address;
                }
                if ($request->has('city')) {
                    $user->city = $request->city;
                }

                if (!$user->isDirty()) {
                    return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 304);
                }

                try {
                    $user->update();
                    return $this->perfectResponse('Proveedor Actualizado', 201);
                } catch (Exception $e) {
                    return $this->errorResponse('Error guardando los datos', 500);
                }
    }
    public function destroy(User $id)
    {
        $id->delete();
        return $this->perfectResponse('Proveedor eliminada existosamente!', 200);
    }
}
