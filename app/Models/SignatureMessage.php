<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignatureMessage extends Model
{
    use HasFactory;

    protected $table = "signature_message";


    protected $fillable = ['message', 'employee_id']; 

    
    protected $hidden = ['created_at', 'updated_at'];


}
