<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    protected $fillable = ['name','transaction_date', 'expenses', 'income', 'notes', 'attachment'];

    /**
     * Automatically calculate the balance before saving.
     */
    protected static function booted()
    {
        static::creating(function (CashFlow $cashFlow) {
            // Fetch the latest balance from the most recent cash flow
            $lastCashFlow = CashFlow::latest('transaction_date')->first();
            $previousBalance = $lastCashFlow ? $lastCashFlow->balance : 0;

            // Calculate the new balance
            $cashFlow->balance = $previousBalance + ($cashFlow->income ?? 0) - ($cashFlow->expenses ?? 0);
        });

        static::updating(function (CashFlow $cashFlow) {
            // Recalculate balance for updates
            $lastCashFlow = CashFlow::where('id', '!=', $cashFlow->id)
                ->latest('transaction_date')
                ->first();
            $previousBalance = $lastCashFlow ? $lastCashFlow->balance : 0;

            // Calculate the new balance
            $cashFlow->balance = $previousBalance + ($cashFlow->income ?? 0) - ($cashFlow->expenses ?? 0);
        });
    }
}
