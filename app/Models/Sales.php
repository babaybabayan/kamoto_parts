<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model{
    use HasFactory;
    protected $table = "sales";
    protected $primaryKey = 'id';
    protected $fillable = ['id','id_payment','id_price','quantity','disc','status','created_at','updated_at'];
}
