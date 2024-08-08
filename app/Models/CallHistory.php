<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallHistory extends Model
{
    use HasFactory;

    protected $table = 'call_history';
 
    protected $fillable = [
        'customer_name',
        'phone',
        'call_type',
        'call_duration',
        'call_date',
        'employee_id',
    ];


    // Assuming there's a belongsTo relationship with the Employee model
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');


    }
}
