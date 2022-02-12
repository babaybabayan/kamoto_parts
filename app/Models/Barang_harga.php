<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang_harga extends Model{
    use HasFactory;
    protected $table = "price";
    protected $primaryKey = 'id';
    protected $foreignKey = 'id_product';
    protected $fillable = ['id','id_product','capital','selling','quantity','created_at','updated_at','id_supplier'];
    public function barang(){
    	return $this->belongsTo('App\Models\Barang','id_product');
    }
}
