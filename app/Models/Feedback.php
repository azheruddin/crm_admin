<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Feedback extends Model


{
    use HasFactory; 

    

    protected $table = "feedback";
    
    // protected $fillable = [ 'lead_id', 'expected_revenue', 'notes', 'follow_up_date']; 

    protected $primaryKey = 'id'; // Specify your actual primary key name if different
    
    public function lead()
    {
        return $this->belongsTo(Leads::class, 'lead_id');
    }

   
     
}


