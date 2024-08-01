<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = "city";
    protected $primaryKey = 'city_id';

    protected $fillable = [
        'city_id',
        'city_name',
        'state_id', // Foreign key to State
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'city_id');
    }

}
