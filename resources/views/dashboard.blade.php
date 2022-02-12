@extends('template.index')

@section('content')
  <div class="row">
    <h3>Dashboard</h3>
  </div>
  <div class="row">
    @php 
      $bln = date('m');
      if($bln=='01'){
        $bulan = 'Januari';
      }elseif ($bln=='02'){
        $bulan = 'Februari';
      }elseif ($bln=='03'){
        $bulan = 'Maret';
      }elseif ($bln=='04'){
        $bulan = 'April';
      }elseif ($bln=='05'){
        $bulan = 'Mei';
      }elseif ($bln=='06'){
        $bulan = 'Juni';
      }elseif ($bln=='07'){
        $bulan = 'Juli';
      }elseif ($bln=='08'){
        $bulan = 'Agustus';
      }elseif ($bln=='09'){
        $bulan = 'September';
      }elseif ($bln=='10'){
        $bulan = 'Oktober';
      }elseif ($bln=='11'){
        $bulan = 'November';
      }elseif ($bln=='12'){
        $bulan = 'Desember';
      }
    @endphp
    <h3>Periode Bulan {{$bulan}} {{date('Y')}}</h3>
  </div>
  <div class="row top_tiles">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"><i class="fa fa-mail-forward"></i></div>
        <div class="count">{{$cpnj}}</div>
        <h3>Total Penjualan</h3>
      </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"><i class="fa fa-mail-reply"></i></div>
        <div class="count">{{$cpmb}}</div>
        <h3>Total Pembelian</h3>
      </div>
    </div>
  </div>
  <div id="pnj"></div>
  <div id="pmb"></div>
  <script src="{{url('kamotoparts/chart.js')}}"></script>
  <script type="text/javascript">
    var jml =  <?php echo json_encode($jml) ?>;
    var tgl =  <?php echo json_encode($tgl) ?>;
    var jmlpmb =  <?php echo json_encode($jmlpmb) ?>;
    var tglpmb =  <?php echo json_encode($tglpmb) ?>;
    Highcharts.chart('pnj', {
        title: {
            text: 'Penjualan'
        },
         xAxis: {
            categories: tgl
        },
        yAxis: {
            title: {
                text: 'Jumlah Transaksi'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [{
            name: 'Jumlah Transaksi',
            data: jml
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
});
    Highcharts.chart('pmb', {
        title: {
            text: 'Pembelian'
        },
         xAxis: {
            categories: tglpmb
        },
        yAxis: {
            title: {
                text: 'Jumlah Transaksi'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [{
            name: 'Jumlah Transaksi',
            data: jmlpmb
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
});
</script>
@endsection