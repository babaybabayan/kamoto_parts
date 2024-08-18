@extends('template.index')

@section('content')
    <div class="row">
        <h3>History Pembelian</h3>
    </div>
    <div class="row">
        @foreach ($pym as $p)
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
            if ($tmpo == 0) {
                $hari = $tmpo;
            } else {
                $hari = $tmpo + 1;
            }
            ?>
        @endforeach
        <input type="hidden" class="idpympmb" name="idpympmb" value="{{ $idpym }}">
        <input type="hidden" class="idsplhpmb" name="idsplhpmb" value="{{ $idspl }}">
        <input type="hidden" class="tglaw" value="{{ $tglaw }}">
        <input type="hidden" class="tglak" value="{{ $tglak }}">
        <input type="hidden" class="tgl" value="{{ date('Y-m-d') }}">
        <div class="col-md-2">
            <input type="text" class="form-control has-feedback-left" value="{{ date('d-m-Y', strtotime($tgl3)) }}"
                readonly>
            <input type="hidden" class="hstglpmb1" value="{{ date('m-d-Y', strtotime($tgl3)) }}">
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
        </div>
        <div class="col-md-1"><input type="text" class="form-control htmpopmb" onkeyup="htempopmb()"
                value="{{ $hari }}"></div>
        <div class="col-md-2">
            <input type="text" class="form-control has-feedback-left htgltmpopmb"
                value="{{ date('d-m-Y', strtotime($tgl4)) }}" readonly>
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-5">
            <input type="text" class="form-control has-feedback-left" value="{{ $inv }}" readonly>
            <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-2">
            <input type="text" class="form-control has-feedback-left" value="{{ $spl }}" readonly>
            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-5">
            <input type="text" class="form-control has-feedback-left namebrghpmb" placeholder="Pilih Barang"
                autocomplete="off">
            <span class="fa fa-shopping-cart form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>
    <br />
    <div class="row">
        <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal thstpmbform"
            id="thstpmbform" name="thstpmbform">
            {{ csrf_field() }}
            <input type="hidden" class="idspl" name="idspl" value="{{ $idspl }}">
            <table class="table table-bordered" id="tbhstpnj" style="width: 100%">
                <thead>
                    <tr>
                        <th style="width: 5%; text-align: center">No.</th>
                        <th style="width: 10%; text-align: center">Kode Barang</th>
                        <th style="width: 30%; text-align: center">Nama Barang</th>
                        <th style="width: 10%; text-align: center">Satuan</th>
                        <th style="width: 10%; text-align: center">Qty</th>
                        <th style="width: 10%; text-align: center">Harga Beli</th>
                        <th style="width: 10%; text-align: center">Discount (%)</th>
                        <th style="width: 10%; text-align: center">Grand Total</th>
                        <th style="width: 5%; text-align: center"></th>
                    </tr>
                </thead>
                <tbody id="showdatahpmb">

                </tbody>
            </table>
        </form>
    </div>
    <div class="modal fade hrgmdlhpmb" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

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

@push('scripts')
    <script>
        $('.namebrghpmb').typeahead({
            source: debounce(function(searchValue, process) {
                $.ajax({
                    url: "{{ url('/product/get-search-product') }}",
                    method: 'GET',
                    data: {
                        value: searchValue
                    },
                    success: function(response) {
                        process(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });
            }, 500)
        });

        $(".namebrghpmb").change(function() {
            var a = $(this).val().replace(/^(.{1}[^\s]*).*/, "$1");
            var b = $('.idpympmb').val();
            var c = $('.idsplhpmb').val();
            $.ajax({
                url: '/hst/epmb/tmbrg/' + a + '/' + b + '/' + c,
                type: 'get',
                data: {},
                success: function(data) {

                },
            });
        });
    </script>
@endpush
