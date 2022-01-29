<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model{
    use HasFactory;
    protected $table = "customer";
    protected $primaryKey = 'id';
    protected $fillable = ['id','code_customer','name','address','city','telp','created_at','updated_at'];
}
