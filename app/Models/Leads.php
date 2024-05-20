<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;
    protected $table = 'leads';

    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


}
