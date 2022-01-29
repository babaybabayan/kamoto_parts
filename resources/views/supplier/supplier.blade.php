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
              <h4 class="modal-title" id="myModalLabel">Tambah Supplier</h4>
            </div>
            <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal splform" id="splform" name="splform">
              {{ csrf_field() }}
              <div class="modal-body">
                <span id="elorspl"></span><br/>
                <label for="id">Kode</label>
                <input type="text" id="idspl" class="form-control" name="id" autocomplete="off" required />
  							<label for="nama">Nama</label>
                <input type="text" id="namaspl" class="form-control" name="nama" autocomplete="off" required />
                <label for="alamat">Alamat</label>
                <input type="text" id="alamatspl" class="form-control" name="alamat" autocomplete="off" required />
                <label for="city">Kota</label>
                <input type="text" id="cityspl" class="form-control" name="city" autocomplete="off" required />
                <label for="telepon">Telepon</label>
                <input type="text" id="teleponspl" class="form-control" name="telepon" autocomplete="off" required />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <a href="#" class="btn btn-primary smpnspl">Simpan</a>
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
            <th style="text-align: center">Alamat</th>
            <th style="text-align: center">Kota</th>
            <th style="text-align: center">Telepon</th>
            <th></th>
          </tr>
        </thead>
  			<tbody>
          @foreach($spl as $s)
            <tr>
              <td style="width: 12%"><a href="/hst/spl/{{$s->id}}">{{ $s->code_supplier }}</a></td>
              <td style="width: 25%"><a href="/hst/spl/{{$s->id}}">{{ $s->name }}</a></td>
              <td style="width: 24%"><a href="/hst/spl/{{$s->id}}">{{ $s->address }}</a></td>
              <td style="width: 12%"><a href="/hst/spl/{{$s->id}}">{{ $s->city }}</a></td>
              <td style="width: 12%"><a href="/hst/spl/{{$s->id}}">{{ $s->telp }}</a></td>
              <td style="width: 10%; text-align: center"><button type="button" class="btn btn-success" data-toggle="modal" data-target=".ubah{{ $s->id }}"><span class="fa fa-edit"></span></button></td>
            </tr>
          <div class="modal fade ubah{{ $s->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                  <h4 class="modal-title" id="myModalLabel">Ubah Data Supplier</h4>
                </div>
                <form action="/spl/ubah/{{ $s->id }}" method="post" enctype="multipart/form-data" id="demo-form" data-parsley-validate>
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
                  <div class="modal-body">
                    <label for="uid">Kode</label>
                    <input type="text" id="uid" class="form-control" name="uid" value="{{ $s->code_supplier }}" autocomplete="off" required />
                    <label for="unama">Nama</label>
                    <input type="text" id="unama" class="form-control" name="unama" value="{{ $s->name }}" autocomplete="off" required />
                    <label for="ualamat">Alamat</label>
                    <input type="text" id="ualamat" class="form-control" name="ualamat" value="{{ $s->address }}" autocomplete="off" required />
                    <label for="ucity">Kota</label>
                    <input type="text" id="ucity" class="form-control" name="ucity" value="{{ $s->city }}" autocomplete="off" required />
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