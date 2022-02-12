@extends('template.index')

@section('content')
  <link href="{{url('kamotoparts/kamotoparts.css')}}" rel="stylesheet">
  <div class="row">
    <h3>Detail History Pembelian</h3>
  </div>
	<div class="row">
    <form action="/hst/dpmb" method="post" enctype="multipart/form-data" class="form-horizontal">
      {{ csrf_field() }}
      <div class="col-md-2">
        <input type="text" class="form-control has-feedback-left tanggal" name="tglhst1" placeholder="{{date('d-m-Y')}}" required autocomplete="off">
        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
      </div>
      <div class="col-md-2">
        <input type="text" class="form-control has-feedback-left tanggal" name="tglhst2" placeholder="{{date('d-m-Y')}}" required autocomplete="off">
        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span></button>
      </div>
    </form>
  </div>
  <br/>
  <div class="row">
    <table id="tblicdpmb" class="table table-striped table-bordered" style="width: 100%">
      <thead>
        <tr>
          <th style="text-align: center; width: 7%">No. Faktur</th>
          <th style="text-align: center; width: 8%">Tanggal</th>
          <th style="text-align: center; width: 8%">Jatuh Tempo</th>
          <th style="text-align: center; width: 8%">Nama Supplier</th>
          <th style="text-align: center; width: 7%">Kode Barang</th>
          <th style="text-align: center; width: 27%">Nama Barang</th>
          <th style="text-align: center; width: 7%">Satuan</th>
          <th style="text-align: center; width: 7%">Jumlah</th>
          <th style="text-align: center; width: 7%">Harga</th>
          <th style="text-align: center; width: 7%">Diskon%</th>
          <th style="text-align: center; width: 7%">Sub Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
          function rupiah($angka){
            $hasil_rupiah = number_format($angka,0,',',',');
            return $hasil_rupiah;
          }
        ?>
        @foreach($hst as $h)
          <?php
            if ($h->namests=='Cash') {
              $tmpo = $h->namests;
            }else{
              $tmpo = date('d-m-Y', strtotime($h->due_date));
            }
            if ($h->disc!=0) {
              $disc=$h->disc;
            }else{
              $disc='';
            }
            $jml=$h->quantity*$h->capital;
            $dis=($h->disc/100)*$jml;
            $gt=$jml-$dis;
          ?>
          <tr>
            <td style="text-align: center">{{ $h->invoice }}</td>
            <td style="text-align: center">{{ date('d-m-Y', strtotime($h->created_at)) }}</td>
            <td style="text-align: center">{{ $tmpo }}</td>
            <td>{{ $h->namespl }}</td>
            <td>{{ $h->code_product }}</td>
            <td>{{ $h->namebrg }}</td>
            <td style="text-align: center">{{ $h->nameu }}</td>
            <td style="text-align: center">{{ $h->quantity }}</td>
            <td style="text-align: right">{{ rupiah($h->capital) }}</td>
            <td style="text-align: center">{{ $disc }}</td>
            <td style="text-align: center">{{ $gt }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th colspan="9" style="text-align:right">Total Keseluruhan :</th>
          <th colspan="2" style="text-align: right"></th>
        </tr>
      </tfoot>
    </table>
  </div>
@endsection