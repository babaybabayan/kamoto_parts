@extends('template.index')

@section('content')
    <link href="{{ url('kamotoparts/kamotoparts.css') }}" rel="stylesheet">
    <div class="row">
        <h3>Saldo Stok</h3>
    </div>
    <div class="row">
        <table id="dtsld" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center; width: 15%">Kode</th>
                    <th style="text-align: center; width: 30%">Nama</th>
                    <th style="text-align: center; width: 10%">Satuan</th>
                    <th style="text-align: center; width: 10%">Saldo Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td style='text-align:center; vertical-align:middle'><a href="javascript:void(0)"
                                class="btn btn-info btn-xs" id="btn-detail" data-toggle="modal"
                                data-id="{{ $product->id }}">{{ $product->code }}</a>
                        </td>
                        <td><a href="#" data-toggle="modal">{{ $product->name }}</a></td>
                        <td style="text-align: center"><a href="#" data-toggle="modal">{{ $product->unit }}</a></td>
                        <td style="text-align: center">
                            <a href="#" data-toggle="modal">{{ $product->stock }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body" style="text-align: center">
                        <a href="" id="pembelian" class="btn btn-primary">PEMBELIAN</a><br />
                        <a href="" id="penjualan" class="btn btn-primary">PENJUALAN</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('body').on('click', '#btn-detail', function() {
            let post_id = $(this).data('id');
            $('#modal-detail').modal('show');
            $("#pembelian").attr("href", `/hst/brgpmb/${post_id}`);
            $("#penjualan").attr("href", `/hst/brgpnj/${post_id}`);
        });
    </script>
@endpush
