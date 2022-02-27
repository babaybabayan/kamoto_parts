@extends('template.index')

@section('content')
  <link href="{{url('kamotoparts/kamotoparts.css')}}" rel="stylesheet">
  <?php
    function rupiah($angka){
      $hasil_rupiah = number_format($angka,0,',',',');
      return $hasil_rupiah;
    }
  ?>
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
  <div class="row top_tiles">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"></div>
        <div class="count">{{rupiah($tmdl)}}</div>
        <h3>Total Modal</h3>
      </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"></div>
        <div class="count">{{rupiah($tpnj)}}</div>
        <h3>Total Penjualan</h3>
      </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"></div>
        <div class="count">{{rupiah($tpnj-$tmdl)}}</div>
        <h3>Total Profit</h3>
      </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        @php
          $v1 = $tpnj-$tmdl;
          $v2 = (30/100)*$v1;
        @endphp
        <div class="icon"></div>
        <div class="count">{{rupiah($v2)}}</div>
        <h3>Profit</h3>
      </div>
    </div>
  </div>
  <br>
	<div class="row">
  	<table id="tblrptpnj" class="table table-striped table-bordered" style="width: 100%">
      <thead>
        <tr>
          <th style="text-align: center; width: 14%">No. Faktur</th>
          <th style="text-align: center; width: 14%">Tanggal</th>
          <th style="text-align: center; width: 20%">Nama Customer</th>
          <th style="text-align: center; width: 13%">Total</th>
          <th style="text-align: center; width: 13%">Modal</th>
          <th style="text-align: center; width: 13%">Profit</th>
          <th style="text-align: center; width: 13%">Persen (%)</th>
        </tr>
      </thead>
  		<tbody>
        @foreach($rpt as $h)
          <?php
            $v1 = $h->total_payment-$h->mdl;
            $v2 = $v1/$h->mdl;
            $v3 = $v2*100;
          ?>
          <tr>
            <td style="text-align: center">{{ $h->invoice }}</td>
            <td style="text-align: center">{{ date('d-m-Y', strtotime($h->created_at)) }}</td>   
            <td>{{ $h->namecus }}</td>
            <td style="text-align: right">{{ $h->total_payment }}</td>
            <td style="text-align: right">{{ $h->mdl }}</td>
            <td style="text-align: right">{{ $h->total_payment-$h->mdl; }}</td>
            <td style="text-align: right">{{ round($v3) }} %</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3" style="text-align:right">TOTAL</th>
          <th style="text-align: right;"></th>
          <th style="text-align: right;"></th>
          <th style="text-align: right;"></th>
          <th style="text-align: right;"></th>
        </tr>
      </tfoot>
    </table>
	</div>
@endsection