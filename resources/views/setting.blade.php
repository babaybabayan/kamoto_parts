@extends('template.index')

@section('content')
  @foreach($stg as $s)
  	<div class="row">
      <table class="table" style="width: 30%">
        <tr>
          <td style="vertical-align: middle; width: 50%;"><label>Nama Bank</label></td>
          <td><input type="text" readonly value="{{$s->bank_name}}" class="form-control"></td>
        </tr>
        <tr>
          <td style="vertical-align: middle; width: 50%;"><label>Nomor Rekening</label></td>
          <td><input type="text" readonly value="{{$s->account_no}}" class="form-control"></td>
        </tr>
        <tr>
          <td style="vertical-align: middle; width: 50%;"><label>Atas Nama</label></td>
          <td><input type="text" readonly value="{{$s->name}}" class="form-control"></td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: right;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".ubah{{ $s->id }}"><span class="fa fa-edit"></span></button>
          </td>
        </tr>
      </table>
      <div class="modal fade ubah{{ $s->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form action="/stg/ubah/{{ $s->id }}" method="post" enctype="multipart/form-data" id="demo-form" data-parsley-validate>
                  <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <label for="sbn">Nama Bank</label>
                    <input type="text" id="sbn" class="form-control" name="sbn" value="{{ $s->bank_name }}" autocomplete="off">
                    <label for="san">Nomor Rekening</label>
                    <input type="text" id="san" class="form-control" name="san" value="{{ $s->account_no }}" autocomplete="off">
                    <label for="sn">Atas Nama</label>
                    <input type="text" id="sn" class="form-control" name="sn" value="{{ $s->name }}" autocomplete="off">
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
  @endforeach
@endsection