<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $table = "state";
    // protected $fillable = ['state_name'];
    protected $primaryKey = 'state_id'; // Set primary key column

    // public $incrementing = false; // Use if primary key is not auto-incrementing

    // protected $keyType = 'string'; // Adjust if the primary key is not a string

    protected $fillable = [
        'state_id',
        'state_name',
    ];

    public function city()
    {
        return $this->hasMany(City::class);
    }

   


    
}
