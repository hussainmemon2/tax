<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class ClientPortalCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'portal_type',
        'username',
        'password_encrypted',
        'pin_encrypted',
        'security_question',
        'security_answer_encrypted',
        'last_verified_at',
        'created_by',
    ];

    protected $casts = [
        'last_verified_at' => 'datetime',
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

   

    public function setPasswordEncryptedAttribute($value)
    {
        $this->attributes['password_encrypted'] = Crypt::encryptString($value);
    }

    public function getPasswordEncryptedAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function setPinEncryptedAttribute($value)
    {
        $this->attributes['pin_encrypted'] = $value
            ? Crypt::encryptString($value)
            : null;
    }

    public function getPinEncryptedAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function setSecurityAnswerEncryptedAttribute($value)
    {
        $this->attributes['security_answer_encrypted'] = $value
            ? Crypt::encryptString($value)
            : null;
    }

    public function getSecurityAnswerEncryptedAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }
}