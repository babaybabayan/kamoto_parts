@foreach($prc as $pm)
    {{ csrf_field() }}
    <input type="hidden" class="form-control idehpmb" name="idehpmb" value="{{ $pm->id }}">
    <label for="feqtyp">Jumlah</label>
    <input type="number" class="form-control qtyehpmb" name="qtyehpmb" value="{{ $pm->quantity }}" autocomplete="off">
    <label for="fehjp">Harga Beli</label>
    <input type="number" class="form-control hbehpmb" name="hbehpmb" value="{{ $pm->capital }}" autocomplete="off">
@endforeach