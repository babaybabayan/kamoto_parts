<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class H_sales extends Model{
    use HasFactory;
    protected $table = "h_sales";
    protected $primaryKey = 'id';
    protected $fillable = ['id','id_payment','id_product','quantity','disc','status','created_at','updated_at','price'];
}