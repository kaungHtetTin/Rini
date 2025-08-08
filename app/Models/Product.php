<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function product_category(){
        return $this->belongsTo(ProductCategory::class);
    }

    public function product_images(){
        return $this->hasMany(ProductImage::class);
    }

    public function admin(){
        $admin_id = $this->action_taken;
        $admin = User::find($admin_id);
        return $admin;
    }
}
