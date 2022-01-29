@extends('template.index')

@section('content')
  <div class="row">
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left tglpmb1" value="{{date('d-m-Y')}}" readonly>
      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
    </div>
    <div class="col-md-1"><input type="text" class="form-control tmpopmb" onkeyup="tempopmb()" value="0"></div>
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left tgltmpopmb" value="{{date('d-m-Y')}}" readonly>
      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
    </div>
    <div class="col-md-7" style="text-align: right">
      <a href="#" data-toggle="modal" data-target=".listbrgpmb"><h5><i><u>Klik disini untuk membuka list Barang</u></i></h5></a>
    </div>
    <div class="modal fade listbrgpmb" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">List Barang</h4>
          </div>
          <div class="modal-body">
            <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal mypmbform" id="mypmbform" name="mypmbform">
            {{ csrf_field() }}
            <table class="table table-striped table-bordered dtlbtp" style="width: 875px">
              <thead>
                <tr>
                  <th style="width: 5px; text-align: center"></th>
                  <th style="width: 150px; text-align: center">Kode</th>
                  <th style="width: 400px; text-align: center">Nama</th>
                  <th style="width: 100px; text-align: center">Stok</th>
                </tr>
              </thead>
              <tbody>
                @foreach($brg as $b)
                  <tr>
                    <td><input type="checkbox" data-input-id="{{ $b->id }}" onclick="insbrgpmb(this)"></td>
                    <td>{{ $b->code_product }}</td>
                    <td>{{ $b->name }}</td>
                    <td style="text-align: center">{{ $sldstk = \App\Models\Barang_harga::where(['id_product' => $b->id])->pluck('quantity')->sum() }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a href="#" class="btn btn-primary smpnpmb">OK</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="col-md-4">
      <input type="text" class="form-control has-feedback-left invpmb" placeholder="No. Faktur" id="invpmb">
      <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left namesplpmb" placeholder="Pilih Supplier" autocomplete="off">
      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span><input type="hidden" class="idsplpmb" id="idsplpmb">
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="elortpmb"></div>
  </div>
  <br/>
  <div class="row">
  <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal pmbkform" id="pmbkform" name="pmbkform">
    {{ csrf_field() }}
    <table class="table table-bordered" id="tbpnj" style="width: 100%">
      <thead>
        <tr>
          <th style="width: 10%; text-align: center">Kode Barang</th>
          <th style="width: 30%; text-align: center">Nama Barang</th>
          <th style="width: 5%; text-align: center">Satuan</th>
          <th style="width: 10%; text-align: center">Qty</th>
          <th style="width: 10%; text-align: center">Harga Beli</th>
          <th style="width: 10%; text-align: center">Discount (%)</th>
          <th style="width: 10%; text-align: center">Berat (gr)</th>
          <th style="width: 10%; text-align: center">Grand Total</th>
          <th style="width: 5%; text-align: center"></th>
        </tr>
      </thead>
      <tbody id="showdatapmb">
        
      </tbody>
    </table>
    </form>
    <div class="modal fade epmbm" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel"></h4>
          </div>
          <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal prcpmbform" id="prcpmbform" name="prcpmbform">
            <div class="modal-bodypmb">
                  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <a href="#" class="btn btn-primary edtprcpmb">Simpan</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-10">
      <div><a href="#" class="btn btn-primary smpntpmb" id="smpntpmb">SIMPAN</a></div>
    </div>
    <div class="col-md-2" style="text-align: right">
      <div><b>Total : Rp. <span class="ttlpmb"></span></b><input type="hidden" class="sttlpmb"></div>
    </div>
  </div>
@endsection