<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model{
    use HasFactory;
    protected $table = "unit";
    protected $primaryKey = 'id';
    protected $fillable = ['id','name','created_at','updated_at'];
}
