<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public function vouchers(){
        return $this->hasMany(Voucher::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
