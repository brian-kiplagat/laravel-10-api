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
        //check email
        if (!filter_var($params->email, FILTER_VALIDATE_EMAIL)) {
            return $this->errorResponse('Please provide a valid email', 400, false);
        }
        //check password
        $check = $this->checkPassword($params->password);
        if (!$check['valid']) {
            return $this->errorResponse($check['reason'], 400, false);
        }
        //hash password
        //there should be a backup of this incase the env file is missing this value
        $getSecret = empty(env('APP_KEY')) ? 'base64:UaY73KVgGOa99uFjacq29YLXZBqFGBund7YLahdDA5A=' : env('APP_KEY');
        $passwordHash = hash("sha256", trim($params->password) . $getSecret);

        //save the details
        $store = [
            'email' => trim($params->email),
            'password' => $passwordHash,
            'wallet_id'=> md5(uniqid())


        ];
        Wallet::insert($store);


        return $this->successResponse('You have successfully registered to the platform', 200, true);
    }

    public function login(Request $request)
    {
        return $this->successResponse('Ok sucess', 200, true);
    }

    public function checkPassword($password): array
    {
        if (strlen($password) < 6) {
            return ['valid' => false, 'reason' => 'Your Password must be at least 6 characters long'];

        } elseif (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{6,16}$/m', $password) == 0) {
            return ['valid' => false, 'reason' => 'Your password should be at least 6 characters long with one uppercase letter,one lowercase letter,one special character, and one numeral'];
        } else {
            return ['valid' => true, 'reason' => 'Password ok'];

        }

    }

}
