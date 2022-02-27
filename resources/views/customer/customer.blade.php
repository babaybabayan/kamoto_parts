@extends('template.index')

@section('content')
  <link href="{{url('kamotoparts/kamotoparts.css')}}" rel="stylesheet">
  <div class="row">
    <div style="float: left;">
      <h3>Master Customer</h3>
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
              <h4 class="modal-title" id="myModalLabel">Tambah Customer</h4>
            </div>
            <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal cusform" id="cusform" name="cusform">
              {{ csrf_field() }}
              <div class="modal-body">
                <span id="elorcus"></span><br/>
                <label for="id">Kode</label>
                <input type="text" id="idcus" class="form-control" name="id" autocomplete="off" required />
                <label for="nama">Nama</label>
                <input type="text" id="namacus" class="form-control" name="nama" autocomplete="off" required />
                <label for="alamat">Alamat</label>
                <input type="text" id="alamatcus" class="form-control" name="alamat" autocomplete="off" required />
                <label for="city">Kota</label>
                <input type="text" id="citycus" class="form-control" name="city" autocomplete="off">
                <label for="telepon">Telepon</label>
                <input type="text" id="teleponcus" class="form-control" name="telepon" autocomplete="off">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <a href="#" class="btn btn-primary smpncus" id="smpncus">Simpan</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
	<div class="row">
  		<table id="dtbrg" class="table table-striped table-bordered" style="width: 100%">
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
          @foreach($cus as $c)
            <tr>
              <td style="width: 12%"><a href="/hst/cus/{{$c->id}}">{{ $c->code_customer }}</a></td>
              <td style="width: 25%"><a href="/hst/cus/{{$c->id}}">{{ $c->name }}</a></td>
              <td style="width: 24%"><a href="/hst/cus/{{$c->id}}">{{ $c->address }}</a></td>
              <td style="width: 12%"><a href="/hst/cus/{{$c->id}}">{{ $c->city }}</a></td>
              <td style="width: 12%"><a href="/hst/cus/{{$c->id}}">{{ $c->telp }}</a></td>
              <td style="text-align: center; width: 10%"><button type="button" class="btn btn-success" data-toggle="modal" data-target=".ubah{{ $c->id }}"><span class="fa fa-edit"></span></button></button></td>
            </tr>
          <div class="modal fade ubah{{ $c->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                  <h4 class="modal-title" id="myModalLabel">Ubah Data Customer</h4>
                </div>
                <form action="/cus/ubah/{{ $c->id }}" method="post" enctype="multipart/form-data" id="demo-form" data-parsley-validate>
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
                  <div class="modal-body">
                    <label for="uid">Kode</label>
                    <input type="text" id="uid" class="form-control" name="uid" value="{{ $c->code_customer }}" autocomplete="off" required />
                    <label for="unama">Nama</label>
                    <input type="text" id="unama" class="form-control" name="unama" value="{{ $c->name }}" autocomplete="off" required />
                    <label for="ualamat">Alamat</label>
                    <input type="text" id="ualamat" class="form-control" name="ualamat" value="{{ $c->address }}" autocomplete="off" required />
                    <label for="ucity">Kota</label>
                    <input type="text" id="ucity" class="form-control" name="ucity" value="{{ $c->city }}" autocomplete="off" required />
                    <label for="utelepon">Telepon</label>
                    <input type="text" id="utelepon" class="form-control" name="utelepon" value="{{ $c->telp }}" autocomplete="off" required />
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