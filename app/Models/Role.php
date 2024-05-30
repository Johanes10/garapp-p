<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function companies(){
        return $this->hasMany(Company::class);
    }
    public function delivery_mens(){
        return $this->hasMany(DeliveryMen::class);
    }
    public function users(){
        return $this->hasMany(User::class);
    }

    public function super_users(){
        return $this->belongsToMany(SuperUser::class);
    }
    
}
