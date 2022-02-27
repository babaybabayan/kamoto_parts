@extends('template.index')

@section('content')
  <link href="{{url('kamotoparts/kamotoparts.css')}}" rel="stylesheet">
  <div class="row">
    <h3>History Penjualan</h3>
  </div>
	<div class="row">
    <form action="/hst/rpnj" method="post" enctype="multipart/form-data" class="form-horizontal">
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
    <table id="tblic" class="table table-striped table-bordered" style="width: 100%">
      <thead>
        <tr>
          <th style="text-align: center">No. Faktur</th>
          <th style="text-align: center">Tanggal</th>
          <th style="text-align: center">Jatuh Tempo</th>
          <th style="text-align: center">Nama Customer</th>
          <th style="text-align: center">Nama Sales</th>
          <th style="text-align: center">Grand Total</th>
          <th style="text-align: center"></th>
        </tr>
      </thead>
      <tbody>
        <?php
          function rupiah($angka){
            $hasil_rupiah = number_format($angka,0,',','.');
            return $hasil_rupiah;
          }
          $tgl = date('Y-m-d');
        ?>
        @foreach($hst as $h)
          <?php
            if ($h->namests=='Cash') {
              $tmpo = $h->namests;
            }else{
              $tmpo = date('d-m-Y', strtotime($h->due_date));
            }
          ?>
          <tr>
            <td style="text-align: center">{{ $h->invoice }}</td>
            <td style="text-align: center">{{ date('d-m-Y', strtotime($h->created_at)) }}</td>
            <td style="text-align: center">{{ $tmpo }}</td>
            <td>{{ $h->namecus }}</td>
            <td>{{ $h->namesls }}</td>
            <td style="text-align: right">{{ $h->total_payment }}</td>
            <td style="text-align: center">
              <a href="/hst/epnj/{{ $h->id }}/{{$tgl}}/{{$tgl}}"><span class="fa fa-edit"></span></a>
            </td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th colspan="5" style="text-align:right">Total Keseluruhan :</th>
          <th colspan="2" style="text-align: right"></th>
        </tr>
      </tfoot>
    </table>
  </div>
@endsection
