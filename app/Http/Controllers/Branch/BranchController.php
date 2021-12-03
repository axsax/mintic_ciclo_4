<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends ApiController
{
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
        ]);
        $branch =Branch::create([
            'name' => $request->name
        ]);

        $branch->save();
        return $this->perfectResponse('Sucursal creada existosamente!', 201);
    }
    public function show(Branch $branch){
        return $this->showOne($branch);
    }
}
