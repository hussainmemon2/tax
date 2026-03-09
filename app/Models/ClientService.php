<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientService extends Model
{
    protected $fillable = ['client_id','service_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }



    // Outstanding helper
    public function getOutstandingAttribute()
    {
        $totalInvoices = $this->invoices()->sum('total_amount');
        $totalPayments = $this->payments()->sum('amount');
        return $totalInvoices - $totalPayments;
    }
}
