<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = "sales";


    protected $fillable = [
        'customer_name',
        'business_name',
        'keys',
        'free',
        'amount',
        'transaction',
        'balance',
        'state',
        'city',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
