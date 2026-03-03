<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceIncome extends Model
{
    protected $fillable = ['client_id','client_service_id','payment_id','amount','income_date','category'];
    protected $table = 'finance_income';
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function clientService()
    {
        return $this->belongsTo(ClientService::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}