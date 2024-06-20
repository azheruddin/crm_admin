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


    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


    // {
    //     use SoftDeletes;
    
    //     // Other model properties and methods
    // }






}
