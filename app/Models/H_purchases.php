<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class H_purchases extends Model{
    use HasFactory;
    protected $table = "h_purchases";
    protected $primaryKey = 'id';
    protected $fillable = ['id','id_payment','id_price','quantity','price','disc','status','created_at','updated_at'];
}