<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Leads extends Model


{
    use HasFactory; 

    

    protected $table = "leads";
    
    protected $fillable = ['customer_name', 'customer_email', 'phone', 'state','city', 'employee_id']; 

    // protected $primaryKey = 'lead_id'; // Specify your actual primary key name if different


    


    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }


    
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

   
    public function feedback()
{
    return $this->hasOne(Feedback::class, 'lead_id');
}

public function scopeFindByEmployeeId($query, $employeeId)
{
    return $query->where('employee_id', $employeeId);
}
}


