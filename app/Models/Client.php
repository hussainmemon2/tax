<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_type',
        'full_name',
        'business_name',
        'cnic',
        'registration_number',
        'business_address',
        'business_registration_date',
        'sales_tax_number',
        'portal_registration_date',
        'reference',
        'email',
        'phone',
    ];

    protected $casts = [
        'business_registration_date' => 'date',
        'portal_registration_date'   => 'date',
    ];

  

    public function portalCredentials()
    {
        return $this->hasMany(ClientPortalCredential::class);
    }

    public function services()
    {
        return $this->hasMany(ClientService::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function income()
    {
        return $this->hasMany(FinanceIncome::class);
    }

    public function scopeIndividual($query)
    {
        return $query->where('client_type', 'individual');
    }

    public function scopeBusiness($query)
    {
        return $query->where('client_type', 'business');
    }


    public function getDisplayNameAttribute()
    {
        return $this->client_type === 'business'
            ? $this->business_name
            : $this->full_name;
    }
}