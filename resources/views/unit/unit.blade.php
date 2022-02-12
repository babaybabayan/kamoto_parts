@extends('template.index')

@section('content')
  <div class="row">
    <div style="float: left;">
      <h3>Master Satuan Barang</h3>
    </div>
    <div style="float: right;">
      <div class="col-md-11">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".tambah"><span class="fa fa-plus-square"></span></button>
      </div>
      <div class="modal fade tambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="myModalLabel">Tambah Satuan Barang</h4>
            </div>
            <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal untform" id="untform" name="untform">
              <div class="modal-body">
                {{ csrf_field() }}
                <span id="elorunt"></span><br/>
                <label for="name">Nama</label>
                <input type="text" id="nameunt" class="form-control" name="name" autocomplete="off" required />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <a href="#" class="btn btn-primary smpnunt">Simpan</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
	<div class="row">
  		<table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th style="text-align: center; width: 30%">Nama</th>
            <th style="text-align: center; width: 10%"></th>
          </tr>
        </thead>
  			<tbody>
          @foreach($unit as $u)
            <tr>
              <td>{{ $u->name }}</td>
              <td style="text-align: center">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target=".ubah{{ $u->id }}"><span class="fa fa-edit"></span></button>
              </td>
            </tr>
          <div class="modal fade ubah{{ $u->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                  <h4 class="modal-title" id="myModalLabel">Ubah Data Satuan Barang</h4>
                </div>
                <form action="/brg/sat/ubah/{{ $u->id }}" method="post" enctype="multipart/form-data" id="demo-form" data-parsley-validate>
                  <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <label for="uname">Nama</label>
                    <input type="text" id="uname" class="form-control" name="uname" value="{{ $u->name }}" autocomplete="off" required />
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