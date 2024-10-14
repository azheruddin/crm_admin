<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = "employees";
 protected $fillable = ['name', 'email', 'phone', 'password', 'type','is_login'];



 public function reviews()
 {
     return $this->hasMany(Review::class);
 }



 public function leads()
 {
     return $this->hasMany(Leads::class, 'employee_id'); // Adjust 'employee_id' if your foreign key is named differently
 }



 public function calls()
 {
     return $this->hasMany(CallHistory::class);
 }
}



