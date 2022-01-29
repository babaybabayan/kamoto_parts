@extends('template.index')

@section('content')
  <link href="{{url('kamotoparts/kamotoparts.css')}}" rel="stylesheet">
  <div class="row">
  	<table id="tblicspl" class="table table-striped table-bordered" style="width: 100%">
      <thead>
        <tr>
          <th style="text-align: center; width: 8%">Tanggal</th>
          <th style="text-align: center; width: 8%">No. Faktur</th>
          <th style="text-align: center; width: 8%">Nama Supplier</th>
          <th style="text-align: center; width: 8%">Kode Barang</th>
          <th style="text-align: center; width: 33%">Nama Barang</th>
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
            <td style="text-align: center">{{ date('d-m-Y', strtotime($h->created_at)) }}</td>
            <td style="text-align: center">{{ $h->invoice }}</td>
            
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
          <th colspan="7" style="text-align:right">Total Keseluruhan :</th>
          <th colspan="3" style="text-align: right"></th>
        </tr>
      </tfoot>
    </table>
	</div>
@endsection