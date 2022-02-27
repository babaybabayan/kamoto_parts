@extends('template.index')

@section('content')
  <link href="{{url('kamotoparts/kamotoparts.css')}}" rel="stylesheet">
  <div class="row">
    <h3>Nilai Persediaan</h3>
  </div>
	<div class="row">
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
          <th style="text-align: center; width: 10%">Harga Jual</th>
        </tr>
      </thead>
  		<tbody>
        @foreach($brg as $b)
          <tr>
            <td><a href="#" data-toggle="modal" data-target=".hstpsd{{ $b->id }}">{{ $b->code_product }}</a></td>
            <td><a href="#" data-toggle="modal" data-target=".hstpsd{{ $b->id }}">{{ $b->name }}</a></td>
            <td style="text-align: center"><a href="#" data-toggle="modal" data-target=".hstpsd{{ $b->id }}">{{ $b->nameu }}</a></td>
            <td style="text-align: center">
              <a href="#" data-toggle="modal" data-target=".hstpsd{{ $b->id }}">{{ $b->quantity }}</a>
            </td>
            <td style="text-align: center;">
              <a href="#" data-toggle="modal" data-target=".hstpsd{{ $b->id }}">{{ date('d-m-Y', strtotime($b->created_at)) }}</a>
            </td>
            <td style="text-align: center;"><a href="#" data-toggle="modal" data-target=".hstpsd{{ $b->id }}">{{ $b->weight }}</a></td>
            <td style="text-align: right;">{{ $b->capital }}</td>
            <td style="text-align: right;">{{ $b->selling }}</td>
          </tr>
          <div class="modal fade hstpsd{{ $b->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" style="text-align: center">
                  <a href="/hst/brgpmb/{{ $b->idb }}" class="btn btn-primary">PEMBELIAN</a><br/>
                  <a href="/hst/brgpnj/{{ $b->idb }}" class="btn btn-primary">PENJUALAN</a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </tbody>
    </table>
	</div>
@endsection
