@extends('template.index')

@section('content')
    <div class="row">
      <h3>Pengaturan Invoice</h3>
    </div>
  	<div class="row">
      <table class="table" style="width: 30%">
      <tr>
          <td style="vertical-align: middle; width: 50%;"><label>Nama Toko</label></td>
          <td><input type="text" readonly value="{{$data->store_name ?? "-"}}" class="form-control"></td>
        </tr>
        <tr>
            <td style="vertical-align: middle; width: 50%;"><label>Atas Nama</label></td>
            <td><input type="text" readonly value="{{$data->name ?? "-"}}" class="form-control"></td>
          </tr>
        <tr>
            <tr>
                <td style="vertical-align: middle; width: 50%;"><label>No Telp</label></td>
                <td><input type="text" readonly value="{{$data->phone_number ?? "-"}}" class="form-control"></td>
              </tr>
            <tr>
          <td style="vertical-align: middle; width: 50%;"><label>Nama Bank</label></td>
          <td><input type="text" readonly value="{{$data->bank_name ?? "-"}}" class="form-control"></td>
        </tr>
        <tr>
          <td style="vertical-align: middle; width: 50%;"><label>Nomor Rekening</label></td>
          <td><input type="text" readonly value="{{$data->account_number ?? "-"}}" class="form-control"></td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: right;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".ubah{{ $data->id }}"><span class="fa fa-edit"></span></button>
          </td>
        </tr>
      </table>
      <div class="modal fade ubah{{ $data->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form action="/stg/ubah/{{ $data->id }}" method="post" enctype="multipart/form-data" id="demo-form" data-parsley-validate>
                  <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <label for="storeName">Nama Toko</label>
                    <input type="text" id="storeName" class="form-control" name="storeName" value="{{ $data->store_name ?? "-" }}" autocomplete="off">
                    <label for="onBehalfOf">Atas Nama</label>
                    <input type="text" id="onBehalfOf" class="form-control" name="onBehalfOf" value="{{ $data->name }}" autocomplete="off">
                    <label for="phoneNumber">No Telp</label>
                    <input type="text" id="phoneNumber" class="form-control" name="phoneNumber" value="{{ $data->phone_number ?? "-" }}" autocomplete="off">
                    <label for="bankName">Nama Bank</label>
                    <input type="text" id="bankName" class="form-control" name="bankName" value="{{ $data->bank_name }}" autocomplete="off">
                    <label for="accountNumber">Nomor Rekening</label>
                    <input type="text" id="accountNumber" class="form-control" name="accountNumber" value="{{ $data->account_number }}" autocomplete="off">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
  	</div>
@endsection
