<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead_review extends Model
{
    use HasFactory;


    protected $table = "lead_review";
    
    protected $fillable = ['lead_id', 'employee_id', 'review_text', 'call_date']; 



    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leads()
    {
        return $this->belongsTo(Leads::class);
    }

}
