<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasesPayment extends Model{
    use HasFactory;
    protected $table = "purchases_payment";
    protected $primaryKey = 'id';
    protected $fillable = ['id','due_date','invoice','id_supplier','id_status','total_payment','created_at','updated_at'];
}
