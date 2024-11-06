<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestedIn extends Model
{
    use HasFactory;


    protected $table = "interested_in";
    protected $fillable = ['interested_type', 'admin_id'];

    public $timestamps = false;  
    protected $hidden = ['created_at', 'updated_at'];


   
}
