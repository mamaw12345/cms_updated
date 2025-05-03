<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    protected $fillable = ['product_code', 'name', 'description', 'category_id', 'qr_generated'];
    
}
