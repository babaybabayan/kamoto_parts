<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model{
    use HasFactory;
    protected $table = "product_name";
    protected $primaryKey = 'id';
    protected $fillable = ['id','code_product','id_supplier','name','weight','def_price','id_unit','created_at','updated_at'];
    public function barang_harga(){
    	return $this->hasMany('App\Models\Barang_harga','id');
    }

    public function unit() {
        return $this->belongsTo(Unit::class, 'id_unit');
    }
}
