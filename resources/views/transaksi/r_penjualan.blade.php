@extends('template.index')

@section('content')
	<div class="row">
  	<table id="datatable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>No. Faktur</th>
          <th>Tanggal</th>
          <th>Nama Customer</th>
          <th>Nama Sales</th>
          <th></th>
        </tr>
      </thead>
  		<tbody>
        @foreach($rpj as $r)
          <tr>
            <td>{{ $r->invoice }}</td>
            <td>{{ $r->created_at }}</td>
            <td>{{ $r->namecus }}</td>
            <td>{{ $r->namesls }}</td>
            <td style="text-align: center">
              <a href="/trs/drpnj/{{ $r->id }}"><span class="fa fa-external-link"></span></a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
	</div>
@endsection