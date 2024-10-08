<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $fillable = [
    'name',
    'description',
    'price',
    'quantity',
    'status'
  ];

  protected $casts = [
    'status' => 'boolean'
  ];

  public static function getActives(){
    return Product::where(['status' => true])->get();
  }
}
