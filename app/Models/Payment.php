<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'client_id','client_service_id','amount','payment_method',
        'reference_no','notes','recorded_by','payment_date'
    ];

    public function clientService()
    {
        return $this->belongsTo(ClientService::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function financeIncome()
    {
        return $this->hasOne(FinanceIncome::class);
    }
}
