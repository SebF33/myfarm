<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['animal_id', 'file_path'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
