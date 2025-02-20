<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mtn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'currency',
        'amount',
        'reference',
        'msisdn_id',
        'status',
        'access_token',
        'refresh_token',
        'token_type',
        'txncd',
        'product',
        'expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
