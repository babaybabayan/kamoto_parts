<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Ubah Data Barang</h4>
            </div>
            <form method="post" enctype="multipart/form-data" id="demo-form" data-parsley-validate>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <label for="product-code">Kode</label>
                    <input type="text" id="product-code" class="form-control" name="product-code" autocomplete="off">
                    <label for="product-name">Nama</label>
                    <input type="text" id="product-name" class="form-control" name="product-name" autocomplete="off">
                    <label for="product-weight">Berat</label>
                    <input type="text" id="product-weight" class="form-control product-weight" name="product-weight"
                        onclick="setnolwgbrg(this)" autocomplete="off">
                    <label for="product-price">Harga Umum</label>
                    <input type="text" id="product-price" class="form-control product-price" name="product-price"
                        onclick="setnolhubrg(this)" onkeyup="gethubrg(this)" autocomplete="off">
                    <label for="product-unit">Satuan</label>
                    <select class="form-control" name="product-unit" id="product-unit">
                        <option value="{{ $product->unitId }}">{{ $product->unit }}</option>
                        @foreach ($unit as $u)
                            @if ($product->unitId != $u->id)
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

@push('scripts')
    <script>
        $('body').on('click', '#btn-edit-post', function() {
            let post_id = $(this).data('id');
            $.ajax({
                url: `/product/get-product/${post_id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    let product = response.data;
                    $('#product-code').val(product.code_product);
                    $('#product-name').val(product.name);
                    $('#product-weight').val(product.weight);
                    $('#product-price').val(product.def_price);
                    $('#product-unit').val(product.id_unit);
                    $('#modal-edit').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', status, error);
                }
            });

            $("#demo-form").attr("action", `/brg/ubah/${post_id}`);
        });
    </script>
@endpush
