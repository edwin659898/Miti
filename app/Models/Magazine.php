<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    use HasFactory;
    use \Shetabit\Visitor\Traits\Visitable;

    protected $fillable = ['item_code', 'issue_no', 'title', 'slug', 'file', 'image', 'inventory', 'quantity', 'created_at', 'type'];
}
