<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'fullname', 'address', 'phone', 'note', 'email', 'product', 'method_pay', 'code_bill', 'progress', 'total', 'amount', 'user_id'
    ];
}
