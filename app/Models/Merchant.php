<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Merchant extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * @return mixed
     */
    public static function isMerchantAdmin()
    {
        return auth()->user()->is_admin;
    }

    public function user()
    {
        return $this->belongsTo(User::class,'id');
    }
}
