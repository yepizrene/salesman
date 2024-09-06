<?php

namespace App\Models;

use Attribute;
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

  protected $appends = [
    'total',
    'formattedTotal',
    'customerName',
    'user',
    'items'
  ];

  protected $casts = [
    'status' => 'boolean'
  ];

  public function getItemsAttribute(){
    return $this->items()->get();
  }
  public function items()
  {
    return $this->hasMany(OrderItem::class);
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function getCustomerNameAttribute()
  {
    if ($this->customer) {
      return $this->customer->name;
    }

    return 'General customer';
  }

  public function getUserAttribute(){
    return $this->user()->first();
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function getTotalAttribute()
  {
    return $this->items->map(function ($i) {
      return $i->price;
    })->sum();
  }

  public function getFormattedTotalAttribute()
  {
    return number_format($this->getTotalAttribute(), 2);
  }
}
