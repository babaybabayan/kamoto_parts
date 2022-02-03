@foreach($epmb as $ep)
	<?php
		function rupiah($angka){
            $hasil_rupiah = number_format($angka,0,',','.');
            return $hasil_rupiah; 
        }
	?>
	<form action="#" method="post" enctype="multipart/form-data" class="form-horizontal mhpmbform" id="mhpmbform" name="mhpmbform">
		{{ csrf_field() }}
		<table class="table" style="width: 100%">
			<input type="hidden" value="{{$ep->idp}}" class="midpmb" name="midpmb">
			<tr>
				<td style="width: 50%"><label>Quantity</label></td>
				<td style="width: 50%"><input type="number" value="{{$ep->qtyp}}" class="form-control mqtyhpmb" name="mqtyhpmb"></td>
			</tr>
			<tr>
				<td><label>Harga Beli</label></td>
				<td><input type="text" value="{{rupiah($ep->capital)}}" class="form-control mhjbpmb" name="mhjbpmb" class="mhjbpmb" onkeyup="hpmbrf(this)" autocomplete="off"></td>
			</tr>
			<tr>
				<td><label>Discount</label></td>
				<td><input type="number" value="{{$ep->disc}}" class="form-control mdischpmb" name="mdischpmb"></td>
			</tr>
			<tr>
				<td><label>Berat</label></td>
				<td><input type="number" value="{{$ep->weight}}" class="form-control mwghpmb" name="mwghpmb"></td>
			</tr>
		</table>
	</form>
@endforeach