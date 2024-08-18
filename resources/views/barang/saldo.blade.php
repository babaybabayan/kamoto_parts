@extends('template.index')

@section('content')
    <link href="{{ url('kamotoparts/kamotoparts.css') }}" rel="stylesheet">
    <div class="row">
        <h3>Saldo Stok</h3>
    </div>
    <div class="row">
        <table id="dtsld" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center; width: 15%">Kode</th>
                    <th style="text-align: center; width: 30%">Nama</th>
                    <th style="text-align: center; width: 10%">Satuan</th>
                    <th style="text-align: center; width: 10%">Saldo Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td><a href="#" data-toggle="modal"
                                data-target=".hstsld{{ $product->id }}">{{ $product->code }}</a></td>
                        <td><a href="#" data-toggle="modal"
                                data-target=".hstsld{{ $product->id }}">{{ $product->name }}</a></td>
                        <td style="text-align: center"><a href="#" data-toggle="modal"
                                data-target=".hstsld{{ $product->id }}">{{ $product->unit }}</a></td>
                        <td style="text-align: center">
                            <a href="#" data-toggle="modal"
                                data-target=".hstsld{{ $product->id }}">{{ $product->stock }}</a>
                        </td>
                    </tr>
                    <div class="modal fade hstsld{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span
                                            aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body" style="text-align: center">
                                    <a href="/hst/brgpmb/{{ $product->id }}" class="btn btn-primary">PEMBELIAN</a><br />
                                    <a href="/hst/brgpnj/{{ $product->id }}" class="btn btn-primary">PENJUALAN</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
