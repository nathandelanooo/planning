<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'pengguna'; 
    protected $primaryKey = 'id_pengguna'; 
    public $timestamps = false; 

    protected $fillable = ['username', 'password', 'id_role'];

    public function getAuthPassword() {
        return $this->password;
    }
}