<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $fillable = [
    'customer_id',
    'user_id'
  ];

  
  
  public function items(){
    return $this->hasMany(OrderItem::class);
  }

  public function customer(){
    return $this->belongsTo(Customer::class);
  }

  public function getCustomerName(){
    if($this->customer){
      return $this->customer->name;
    }

    return __('customer.working');
  }

  public function user(){
    return $this->belongsTo(User::class);
  }

  public function getUserName(){
    return $this->user->name;
  }

  public function total(){
    return $this->items->map(function($i){
      return $i -> price;
    })->sum();
  }

  public function formattedTotal(){
    return number_format($this->total(),2);
  }
}
