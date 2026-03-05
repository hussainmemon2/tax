<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceExpense extends Model
{
    protected $fillable = ['title','amount','expense_date','category','recorded_by'];

    protected $table = 'finance_expense';
    public function recorder()
    {
        return $this->belongsTo(User::class,'recorded_by');
    }
}