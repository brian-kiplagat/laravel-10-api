<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponser;

    public function __construct(Request $request)
    {

        $this->request = $request;

    }

    public function register(Request $request)
    {

        $params = json_decode($request->getContent());
        if (empty($params->email)) {
            return $this->errorResponse('Email cannot be empty', 400, false);
        }
        if (empty($params->password)) {
            return $this->errorResponse('Password cannot be empty', 400, false);
        }
        //dd($params);
        $fetch = Wallet::query()->where('email', $params->email)->first();
        if (!is_null($fetch)) {
            return $this->errorResponse('This account already exists. Please Register a different Email', 400, false);

        }


        return $this->successResponse('You have successfully registered to the platform', 200, true);
    }

    public function login(Request $request)
    {
        return $this->successResponse('Ok sucess', 200, true);
    }

}
