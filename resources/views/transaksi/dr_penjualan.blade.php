@extends('template.index')

@section('content')
	<div class="row">
  	<table id="datatable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Satuan</th>
          <th>Jumlah</th>
          <th>Harga Jual</th>
          <th>Diskon</th>
          <th>Retur</th>
          <th></th>
        </tr>
      </thead>
  		<tbody>
        @foreach($drpj as $d)
          <tr>
            <td>{{ $d->code_product }}</td>
            <td>{{ $d->nameprd }}</td>
            <td>{{ $d->nameu }}</td>
            <td>{{ $d->quantity }}</td>
            <td>{{ $d->selling }}</td>
            <td>{{ $d->disc }}</td>
            <td>{{ $d->retur }}</td>
            <td style="text-align: center">
              <a href="#" data-toggle="modal" data-target=".ubah{{ $d->id }}"><span class="fa fa-edit"></span></a>
            </td>
          </tr>
          <div class="modal fade ubah{{ $d->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                  <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <form action="/trs/drpnj/insdrpnj" method="post" enctype="multipart/form-data" id="demo-form" data-parsley-validate>
                  <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $d->id }}">
                    <input type="hidden" name="idpym" value="{{ $d->idpym }}">
                    <input type="hidden" name="idprc" value="{{ $d->idprc }}">
                    <label for="retur">Retur</label>
                    <input type="number" class="form-control" name="retur" value="{{ $d->retur }}" autocomplete="off">
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