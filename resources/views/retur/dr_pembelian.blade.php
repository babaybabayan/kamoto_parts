@extends('template.index')

@section('content')
  <link href="{{url('kamotoparts/kamotoparts.css')}}" rel="stylesheet">
  <div class="row">
    <h3>Retur Pembelian</h3>
  </div>
  <div class="row">
    <table id="tblic" class="table table-striped table-bordered" style="width: 100%">
      <thead>
        <tr>
          <th style="text-align: center">Kode</th>
          <th style="text-align: center">Nama</th>
          <th style="text-align: center">Satuan</th>
          <th style="text-align: center">Jumlah</th>
          <th style="text-align: center">Harga</th>
          <th style="text-align: center">Disc(%)</th>
          <th style="text-align: center">Grand Total</th>
          <th style="text-align: center">Retur</th>
          <th style="text-align: center"></th>
        </tr>
      </thead>
      <tbody>
        <?php
          function rupiah($angka){
            $hasil_rupiah = number_format($angka,0,',',',');
            return $hasil_rupiah;
          }
        ?>
        @foreach($drpm as $d)
          <?php
            $jml = $d->quantity*$d->capital;
            $dis = ($d->disc/100)*$jml;
            $dis2 = $jml-$dis;
          ?>
          <tr>
            <td>{{ $d->code_product }}</td>
            <td>{{ $d->namebrg }}</td>
            <td style="text-align: center">{{ $d->nameu }}</td>
            <td style="text-align: center">{{ $d->quantity }}</td>
            <td style="text-align: right">{{ rupiah($d->capital) }}</td>
            <td style="text-align: center">{{ $d->disc }}</td>
            <td style="text-align: right">{{ rupiah($dis2) }}</td>
            <td style="text-align: center">{{ $d->retur }}</td>
            <td style="text-align: center">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target=".ubah{{ $d->idp }}"><span class="fa fa-edit"></span></button>
            </td>
          </tr>
          <div class="modal fade ubah{{ $d->idp }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                  <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <form action="/rtr/drpmb/insdrpmb" method="post" enctype="multipart/form-data" id="demo-form" data-parsley-validate>
                  <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $d->idp }}">
                    <input type="hidden" name="idpym" value="{{ $d->id_payment }}">
                    <label for="jmlrtr">Jumlah</label>
                    <input type="text" id="jmlrtr" class="form-control" name="jmlrtr" value="{{ $d->retur }}" autocomplete="off">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection