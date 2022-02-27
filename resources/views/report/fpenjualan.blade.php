@extends('template.index')

@section('content')
  <form action="/rpt/hpnj" method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="row">
      <h3>Laporan Penjualan</h3>
    </div>
    <div class="row">
      @if($errors->any())
        <h4>{{$errors->first()}}</h4>
      @endif
    </div>
    <div class="row">
      {{ csrf_field() }}
      <div class="col-md-2">
        <input type="text" class="form-control has-feedback-left tanggal" name="tgl1" placeholder="{{date('d-m-Y')}}" required autocomplete="off">
        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
      </div>
      <div class="col-md-2">
        <input type="text" class="form-control has-feedback-left tanggal" name="tgl2" placeholder="{{date('d-m-Y')}}" required autocomplete="off">
        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-2">
        <input type="text" class="form-control has-feedback-left nameslsrpt" placeholder="Pilih Sales" required>
        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span><input type="hidden" name="idslsrpt" class="idslsrpt" required>
      </div>
      <div class="col-md-2">
          <button type="submit" class="btn btn-primary" id="crptpnj" disabled><span class="fa fa-search"></span></button>
        </div>
    </div>
  </form>
@endsection