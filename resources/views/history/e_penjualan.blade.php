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
    <div class="col-md-7" style="text-align: right">
      <a href="#" data-toggle="modal" data-target=".listbrghstpnj"><h5><i><u>Klik disini untuk membuka list Barang</u></i></h5></a>
    </div>
    <div class="modal fade listbrghstpnj" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">List Barang</h4>
          </div>
          <div class="modal-body">
          <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal brghstpnjform" id="brghstpnjform" name="brghstpnjform">
            {{ csrf_field() }}
            <input type="hidden" class="idpympnj" name="idpympnj" value="{{$idpym}}">
            <table class="table table-striped table-bordered dtlbtp" style="width: 875px">
              <thead>
                <tr>
                  <th style="width: 5px"></th>
                  <th style="width: 150px; text-align: center">Kode</th>
                  <th style="width: 400px; text-align: center">Nama</th>
                  <th style="width: 100px; text-align: center">Stok</th>
                </tr>
              </thead>
              <tbody>
                @foreach($brg as $b)
                  <tr>
                    <td><input type="checkbox" data-input-id="{{ $b->id }}" onclick="insbrghpnj(this)"></td>
                    <td>{{ $b->code_product }}</td>
                    <td>{{ $b->name }}</td>
                    <td style="text-align: center">{{ $sldstk = \App\Models\Barang_harga::where(['id_product' => $b->idb])->pluck('quantity')->sum() }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a href="#" class="btn btn-primary smpnhpnj">OK</a>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade listcus" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">List Customer</h4>
          </div>
          
            <div class="modal-body">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          
        </div>
      </div>
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