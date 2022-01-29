<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingInv extends Model{
    use HasFactory;
    protected $table = "setting_inv";
    protected $primaryKey = 'id';
    protected $fillable = ['id','bank_name','account_no','name','created_at','updated_at'];
}