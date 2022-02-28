@extends('template.index')

@section('content')
    <link href="{{ url('kamotoparts/kamotoparts.css') }}" rel="stylesheet">
    <div class="row">
        <h3>Nilai Persediaan</h3>
    </div>
    <div class="row">
        <div class="row top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"></div>
                    <div class="count">{{ $totalQuantity }}</div>
                    <h3>Total Product</h3>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"></div>
                    <div class="count">Rp. {{ $totalAsset->decimalIdr }}</div>
                    <div class="col-xs-12">{{ ucwords($totalAsset->terbilang) }} Rupiah</div>
                    <h3>Nilai Asset</h3>
                </div>
            </div>
        </div>
        <table id="dtpsd" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center; width: 10%">Kode</th>
                    <th style="text-align: center; width: 30%">Nama</th>
                    <th style="text-align: center; width: 10%">Satuan</th>
                    <th style="text-align: center; width: 10%">Stok</th>
                    <th style="text-align: center; width: 10%">Tanggal</th>
                    <th style="text-align: center; width: 10%">Berat (gr)</th>
                    <th style="text-align: center; width: 10%">Harga Beli</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($products as $product)
                    <tr>
                        <td><a href="#" data-toggle="modal"
                                data-target=".hstpsd{{ $product->id }}">{{ $product->code_product }}</a></td>
                        <td><a href="#" data-toggle="modal"
                                data-target=".hstpsd{{ $product->id }}">{{ $product->product_name }}</a>
                        </td>
                        <td style="text-align: center"><a href="#" data-toggle="modal"
                                data-target=".hstpsd{{ $product->id }}">{{ $product->unit }}</a></td>
                        <td style="text-align: center">
                            <a href="#" data-toggle="modal"
                                data-target=".hstpsd{{ $product->id }}">{{ $product->quantity }}</a>
                        </td>
                        <td style="text-align: center;">
                            <a href="#" data-toggle="modal"
                                data-target=".hstpsd{{ $product->id }}">{{ $product->date }}</a>
                        </td>
                        <td style="text-align: center;"><a href="#" data-toggle="modal"
                                data-target=".hstpsd{{ $product->id }}">{{ $product->weight }}</a></td>
                        <td style="text-align: right;">{{ $product->capital }}</td>
                    </tr>
                    <div class="modal fade hstpsd{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span
                                            aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body" style="text-align: center">
                                    <a href="/hst/brgpmb/{{ $product->id_product }}"
                                        class="btn btn-primary">PEMBELIAN</a><br />
                                    <a href="/hst/brgpnj/{{ $product->id_product }}"
                                        class="btn btn-primary">PENJUALAN</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
