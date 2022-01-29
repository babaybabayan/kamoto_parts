@extends('template.index')

@section('content')
	<div class="row">
    <div class="col-md-11">
  		<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".tambah"><span class="fa fa-plus-square"></span></button>
  		<div class="modal fade tambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
  					<div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="myModalLabel">Tambah Sales</h4>
            </div>
            <form action="/sls/tmb" method="post" enctype="multipart/form-data" class="form-horizontal slsform" id="slsform" name="slsform">
              {{ csrf_field() }}
              <div class="modal-body">
                <span id="elorsls"></span><br/>
                <label for="id">Kode</label>
                <input type="text" id="idsls" class="form-control" name="id" autocomplete="off" required />
  							<label for="nama">Nama</label>
                <input type="text" id="namasls" class="form-control" name="nama" autocomplete="off" required />
                <label for="telepon">Telepon</label>
                <input type="text" id="teleponsls" class="form-control" name="telepon" autocomplete="off" required />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <a href="#" class="btn btn-primary smpnsls">Simpan</a>
              </div>
            </form>
  				</div>
        </div>
      </div>
    </div>
  		<table id="datatable" class="table table-striped table-bordered" style="width: 100%">
        <thead>
          <tr>
            <th style="text-align: center">Kode</th>
            <th style="text-align: center">Nama</th>
            <th style="text-align: center">Telepon</th>
            <th></th>
          </tr>
        </thead>
  			<tbody>
          @foreach($sls as $s)
            <tr>
              <td style="width: 12%"><a href="/hst/sls/{{ $s->id }}">{{ $s->code_sales }}</a></td>
              <td style="width: 25%"><a href="/hst/sls/{{ $s->id }}">{{ $s->name }}</a></td>
              <td style="width: 12%"><a href="/hst/sls/{{ $s->id }}">{{ $s->telp }}</a></td>
              <td style="text-align: center; width: 10%"><button type="button" class="btn btn-success" data-toggle="modal" data-target=".ubah{{ $s->id }}"><span class="fa fa-edit"></span></button></button></td>
            </tr>
          <div class="modal fade ubah{{ $s->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                  <h4 class="modal-title" id="myModalLabel">Ubah Data Customer</h4>
                </div>
                <form action="/sls/ubah/{{ $s->id }}" method="post" enctype="multipart/form-data" id="demo-form" data-parsley-validate>
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
                  <div class="modal-body">
                    <label for="uid">Kode</label>
                    <input type="text" id="uid" class="form-control" name="uid" value="{{ $s->code_sales }}" autocomplete="off" required />
                    <label for="unama">Nama</label>
                    <input type="text" id="unama" class="form-control" name="unama" value="{{ $s->name }}" autocomplete="off" required />
                    <label for="utelepon">Telepon</label>
                    <input type="text" id="utelepon" class="form-control" name="utelepon" value="{{ $s->telp }}" autocomplete="off" required />
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