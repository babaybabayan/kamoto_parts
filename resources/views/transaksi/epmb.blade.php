@foreach($prc as $pm)
    {{ csrf_field() }}
    <input type="hidden" class="form-control feidpmb" name="feidpmb" value="{{ $pm->id }}">
    <label for="feqtyp">Jumlah</label>
    <input type="number" class="form-control feqtypmb" name="feqtypmb" value="{{ $pm->quantity }}" autocomplete="off">
    <label for="fehjp">Harga Beli</label>
    <input type="number" class="form-control fehjpmb" name="fehjpmb" value="{{ $pm->capital }}" autocomplete="off">
@endforeach