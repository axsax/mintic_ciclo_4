<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

class AuthController extends ApiController
{
    public function signupAdmin(Request $request)
    {
        //role
        //0 -> admin
        //1 -> Buyer
        //2 -> Seller
        //3 -> Provider
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        $user = new User([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'phone'    => '',
            'address'=> '',
            'city'=> '',
            'role' => '0',
            'admin'=> User::user_not_admin,
        ]);

        try {
            $user->save();
            return $this->perfectResponse('Admin creado existosamente!', 201);
        } catch (Exception $e) {
            return $this->errorResponse('No se puede crear el admin' . $e, 500);
        }

    }
    public function signupBuyer(Request $request)
    {
        //role
        //0 -> admin
        //1 -> Buyer
        //2 -> Seller
        //3 -> Provider
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'branch' => 'required|string',
            'identification' => 'required',
        ]);
        $user = new User([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'identification' => $request->identification,
            'phone'    =>$request->phone,
            'address'=>$request->address,
            'city'=>$request->city,
            'role' => '1',
            'admin'=> User::user_not_admin,
        ]);

        try {
            $user->save();
            return $this->perfectResponse('Comprador creado existosamente!', 201);
        } catch (Exception $e) {
            return $this->errorResponse('No se puede crear el comprador' . $e, 500);
        }

    }
    public function signupSeller(Request $request)
    {
        //role
        //0 -> admin
        //1 -> Buyer
        //2 -> Seller
        //3 -> Provider
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'branch' => 'required|string',
            'identification' => 'required',
        ]);

        $user = new User([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'branch' => $request->branch,
            'identification' => $request->identification,
            'phone'    =>$request->phone,
            'address'=>$request->address,
            'city'=>$request->city,
            'role' => '2',
            'admin'=> User::user_not_admin,
        ]);

        try {
            $user->save();
            return $this->perfectResponse('Vendedor creado existosamente!', 201);
        } catch (Exception $e) {
            return $this->errorResponse('No se puede crear el Vendedor' . $e, 500);
        }

    }
    public function signupProvider(Request $request)
    {
        //role
        //0 -> admin
        //1 -> Buyer
        //2 -> Seller
        //3 -> Provider
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'branch' => 'required|string',
            'identification' => 'required',
        ]);
        $user = new User([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'branch' => $request->branch,
            'identification' => $request->identification,
            'phone'    =>$request->phone,
            'address'=>$request->address,
            'city'=>$request->city,
            'role' => '3',
            'admin'=> User::user_not_admin,
        ]);

        try {
            $user->save();
            return $this->perfectResponse('Proveedor creado existosamente!', 201);
        } catch (Exception $e) {
            return $this->errorResponse('No se puede crear el Proveedor' . $e, 500);
        }

    }
    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at
            )
                ->toDateTimeString(),
        ]);

    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' =>
            'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
