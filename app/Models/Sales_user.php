<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_user extends Model{
    use HasFactory;
    protected $table = "sales_user";
    protected $primaryKey = 'id';
    protected $fillable = ['id','code_sales','name','address','city','telp','created_at','updated_at'];
}
