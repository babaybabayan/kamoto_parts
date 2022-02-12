@extends('template.index')

@section('content')
  <link href="{{url('kamotoparts/kamotoparts.css')}}" rel="stylesheet">
  <div class="row">
    <h3>Laporan Penjualan</h3>
  </div>
  <form action="/rpt/ppnj" method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="row">
      {{ csrf_field() }}
      <div class="col-md-2">
        <input type="text" class="form-control has-feedback-left" name="tgl1" value="{{$tgl1}}" readonly>
        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
      </div>
      <div class="col-md-2">
        <input type="text" class="form-control has-feedback-left" name="tgl2" value="{{$tgl2}}" readonly>
        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
      </div>
      <!-- <div class="col-md-8" style="text-align: right;">
        <button type="submit" class="btn btn-primary"><span class="fa fa-print"></span></button>
      </div> -->
    </div>
    <br>
    <div class="row">
      <div class="col-md-2">
        <input type="text" class="form-control has-feedback-left" value="{{$sls->code_sales}} - {{$sls->name}}" readonly>
        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span><input type="hidden" name="idsls" value="{{$sls->id}}">
      </div>
    </div>
  </form>
  <br>
	<div class="row">
  	<table id="tblrptpnj" class="table table-striped table-bordered" style="width: 100%">
      <thead>
        <tr>
          <th style="text-align: center; width: 7%">Tanggal</th>
          <th style="text-align: center; width: 7%">No. Faktur</th>
          <th style="text-align: center; width: 7%">Nama Customer</th>
          <th style="text-align: center; width: 7%">Kode Barang</th>
          <th style="text-align: center; width: 23%">Nama Barang</th>
          <th style="text-align: center; width: 7%">Satuan</th>
          <th style="text-align: center; width: 7%">Jumlah</th>
          <th style="text-align: center; width: 7%">Harga Beli</th>
          <th style="text-align: center; width: 7%">Harga Jual</th>
          <th style="text-align: center; width: 7%">Diskon%</th>
          <th style="text-align: center; width: 7%">Sub Total</th>
          <th style="text-align: center; width: 7%">Bersih</th>
        </tr>
      </thead>
  		<tbody>
        <?php
          function rupiah($angka){
            $hasil_rupiah = number_format($angka,0,',',',');
            return $hasil_rupiah;
          }
        ?>
        @foreach($rpt as $h)
          <?php
            if ($h->disc!=0) {
              $disc=$h->disc;
            }else{
              $disc='';
            }
            $jml=$h->qty*$h->price;
            $dis=($h->disc/100)*$jml;
            $gt=$jml-$dis;
            $hb=$h->capital*$h->qty;
            $brs=$gt-$hb;
          ?>
          <tr>
            <td style="text-align: center">{{ date('d-m-Y', strtotime($h->created_at)) }}</td>
            <td style="text-align: center">{{ $h->invoice }}</td>
            <td>{{ $h->namecus }}</td>
            <td>{{ $h->code_product }}</td>
            <td>{{ $h->namebrg }}</td>
            <td style="text-align: center">{{ $h->nameu }}</td>
            <td style="text-align: center">{{ $h->qty }}</td>
            <td style="text-align: right">{{ rupiah($h->capital) }}</td>
            <td style="text-align: right">{{ rupiah($h->price) }}</td>
            <td style="text-align: center">{{ $disc }}</td>
            <td style="text-align: right">{{ $gt }}</td>
            <td style="text-align: right">{{ $brs }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th colspan="5" style="text-align:right">Total Keseluruhan :</th>
          <th colspan="3" style="text-align: right;"></th>
          <th colspan="2" style="text-align: right;">Total Bersih :</th>
          <th colspan="2" style="text-align: right;"></th>
        </tr>
      </tfoot>
    </table>
	</div>
@endsection