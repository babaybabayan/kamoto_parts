@extends('template.index')

@section('content')
  <div class="row">
    <h3>Transaksi Penjualan</h3>
  </div>
  <div class="row">
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left tglpnj1" value="{{date('d-m-Y')}}" readonly>
      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
    </div>
    <div class="col-md-1"><input type="text" class="form-control tmpo" onkeyup="tempo()" value="0"></div>
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left tgltmpo" value="{{date('d-m-Y')}}" readonly>
      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="col-md-5">
      <?php
        $ltrs = strlen($ctrs);
        if ($ltrs==1) {
          $jmltrs = '000000'.$ctrs;
        }elseif ($ltrs==2) {
          $jmltrs = '00000'.$ctrs;
        }elseif ($ltrs==3) {
          $jmltrs = '0000'.$ctrs;
        }elseif ($ltrs==4) {
          $jmltrs = '000'.$ctrs;
        }elseif ($ltrs==5) {
          $jmltrs = '00'.$ctrs;
        }elseif ($ltrs==6) {
          $jmltrs = '0'.$ctrs;
        }elseif ($ltrs==7) {
          $jmltrs = $ctrs;
        }
      ?>
      <input type="text" class="form-control has-feedback-left invpnj" value="{{ $jmltrs }}" readonly>
      <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left namecus" placeholder="Pilih Customer">
      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span><input type="hidden" class="idcus" id="idcus">
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left namesls" placeholder="Pilih Sales">
      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span><input type="hidden" class="idsls" id="idsls">
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="col-md-5">
      <input type="text" class="form-control has-feedback-left namebrgpnj" placeholder="Pilih Barang" autocomplete="off">
      <span class="fa fa-shopping-cart form-control-feedback left" aria-hidden="true"></span>
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="elortpnj"></div>
  </div>
  <br/>
  <div class="row">
  <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal pnjkform" id="pnjkform" name="pnjkform">
    {{ csrf_field() }}
    <table class="table table-bordered" id="tblpnj" style="width: 100%">
      <thead>
        <tr>
          <th style="width: 10%; text-align: center">Kode Barang</th>
          <th style="width: 32%; text-align: center">Nama Barang</th>
          <th style="width: 8%; text-align: center">Satuan</th>
          <th style="width: 10%; text-align: center">Qty</th>
          <th style="width: 10%; text-align: center">Harga Jual</th>
          <th style="width: 10%; text-align: center; text-align: center">Discount</th>
          <th style="width: 10%; text-align: center">Grand Total</th>
          <th style="width: 6%; text-align: center"></th>
        </tr>
      </thead>
      <tbody id="showdata">

      </tbody>
    </table>
    </form>
  </div>
  <div class="row">
    <div class="col-md-1">
      <div><a href="#" class="btn btn-primary smpntpnj">SIMPAN</a></div>
    </div>
    <div class="col-md-9">
      <div><a href="#" class="btn btn-primary smpnprnttpnj">SIMPAN & PRINT</a></div>
    </div>
    <div class="col-md-2" style="text-align: right">
      <div><b>Total : Rp. <span class="ttlpnj"></span></b><input type="hidden" class="sttlpnj"></div>
    </div>
  </div>
@endsection