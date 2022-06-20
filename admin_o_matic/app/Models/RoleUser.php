<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users;

class RoleUser extends Model {
    
    use HasFactory;

    public $connection = 'mysql2';
    protected $table = 'Role';
    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->hasMany(Users::class);
    }
}
