<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    protected $fillable = ['name','transaction_date', 'expenses', 'income', 'notes', 'attachment', 'balance'];
}
