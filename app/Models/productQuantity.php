<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productQuantity extends Model
{
    use HasFactory;

    protected $table = "product_quantitiy";
    protected $primaryKey = "id";
    protected $fillable = ['qty', 'sku_product'];
}
