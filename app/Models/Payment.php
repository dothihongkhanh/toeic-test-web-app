<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_user',
        'id_exam',
        'payment_amount',
        'payment_time',
        'vnp_TxnRef',
    ];
}
