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

  protected $appends = [
    'product',
    'formattedPrice',
  ];

  public function getProductAttribute(){
    return $this->product()->first();
  }

  public function product(){
    return $this->belongsTo(Product::class);
  }

  public function getFormattedPriceAttribute()
  {
    return number_format($this->price, 2);
  }

}
