<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['total', 'discount', 'vat', 'payable', 'user_id', 'customer_id'];

    function customer(){
        return $this->belongsTo(Customer::class);
    }
}
