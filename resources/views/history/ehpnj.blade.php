@foreach($prc as $ps)
    {{ csrf_field() }}
    <input type="hidden" class="form-control idehpnj" name="idehpnj" value="{{ $ps->id }}">
    <label for="feqtyp">Jumlah</label>
    <input type="number" class="form-control qtyehpnj" name="qtyehpnj" value="{{ $ps->quantity }}" autocomplete="off">
    <label for="fehjp">Harga Jual</label>
    <input type="number" class="form-control hjehpnj" name="hjehpnj" value="{{ $ps->selling }}" autocomplete="off">
    <label for="fedisp">Diskon</label>
    <input type="number" class="form-control discehpnj" name="discehpnj" value="{{ $ps->disc }}" autocomplete="off">
@endforeach