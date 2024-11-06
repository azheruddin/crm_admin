<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $table = "business";
    protected $fillable = ['business_type' , 'admin_id'];

    protected $hidden = ['created_at', 'updated_at'];


}
