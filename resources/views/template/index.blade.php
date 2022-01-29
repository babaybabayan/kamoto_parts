<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kamoto Parts</title>
    <link href="{{url('gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentelella-master/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{url('gentelella-master/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <link href="{{url('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <link href="{{url('gentelella-master/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentelella-master/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentelella-master/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentelella-master/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentelella-master/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentelella-master/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <link href="{{url('datepicker/datepicker3.css')}}" rel="stylesheet">
    <link href="{{url('daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <link href="{{url('gentelella-master/build/css/custom.min.css')}}" rel="stylesheet">
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        @include('template.sidebar')
        @include('template.header')
        <div class="right_col" role="main">
          @yield('content')
        </div>
        @include('template.footer')
      </div>
    </div>
    <script src="{{url('gentelella-master/vendors/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    
    <script src="{{url('gentelella-master/vendors/fastclick/lib/fastclick.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/nprogress/nprogress.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{url('gentelella-master/vendors/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{url('daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{url('datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{url('kamotoparts/typehead.js')}}"></script>

    <script type="text/javascript">
    
        var route = "{{url('/cus/namecus')}}";
        $('.namecus').typeahead({
            source: function (query, process){
                return $.get(route, {
                    query: query
                }, function (data){
                    return process(data);
                });
            }
        });
        $(".namecus").change(function() {
            $.ajax({
                url: '/cus/getidcus/' + $(this).val(),
                type: 'get',
                data: {},
                dataType: 'json',
                success: function(data) {
                    if (data.success == true) {
                        $(".idcus").val(data.info);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        });
        var namesls = "{{url('/sls/namesls')}}";
        $('.namesls').typeahead({
            source: function (query, process){
                return $.get(namesls, {
                    query: query
                }, function (data){
                    return process(data);
                });
            }
        });
        $(".namesls").change(function() {
            $.ajax({
                url: '/sls/getidsls/' + $(this).val(),
                type: 'get',
                data: {},
                dataType: 'json',
                success: function(data) {
                    if (data.success == true) {
                        $(".idsls").val(data.info);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        });
        var namesplpmb = "{{url('/spl/namesplpmb')}}";
        $('.namesplpmb').typeahead({
            source: function (qnamespl, process){
                return $.get(namesplpmb, {
                    qnamespl: qnamespl
                }, function (data){
                    return process(data);
                });
            }
        });
        $(".namesplpmb").change(function() {
            $.ajax({
                url: '/spl/getidsplpmb/' + $(this).val(),
                type: 'get',
                data: {},
                dataType: 'json',
                success: function(data) {
                    if (data.success == true) {
                        $(".idsplpmb").val(data.info);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        });
    </script>
    <script src="{{url('kamotoparts/kamotoparts.js')}}"></script>
    <script src="{{url('gentelella-master/build/js/custom.min.js')}}"></script>
  </body>
</html>