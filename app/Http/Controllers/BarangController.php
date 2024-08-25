<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Barang_harga;
use App\Models\Unit;

class BarangController extends Controller{
    public function index(){
        $products = Barang::with('unit')->orderBy('name', 'asc')->get();
        $mappedProducts = $products->map(function($product) {
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
    public function getProductById($id) {
        $products = Barang::with('unit')->findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $products
        ]);
    }

    public function tambah(Request $request){
        $productExist = Barang::where('code_product', $request->kode)->exists();
        if (!$productExist) {
            $weight = $request->weigh ?? 0;
            $price = preg_replace("/[^0-9]/", "", $request->defprice) ?? 0;
            Barang::create([
	            'code_product' => $request->kode,
	            'name' => $request->nama,
	            'weight' => $weight,
                'def_price' => $price,
                'id_unit' => $request->unit
	        ]);
        }
        return response()->json(['success'=>true, 'info'=>$productExist]);
    }
    public function ubah($id_brg, Request $request){
        $hrg = preg_replace("/[^0-9]/", "", $request["product-price"]);
        $products = Barang::find($id_brg);
        $products->code_product = $request["product-code"];
        $products->name = $request["product-name"];
        $products->weight = $request["product-weight"] ?? 0;
        $products->def_price = $hrg;
        $products->id_unit = $request["product-unit"];
        $products->save();
        return redirect('/brg');
    }
    public function saldo(){
        $dataProducts = Barang::with("unit","prices")->orderBy('name', 'asc')->get();
        $mappedProducts = $dataProducts->map(function($product){
            return (object) ([
                'id' => $product->id,
                'code' => $product->code_product,
                'name' => $product->name,
                'unit' => $product->unit->name,
                'stock' => $product->prices->pluck('quantity')->sum(),
            ]);
        })->where('stock', '>', 0);
        return view('barang/saldo', ['products' => $mappedProducts]);
    }
    public function persediaan(){
        $inventoryValues = $this->getAllInventoryValue();
        $products = $inventoryValues->map(function($value) {
            return (object) ([
                'id' => $value['id'] ?? "",
                'id_product' => $value['id_product'] ?? "",
                'capital' => $value['capital'] ?? "",
                'selling' => $value['selling'] ?? "",
                'quantity' => $value['quantity'] ?? "",
                'code_product' => $value['product']['code_product'] ?? "",
                'product_name' => $value['product']['name']  ?? "",
                'weight' => $value['product']['weight']  ?? "",
                'unit' => $value['product']['unit']['name'] ?? "" ,
                'date' => dateformatted($value['created_at']) ?? "",
                'grandTotal' => ($value['capital'] * $value['quantity']) ?? ""
            ]);
        })->sortBy('product_name');
        $totalAsset = (object) ([
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
        $filterResult = [];
        foreach ($mapProducts as $product) {
            $filterResult[] = $product->codeProduct.' - '.$product->productName.' - '.$product->quantity.' - '.number_format($product->price,0,',','.');
        }
        return response()->json($filterResult);
    }
}
