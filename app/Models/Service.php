<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public function orders(){
        return $this->belongsToMany(Order::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
