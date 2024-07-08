<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Leads extends Model


{
    use HasFactory; 

    

    protected $table = "leads";
    
    protected $fillable = ['customer_name', 'customer_email', 'phone', 'state','city']; 

    


    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }


    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

         
    
}


