<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchases extends Model{
    use HasFactory;
    protected $table = "purchases";
    protected $primaryKey = 'id';
    protected $fillable = ['id','id_payment','id_price','quantity','disc','status','created_at','updated_at'];
}
