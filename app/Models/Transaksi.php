<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model{
    use HasFactory;
    protected $table = "payment";
    protected $primaryKey = 'id';
    protected $fillable = ['id','due_date','invoice','id_customer','id_salesuser','id_status','total_payment','created_at','updated_at'];
}
