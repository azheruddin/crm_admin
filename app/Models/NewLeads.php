<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewLeads extends Model
{
    use HasFactory;


    protected $table = "leads";
    public $timestamps = false;
    protected $fillable = [
        'customer_name',
        'customer_name',
        'phone',
    ];
}

