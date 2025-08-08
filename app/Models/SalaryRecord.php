<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryRecord extends Model
{
    use HasFactory;
    public function financial(){
        return $this->belongsTo(Financial::class);
    }

    public function admin(){
        $admin_id = $this->action_taken;
        $admin = User::find($admin_id);
        return $admin;
    }
}
