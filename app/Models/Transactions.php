<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    public $timestamps = true;

    protected $fillable = [
        'amount',
        'status',
        'payment_id',
        'order_id',
        'user_id',
    ];
}
