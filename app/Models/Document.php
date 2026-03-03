<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['client_id','client_service_id','file_name','file_path','file_size','mime_type','uploaded_by','documentdate'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function clientService()
    {
        return $this->belongsTo(ClientService::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class,'uploaded_by');
    }
}
