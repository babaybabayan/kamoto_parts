@extends('template.index')

@section('content')
    <link href="{{ url('kamotoparts/kamotoparts.css') }}" rel="stylesheet">
    <div class="row">
        <div style="float: left">
            <h3>Master Barang</h3>
        </div>
        <div style="float: right;">
            <div class="col-md-11" style="text-align: right;">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".tambah">
                    <span class="fa fa-plus-square"></span>
                </button>
            </div>
            <div class="modal fade tambah" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Tambah Barang</h4>
                        </div>
                        <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal brgform"
                            id="brgform" name="brgform">
                            <div class="modal-body">
                                {{ csrf_field() }}
                                <span id="elorbrg"></span><br />
                                <label for="kode">Kode</label>
                                <input type="text" id="kode" class="form-control" name="kode" autocomplete="off">
                                <label for="nama">Nama</label>
                                <input type="text" id="nama" class="form-control" name="nama" autocomplete="off">
                                <label for="weight">Berat</label>
                                <input type="text" id="weight" class="form-control" name="weight" autocomplete="off">
                                <label for="defprice">Harga Umum</label>
                                <input type="text" id="defprice" class="form-control defprice" name="defprice"
                                    autocomplete="off" onkeyup="gethutbrg(this)">
                                <label for="unit">Satuan</label>
                                <select class="form-control" name="unit">
                                    @foreach ($unit as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                <a href="#" class="btn btn-primary smpnbrg" id="smpnbrg">Simpan</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <table id="dtbrg" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center; width: 15%">Kode</th>
                    <th style="text-align: center; width: 35%">Nama</th>
                    <th style="text-align: center; width: 15%">Berat</th>
                    <th style="text-align: center; width: 15%">Harga Umum</th>
                    <th style="text-align: center; width: 10%">Satuan</th>
                    <th style="text-align: center; width: 10%"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                function rupiah($angka)
                {
                    $hasil_rupiah = number_format($angka, 0, ',', ',');
                    return $hasil_rupiah;
                }
                ?>
                @foreach ($products as $product)
                    <tr>
                        <td style='text-align:center; vertical-align:middle'>
                            <a href="javascript:void(0)" class="btn btn-info btn-xs" id="btn-detail" data-toggle="modal"
                                data-id="{{ $product->id }}">{{ $product->code }}</a>
                        </td>
                        <td><a href="#" data-toggle="modal"
                                data-target=".hst{{ $product->id }}">{{ $product->name }}</a>
                        </td>
                        <td><a href="#" data-toggle="modal"
                                data-target=".hst{{ $product->id }}">{{ $product->weight }}</a>
                        <td style="text-align: right"><a href="#" data-toggle="modal"
                                data-target=".hst{{ $product->id }}">{{ rupiah($product->price) }}</a>
                        </td>
                        <td style="text-align: center"><a href="#" data-toggle="modal"
                                data-target=".hst{{ $product->id }}">{{ $product->unit }}</a></td>
                        <td style="text-align: center">
                            <button type="button" id="btn-edit-post" class="btn btn-success" data-toggle="modal"
                                data-id="{{ $product->id }}">
                                <span class="fa fa-edit"></span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align: center">
                        <a href="" id="pembelian" class="btn btn-primary">PEMBELIAN</a><br />
                        <a href="" id="penjualan" class="btn btn-primary">PENJUALAN</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('barang.modal-edit')
@endsection

@push('scripts')
    <script>
        // let page = 1;
        // let isLoading = false;
        // $(window).scroll(function() {
        //     let height = ($(document).height());
        //     console.log($(window).scrollTop() + $(window).height() >= height && !isLoading)
        //     if ($(window).scrollTop() + $(window).height() >= height && !isLoading) {
        //         isLoading = true
        //     }
        // });
        $('body').on('click', '#btn-detail', function() {
            let post_id = $(this).data('id');
            $('#modal-detail').modal('show');
            $("#pembelian").attr("href", `/hst/brgpmb/${post_id}`);
            $("#penjualan").attr("href", `/hst/brgpnj/${post_id}`);
        });
    </script>
@endpush
