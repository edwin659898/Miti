<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MagazineUser extends Pivot
{
    use HasFactory;

    protected $fillable = ['user_id', 'magazine_id'];
}
