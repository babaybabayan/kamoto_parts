@extends('template.index')

@section('content')
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
                                <label for="unit">Satuan</label>
                                <select class="form-control" name="unit">
                                    @foreach ($unit as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                <a href="#" class="btn btn-primary smpnbrg">Simpan</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <table id="datatable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center; width: 18%">Kode</th>
                    <th style="text-align: center; width: 29%">Nama</th>
                    <th style="text-align: center; width: 10%">Berat</th>
                    <th style="text-align: center; width: 10%">Satuan</th>
                    <th style="text-align: center; width: 8%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brg as $b)
                    <tr>
                        <td><a href="#" data-toggle="modal"
                                data-target=".hst{{ $b->idb }}">{{ $b->code_product }}</a></td>
                        <td><a href="#" data-toggle="modal" data-target=".hst{{ $b->idb }}">{{ $b->name }}</a>
                        </td>
                        <td><a href="#" data-toggle="modal" data-target=".hst{{ $b->idb }}">{{ $b->weight }}</a>
                        </td>
                        <td style="text-align: center"><a href="#" data-toggle="modal"
                                data-target=".hst{{ $b->idb }}">{{ $b->nameu }}</a></td>
                        <td style="text-align: center">
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target=".ubah{{ $b->idb }}">
                                <span class="fa fa-edit"></span>
                            </button>
                        </td>
                    </tr>
                    <div class="modal fade ubah{{ $b->idb }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Ubah Data Barang</h4>
                                </div>
                                <form action="/brg/ubah/{{ $b->idb }}" method="post" enctype="multipart/form-data"
                                    id="demo-form" data-parsley-validate>
                                    <div class="modal-body">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <label for="ukode">Kode</label>
                                        <input type="text" id="ukode" class="form-control" name="ukode"
                                            value="{{ $b->code_product }}" autocomplete="off">
                                        <label for="unama">Nama</label>
                                        <input type="text" id="unama" class="form-control" name="unama"
                                            value="{{ $b->name }}" autocomplete="off">
                                        <label for="idweight">Berat</label>
                                        <input type="text" id="idweight" class="form-control" name="idweight"
                                            value="{{ $b->weight }}" autocomplete="off">
                                        <label for="uunit">Satuan</label>
                                        <select class="form-control" name="uunit">
                                            <option value="{{ $b->idu }}">{{ $b->nameu }}</option>
                                            @foreach ($unit as $u)
                                                @if ($b->idu != $u->id)
                                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade hst{{ $b->idb }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="text-align: center">
                                    <a href="/hst/brgpmb/{{ $b->idb }}" class="btn btn-primary">PEMBELIAN</a><br />
                                    <a href="/hst/brgpnj/{{ $b->idb }}" class="btn btn-primary">PENJUALAN</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
