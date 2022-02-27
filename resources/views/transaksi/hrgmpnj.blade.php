<table class="table">
	<tr>
		<td>No.</td>
		<td>Tanggal</td>
		<td>Harga</td>
		<td></td>
	</tr>
	<?php
		$nh=1;
		function rupiah($angka){
	        $hasil_rupiah = number_format($angka,0,',','.');
	        return $hasil_rupiah; 
	    }
    ?>
	@foreach($hsthrg as $hh)
		<tr>
			<td>{{ $nh++ }}</td>
			<td>{{date('d-m-Y', strtotime($hh->created_at))}}</td>
			<td>{{rupiah($hh->price)}}</td>
			<td><a href="#" class="edthrgmpnj" data-id="/trs/pnj/edthrgmpnj/{{$hh->id}}/{{$ids}}"><span class="fa fa-edit"></a></td>
		</tr>
	@endforeach
</table>