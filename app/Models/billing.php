<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'addresses',
        'apartments',
        'zip_codes',
        'citys',
        'states',
    ];
}
