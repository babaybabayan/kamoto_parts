@extends('template.index')

@section('content')
  @foreach($pym as $p)
      <?php 
        $tgl3 = $p->created_at;
        $tgl4 = $p->due_date;
        $tgl1 = new DateTime($p->created_at);
        $tgl2 = new DateTime($p->due_date);
        $inv = $p->invoice;
        $cus = $p->namecus;
        $sls = $p->namesls;
        $idpym = $p->id;
        $idcus = $p->idcus;
        $idsls = $p->idsls;
        $tmpo = $tgl2->diff($tgl1)->days; 
        if ($tmpo==0) {
          $hari = $tmpo;
        }else{
          $hari = $tmpo+1;
        }
      ?>
    @endforeach
  <input type="hidden" class="idpympnj" name="idpympnj" value="{{$idpym}}">
  <input type="hidden" class="idcushpnj" name="idcushpnj" value="{{$idcus}}">
  <div class="row">
    <h3>History Penjualan</h3>
  </div>
  <div class="row">
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left tglpnj1" value="{{date('d-m-Y', strtotime($tgl3))}}" readonly>
      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
    </div>
    <div class="col-md-1"><input type="text" class="form-control tmpo" value="{{$hari}}" readonly></div>
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left tgltmpo" value="{{date('d-m-Y', strtotime($tgl4))}}" readonly>
      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="col-md-5">
      <input type="text" class="form-control has-feedback-left invpnj" value="{{ $inv }}" readonly>
      <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left namecus" value="{{$cus}}" readonly>
      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span><input type="hidden" class="idcus">
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left namesls" value="{{$sls}}" readonly>
      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span><input type="hidden" class="idsls">
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="col-md-5">
      <input type="text" class="form-control has-feedback-left namebrghpnj" placeholder="Pilih Barang" autocomplete="off">
      <span class="fa fa-shopping-cart form-control-feedback left" aria-hidden="true"></span>
    </div>
  </div>
  <br/>
  <div class="row">
  <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal hstpnjform" id="hstpnjform" name="hstpnjform">
    {{ csrf_field() }}
    <input type="hidden" class="idpympnjhst" name="idpympnjhst" value="{{$idpym}}">
    <table class="table table-bordered" id="tblpnjhst" style="width: 100%">
      <thead>
        <tr>
          <th style="width: 10%; text-align: center">Kode Barang</th>
          <th style="width: 30%; text-align: center">Nama Barang</th>
          <th style="width: 10%; text-align: center">Satuan</th>
          <th style="width: 10%; text-align: center">Qty</th>
          <th style="width: 10%; text-align: center">Harga Jual</th>
          <th style="width: 10%; text-align: center; text-align: center">Discount(%)</th>
          <th style="width: 10%; text-align: center">Grand Total</th>
          <th style="width: 5%; text-align: center"></th>
          <th style="width: 5%; text-align: center"></th>
        </tr>
      </thead>
      <tbody id="showdataepnj">

      </tbody>
    </table>
    </form>
  </div>
  <div class="modal fade medthpnj" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          </div>
            <div class="modal-body">
              
            </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <a href="#" class="btn btn-primary smpnmehpnj">OK</a>
            </div>
            
        </div>
      </div>
    </div>
  <div class="row">
    <div class="col-md-1">
      <div><a href="#" class="btn btn-primary smpnthpnj">SIMPAN</a></div>
    </div>
    <div class="col-md-9">
      <div><a href="#" class="btn btn-primary smpnprntthpnj">SIMPAN & PRINT</a></div>
    </div>
    <div class="col-md-2" style="text-align: right">
      <div><b>Total : Rp. <span class="ttlhpnj"></span></b><input type="hidden" class="sttlhpnj"></div>
    </div>
  </div>
@endsection