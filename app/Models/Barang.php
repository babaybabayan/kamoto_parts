<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model{
    use HasFactory;
    protected $table = "product_name";
    protected $primaryKey = 'id';
    protected $fillable = ['id','code_product','id_supplier','name','weight','def_price','id_unit','created_at','updated_at'];
    
    public function prices() {
    	return $this->hasMany(Barang_harga::class, 'id_product');
    }

    public function unit() {
        return $this->belongsTo(Unit::class, 'id_unit');
    }
}
