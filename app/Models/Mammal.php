<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mammal extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function animal()
    {
        return $this->hasOne(Animal::class, 'mammal_id', 'id');
    }
}
