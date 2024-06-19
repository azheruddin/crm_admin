<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;
    protected $table = "leads";
    protected $fillable = ['customer_name', 'customer_email', 'phone', 'lead_stage'];


    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


}
