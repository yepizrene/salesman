<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $fillable = [
    'price',
    'quantity',
    'product_id',
    'order_id'
  ];

  public function product(){
    return $this->belongsTo(Product::class);
  }
}
