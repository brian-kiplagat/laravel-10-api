<?php

namespace App\Http\Controllers;

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
        return $this->successResponse('Ok sucess',200,true);
    }
    public function login(Request $request)
    {
        return $this->successResponse('Ok sucess',200,true);
    }

}
