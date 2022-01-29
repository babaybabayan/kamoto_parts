@foreach($epnj as $ep)
	<?php
		function rupiah($angka){
            $hasil_rupiah = number_format($angka,0,',','.');
            return $hasil_rupiah; 
        }
	?>
	<form action="#" method="post" enctype="multipart/form-data" class="form-horizontal mhpnjform" id="mhpnjform" name="mhpnjform">
		{{ csrf_field() }}
		<table class="table" style="width: 100%">
			<input type="hidden" value="{{$ep->idb}}" class="midbhpnj" name="midbhpnj">
			<input type="hidden" value="{{$ep->id_payment}}" class="midpymhpnj" name="midpymhpnj">
			<tr>
				<td style="width: 50%"><label>Quantity</label></td>
				<td style="width: 50%"><input type="number" value="{{$ep->qtyp}}" class="form-control mqtyhpnj" name="mqtyhpnj"></td>
			</tr>
			<tr>
				<td><label>Harga Jual</label></td>
				<td><input type="number" value="{{rupiah($ep->price)}}" class="form-control mhjhpnj" name="mhjhpnj" class="mhjhpnj" onkeyup="hpnjrf(this)" autocomplete="off"></td>
			</tr>
			<tr>
				<td><label>Discount</label></td>
				<td><input type="number" value="{{$ep->disc}}" class="form-control mdischpnj" name="mdischpnj"></td>
			</tr>
		</table>
	</form>
@endforeach