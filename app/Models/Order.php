<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
      'customerId',
      'totalPrice',
      'shipName',
      'shipPhone',
      'shipAddress',
      'note',
      'isCheckOut',
      'status'
    ];
}
