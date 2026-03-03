<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    protected $fillable = ['client_id','client_service_id','invoice_number','total_amount','issued_date' ,'narration'];

    public static function generateInvoiceNumber()
    {
        return DB::transaction(function () {

            $year = now()->year;

            $lastInvoice = self::lockForUpdate()
                ->whereYear('created_at', $year)
                ->orderBy('id', 'desc')
                ->first();

            $newNumber = $lastInvoice
                ? intval(substr($lastInvoice->invoice_number, -4)) + 1
                : 1;

            return 'INV-' . $year . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        });
    }
    public function clientService()
    {
        return $this->belongsTo(ClientService::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
