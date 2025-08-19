<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function voucher_items(){
        return $this->hasMany(VoucherItem::class);
    }

    public function voucher_attachments(){
        return $this->hasMany(VoucherAttachment::class);
    }

    public function admin(){
        $admin_id = $this->action_taken;
        $admin = User::find($admin_id);
        return $admin;
    }
}
