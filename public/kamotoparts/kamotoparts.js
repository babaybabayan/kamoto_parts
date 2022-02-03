$('.tanggal').datepicker({
    format: "dd-mm-yyyy",
    autoclose:true
});
$('.dtlbtp').dataTable({
    "bPaginate": true,
    bLengthChange: false,
    "lengthMenu": [ [10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "All"] ],
    "iDisplayLength": 10,
    bInfo: false,
    responsive: true,
    "bAutoWidth": false,
    "ordering": false
});
$('#datatable').DataTable({
    "ordering": false
});
$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function nol(n){
    if(n <= 9){
        return "0" + n;
    }
    return n;
}
function tempo(){
    var hari = $('.tmpo').val();
    var tgltmpo = new Date(new Date().getTime()+(hari*24*60*60*1000));
    let format = nol(tgltmpo.getDate()) + "-" + nol(tgltmpo.getMonth() + 1) + "-" + tgltmpo.getFullYear();
    $('.tgltmpo').val(format);
}
function tempopmb(){
    var hari = $('.tmpopmb').val();
    var tgltmpo = new Date(new Date().getTime()+(hari*24*60*60*1000));
    let format = nol(tgltmpo.getDate()) + "-" + nol(tgltmpo.getMonth() + 1) + "-" + tgltmpo.getFullYear();
    $('.tgltmpopmb').val(format);
}
$(document).ready(function(){
    tampildatapenjualan();
    tampildatapembelian();
    tampildataepenjualan();
    tampildataepembelian();
    $('.smpnbrg').click(function(){
        var form = document.brgform;
        var dataString = $(form).serialize();
        var a = document.getElementById("kode").value;
        var b = document.getElementById("nama").value;
        if (a=="") {
            $("#elorbrg").html('Kode Harus Diisi');
        }else if (b=="") {
            $("#elorbrg").html('Nama Harus Diisi');
        }else{
            $.ajax({
                url: '/brg/tmb',
                type: 'post',
                data: dataString,
                success: function(data){
                    if (data.info == 0) {
                        location.reload();
                    } else {
                        $("#elorbrg").html('Data Sudah Ada');
                    }
                }
            });
        }
    });
    $('.smpnunt').click(function(){
        var form = document.untform;
        var dataString = $(form).serialize();
        var a = document.getElementById("nameunt").value;
        if (a=="") {
            $("#elorunt").html('Nama Harus Diisi');
        }else{
            $.ajax({
                url: '/brg/sat/tmb',
                type: 'post',
                data: dataString,
                success: function(data){
                    if (data.info == 0) {
                        location.reload();
                    } else {
                        $("#elorunt").html('Data Sudah Ada');
                    }
                }
            });
        }
    });
    $('.smpnspl').click(function(){
        var form = document.splform;
        var dataString = $(form).serialize();
        var a = document.getElementById("idspl").value;
        var b = document.getElementById("namaspl").value;
        var c = document.getElementById("alamatspl").value;
        var d = document.getElementById("cityspl").value;
        var e = document.getElementById("teleponspl").value;
        if (a=="") {
            $("#elorspl").html('Kode Harus Diisi');
        }else if(b==""){
            $("#elorspl").html('Nama Harus Diisi');
        }else if(c==""){
            $("#elorspl").html('Alamat Harus Diisi');
        }else if(d==""){
            $("#elorspl").html('Kota Harus Diisi');
        }else if(e==""){
            $("#elorspl").html('Telepon Harus Diisi');
        }else{
            $.ajax({
                url: '/spl/tmb',
                type: 'post',
                data: dataString,
                success: function(data){
                    if (data.info == 0) {
                        location.reload();
                    } else {
                        $("#elorspl").html('Data Sudah Ada');
                    }
                }
            });
        }
    });
    $('.smpncus').click(function(){
        var form = document.cusform;
        var dataString = $(form).serialize();
        var a = document.getElementById("idcus").value;
        var b = document.getElementById("namacus").value;
        var c = document.getElementById("alamatcus").value;
        var d = document.getElementById("citycus").value;
        var e = document.getElementById("teleponcus").value;
        if (a=="") {
            $("#elorcus").html('Kode Harus Diisi');
        }else if(b==""){
            $("#elorcus").html('Nama Harus Diisi');
        }else if(c==""){
            $("#elorcus").html('Alamat Harus Diisi');
        }else if(d==""){
            $("#elorcus").html('Kota Harus Diisi');
        }else if(e==""){
            $("#elorcus").html('Telepon Harus Diisi');
        }else{
            $.ajax({
                url: '/cus/tmb',
                type: 'post',
                data: dataString,
                success: function(data){
                    if (data.info == 0) {
                        location.reload();
                    } else {
                        $("#elorcus").html('Data Sudah Ada');
                    }
                }
            });
        }
    });
    $('.smpnsls').click(function(){
        var form = document.slsform;
        var dataString = $(form).serialize();
        var a = document.getElementById("idsls").value;
        var b = document.getElementById("namasls").value;
        var c = document.getElementById("teleponsls").value;
        if (a=="") {
            $("#elorsls").html('Kode Harus Diisi');
        }else if(b==""){
            $("#elorsls").html('Nama Harus Diisi');
        }else if(c==""){
            $("#elorsls").html('Telepon Harus Diisi');
        }else{
            $.ajax({
                url: '/sls/tmb',
                type: 'post',
                data: dataString,
                success: function(data){
                    if (data.info == 0) {
                        location.reload();
                    } else {
                        $("#elorsls").html('Data Sudah Ada');
                    }
                }
            });
        }
    });
    function tampildatapenjualan(){
        $.ajax({
            type: 'GET',
            url: '/trs/pnj/data',
            async: true,
            dataType:'json',
            success : function(data){
                var html = '';
                var i;
                var jmlp;
                var disco;
                var har1;
                var harfix;
                var sumharfix = [];
                for(i=0; i<data.length; i++){
                    jmlp = data[i].selling*data[i].qtyp;
                    disco = data[i].disc/100;
                    har1 = jmlp * disco;
                    harfix = jmlp - har1;
                    sumharfix.push(harfix);
                    var hrgpnjrp = data[i].selling;
                    var numstrhpnj = hrgpnjrp.toString(), sisahpnj = numstrhpnj.length % 3, rupiahpnj = numstrhpnj.substr(0, sisahpnj), ribuanhpnj = numstrhpnj.substr(sisahpnj).match(/\d{3}/g);
                    if (ribuanhpnj) {
                        separatorhpnj = sisahpnj ? '.' : '';
                        rupiahpnj += separatorhpnj + ribuanhpnj.join('.');
                    }
                    var gtpnjrp = harfix;
                    var numstrgtpnj = gtpnjrp.toString(), sisagtpnj = numstrgtpnj.length % 3, rupiahgtpnj = numstrgtpnj.substr(0, sisagtpnj), ribuangtpnj = numstrgtpnj.substr(sisagtpnj).match(/\d{3}/g);
                    if (ribuangtpnj) {
                        separatorgtpnj = sisagtpnj ? '.' : '';
                        rupiahgtpnj += separatorgtpnj + ribuangtpnj.join('.');
                    }
                    html += '<tr>'+
                        '<td><input type="hidden" id="ipnj" class="ipnj'+i+'" name="ipnj[]" value="'+data[i].idp+'">'+data[i].code_product+'</td>'+
                        '<td>'+data[i].name+'</td>'+
                        '<td>'+data[i].nameu+'</td>'+
                        '<td style="text-align: center"><input type="number" class="form-control qpnj'+i+'" id="qpnj" name="qpnj[]" data-input-id="'+i+'" onkeyup="getqpnj(this)" onclick="setnolqpnj(this)" value="'+data[i].qtyp+'"><input type="hidden" id="vqpnj" class="vqpnj" name="vqpnj[]" value="'+data[i].quantity+'"></td>'+
                        '<td style="text-align: center"><input type="text" class="form-control hpnj'+i+'" id="hpnj" name="hpnj[]" data-input-id="'+i+'" onkeyup="gethpnj(this)" onclick="setnol(this)" value="'+rupiahpnj+'" autocomplete="off"></td>'+
                        '<td style="text-align: center"><input type="number" class="form-control dpnj'+i+'" id="dpnj" name="dpnj[]" data-input-id="'+i+'" onkeyup="getdpnj(this)" onclick="setnoldpnj(this)" value="'+data[i].disc+'"></td>'+
                        '<td style="text-align:center"><b><span class="gpnj'+i+'">'+rupiahgtpnj+'</span></b><input type="hidden" id="gtpnj" class="gtpnj'+i+'" value="'+harfix+'"></td>'+
                        '<td style="text-align:center"><a href="#" class="delprcpnj" data-id="/trs/pnj/delprc/'+data[i].idp+'"><span class="fa fa-trash"></span></a></td>'+
                    '</tr>';
                }
                var sum = sumharfix.reduce(function(sumharfix, b){return sumharfix + b;}, 0);
                var tpnjrp = sum;
                var numstrtpnj = tpnjrp.toString(), sisatpnj = numstrtpnj.length % 3, rupiahtpnj = numstrtpnj.substr(0, sisatpnj), ribuantpnj = numstrtpnj.substr(sisatpnj).match(/\d{3}/g);
                    if (ribuantpnj) {
                        separatortpnj = sisatpnj ? '.' : '';
                        rupiahtpnj += separatortpnj + ribuantpnj.join('.');
                    }
                $('#showdata').html(html);
                $('.ttlpnj').html(rupiahtpnj);
                $('.sttlpnj').val(sum.toFixed(0));
            }
        });
    }
    $('.smpnpnj').click(function(){
        $('input:checkbox').removeAttr('checked');
        $('.listbrg').modal('hide');
        tampildatapenjualan();

    });
    $(function(){
        $(document).on('click','.delprcpnj',function(e){
            e.preventDefault();
            var ud = $(this).attr('data-id');
            $.ajax({
                type: 'get',
                url: ud,
                data: {},
                success: function() {
                    tampildatapenjualan();
                }
            });
        });
    });
    $('.smpntpnj').click(function(){
        var vtgltmpo = $('.tgltmpo').val();
        var vtmpo = $('.tmpo').val();
        var vinvpnj = $('.invpnj').val();
        var vidcus = $('.idcus').val();
        var vidsls = $('.idsls').val();
        var vsttlpnj = $('.sttlpnj').val();
        var a = document.getElementById("idcus").value;
        var b = document.getElementById("idsls").value;
        if (a=="") {
            $(".elortpnj").html('Nama Customer Harus Diisi');
        }else if(b==""){
            $(".elortpnj").html('Nama Sales Harus Diisi');
        }else{
            $.ajax({
                url: '/trs/pnj/inspympnj',
                type: 'post',
                data: {tgltmpo: vtgltmpo, tmpo: vtmpo, invpnj: vinvpnj, idcus: vidcus, idsls: vidsls, sttlpnj: vsttlpnj},
                success: function(data){
                    var pnjform = document.pnjkform;
                    var pnjdataString = $(pnjform).serialize();
                    $.ajax({
                        url: '/trs/pnj/inspnj',
                        type: 'post',
                        data: pnjdataString,
                        success: function(data){
                            location.reload();
                        }
                    });
                }
            });
        }
    });
    $('.smpnprnttpnj').click(function(){
        var vtgltmpo = $('.tgltmpo').val();
        var vtmpo = $('.tmpo').val();
        var vinvpnj = $('.invpnj').val();
        var vidcus = $('.idcus').val();
        var vidsls = $('.idsls').val();
        var vsttlpnj = $('.sttlpnj').val();
        var a = document.getElementById("idcus").value;
        var b = document.getElementById("idsls").value;
        if (a=="") {
            $(".elortpnj").html('Nama Customer Harus Diisi');
        }else if(b==""){
            $(".elortpnj").html('Nama Sales Harus Diisi');
        }else{
            $.ajax({
                url: '/trs/pnj/inspympnj',
                type: 'post',
                data: {tgltmpo: vtgltmpo, tmpo: vtmpo, invpnj: vinvpnj, idcus: vidcus, idsls: vidsls, sttlpnj: vsttlpnj},
                success: function(data){
                    var pnjform = document.pnjkform;
                    var pnjdataString = $(pnjform).serialize();
                    $.ajax({
                        url: '/trs/pnj/inspnj',
                        type: 'post',
                        data: pnjdataString,
                        success: function(data){
                            window.open('/trs/pnj/inv');
                            location.reload();
                        }
                    });
                }
            });
        }
    });
    function tampildatapembelian(){
        $.ajax({
            type: 'GET',
            url: '/trs/pmb/data',
            async: true,
            dataType:'json',
            success : function(data){
                var html = '';
                var i;
                var jmlp;
                var disco;
                var har1;
                var harfix;
                var sumharfix = [];
                var o=[];
                for(i=0; i<data.length; i++){
                    jmlp = data[i].capital*data[i].qtyp;
                    disco = data[i].disc/100;
                    har1 = jmlp * disco;
                    harfix = jmlp - har1;
                    sumharfix.push(harfix);
                    o.push(i);
                    var hrgpmbrp = data[i].capital;
                    var numstrhpmb = hrgpmbrp.toString(), sisahpmb = numstrhpmb.length % 3, rupiahpmb = numstrhpmb.substr(0, sisahpmb), ribuanhpmb = numstrhpmb.substr(sisahpmb).match(/\d{3}/g);
                    if (ribuanhpmb) {
                        separatorhpmb = sisahpmb ? '.' : '';
                        rupiahpmb += separatorhpmb + ribuanhpmb.join('.');
                    }
                    var gtpmbrp = harfix;
                    var numstrgtpmb = gtpmbrp.toString(), sisagtpmb = numstrgtpmb.length % 3, rupiahgtpmb = numstrgtpmb.substr(0, sisagtpmb), ribuangtpmb = numstrgtpmb.substr(sisagtpmb).match(/\d{3}/g);
                    if (ribuangtpmb) {
                        separatorgtpmb = sisagtpmb ? '.' : '';
                        rupiahgtpmb += separatorgtpmb + ribuangtpmb.join('.');
                    }
                    html += '<tr>'+
                        '<td><input type="hidden" id="ipmb" class="ipmb'+i+'" name="ipmb[]" value="'+data[i].idp+'">'+data[i].code_product+'</td>'+
                        '<td>'+data[i].name+'</td>'+
                        '<td>'+data[i].nameu+'</td>'+
                        '<td style="text-align: center"><input type="number" class="form-control qpmb'+i+'" id="qpmb" name="qpmb[]" data-input-id="'+i+'" onkeyup="getqpmb(this)" onclick="setnolqpmb(this)" value="'+data[i].qtyp+'"></td>'+
                        '<td style="text-align: center"><input type="text" class="form-control hpmb'+i+'" id="hpmb" name="hpmb[]" data-input-id="'+i+'" onkeyup="gethpmb(this)" onclick="setnolhpmb(this)" value="'+rupiahpmb+'" autocomplete="off"></td>'+
                        '<td style="text-align: center"><input type="number" class="form-control dpmb'+i+'" id="dpmb" name="dpmb[]" data-input-id="'+i+'" onkeyup="getdpmb(this)" onclick="setnoldpmb(this)" value="'+data[i].disc+'"></td>'+
                        '<td style="text-align:center"><b><span class="gpmb'+i+'">'+rupiahgtpmb+'</span></b><input type="hidden" id="gtpmb" class="gtpmb'+i+'" value="'+harfix+'"></td>'+
                        '<td style="text-align:center"><a href="#" class="delprcpmb" data-id="/trs/pmb/delprc/'+data[i].id+'/'+data[i].qtyp+'"><span class="fa fa-trash"></span></a></td>'+
                    '</tr>';
                }
                var sum = sumharfix.reduce(function(sumharfix, b){return sumharfix + b;}, 0);
                var tpmbrp = sum;
                var numstrtpmb = tpmbrp.toString(), sisatpmb = numstrtpmb.length % 3, rupiahtpmb = numstrtpmb.substr(0, sisatpmb), ribuantpmb = numstrtpmb.substr(sisatpmb).match(/\d{3}/g);
                if (ribuantpmb) {
                    separatortpmb = sisatpmb ? '.' : '';
                    rupiahtpmb += separatortpmb + ribuantpmb.join('.');
                }
                $('#showdatapmb').html(html);
                $('.ttlpmb').html(rupiahtpmb);
                $('.sttlpmb').val(sum.toFixed(0));
            }
        });
    }
    $('.smpnpmb').click(function(){
        $('input:checkbox').removeAttr('checked');
        $('.listbrgpmb').modal('hide');
        tampildatapembelian();
    });
    $(function(){
        $(document).on('click','.delprcpmb',function(e){
            e.preventDefault();
            var ud = $(this).attr('data-id');
            $.ajax({
                type: 'get',
                url: ud,
                data: {},
                success: function() {
                    tampildatapembelian();
                }
            });
        });
    });
    $('.smpntpmb').click(function(){
        var vtmpopmb = $('.tmpopmb').val();
        var vtgltmpopmb = $('.tgltmpopmb').val();
        var vinvpmb = $('.invpmb').val();
        var vidsplpmb = $('.idsplpmb').val();
        var vsttlpmb = $('.sttlpmb').val();
        var a = document.getElementById("invpmb").value;
        var b = document.getElementById("idsplpmb").value;
        if (a=="") {
            $(".elortpmb").html('Invoice Harus Diisi');
        }else if(b==""){
            $(".elortpmb").html('Nama Supplier Harus Diisi');
        }else{
            $.ajax({
                url: '/trs/pmb/inspym',
                type: 'post',
                data: {tmpopmb: vtmpopmb, tgltmpopmb: vtgltmpopmb, invpmb: vinvpmb, idsplpmb: vidsplpmb, sttlpmb: vsttlpmb},
                success: function(data){
                    var pmbform = document.pmbkform;
                    var pmbdataString = $(pmbform).serialize();
                    $.ajax({
                        url: '/trs/pmb/inspmb',
                        type: 'post',
                        data: pmbdataString,
                        success: function(data){
                            location.reload();
                        }
                    });
                }
            });
        }
    });
    function tampildataepenjualan(){
        var idpym = $('.idpympnj').val();
        $.ajax({
            type: 'GET',
            url: '/hst/epnj/data/' + idpym,
            async: true,
            dataType:'json',
            success : function(data){
                var html = '';
                var i;
                var jmlp;
                var disco;
                var har1;
                var harfix;
                var sumharfix = [];
                for(i=0; i<data.length; i++){
                    jmlp = data[i].price*data[i].qtyp;
                    disco = data[i].disc/100;
                    har1 = jmlp * disco;
                    harfix = jmlp - har1;
                    sumharfix.push(harfix);
                    var hrghpnj = harfix.toFixed(0);
                    var numstrhpnj = hrghpnj.toString(), sisahpnj = numstrhpnj.length % 3, rupiahpnj = numstrhpnj.substr(0, sisahpnj), ribuanhpnj = numstrhpnj.substr(sisahpnj).match(/\d{3}/g);
                    if (ribuanhpnj) {
                        separatorhpnj = sisahpnj ? ',' : '';
                        rupiahpnj += separatorhpnj + ribuanhpnj.join(',');
                    }
                    var hrghpnj2 = data[i].price;
                    var numstrhpnj2 = hrghpnj2.toString(), sisahpnj2 = numstrhpnj2.length % 3, rupiahpnj2 = numstrhpnj2.substr(0, sisahpnj2), ribuanhpnj2 = numstrhpnj2.substr(sisahpnj2).match(/\d{3}/g);
                    if (ribuanhpnj2) {
                        separatorhpnj2 = sisahpnj2 ? ',' : '';
                        rupiahpnj2 += separatorhpnj2 + ribuanhpnj2.join(',');
                    }
                    html += '<tr>'+
                        '<td><input type="hidden" id="ihpnj" class="ihpnj" name="ihpnj[]" value="'+data[i].idb+'">'+data[i].code_product+'</td>'+
                        '<td>'+data[i].name+'</td>'+
                        '<td style="text-align: center">'+data[i].nameu+'</td>'+
                        '<td style="text-align: center"><input type="number" class="form-control qhpnj'+i+'" id="qhpnj" name="qhpnj[]" value="'+data[i].qtyp+'" readonly><input type="hidden" id="vqhpnj" class="vqhpnj" name="vqhpnj[]" value="'+data[i].qtyp+'"></td>'+
                        '<td style="text-align: center"><input type="text" class="form-control hhpnj'+i+'" id="hhpnj" name="hhpnj[]" value="'+rupiahpnj2+'" readonly></td>'+
                        '<td style="text-align: center"><input type="number" class="form-control dhpnj'+i+'" id="dhpnj" name="dhpnj[]" value="'+data[i].disc+'" readonly></td>'+
                        '<td style="text-align:center"><b><span class="ghpnj'+i+'">'+rupiahpnj+'</span></b><input type="hidden" id="gthpnj" class="gthpnj'+i+'"></td>'+
                        '<td style="text-align:center"><a href="#" class="edthpnj" data-id="/hst/epnj/edthpnj/'+idpym+'/'+data[i].idb+'"><span class="fa fa-edit"></span></a>'+
                        '<td style="text-align:center"><a href="#" class="delhpnj" data-id="/hst/epnj/delhpnj/'+idpym+'/'+data[i].idb+'"><span class="fa fa-trash"></span></a></td>'+
                    '</tr>';
                }
                var sum = sumharfix.reduce(function(sumharfix, b){return sumharfix + b;}, 0);
                var hrghpnj2 = sum.toFixed(0);
                var numstrhpnj2 = hrghpnj2.toString(), sisahpnj2 = numstrhpnj2.length % 3, rupiahpnj2 = numstrhpnj2.substr(0, sisahpnj2), ribuanhpnj2 = numstrhpnj2.substr(sisahpnj2).match(/\d{3}/g);
                if (ribuanhpnj2) {
                    separatorhpnj2 = sisahpnj2 ? ',' : '';
                    rupiahpnj2 += separatorhpnj2 + ribuanhpnj2.join(',');
                }
                $('.ttlhpnj').html(rupiahpnj2);
                $('.sttlhpnj').val(sum);
                $('#showdataepnj').html(html);
            }
        });
    }
    $('.smpnhpnj').click(function(){
        var formhpnj = document.brghstpnjform;
        var dataStringhpnj = $(formhpnj).serialize();
        $.ajax({
            url: '/hst/epnj/tmbprc2',
            type: 'post',
            data: dataStringhpnj,
            success: function(data){
                $('input:checkbox').removeAttr('checked');
                $('.listbrghstpnj').modal('hide');
                tampildataepenjualan();
            }
        });
    });
    $(function(){
        $(document).on('click','.edthpnj',function(e){
            e.preventDefault();
            var idml = $(this).attr('data-id');
            $(".medthpnj").modal('show');
            $(".modal-body").load(idml);
        });
    });
    $('.smpnmehpnj').click(function(){
        var formhpnj = document.mhpnjform;
        var dataStringhpnj = $(formhpnj).serialize();
        $.ajax({
            url: '/hst/epnj/edtmhpnj',
            type: 'post',
            data: dataStringhpnj,
            success: function(data){
                location.reload();
            }
        });
    });
    $(function(){
        $(document).on('click','.delhpnj',function(e){
            e.preventDefault();
            var ud = $(this).attr('data-id');
            $.ajax({
                type: 'get',
                url: ud,
                data: {},
                success: function() {
                    tampildataepenjualan();
                }
            });
        });
    });
    $('.smpnthpnj').click(function(){
        var vidpympnj = $('.idpympnj').val();
        var vsttlhpnj = $('.sttlhpnj').val();
        $.ajax({
            url: '/hst/epnj/inshtpnj',
            type: 'post',
            data: {idpympnj: vidpympnj, sttlhpnj: vsttlhpnj},
            success: function(data){
                location.reload();
            }
        });
    });
    $('.smpnprntthpnj').click(function(){
        var vidpympnj = $('.idpympnj').val();
        var vsttlhpnj = $('.sttlhpnj').val();
        $.ajax({
            url: '/hst/epnj/inshtpnj',
            type: 'post',
            data: {idpympnj: vidpympnj, sttlhpnj: vsttlhpnj},
            success: function(data){
                window.open('/hst/epnj/inv/'+vidpympnj);
                location.reload();
            }
        });
    });
    function tampildataepembelian(){
        var idpym = $('.idpympmb').val();
        $.ajax({
            type: 'GET',
            url: '/hst/epmb/data/'+idpym,
            async: true,
            dataType:'json',
            success : function(data){
                var html = '';
                var i;
                var jmlp;
                var dis;
                var dis2;
                var sumharfix = [];
                for(i=0; i<data.length; i++){
                    jmlp = data[i].capital*data[i].qtyp;
                    dis = (data[i].disc/100)*jmlp;
                    dis2 = jmlp-dis;
                    sumharfix.push(dis2);
                    var hrghpmb = dis2.toFixed(0);
                    var numstrhpmb = hrghpmb.toString(), sisahpmb = numstrhpmb.length % 3, rupiahpmb = numstrhpmb.substr(0, sisahpmb), ribuanhpmb = numstrhpmb.substr(sisahpmb).match(/\d{3}/g);
                    if (ribuanhpmb) {
                        separatorhpmb = sisahpmb ? ',' : '';
                        rupiahpmb += separatorhpmb + ribuanhpmb.join(',');
                    }
                    var hrgf = data[i].capital;
                    var numstrhpmb2 = hrgf.toString(), sisahpmb2 = numstrhpmb2.length % 3, rupiahpmb2 = numstrhpmb2.substr(0, sisahpmb2), ribuanhpmb2 = numstrhpmb2.substr(sisahpmb2).match(/\d{3}/g);
                    if (ribuanhpmb2) {
                        separatorhpmb2 = sisahpmb2 ? ',' : '';
                        rupiahpmb2 += separatorhpmb2 + ribuanhpmb2.join(',');
                    }
                    html += '<tr>'+
                        '<td><input type="hidden" id="ihpmb" class="ihpmb" name="ihpmb[]" value="'+data[i].idp+'">'+data[i].code_product+'</td>'+
                        '<td>'+data[i].name+'</td>'+
                        '<td style="text-align: center">'+data[i].nameu+'</td>'+
                        '<td style="text-align: center"><input type="number" class="form-control qhpmb'+i+'" id="qhpmb" name="qhpmb[]" value="'+data[i].qtyp+'" readonly></td>'+
                        '<td style="text-align: center"><input type="text" class="form-control hhpmb'+i+'" id="hhpmb" name="hhpmb[]" value="'+rupiahpmb2+'" readonly></td>'+
                        '<td style="text-align: center"><input type="number" class="form-control dhpmb'+i+'" id="dhpmb" name="dhpmb[]" value="'+data[i].disc+'" readonly></td>'+
                        '<td style="text-align:center"><b><span class="ghpmb'+i+'">'+rupiahpmb+'</span></b><input type="hidden" id="gthpmb" class="gthpmb'+i+'" value="'+dis2+'"></td>'+
                        '<td style="text-align:center"><a href="#" class="edthpmb" data-id="/hst/epmb/edthpmb/'+data[i].idp+'"><span class="fa fa-edit"></span></a></td>'+
                        '<td style="text-align:center"><a href="#" class="delhpmb" data-id="/hst/epmb/delhpmb/'+data[i].idp+'"><span class="fa fa-trash"></span></a></td>'+
                    '</tr>';
                }
                var sum = sumharfix.reduce(function(sumharfix, b){return sumharfix + b;}, 0);
                var hrghpmb2 = sum.toFixed(0);
                var numstrhpmb2 = hrghpmb2.toString(), sisahpmb2 = numstrhpmb2.length % 3, rupiahpmb2 = numstrhpmb2.substr(0, sisahpmb2), ribuanhpmb2 = numstrhpmb2.substr(sisahpmb2).match(/\d{3}/g);
                if (ribuanhpmb2) {
                    separatorhpmb2 = sisahpmb2 ? ',' : '';
                    rupiahpmb2 += separatorhpmb2 + ribuanhpmb2.join(',');
                }
                $('.ttlhpmb').html(rupiahpmb2);
                $('.sttlhpmb').val(sum);
                $('#showdatahpmb').html(html);
            }
        });
    }
    $('.smpnhstpmb').click(function(){
        var hpmbform = document.hstpmbform;
        var hpmbdataString = $(hpmbform).serialize();
        $.ajax({
            url: '/hst/epmb/tmbprc2',
            type: 'post',
            data: hpmbdataString,
            success: function(data){
                $('input:checkbox').removeAttr('checked');
                $('.listbrghstpmb').modal('hide');
                tampildataepembelian();
            }
        });
    });
    $(function(){
        $(document).on('click','.edthpmb',function(e){
            e.preventDefault();
            var idml = $(this).attr('data-id');
            $(".medthpmb").modal('show');
            $(".modal-body").load(idml);
        });
    });
    $('.smpnmehpmb').click(function(){
        var formhpnj = document.mhpmbform;
        var dataStringhpnj = $(formhpnj).serialize();
        $.ajax({
            url: '/hst/epmb/edtmhpmb',
            type: 'post',
            data: dataStringhpnj,
            success: function(data){
                location.reload();
            }
        });
    });
    $(function(){
        $(document).on('click','.delhpmb',function(e){
            e.preventDefault();
            var ud = $(this).attr('data-id');
            $.ajax({
                type: 'get',
                url: ud,
                data: {},
                success: function() {
                    tampildataepembelian();
                }
            });
        });
    });
    $('.smpnthstpmb').click(function(){
        var vidpympmb = $('.idpympmb').val();
        var vsttlhpmb = $('.sttlhpmb').val();
        $.ajax({
            url: '/hst/epmb/inshtpmb',
            type: 'post',
            data: {idpympmb: vidpympmb, sttlhpmb: vsttlhpmb},
            success: function(data){
                location.reload();
            }
        });
    });
    $('#tblic thead tr').clone(true).addClass('filters').appendTo('#tblic thead');
    var table = $('#tblic').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        buttons: ['csv'],
        columnDefs: [{targets: 5,render: $.fn.dataTable.render.number( ',', '.', 0, '' ),},],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns().eq(0).each(function (colIdx) {
                var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                $(cell).html('<input type="text"/>');
                $('input',$('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
                    e.stopPropagation();
                    $(this).attr('title', $(this).val());
                    var regexr = '({search})';
                    var cursorPosition = this.selectionStart;
                    api.column(colIdx).search(this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))'): '',this.value != '',this.value == '').draw();
                    $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                });
            });
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var numformat = $.fn.dataTable.render.number( ',', '.', 0, '' ).display;
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
            };
            total = api.column( 5 ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            pageTotal = api.column( 5, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            $( api.column( 5 ).footer() ).html(
                numformat(pageTotal) +' ('+ numformat(total) +' Total)'
            );
        }
    });
    $('#tblicdpnj thead tr').clone(true).addClass('filters').appendTo('#tblicdpnj thead');
    var table = $('#tblicdpnj').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        buttons: ['csv'],
        columnDefs: [{targets: 11,render: $.fn.dataTable.render.number( ',', '.', 0, '' ),},],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns().eq(0).each(function (colIdx) {
                var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                $(cell).html('<input type="text"/>');
                $('input',$('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
                    e.stopPropagation();
                    $(this).attr('title', $(this).val());
                    var regexr = '({search})';
                    var cursorPosition = this.selectionStart;
                    api.column(colIdx).search(this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))'): '',this.value != '',this.value == '').draw();
                    $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                });
            });
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var numformat = $.fn.dataTable.render.number( ',', '.', 0, '' ).display;
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
            };
            total = api.column( 11 ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            pageTotal = api.column( 11, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            $( api.column( 11 ).footer() ).html(
                numformat(pageTotal) +' ('+ numformat(total) +' Total)'
            );
        }
    });
    $('#tblicpmb thead tr').clone(true).addClass('filters').appendTo('#tblicpmb thead');
    var table = $('#tblicpmb').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        buttons: ['csv'],
        columnDefs: [{targets: 4,render: $.fn.dataTable.render.number( ',', '.', 0, '' ),},],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns().eq(0).each(function (colIdx) {
                var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                $(cell).html('<input type="text"/>');
                $('input',$('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
                    e.stopPropagation();
                    $(this).attr('title', $(this).val());
                    var regexr = '({search})';
                    var cursorPosition = this.selectionStart;
                    api.column(colIdx).search(this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))'): '',this.value != '',this.value == '').draw();
                    $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                });
            });
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var numformat = $.fn.dataTable.render.number( ',', '.', 0, '' ).display;
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
            };
            total = api.column( 4 ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            pageTotal = api.column( 4, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            $( api.column( 4 ).footer() ).html(
                numformat(pageTotal) +' ('+ numformat(total) +' Total)'
            );
        }
    });
    $('#tblicdpmb thead tr').clone(true).addClass('filters').appendTo('#tblicdpmb thead');
    var table = $('#tblicdpmb').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        buttons: ['csv'],
        columnDefs: [{targets: 10,render: $.fn.dataTable.render.number( ',', '.', 0, '' ),},],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns().eq(0).each(function (colIdx) {
                var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                $(cell).html('<input type="text"/>');
                $('input',$('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
                    e.stopPropagation();
                    $(this).attr('title', $(this).val());
                    var regexr = '({search})';
                    var cursorPosition = this.selectionStart;
                    api.column(colIdx).search(this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))'): '',this.value != '',this.value == '').draw();
                    $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                });
            });
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var numformat = $.fn.dataTable.render.number( ',', '.', 0, '' ).display;
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
            };
            total = api.column( 10 ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            pageTotal = api.column( 10, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            $( api.column( 10 ).footer() ).html(
                numformat(pageTotal) +' ('+ numformat(total) +' Total)'
            );
        }
    });
    $('#tblicrpnj thead tr').clone(true).addClass('filters').appendTo('#tblicrpnj thead');
    var table = $('#tblicrpnj').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        buttons: ['csv'],
        columnDefs: [{targets: 5,render: $.fn.dataTable.render.number( ',', '.', 0, '' ),},],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns().eq(0).each(function (colIdx) {
                var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                $(cell).html('<input type="text"/>');
                $('input',$('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
                    e.stopPropagation();
                    $(this).attr('title', $(this).val());
                    var regexr = '({search})';
                    var cursorPosition = this.selectionStart;
                    api.column(colIdx).search(this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))'): '',this.value != '',this.value == '').draw();
                    $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                });
            });
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var numformat = $.fn.dataTable.render.number( ',', '.', 0, '' ).display;
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
            };
            total = api.column( 5 ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            pageTotal = api.column( 5, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            $( api.column( 5 ).footer() ).html(
                numformat(pageTotal) +' ('+ numformat(total) +' Total)'
            );
        }
    });
    $('#tblicrpmb thead tr').clone(true).addClass('filters').appendTo('#tblicrpmb thead');
    var table = $('#tblicrpmb').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        buttons: ['csv'],
        columnDefs: [{targets: 4,render: $.fn.dataTable.render.number( ',', '.', 0, '' ),},],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns().eq(0).each(function (colIdx) {
                var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                $(cell).html('<input type="text"/>');
                $('input',$('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
                    e.stopPropagation();
                    $(this).attr('title', $(this).val());
                    var regexr = '({search})';
                    var cursorPosition = this.selectionStart;
                    api.column(colIdx).search(this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))'): '',this.value != '',this.value == '').draw();
                    $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                });
            });
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var numformat = $.fn.dataTable.render.number( ',', '.', 0, '' ).display;
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
            };
            total = api.column( 4 ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            pageTotal = api.column( 4, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            $( api.column( 4 ).footer() ).html(
                numformat(pageTotal) +' ('+ numformat(total) +' Total)'
            );
        }
    });
    $('#tblicspl thead tr').clone(true).addClass('filters').appendTo('#tblicspl thead');
    var table = $('#tblicspl').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        buttons: ['csv'],
        columnDefs: [{targets: 9,render: $.fn.dataTable.render.number( ',', '.', 0, '' ),},],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns().eq(0).each(function (colIdx) {
                var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                $(cell).html('<input type="text"/>');
                $('input',$('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
                    e.stopPropagation();
                    $(this).attr('title', $(this).val());
                    var regexr = '({search})';
                    var cursorPosition = this.selectionStart;
                    api.column(colIdx).search(this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))'): '',this.value != '',this.value == '').draw();
                    $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                });
            });
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var numformat = $.fn.dataTable.render.number( ',', '.', 0, '' ).display;
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
            };
            total = api.column( 9 ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            pageTotal = api.column( 9, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            $( api.column( 9 ).footer() ).html(
                numformat(pageTotal) +' ('+ numformat(total) +' Total)'
            );
        }
    });
    $('#tbliccus thead tr').clone(true).addClass('filters').appendTo('#tbliccus thead');
    var table = $('#tbliccus').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        buttons: ['csv'],
        columnDefs: [{targets: 9,render: $.fn.dataTable.render.number( ',', '.', 0, '' ),},],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns().eq(0).each(function (colIdx) {
                var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                $(cell).html('<input type="text"/>');
                $('input',$('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
                    e.stopPropagation();
                    $(this).attr('title', $(this).val());
                    var regexr = '({search})';
                    var cursorPosition = this.selectionStart;
                    api.column(colIdx).search(this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))'): '',this.value != '',this.value == '').draw();
                    $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                });
            });
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var numformat = $.fn.dataTable.render.number( ',', '.', 0, '' ).display;
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
            };
            total = api.column( 9 ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            pageTotal = api.column( 9, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            $( api.column( 9 ).footer() ).html(
                numformat(pageTotal) +' ('+ numformat(total) +' Total)'
            );
        }
    });
    $('#tblicbrgpnj thead tr').clone(true).addClass('filters').appendTo('#tblicbrgpnj thead');
    var table = $('#tblicbrgpnj').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        buttons: ['csv'],
        columnDefs: [{targets: 10,render: $.fn.dataTable.render.number( ',', '.', 0, '' ),},],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns().eq(0).each(function (colIdx) {
                var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                $(cell).html('<input type="text"/>');
                $('input',$('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
                    e.stopPropagation();
                    $(this).attr('title', $(this).val());
                    var regexr = '({search})';
                    var cursorPosition = this.selectionStart;
                    api.column(colIdx).search(this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))'): '',this.value != '',this.value == '').draw();
                    $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                });
            });
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var numformat = $.fn.dataTable.render.number( ',', '.', 0, '' ).display;
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
            };
            total = api.column( 10 ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            pageTotal = api.column( 10, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            $( api.column( 10 ).footer() ).html(
                numformat(pageTotal) +' ('+ numformat(total) +' Total)'
            );
        }
    });
    $('#tblrptpnj thead tr').clone(true).addClass('filters').appendTo('#tblrptpnj thead');
    var table = $('#tblrptpnj').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        buttons: ['csv'],
        columnDefs: [
            {targets: 10,render: $.fn.dataTable.render.number( ',', '.', 0, '' ),},
            {targets: 11,render: $.fn.dataTable.render.number( ',', '.', 0, '' ),},
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns().eq(0).each(function (colIdx) {
                var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                $(cell).html('<input type="text"/>');
                $('input',$('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
                    e.stopPropagation();
                    $(this).attr('title', $(this).val());
                    var regexr = '({search})';
                    var cursorPosition = this.selectionStart;
                    api.column(colIdx).search(this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))'): '',this.value != '',this.value == '').draw();
                    $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                });
            });
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var numformat = $.fn.dataTable.render.number( ',', '.', 0, '' ).display;
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
            };
            total = api.column( 10 ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            pageTotal = api.column( 10, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            total2 = api.column( 11 ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            pageTotal2 = api.column( 11, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            $( api.column( 5 ).footer() ).html(
                numformat(pageTotal) +' ('+ numformat(total) +' Total)'
            );
            $( api.column( 10 ).footer() ).html(
                numformat(pageTotal2) +' ('+ numformat(total2) +' Total)'
            );
        }
    });

});
function getqpmb(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipmb = $('.ipmb'+inputId).val();
    var hpnj = $('.hpmb'+inputId).val();
    var dpnj = $('.dpmb'+inputId).val();
    var val2 = hpnj.replace(/[^,\d]/g, '').toString();
    if (val=='') {
        var qf = 0;
    }else{
        var qf = val;
    }
    if (val2=='') {
        var hf = 0;
    }else{
        var hf = val2;
    }
    if (dpnj=='') {
        var df = 0;
    }else{
        var df = dpnj;
    }
    var jml = parseInt(qf) * parseInt(hf);
    var dis = parseInt(df)/100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(), sisa = numstr.length % 3, rupiah = numstr.substr(0, sisa), ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? ',' : '';
        rupiah += separator + ribuan.join(',');
    }
    $('.gpmb'+inputId).html(rupiah);
    $('.gtpmb'+inputId).val(hrg);
    var sum=0;
    $("#tbpnj tr").each(function(){
        $(this).find('input[id="gtpmb"]').each(function(){
            if (!isNaN(this.value)&&this.value.length!=0) {
                sum+=parseInt(this.value);
            }
        });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(), sisa2 = numstr2.length % 3, rupiah2 = numstr2.substr(0, sisa2), ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? ',' : '';
        rupiah2 += separator2 + ribuan2.join(',');
    }
    $('.ttlpmb').html(rupiah2);
    $('.sttlpmb').val(sum.toFixed(0));
    $.ajax({
        url: '/trs/pmb/qtypmb',
        type: 'post',
        data: {id:ipmb, qty:qf},
        success: function(data){

        }
    })
}
function gethpmb(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    var val2 = val.replace(/[^,\d]/g, '').toString();
    var ipmb = $('.ipmb'+inputId).val();
    var qpnj = $('.qpmb'+inputId).val();
    var dpnj = $('.dpmb'+inputId).val();
    if (qpnj=='') {
        var qf = 0;
    }else{
        var qf = qpnj;
    }
    if (val2=='') {
        var hf = 0;
    }else{
        var hf = val2;
    }
    if (dpnj=='') {
        var df = 0;
    }else{
        var df = dpnj;
    }
    var jml = parseInt(hf) * parseInt(qf);
    var dis = parseInt(df)/100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(), sisa = numstr.length % 3, rupiah = numstr.substr(0, sisa), ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? ',' : '';
        rupiah += separator + ribuan.join(',');
    }
    $('.gpmb'+inputId).html(rupiah);
    $('.gtpmb'+inputId).val(hrg);
    var sum=0;
    $("#tbpnj tr").each(function(){
        $(this).find('input[id="gtpmb"]').each(function(){
            if (!isNaN(this.value)&&this.value.length!=0) {
                sum+=parseInt(this.value);
            }
        });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(), sisa2 = numstr2.length % 3, rupiah2 = numstr2.substr(0, sisa2), ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? ',' : '';
        rupiah2 += separator2 + ribuan2.join(',');
    }
    $('.ttlpmb').html(rupiah2);
    $('.sttlpmb').val(sum.toFixed(0));
    $('.hpmb'+inputId).val(formatRupiahx(val));
    $.ajax({
        url: '/trs/pmb/hrgpmb',
        type: 'post',
        data: {id:ipmb, hrg:hf},
        success: function(data){

        }
    })
}
function getdpmb(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipmb = $('.ipmb'+inputId).val();
    var qpnj = $('.qpmb'+inputId).val();
    var hpnj = $('.hpmb'+inputId).val();
    var val2 = hpnj.replace(/[^,\d]/g, '').toString();
    if (qpnj=='') {
        var qf = 0;
    }else{
        var qf = qpnj;
    }
    if (val2=='') {
        var hf = 0;
    }else{
        var hf = val2;
    }
    if (val=='') {
        var df = 0;
    }else{
        var df = val;
    }
    var jml = parseInt(hf) * parseInt(qf);
    var dis = parseInt(df)/100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(), sisa = numstr.length % 3, rupiah = numstr.substr(0, sisa), ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? ',' : '';
        rupiah += separator + ribuan.join(',');
    }
    $('.gpmb'+inputId).html(rupiah);
    $('.gtpmb'+inputId).val(hrg);
    var sum=0;
    $("#tbpnj tr").each(function(){
        $(this).find('input[id="gtpmb"]').each(function(){
            if (!isNaN(this.value)&&this.value.length!=0) {
                sum+=parseInt(this.value);
            }
        });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(), sisa2 = numstr2.length % 3, rupiah2 = numstr2.substr(0, sisa2), ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? ',' : '';
        rupiah2 += separator2 + ribuan2.join(',');
    }
    $('.ttlpmb').html(rupiah2);
    $('.sttlpmb').val(sum.toFixed(0));
    $.ajax({
        url: '/trs/pmb/dispmb',
        type: 'post',
        data: {id:ipmb, dis:df},
        success: function(data){

        }
    })
}
function getbpmb(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipmb = $('.ipmb'+inputId).val();
    $.ajax({
        url: '/trs/pmb/brtpmb',
        type: 'post',
        data: {id:ipmb, brt:val},
        success: function(data){

        }
    })
}
function getqpnj(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipnj = $('.ipnj'+inputId).val();
    var hpnj = $('.hpnj'+inputId).val();
    var dpnj = $('.dpnj'+inputId).val();
    var val2 = hpnj.replace(/[^,\d]/g, '').toString();
    if (val=='') {
        var qf = 0;
    }else{
        var qf = val;
    }
    if (val2=='') {
        var hf = 0;
    }else{
        var hf = val2;
    }
    if (dpnj=='') {
        var df = 0;
    }else{
        var df = dpnj;
    }
    var jml = parseInt(qf) * parseInt(hf);
    var dis = parseInt(df)/100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(), sisa = numstr.length % 3, rupiah = numstr.substr(0, sisa), ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? ',' : '';
        rupiah += separator + ribuan.join(',');
    }
    $('.gpnj'+inputId).html(rupiah);
    $('.gtpnj'+inputId).val(hrg);
    var sum=0;
    $("#tblpnj tr").each(function(){
        $(this).find('input[id="gtpnj"]').each(function(){
            if (!isNaN(this.value)&&this.value.length!=0) {
                sum+=parseInt(this.value);
            }
        });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(), sisa2 = numstr2.length % 3, rupiah2 = numstr2.substr(0, sisa2), ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? ',' : '';
        rupiah2 += separator2 + ribuan2.join(',');
    }

    $('.ttlpnj').html(rupiah2);
    $('.sttlpnj').val(sum.toFixed(0));
    $.ajax({
        url: '/trs/pnj/qtypnj',
        type: 'post',
        data: {id:ipnj, qty:qf},
        success: function(data){

        }
    })
}
function gethpnj(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipnj = $('.ipnj'+inputId).val();
    var qpnj = $('.qpnj'+inputId).val();
    var dpnj = $('.dpnj'+inputId).val();
    var val2 = val.replace(/[^,\d]/g, '').toString();
    if (qpnj=='') {
        var qf = 0;
    }else{
        var qf = qpnj;
    }
    if (val2=='') {
        var hf = 0;
    }else{
        var hf = val2;
    }
    if (dpnj=='') {
        var df = 0;
    }else{
        var df = dpnj;
    }
    var jml = parseInt(hf) * parseInt(qf);
    var dis = parseInt(df)/100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(), sisa = numstr.length % 3, rupiah = numstr.substr(0, sisa), ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? ',' : '';
        rupiah += separator + ribuan.join(',');
    }
    $('.gpnj'+inputId).html(rupiah);
    $('.gtpnj'+inputId).val(hrg);
    var sum=0;
    $("#tblpnj tr").each(function(){
        $(this).find('input[id="gtpnj"]').each(function(){
            if (!isNaN(this.value)&&this.value.length!=0) {
                sum+=parseInt(this.value);
            }
        });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(), sisa2 = numstr2.length % 3, rupiah2 = numstr2.substr(0, sisa2), ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? ',' : '';
        rupiah2 += separator2 + ribuan2.join(',');
    }

    $('.ttlpnj').html(rupiah2);
    $('.sttlpnj').val(sum.toFixed(0));
    $('.hpnj'+inputId).val(formatRupiahx(val));
    $.ajax({
        url: '/trs/pnj/hrgpnj',
        type: 'post',
        data: {id:ipnj, hrg:hf},
        success: function(data){

        }
    })
}
function getdpnj(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipnj = $('.ipnj'+inputId).val();
    var qpnj = $('.qpnj'+inputId).val();
    var hpnj = $('.hpnj'+inputId).val();
    var val2 = hpnj.replace(/[^,\d]/g, '').toString();
    if (qpnj=='') {
        var qf = 0;
    }else{
        var qf = qpnj;
    }
    if (val2=='') {
        var hf = 0;
    }else{
        var hf = val2;
    }
    if (val=='') {
        var df = 0;
    }else{
        var df = val;
    }
    var jml = parseInt(hf) * parseInt(qf);
    var dis = parseInt(df)/100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(), sisa = numstr.length % 3, rupiah = numstr.substr(0, sisa), ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? ',' : '';
        rupiah += separator + ribuan.join(',');
    }
    $('.gpnj'+inputId).html(rupiah);
    $('.gtpnj'+inputId).val(hrg);
    var sum=0;
    $("#tblpnj tr").each(function(){
        $(this).find('input[id="gtpnj"]').each(function(){
            if (!isNaN(this.value)&&this.value.length!=0) {
                sum+=parseInt(this.value);
            }
        });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(), sisa2 = numstr2.length % 3, rupiah2 = numstr2.substr(0, sisa2), ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? ',' : '';
        rupiah2 += separator2 + ribuan2.join(',');
    }

    $('.ttlpnj').html(rupiah2);
    $('.sttlpnj').val(sum.toFixed(0));
    $.ajax({
        url: '/trs/pnj/dispnj',
        type: 'post',
        data: {id:ipnj, dis:df},
        success: function(data){

        }
    })
}
function insbrgpnj(element){
    const inputId = element.dataset.inputId;
    $.ajax({
        url: '/trs/pnj/tmbprc',
        type: 'post',
        data: { checked : inputId},
        success: function(data){

        }
    })
}
function insbrgpmb(element){
    const inputId = element.dataset.inputId;
    $.ajax({
        url: '/trs/pmb/tmbprc',
        type: 'post',
        data: { checked : inputId},
        success: function(data){

        }
    })
}
function insbrghpnj(element){
    const inputId = element.dataset.inputId;
    var idpym = $('.idpympnj').val();
    $.ajax({
        url: '/hst/epnj/tmbprc',
        type: 'post',
        data: { checked : inputId, idpym : idpym },
        success: function(data){

        }
    })
}
function insbrghpmb(element){
    const inputId = element.dataset.inputId;
    var idpym = $('.idpympmb').val();
    $.ajax({
        url: '/hst/epmb/tmbprc',
        type: 'post',
        data: { checked : inputId, idpym : idpym },
        success: function(data){

        }
    })
}
function hpmbrf(element){
    const val = element.value;
    $('.mhjbpmb').val(formatRupiahx(val));
}
function setnolqpmb(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val==0) {
        var h = '';
    }else{
        var h = val;
    }
    $('.qpmb'+inputId).val(h);
}
function setnolhpmb(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val==0) {
        var h = '';
    }else{
        var h = val;
    }
    $('.hpmb'+inputId).val(formatRupiahx(h));
}
function setnoldpmb(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val==0) {
        var h = '';
    }else{
        var h = val;
    }
    $('.dpmb'+inputId).val(h);
}
function setnolqpnj(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val==0) {
        var h = '';
    }else{
        var h = val;
    }
    $('.qpnj'+inputId).val(h);
}
function setnol(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val==0) {
        var h = '';
    }else{
        var h = val;
    }
    $('.hpnj'+inputId).val(formatRupiahx(h));
}
function setnoldpnj(element){
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val==0) {
        var h = '';
    }else{
        var h = val;
    }
    $('.dpnj'+inputId).val(h);
}
function hpnjrf(element){
    const val = element.value;
    $('.mhjhpnj').val(formatRupiahx(val));
}
function formatRupiahx(angkax, prefixx){

    var number_string3 = angkax.replace(/[^,\d]/g, '').toString(),
            split3           = number_string3.split(','),
            sisa3            = split3[0].length % 3,
            rupiah3          = split3[0].substr(0, sisa3),
            ribuan3          = split3[0].substr(sisa3).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan3){
                separator3 = sisa3 ? '.' : '';
                rupiah3 += separator3 + ribuan3.join('.');
            }

            rupiah3 = split3[1] != undefined ? rupiah3 + ',' + split3[1] : rupiah3;
            return prefixx == undefined ? rupiah3 : (rupiah3 ? rupiah3 : '');
        }
