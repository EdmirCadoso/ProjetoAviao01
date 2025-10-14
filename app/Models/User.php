<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //atributes that are hidden for serialization



    public function aviaos(){
        return $this->hasMany(Aviao::class);
    }
}
