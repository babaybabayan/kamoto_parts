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
                        <td style='text-align:center; vertical-align:middle'><a href="javascript:void(0)"
                                class="btn btn-info btn-xs" id="btn-detail" data-toggle="modal"
                                data-id="{{ $product->id_product }}">{{ $product->code_product }}</a>
                        </td>
                        <td><a href="#" data-toggle="modal">{{ $product->product_name }}</a>
                        </td>
                        <td style="text-align: center"><a href="#" data-toggle="modal">{{ $product->unit }}</a></td>
                        <td style="text-align: center">
                            <a href="#" data-toggle="modal">{{ $product->quantity }}</a>
                        </td>
                        <td style="text-align: center;">
                            <a href="#" data-toggle="modal">{{ $product->date }}</a>
                        </td>
                        <td style="text-align: center;"><a href="#" data-toggle="modal">{{ $product->weight }}</a>
                        </td>
                        <td style="text-align: right;">{{ $product->capital }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body" style="text-align: center">
                        <a href="" id="pembelian" class="btn btn-primary">PEMBELIAN</a><br />
                        <a href="" id="penjualan" class="btn btn-primary">PENJUALAN</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('body').on('click', '#btn-detail', function() {
            let post_id = $(this).data('id');
            $('#modal-detail').modal('show');
            $("#pembelian").attr("href", `/hst/brgpmb/${post_id}`);
            $("#penjualan").attr("href", `/hst/brgpnj/${post_id}`);
        });
    </script>
@endpush
