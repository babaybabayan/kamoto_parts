<html>
  <head>
    <style>
      @page { margin: 35px 0px 10px 0px; }
      #footer { position: fixed; left: 30px; bottom: 0px; right: 30px; height: 130px; }
      #page:after { content: counter( page, upper); }
    </style>
  </head>
  <body>
  <script type="text/php">
    if ( isset($pdf)){
      $x = 540;
      $y = 7;
      $text = "Hal {PAGE_NUM} / {PAGE_COUNT}";
      $font = $fontMetrics->get_font("helvetica", "bold");
      $size = 11;
      $pdf->page_text($x, $y, $text, $font, $size);
    }
  </script>
    @foreach($sls as $s)
      @php $inv=$s->invoice @endphp
      @php $nc=$s->namecus @endphp
      @php $dt=$s->created_at @endphp
      @php $dd=$s->due_date @endphp
      @php $adr=$s->address @endphp
      @php $cs=$s->code_sales @endphp
      @php $ct=$s->city @endphp
      @php $tlp=$s->telp @endphp
      @php $ttl=$s->total_payment @endphp
    @endforeach
    @foreach($stg as $s2)
      @php $bn=$s2->bank_name @endphp
      @php $an=$s2->account_no @endphp
      @php $nb=$s2->name @endphp
    @endforeach
    <div id="header" style="margin-top: -10px; margin-left: 30px; margin-right: 30px;">
      <div style="width: 100%;">
        <div style="float: left; width: 44%"><b><font size="12pt">Kamoto Parts</font></b></div>
        <div style="float: right; width: 56%;"><b><font size="14pt">Invoice</font></b></div>
      </div>
      <br>
      <div><b><font size="12pt">BANDUNG HP/WA-0821.2008.6518</font></b></div>
      <div style="border: 1px solid #000000;">
        <table style="width: 100%">
          <tr>
            <td style="width: 13%"><font size="11pt"><b>No. Faktur</b></font></td>
            <td style="width: 37%"><font size="11pt">{{$inv}}</font></td>
            <td style="width: 13%"><font size="11pt"><b>Kepada Yth</b></font></td>
            <td style="width: 37%"><font size="11pt">{{$nc}}</font></td>
          </tr>
          <tr>
            <td><font size="11pt"><b>Tanggal</b></font></td>
            <td><font size="11pt">{{date('d-m-Y', strtotime($dt))}} / {{date('d-m-Y', strtotime($dd))}}</font></td>
            <td><font size="11pt"><b>Alamat</b></font></td>
            <td><font size="11pt">{{$adr}}</font></td>
          </tr>
          <tr>
            <td><font size="11pt"><b>Sales</b></font></td>
            <td colspan="2"><font size="11pt">{{$cs}}</font></td>
            <td><font size="11pt">{{$ct}} - {{$tlp}}</font></td>
          </tr>
        </table>
      </div>
    </div>
    
    <div id="footer">
      <div>
        <div style="border-top: 1px solid #000000; width: 100%">
          <div style="float: left; width: 75%">
            <?php
              function penyebut($nilai){
                $nilai = abs($nilai);
                $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
                $temp = "";
                if ($nilai < 12) {
                  $temp = " ". $huruf[$nilai];
                } else if ($nilai <20) {
                  $temp = penyebut($nilai - 10). " belas";
                } else if ($nilai < 100) {
                  $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
                } else if ($nilai < 200) {
                  $temp = " seratus" . penyebut($nilai - 100);
                } else if ($nilai < 1000) {
                  $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
                } else if ($nilai < 2000) {
                  $temp = " seribu" . penyebut($nilai - 1000);
                } else if ($nilai < 1000000) {
                  $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
                } else if ($nilai < 1000000000) {
                  $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
                } else if ($nilai < 1000000000000) {
                  $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
                } else if ($nilai < 1000000000000000) {
                  $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
                }     
                return $temp;
              }
              function terbilang($nilai) {
                if($nilai<0) {
                  $hasil = "minus ". trim(penyebut($nilai));
                } else {
                  $hasil = trim(penyebut($nilai));
                }         
                return $hasil;
              }
              function rupiah($angka){
                $hasil_rupiah = number_format($angka,0,',','.');
                return $hasil_rupiah; 
              }
            ?>
            <font size="10pt" style="text-transform: uppercase;"><i>{{terbilang($ttl)}}</i></font>
          </div>
          <div style="float: right; width: 25%">
            <table style="width: 100%">
              <tr>
                <td style="width: 50%"><font size="11pt"><b></b></font></td>
                <td style="width: 50%; text-align: right"><font size="11pt"></font></td>
              </tr>
              <tr>
                <td><font size="11pt"><b>Discount</b></font></td>
                <td style="text-align: right"><font size="11pt">{{rupiah($jdisc)}}</font></td>
              </tr>
              <tr>
                <td><font size="11pt"><b>Grand Total</b></font></td>
                <td style="text-align: right"><font size="11pt">{{rupiah($ttl)}}</font></td>
              </tr>
            </table>
          </div>
        </div>
        <br>
        <div style="width: 100%; text-align: center">
          <div style="float: left; width: 20%">
            <font size="11pt">Penerima</font>
            <br>
            <br>
            <br>
            <font size="11pt">(_____________)</font>
          </div>
          <div style="float: right; width: 50%">
            <div style="float: left; border: 1px solid #000000; width: 40%; margin-top: 7px">
              <font size="11pt">No. Rekening {{$bn}}</font>
              <br>
              <font size="11pt"><b>A/C. {{$an}}</b></font>
              <br>
              <font size="11pt">A.N {{$nb}}</font>
            </div>
            <div style="float: right; width: 30%; margin-right: 50px">
              <font size="11pt">Hormat Kami</font>
              <br>
              <br>
              <br>
              <font size="11pt">(_____________)</font>
            </div>
          </div>
        </div>
        <div style="clear: both;">
          <font size="9pt">Catatan:klaim barang maximal 5hari dari tanggal terima barang / selain no rekening di atas tidak sah</font>
        </div>
      </div>
    
    
    </div>   
    <div id="content" style="margin-top: 0px ;margin-bottom: 120px; margin-left: 20px; margin-right: 30px">
      <table style="width: 100%;" id="tbinvpnj">
       
          <tr>
            <td style="width: 5%; text-align: right;"><font size="11pt"><b>NO</b></font></td>
            <td style="width: 12%; text-align: left;"><font size="11pt"><b>Kode Barang</b></font></td>
            <td style="width: 44%; text-align: left;"><font size="11pt"><b>Nama Barang</b></font></td>
            <td style="width: 6%; text-align: right;"><font size="11pt"><b>QTY</b></font></td>
            <td style="width: 5%; text-align: left;"><font size="11pt"><b>Unit</b></font></td>
            <td style="width: 11%; text-align: right;"><font size="11pt"><b>Hrg. Satuan</b></font></td>
            <td style="width: 7%; text-align: right;"><font size="11pt"><b>Disc%</b></font></td>
            <td style="width: 10%; text-align: right;"><font size="11pt"><b>Sub Total</b></font></td>
          </tr>
        
          @php $i=1 @endphp
          @foreach($brg as $b)
              <tr>
                <td style="text-align: right;"><font size="10pt">{{ $i++ }}</font></td>
                <td><font size="10pt">{{$b->code_product}}</font></td>
                <td><font size="10pt">{{$b->nameprod}}</font></td>
                <td style="text-align: right;"><font size="10pt">{{$b->qtyp}}</font></td>
                <td><font size="10pt">{{$b->nameu}}</font></td>
                <td style="text-align: right"><font size="10pt">{{rupiah($b->price)}}</font></td>
                <td style="text-align: right"><font size="10pt">{{$b->disc}}</font></td>
                <td style="text-align: right"><font size="10pt">
                  @php
                    $a = $b->qtyp*$b->price;
                    $c = $b->disc/100;
                    $d = $a*$c;
                    $e = $a-$d;
                    echo rupiah(round($e));
                  @endphp
                </font></td>
              </tr>  
          @endforeach
       
      </table>
    </div>
  </body>
</html>