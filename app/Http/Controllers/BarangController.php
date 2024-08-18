<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\Barang_harga;
use App\Models\Unit;

class BarangController extends Controller{
    public function index(){
        $products = Barang::with('unit')->orderBy('name', 'desc')->get();
        $mappedProducts = $products->map(function($product){
            return (object) ([
                'id' => $product->id,
                'code' => $product->code_product,
                'name' => $product->name,
                'weight' => $product->weight,
                'price' => $product->def_price,
                'unitId' => $product->id_unit,
                'unit' => $product->unit->name,
            ]);
        });
        $unit = Unit::all();
        return view('barang/barang', ['products' => $mappedProducts, 'unit' => $unit]);
    }
    public function tambah(Request $request){
    	$cdprd = DB::table('product_name')->where('code_product', $request->kode)->count();
        if ($cdprd == 0) {
            if ($request->weight=='') {
                $brt=0;
            }else{
                $brt=$request->weight;
            }
            $hrg = preg_replace("/[^0-9]/", "", $request->defprice);
            if ($hrg=='') {
                $dp=0;
            }else{
                $dp=$hrg;
            }
            Barang::create([
	            'code_product' => $request->kode,
	            'name' => $request->nama,
	            'weight' => $brt,
                'def_price' => $dp,
                'id_unit' => $request->unit
	        ]);
        }
        return response()->json(['success'=>true, 'info'=>$cdprd]);
    }
    public function ubah($id_brg, Request $request){
        $hrg = preg_replace("/[^0-9]/", "", $request->iddefprice);
        $brg = Barang::find($id_brg);
        $brg->code_product = $request->ukode;
        $brg->name = $request->unama;
        $brg->weight = $request->idweight;
        $brg->def_price = $hrg;
        $brg->id_unit = $request->uunit;
        $brg->save();
        return redirect('/brg');
    }
    public function saldo(){
        $dataProducts = Barang::with("unit","prices")->get();
        $mappedProducts = $dataProducts->map(function($product){
            return (object) ([
                'id' => $product->id,
                'code' => $product->code_product,
                'name' => $product->name,
                'unit' => $product->unit->name,
                'stock' => $product->prices->pluck('quantity')->sum(),
            ]);
        });
        return view('barang/saldo', ['products' => $mappedProducts]);
    }
    public function persediaan(){
        $inventoryValues = $this->getAllInventoryValue();
        $products = $inventoryValues->map(function($value) {
            return (object) ([
                'id' => $value['id'],
                'id_product' => $value['id_product'],
                'capital' => $value['capital'],
                'selling' => $value['selling'],
                'quantity' => $value['quantity'],
                'code_product' => $value['product']['code_product'],
                'product_name' => $value['product']['name'],
                'weight' => $value['product']['weight'],
                'unit' => $value['product']['unit']['name'],
                'date' => dateformatted($value['created_at']),
                'grandTotal' => $value['capital'] * $value['quantity']
            ]);
        })->sortBy('product_name');
        $totalAsset = (object)([
            "decimalIdr" => convertToIdr($products->pluck('grandTotal')->sum()),
            "terbilang" => idrToStringDesc($products->pluck('grandTotal')->sum())
        ]);
        $totalQuantity = $products->count();
        return view('barang/persediaan', ['products' =>  $products, 'totalAsset' => $totalAsset, 'totalQuantity' => $totalQuantity]);
    }

    private function getAllInventoryValue() {
        $prices = Barang_harga::with('product','product.unit')->get();
        $filteredProducts = $prices->filter(function($products){
            return $products-> quantity > 0;
        });
        return $filteredProducts;
    }

    public function getProductWithPrice(Request $request) {
        $requestName = $request->value;
        $products = Barang::with('prices')->where('name', 'like', '%'.$requestName.'%')->take(8)->get();
        $mapProducts = $products->map(function($product) {
            return (object) ([
                'idProduct' => $product['id'],
                'codeProduct' => $product['code_product'],
                'productName' => $product['name'],
                'quantity' => $product['prices']->where('capital', '>', 0)->pluck('quantity')->sum(),
                'price' => $product['def_price'],
            ]);
        });
        $filterResult = array();
        foreach ($mapProducts as $product) {
            $filterResult[] = $product->codeProduct.' - '.$product->productName.' - '.$product->quantity.' - '.number_format($product->price,0,',','.');
        }
        return response()->json($filterResult);
    }
}
