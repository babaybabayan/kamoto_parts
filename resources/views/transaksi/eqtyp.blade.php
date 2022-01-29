@foreach($prc as $ps)
    {{ csrf_field() }}
    <input type="hidden" class="form-control feidp" name="feidp" value="{{ $ps->id }}">
    <label for="feqtyp">Jumlah</label>
    <input type="number" class="form-control feqtyp" name="feqtyp" value="{{ $ps->quantity }}" autocomplete="off">
    <label for="fehjp">Harga Jual</label>
    <input type="number" class="form-control fehjp" name="fehjp" value="{{ $ps->selling }}" autocomplete="off">
    <label for="fedisp">Diskon</label>
    <input type="number" class="form-control fedisp" name="fedisp" value="{{ $ps->disc }}" autocomplete="off">
@endforeach