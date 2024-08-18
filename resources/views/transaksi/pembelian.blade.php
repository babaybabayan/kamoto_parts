@extends('template.index')

@section('content')
    <div class="row">
        <h3>Transaksi Pembelian</h3>
    </div>
    <div class="row">
        <div class="col-md-2">
            <input type="text" class="form-control has-feedback-left tglpmb1" value="{{ date('d-m-Y') }}" readonly>
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
        </div>
        <div class="col-md-1"><input type="text" class="form-control tmpopmb" onkeyup="tempopmb()" value="0"></div>
        <div class="col-md-2">
            <input type="text" class="form-control has-feedback-left tgltmpopmb" value="{{ date('d-m-Y') }}" readonly>
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-5">
            <input type="text" class="form-control has-feedback-left invpmb" placeholder="No. Faktur" id="invpmb">
            <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-2">
            <input type="text" class="form-control has-feedback-left namesplpmb" placeholder="Pilih Supplier"
                autocomplete="off">
            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span><input type="hidden"
                class="idsplpmb" id="idsplpmb">
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-5">
            <input type="text" class="form-control has-feedback-left namebrgpmb" id="namebrgpmb"
                placeholder="Pilih Barang" autocomplete="off" disabled>
            <span class="fa fa-shopping-cart form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="elortpmb"></div>
    </div>
    <br />
    <div class="row">
        <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal pmbkform" id="pmbkform"
            name="pmbkform">
            {{ csrf_field() }}
            <table class="table table-bordered" id="tbpnj" style="width: 100%">
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
                <tbody id="showdatapmb">

                </tbody>
            </table>
        </form>
        <div class="modal fade epmbm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal prcpmbform"
                        id="prcpmbform" name="prcpmbform">
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
    <div class="modal fade hrgmdlpmb" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

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

@push('scripts')
    <script>
        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        };

        $('.namebrgpmb').typeahead({
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

        $(".namebrgpmb").change(function() {
            var a = $(this).val().replace(/^(.{1}[^\s]*).*/, "$1");
            $.ajax({
                url: '/trs/pmb/tmbrg/' + a,
                type: 'get',
                data: {},
                success: function(data) {

                },
            });
        });
    </script>
@endpush
