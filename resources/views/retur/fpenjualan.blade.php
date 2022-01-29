@extends('template.index')

@section('content')
	<div class="row">
    <form action="/rtr/rpnj" method="post" enctype="multipart/form-data" class="form-horizontal">
      {{ csrf_field() }}
      <div class="col-md-2">
        <input type="text" class="form-control has-feedback-left tanggal" name="tglhst1" placeholder="{{date('d-m-Y')}}" required autocomplete="off">
        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
      </div>
      <div class="col-md-2">
        <input type="text" class="form-control has-feedback-left tanggal" name="tglhst2" placeholder="{{date('d-m-Y')}}" required autocomplete="off">
        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span></button>
      </div>
    </form>
  </div>
@endsection