<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $table = "state";
    protected $fillable = ['state_name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'state_id');
    }


    
}
