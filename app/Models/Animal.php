<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'age',
        'mammal_id',
        'breed_id',
        'description',
        'status_id',
        'htprice',
        'photo_number'
    ];

    public function breed()
    {
        return $this->belongsTo(Breed::class, 'breed_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function mammal()
    {
        return $this->belongsTo(Mammal::class, 'mammal_id', 'id');
    }
}
