<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Mockery\Exception;

class AuthController extends Controller
{
    use ApiResponser;

    public function __construct(Request $request)
    {

        $this->request = $request;

    }

    public function createAccount(Request $request)
    {
        try {


            $params = json_decode($request->getContent());
            if (empty($params->email) || !filter_var($params->email, FILTER_VALIDATE_EMAIL)) {
                return $this->errorResponse('Please provide a valid email', 400, false);
            }

            if (empty($params->password)) {
                return $this->errorResponse('Password cannot be empty', 400, false);
            }
            //dd($params);
            $fetch = Wallet::query()->where('email', $params->email)->first();
            if (!is_null($fetch)) {
                return $this->errorResponse('This account already exists. Please Register a different Email', 400, false);

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
            $username = $this->generateUsername();
            //save the details
            $user = new Wallet();
            $user->email = $params->email;
            $user->password = $passwordHash;
            $user->wallet_id = md5(uniqid());
            $user->username = $username;
            $user->save();
            //Generate token
            $token = $user->createToken(env('APP_KEY'))->plainTextToken;
            //Return Token. Can store this in localstorage and use it to make request in headers
            return $this->successResponse(['username' => $username, 'email' => $params->email, 'token' => $token], 200, true);


        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400, false);
        }
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

    public function checkUsernameExists($username)
    {

        //Check if the username exists
        $verifyUsernameExists = Wallet::query()->where('username', $username)->first();
        if (is_null($verifyUsernameExists)) {

            //here the username does not exist so the function generateUserName() runs only once
            return false;

        } else {

            //here the username exists the function generateUserName() will run more than once till a user not existing is fount
            return true;
        }

    }

    function generateUsername()
    {

        // Define a list of English nouns that can be used as the first part.
        $nouns = ['apple', 'banana', 'cherry', 'dog', 'elephant', 'fish', 'grape', 'horse', 'iguana', 'jellyfish', 'kangaroo', 'lemon', 'apple', 'banana', 'cherry', 'dog', 'elephant', 'fish', 'grape', 'horse', 'iguana', 'jellyfish',
            'kangaroo', 'lemon', 'mango', 'parrot', 'quokka', 'rabbit', 'snake', 'tiger', 'unicorn', 'zebra',
            'ant', 'bear', 'cat', 'deer', 'eagle', 'frog', 'giraffe', 'hedgehog', 'iguana', 'jaguar',
            'koala', 'lion', 'monkey', 'newt', 'octopus', 'panda', 'quail', 'rhinoceros', 'sloth', 'toucan',
            'vulture', 'walrus', 'x-ray fish', 'yak', 'zeppelin'];

        // Choose a random noun as the first part.
        $firstPart = $nouns[rand(0, count($nouns) - 1)];

        // Generate a random 4-letter alphabet string for the second part.
        $secondPart = '';
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        for ($i = 0; $i < 4; $i++) {
            $secondPart .= $alphabet[rand(0, strlen($alphabet) - 1)];
        }

        // Generate a random 3-digit number for the third part.
        $thirdPart = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

        // Combine the three parts to create the final username.
        $finalUsername = ucfirst($firstPart) . ucfirst($secondPart) . $thirdPart;
        //now here check if the username is already generated
        $verifyIfExists = Self::checkUsernameExists($finalUsername);
        //if the username doest not exist then return the
        while (!$verifyIfExists) {

            return $finalUsername;
        }

    }


}
