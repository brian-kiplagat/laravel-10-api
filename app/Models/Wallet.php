<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Wallet extends Model
{
    use HasApiTokens;
    protected $table = 'wallet';

    protected $fillable = ['id'];
}
