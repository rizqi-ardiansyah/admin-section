<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\Transaction;

class Customer extends Model {
    use HasFactory;

    public $connection = 'mysql2';
    protected $table = 'customer';
    protected $primaryKey = 'cust_id';
    protected $fillable = [
        'cust_id',
        'address',
        'photos',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo(Users::class);
    }

    // public function transaction(){
    //     return $this->hasMany(Transaction::class);
    // }
}
