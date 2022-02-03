@extends('template.index')

@section('content')
  <div class="row">
    @foreach($pym as $p)
      <?php 
        $tgl3 = $p->created_at;
        $tgl4 = $p->due_date;
        $tgl1 = new DateTime($p->created_at);
        $tgl2 = new DateTime($p->due_date);
        $inv = $p->invoice;
        $spl = $p->name;
        $idpym = $p->id;
        $idspl = $p->idspl;
        $tmpo = $tgl2->diff($tgl1)->days; 
        if ($tmpo==0) {
          $hari = $tmpo;
        }else{
          $hari = $tmpo+1;
        }
      ?>
    @endforeach

    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left" value="{{date('d-m-Y', strtotime($tgl3))}}" readonly>
      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
    </div>
    <div class="col-md-1"><input type="text" class="form-control" value="{{$hari}}" readonly></div>
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left" value="{{date('d-m-Y', strtotime($tgl4))}}" readonly>
      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
    </div>
    <div class="col-md-7" style="text-align: right">
      <a href="#" data-toggle="modal" data-target=".listbrghstpmb"><h5><i><u>Klik disini untuk membuka list Barang</u></i></h5></a>
    </div>
    <div class="modal fade listbrghstpmb" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">List Barang</h4>
          </div>
          <div class="modal-body">
            <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal hstpmbform" id="hstpmbform" name="hstpmbform">
            {{ csrf_field() }}
            <input type="hidden" class="idpympmb" name="idpympmb" value="{{$idpym}}">
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
                    <td><input type="checkbox" data-input-id="{{ $b->id }}" onclick="insbrghpmb(this)"></td>
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
            <a href="#" class="btn btn-primary smpnhstpmb">OK</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="col-md-4">
      <input type="text" class="form-control has-feedback-left" value="{{$inv}}" readonly>
      <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="col-md-2">
      <input type="text" class="form-control has-feedback-left" value="{{$spl}}" readonly>
      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
    </div>
  </div>
  <br/>
  <div class="row">
  <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal thstpmbform" id="thstpmbform" name="thstpmbform">
    {{ csrf_field() }}
    <input type="hidden" class="idspl" name="idspl" value="{{$idspl}}">
    <table class="table table-bordered" id="tbhstpnj" style="width: 100%">
      <thead>
        <tr>
          <th style="width: 9%; text-align: center">Kode Barang</th>
          <th style="width: 28%; text-align: center">Nama Barang</th>
          <th style="width: 5%; text-align: center">Satuan</th>
          <th style="width: 10%; text-align: center">Qty</th>
          <th style="width: 10%; text-align: center">Harga Beli</th>
          <th style="width: 10%; text-align: center">Discount (%)</th>
          <th style="width: 10%; text-align: center">Berat (gr)</th>
          <th style="width: 10%; text-align: center">Grand Total</th>
          <th style="width: 4%; text-align: center"></th>
          <th style="width: 4%; text-align: center"></th>
        </tr>
      </thead>
      <tbody id="showdatahpmb">
        
      </tbody>
    </table>
    </form>
  </div>
  <div class="modal fade medthpmb" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          </div>
            <div class="modal-body">
              
            </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <a href="#" class="btn btn-primary smpnmehpmb">OK</a>
            </div>
            
        </div>
      </div>
    </div>
  <div class="row">
    <div class="col-md-10">
      <div><a href="#" class="btn btn-primary smpnthstpmb" id="smpnthstpmb">SIMPAN</a></div>
    </div>
    <div class="col-md-2" style="text-align: right">
      <div><b>Total : Rp. <span class="ttlhpmb"></span></b><input type="hidden" class="sttlhpmb"></div>
    </div>
  </div>
@endsection