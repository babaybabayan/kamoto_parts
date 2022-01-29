@extends('template.index')

@section('content')
	<div class="row">
  	<table id="datatable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>No. Faktur</th>
          <th>Tanggal</th>
          <th></th>
        </tr>
      </thead>
  		<tbody>
        @foreach($rpm as $r)
          <tr>
            <td>{{ $r->invoice }}</td>
            <td>{{ $r->created_at }}</td>
            <td style="text-align: center">
              <a href="/trs/drpmb/{{ $r->id }}"><span class="fa fa-external-link"></span></a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
	</div>
@endsection