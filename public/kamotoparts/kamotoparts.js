$(".tanggal").datepicker({
    format: "dd-mm-yyyy",
    autoclose: true,
});
$(".dtlbtp").dataTable({
    bPaginate: true,
    bLengthChange: false,
    lengthMenu: [
        [10, 15, 25, 50, 100, -1],
        [10, 15, 25, 50, 100, "All"],
    ],
    iDisplayLength: 10,
    bInfo: false,
    responsive: true,
    bAutoWidth: false,
    ordering: false,
});
$("#datatable").DataTable({
    bPaginate: false,
    bInfo: false,
    ordering: false,
});
$("#datatablebtn").DataTable({
    bPaginate: false,
    bInfo: false,
    ordering: false,
    dom: "Bfrtip",
    buttons: ["excel"],
});
$("#datatablebtnpsd").DataTable({
    bPaginate: false,
    bInfo: false,
    ordering: false,
    dom: "Bfrtip",
    buttons: ["excel"],
    columnDefs: [
        { targets: 6, render: $.fn.dataTable.render.number(",", ".", 0, "") },
        { targets: 7, render: $.fn.dataTable.render.number(",", ".", 0, "") },
    ],
});
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function nol(n) {
    if (n <= 9) {
        return "0" + n;
    }
    return n;
}
function tempo() {
    var hari = $(".tmpo").val();
    var tgltmpo = new Date(new Date().getTime() + hari * 24 * 60 * 60 * 1000);
    let format =
        nol(tgltmpo.getDate()) +
        "-" +
        nol(tgltmpo.getMonth() + 1) +
        "-" +
        tgltmpo.getFullYear();
    $(".tgltmpo").val(format);
}
function tempopmb() {
    var hari = $(".tmpopmb").val();
    var tgltmpo = new Date(new Date().getTime() + hari * 24 * 60 * 60 * 1000);
    let format =
        nol(tgltmpo.getDate()) +
        "-" +
        nol(tgltmpo.getMonth() + 1) +
        "-" +
        tgltmpo.getFullYear();
    $(".tgltmpopmb").val(format);
}
function htempo() {
    var hari = $(".htmpo").val();
    var tgl1 = $(".hstglpnj1").val();
    var tgltmpo = new Date(
        new Date(tgl1).getTime() + hari * 24 * 60 * 60 * 1000
    );
    let format =
        nol(tgltmpo.getDate()) +
        "-" +
        nol(tgltmpo.getMonth() + 1) +
        "-" +
        tgltmpo.getFullYear();
    $(".htgltmpo").val(format);
}
function htempopmb() {
    var hari = $(".htmpopmb").val();
    var tgl1 = $(".hstglpmb1").val();
    var tgltmpo = new Date(
        new Date(tgl1).getTime() + hari * 24 * 60 * 60 * 1000
    );
    let format =
        nol(tgltmpo.getDate()) +
        "-" +
        nol(tgltmpo.getMonth() + 1) +
        "-" +
        tgltmpo.getFullYear();
    $(".htgltmpopmb").val(format);
}
$(document).ready(function () {
    tampildatapenjualan();
    tampildatapembelian();
    tampildataepenjualan();
    tampildataepembelian();
    $(".smpnbrg").click(function () {
        $("#smpnbrg").attr("disabled", true);
        var form = document.brgform;
        var dataString = $(form).serialize();
        var a = document.getElementById("kode").value;
        var b = document.getElementById("nama").value;
        if (a == "") {
            $("#elorbrg").html("Kode Harus Diisi");
            $("#smpnbrg").attr("disabled", false);
        } else if (b == "") {
            $("#elorbrg").html("Nama Harus Diisi");
            $("#smpnbrg").attr("disabled", false);
        } else {
            $.ajax({
                url: "/brg/tmb",
                type: "post",
                data: dataString,
                success: function (data) {
                    if (data.info == 0) {
                        location.reload();
                    } else {
                        $("#elorbrg").html("Data Sudah Ada");
                        $("#smpnbrg").attr("disabled", false);
                    }
                },
            });
        }
    });
    $(".smpnunt").click(function () {
        $("#smpnunt").attr("disabled", true);
        var form = document.untform;
        var dataString = $(form).serialize();
        var a = document.getElementById("nameunt").value;
        if (a == "") {
            $("#elorunt").html("Nama Harus Diisi");
            $("#smpnunt").attr("disabled", false);
        } else {
            $.ajax({
                url: "/brg/sat/tmb",
                type: "post",
                data: dataString,
                success: function (data) {
                    if (data.info == 0) {
                        location.reload();
                    } else {
                        $("#elorunt").html("Data Sudah Ada");
                        $("#smpnunt").attr("disabled", false);
                    }
                },
            });
        }
    });
    $(".smpnspl").click(function () {
        $("#smpnspl").attr("disabled", true);
        var form = document.splform;
        var dataString = $(form).serialize();
        var a = document.getElementById("idspl").value;
        var b = document.getElementById("namaspl").value;
        var c = document.getElementById("alamatspl").value;
        if (a == "") {
            $("#elorspl").html("Kode Harus Diisi");
            $("#smpnspl").attr("disabled", false);
        } else if (b == "") {
            $("#elorspl").html("Nama Harus Diisi");
            $("#smpnspl").attr("disabled", false);
        } else if (c == "") {
            $("#elorspl").html("Alamat Harus Diisi");
            $("#smpnspl").attr("disabled", false);
        } else {
            $.ajax({
                url: "/spl/tmb",
                type: "post",
                data: dataString,
                success: function (data) {
                    if (data.info == 0) {
                        location.reload();
                    } else {
                        $("#elorspl").html("Data Sudah Ada");
                        $("#smpnspl").attr("disabled", false);
                    }
                },
            });
        }
    });
    $(".smpncus").click(function () {
        $("#smpncus").attr("disabled", true);
        var form = document.cusform;
        var dataString = $(form).serialize();
        var a = document.getElementById("idcus").value;
        var b = document.getElementById("namacus").value;
        var c = document.getElementById("alamatcus").value;
        if (a == "") {
            $("#elorcus").html("Kode Harus Diisi");
            $("#smpncus").attr("disabled", false);
        } else if (b == "") {
            $("#elorcus").html("Nama Harus Diisi");
            $("#smpncus").attr("disabled", false);
        } else if (c == "") {
            $("#elorcus").html("Alamat Harus Diisi");
            $("#smpncus").attr("disabled", false);
        } else {
            $.ajax({
                url: "/cus/tmb",
                type: "post",
                data: dataString,
                success: function (data) {
                    if (data.info == 0) {
                        location.reload();
                    } else {
                        $("#elorcus").html("Data Sudah Ada");
                        $("#smpncus").attr("disabled", false);
                    }
                },
            });
        }
    });
    $(".smpnsls").click(function () {
        $("#smpnsls").attr("disabled", true);
        var form = document.slsform;
        var dataString = $(form).serialize();
        var a = document.getElementById("idsls").value;
        var b = document.getElementById("namasls").value;
        if (a == "") {
            $("#elorsls").html("Kode Harus Diisi");
            $("#smpnsls").attr("disabled", false);
        } else if (b == "") {
            $("#elorsls").html("Nama Harus Diisi");
            $("#smpnsls").attr("disabled", false);
        } else {
            $.ajax({
                url: "/sls/tmb",
                type: "post",
                data: dataString,
                success: function (data) {
                    if (data.info == 0) {
                        location.reload();
                    } else {
                        $("#elorsls").html("Data Sudah Ada");
                        $("#smpnsls").attr("disabled", false);
                    }
                },
            });
        }
    });
    function tampildatapenjualan() {
        $.ajax({
            type: "GET",
            url: "/trs/pnj/data",
            async: true,
            dataType: "json",
            success: function (data) {
                var html = "";
                var i;
                var jmlp;
                var disco;
                var har1;
                var harfix;
                var sumharfix = [];
                for (i = 0; i < data.length; i++) {
                    jmlp = data[i].price * data[i].qtyp;
                    disco = data[i].disc / 100;
                    har1 = jmlp * disco;
                    harfix = jmlp - har1;
                    sumharfix.push(harfix);
                    var no = i + 1;
                    var hrgpnjrp = data[i].price;
                    var numstrhpnj = hrgpnjrp.toString(),
                        sisahpnj = numstrhpnj.length % 3,
                        rupiahpnj = numstrhpnj.substr(0, sisahpnj),
                        ribuanhpnj = numstrhpnj
                            .substr(sisahpnj)
                            .match(/\d{3}/g);
                    if (ribuanhpnj) {
                        separatorhpnj = sisahpnj ? "." : "";
                        rupiahpnj += separatorhpnj + ribuanhpnj.join(".");
                    }
                    var gtpnjrp = harfix;
                    var numstrgtpnj = gtpnjrp.toString(),
                        sisagtpnj = numstrgtpnj.length % 3,
                        rupiahgtpnj = numstrgtpnj.substr(0, sisagtpnj),
                        ribuangtpnj = numstrgtpnj
                            .substr(sisagtpnj)
                            .match(/\d{3}/g);
                    if (ribuangtpnj) {
                        separatorgtpnj = sisagtpnj ? "." : "";
                        rupiahgtpnj += separatorgtpnj + ribuangtpnj.join(".");
                    }
                    html +=
                        "<tr>" +
                        '<td style="text-align: center"><a href="#" class="hrgmpnj" data-id="/trs/pnj/hrgmpnj/' +
                        data[i].idp +
                        "/" +
                        data[i].idb +
                        '/">' +
                        no +
                        "</a></td>" +
                        '<td><input type="hidden" id="ipnj" class="ipnj' +
                        i +
                        '" name="ipnj[]" value="' +
                        data[i].idp +
                        '"><a href="#" class="hrgmpnj" data-id="/trs/pnj/hrgmpnj/' +
                        data[i].idp +
                        "/" +
                        data[i].idb +
                        '/">' +
                        data[i].code_product +
                        "</a></td>" +
                        '<td><a href="#" class="hrgmpnj" data-id="/trs/pnj/hrgmpnj/' +
                        data[i].idp +
                        "/" +
                        data[i].idb +
                        '/">' +
                        data[i].name +
                        "</a></td>" +
                        '<td><a href="#" class="hrgmpnj" data-id="/trs/pnj/hrgmpnj/' +
                        data[i].idp +
                        "/" +
                        data[i].idb +
                        '/">' +
                        data[i].nameu +
                        "</a></td>" +
                        '<td style="text-align: center"><input type="number" class="form-control qpnj' +
                        i +
                        '" id="qpnj" name="qpnj[]" data-input-id="' +
                        i +
                        '" onkeyup="getqpnj(this)" onclick="setnolqpnj(this)" value="' +
                        data[i].qtyp +
                        '"><input type="hidden" id="vqpnj" class="vqpnj" name="vqpnj[]" value="' +
                        data[i].quantity +
                        '"></td>' +
                        '<td style="text-align: center"><input type="text" class="form-control hpnj' +
                        i +
                        '" id="hpnj" name="hpnj[]" data-input-id="' +
                        i +
                        '" onkeyup="gethpnj(this)" onclick="setnol(this)" value="' +
                        rupiahpnj +
                        '" autocomplete="off"></td>' +
                        '<td style="text-align: center"><input type="number" class="form-control dpnj' +
                        i +
                        '" id="dpnj" name="dpnj[]" data-input-id="' +
                        i +
                        '" onkeyup="getdpnj(this)" onclick="setnoldpnj(this)" value="' +
                        data[i].disc +
                        '"></td>' +
                        '<td style="text-align:center"><b><span class="gpnj' +
                        i +
                        '">' +
                        rupiahgtpnj +
                        '</span></b><input type="hidden" id="gtpnj" class="gtpnj' +
                        i +
                        '" value="' +
                        harfix +
                        '"></td>' +
                        '<td style="text-align:center"><a href="#" class="delprcpnj" data-id="/trs/pnj/delprc/' +
                        data[i].idp +
                        '"><span class="fa fa-trash"></span></a></td>' +
                        "</tr>";
                }
                var sum = sumharfix.reduce(function (sumharfix, b) {
                    return sumharfix + b;
                }, 0);
                var tpnjrp = sum;
                var numstrtpnj = tpnjrp.toString(),
                    sisatpnj = numstrtpnj.length % 3,
                    rupiahtpnj = numstrtpnj.substr(0, sisatpnj),
                    ribuantpnj = numstrtpnj.substr(sisatpnj).match(/\d{3}/g);
                if (ribuantpnj) {
                    separatortpnj = sisatpnj ? "." : "";
                    rupiahtpnj += separatortpnj + ribuantpnj.join(".");
                }
                $("#showdata").html(html);
                $(".ttlpnj").html(rupiahtpnj);
                $(".sttlpnj").val(sum.toFixed(0));
            },
        });
    }
    $(".namebrgpnj").change(function () {
        tampildatapenjualan();
        $(this).val("");
    });
    $(function () {
        $(document).on("click", ".hrgmpnj", function (e) {
            e.preventDefault();
            var idcus = $(".idcus").val();
            var idml = $(this).attr("data-id") + idcus;
            $(".hrgmdlpnj").modal("show");
            $(".modal-body").load(idml);
        });
    });
    $(function () {
        $(document).on("click", ".edthrgmpnj", function (e) {
            e.preventDefault();
            var ud = $(this).attr("data-id");
            $.ajax({
                type: "get",
                url: ud,
                data: {},
                success: function () {
                    $(".hrgmdlpnj").modal("hide");
                    tampildatapenjualan();
                },
            });
        });
    });
    $(function () {
        $(document).on("click", ".delprcpnj", function (e) {
            e.preventDefault();
            var ud = $(this).attr("data-id");
            $.ajax({
                type: "get",
                url: ud,
                data: {},
                success: function () {
                    tampildatapenjualan();
                },
            });
        });
    });
    $(".smpntpnj").click(function () {
        $("#smpntpnj").attr("disabled", true);
        var vtgltmpo = $(".tgltmpo").val();
        var vtmpo = $(".tmpo").val();
        var vinvpnj = $(".invpnj").val();
        var vidcus = $(".idcus").val();
        var vidsls = $(".idsls").val();
        var vsttlpnj = $(".sttlpnj").val();
        var a = document.getElementById("idcus").value;
        var b = document.getElementById("idsls").value;
        if (a == "") {
            $(".elortpnj").html("Nama Customer Harus Diisi");
            $("#smpntpnj").attr("disabled", false);
        } else if (b == "") {
            $(".elortpnj").html("Nama Sales Harus Diisi");
            $("#smpntpnj").attr("disabled", false);
        } else {
            $.ajax({
                url: "/trs/pnj/inspympnj",
                type: "post",
                data: {
                    tgltmpo: vtgltmpo,
                    tmpo: vtmpo,
                    invpnj: vinvpnj,
                    idcus: vidcus,
                    idsls: vidsls,
                    sttlpnj: vsttlpnj,
                },
                success: function (data) {
                    var pnjform = document.pnjkform;
                    var pnjdataString = $(pnjform).serialize();
                    $.ajax({
                        url: "/trs/pnj/inspnj",
                        type: "post",
                        data: pnjdataString,
                        success: function (data) {
                            location.reload();
                        },
                    });
                },
            });
        }
    });
    $(".smpnprnttpnj").click(function () {
        $("#smpnprnttpnj").attr("disabled", true);
        var vtgltmpo = $(".tgltmpo").val();
        var vtmpo = $(".tmpo").val();
        var vinvpnj = $(".invpnj").val();
        var vidcus = $(".idcus").val();
        var vidsls = $(".idsls").val();
        var vsttlpnj = $(".sttlpnj").val();
        var a = document.getElementById("idcus").value;
        var b = document.getElementById("idsls").value;
        if (a == "") {
            $(".elortpnj").html("Nama Customer Harus Diisi");
            $("#smpnprnttpnj").attr("disabled", false);
        } else if (b == "") {
            $(".elortpnj").html("Nama Sales Harus Diisi");
            $("#smpnprnttpnj").attr("disabled", false);
        } else {
            $.ajax({
                url: "/trs/pnj/inspympnj",
                type: "post",
                data: {
                    tgltmpo: vtgltmpo,
                    tmpo: vtmpo,
                    invpnj: vinvpnj,
                    idcus: vidcus,
                    idsls: vidsls,
                    sttlpnj: vsttlpnj,
                },
                success: function (data) {
                    var pnjform = document.pnjkform;
                    var pnjdataString = $(pnjform).serialize();
                    $.ajax({
                        url: "/trs/pnj/inspnj",
                        type: "post",
                        data: pnjdataString,
                        success: function (data) {
                            window.open("/trs/pnj/inv");
                            location.reload();
                        },
                    });
                },
            });
        }
    });
    function tampildatapembelian() {
        $.ajax({
            type: "GET",
            url: "/trs/pmb/data",
            async: true,
            dataType: "json",
            success: function (data) {
                var html = "";
                var i;
                var jmlp;
                var disco;
                var har1;
                var harfix;
                var sumharfix = [];
                var o = [];
                var berat;
                for (i = 0; i < data.length; i++) {
                    jmlp = data[i].capital * data[i].qtyp;
                    disco = data[i].disc / 100;
                    har1 = jmlp * disco;
                    harfix = jmlp - har1;
                    sumharfix.push(harfix);
                    o.push(i);
                    var no = i + 1;
                    var hrgpmbrp = data[i].capital;
                    var numstrhpmb = hrgpmbrp.toString(),
                        sisahpmb = numstrhpmb.length % 3,
                        rupiahpmb = numstrhpmb.substr(0, sisahpmb),
                        ribuanhpmb = numstrhpmb
                            .substr(sisahpmb)
                            .match(/\d{3}/g);
                    if (ribuanhpmb) {
                        separatorhpmb = sisahpmb ? "." : "";
                        rupiahpmb += separatorhpmb + ribuanhpmb.join(".");
                    }
                    var gtpmbrp = harfix;
                    var numstrgtpmb = gtpmbrp.toString(),
                        sisagtpmb = numstrgtpmb.length % 3,
                        rupiahgtpmb = numstrgtpmb.substr(0, sisagtpmb),
                        ribuangtpmb = numstrgtpmb
                            .substr(sisagtpmb)
                            .match(/\d{3}/g);
                    if (ribuangtpmb) {
                        separatorgtpmb = sisagtpmb ? "." : "";
                        rupiahgtpmb += separatorgtpmb + ribuangtpmb.join(".");
                    }
                    html +=
                        "<tr>" +
                        '<td style="text-align: center"><a href="#" class="hrgmpmb" data-id="/trs/pmb/hrgmpmb/' +
                        data[i].idp +
                        "/" +
                        data[i].idb +
                        '/">' +
                        no +
                        "</a></td>" +
                        '<td><input type="hidden" id="ipmb" class="ipmb' +
                        i +
                        '" name="ipmb[]" value="' +
                        data[i].idp +
                        '"><a href="#" class="hrgmpmb" data-id="/trs/pmb/hrgmpmb/' +
                        data[i].idp +
                        "/" +
                        data[i].idb +
                        '/">' +
                        data[i].code_product +
                        "</a></td>" +
                        '<td><a href="#" class="hrgmpmb" data-id="/trs/pmb/hrgmpmb/' +
                        data[i].idp +
                        "/" +
                        data[i].idb +
                        '/">' +
                        data[i].name +
                        "</a></td>" +
                        '<td><a href="#" class="hrgmpmb" data-id="/trs/pmb/hrgmpmb/' +
                        data[i].idp +
                        "/" +
                        data[i].idb +
                        '/">' +
                        data[i].nameu +
                        "</a></td>" +
                        '<td style="text-align: center"><input type="number" class="form-control qpmb' +
                        i +
                        '" id="qpmb" name="qpmb[]" data-input-id="' +
                        i +
                        '" onkeyup="getqpmb(this)" onclick="setnolqpmb(this)" value="' +
                        data[i].qtyp +
                        '"></td>' +
                        '<td style="text-align: center"><input type="text" class="form-control hpmb' +
                        i +
                        '" id="hpmb" name="hpmb[]" data-input-id="' +
                        i +
                        '" onkeyup="gethpmb(this)" onclick="setnolhpmb(this)" value="' +
                        rupiahpmb +
                        '" autocomplete="off"></td>' +
                        '<td style="text-align: center"><input type="number" class="form-control dpmb' +
                        i +
                        '" id="dpmb" name="dpmb[]" data-input-id="' +
                        i +
                        '" onkeyup="getdpmb(this)" onclick="setnoldpmb(this)" value="' +
                        data[i].disc +
                        '"></td>' +
                        '<td style="text-align:center"><b><span class="gpmb' +
                        i +
                        '">' +
                        rupiahgtpmb +
                        '</span></b><input type="hidden" id="gtpmb" class="gtpmb' +
                        i +
                        '" value="' +
                        harfix +
                        '"></td>' +
                        '<td style="text-align:center"><a href="#" class="delprcpmb" data-id="/trs/pmb/delprc/' +
                        data[i].id +
                        "/" +
                        data[i].qtyp +
                        '"><span class="fa fa-trash"></span></a></td>' +
                        "</tr>";
                }
                var sum = sumharfix.reduce(function (sumharfix, b) {
                    return sumharfix + b;
                }, 0);
                var tpmbrp = sum;
                var numstrtpmb = tpmbrp.toString(),
                    sisatpmb = numstrtpmb.length % 3,
                    rupiahtpmb = numstrtpmb.substr(0, sisatpmb),
                    ribuantpmb = numstrtpmb.substr(sisatpmb).match(/\d{3}/g);
                if (ribuantpmb) {
                    separatortpmb = sisatpmb ? "." : "";
                    rupiahtpmb += separatortpmb + ribuantpmb.join(".");
                }
                $("#showdatapmb").html(html);
                $(".ttlpmb").html(rupiahtpmb);
                $(".sttlpmb").val(sum.toFixed(0));
            },
        });
    }
    $(".namebrgpmb").change(function () {
        tampildatapembelian();
        $(this).val("");
    });
    $(function () {
        $(document).on("click", ".hrgmpmb", function (e) {
            e.preventDefault();
            var idspl = $(".idsplpmb").val();
            var idml = $(this).attr("data-id") + idspl;
            $(".hrgmdlpmb").modal("show");
            $(".modal-body").load(idml);
        });
    });
    $(function () {
        $(document).on("click", ".edthrgmpmb", function (e) {
            e.preventDefault();
            var ud = $(this).attr("data-id");
            $.ajax({
                type: "get",
                url: ud,
                data: {},
                success: function () {
                    $(".hrgmdlpmb").modal("hide");
                    tampildatapembelian();
                },
            });
        });
    });
    $(function () {
        $(document).on("click", ".delprcpmb", function (e) {
            e.preventDefault();
            var ud = $(this).attr("data-id");
            $.ajax({
                type: "get",
                url: ud,
                data: {},
                success: function () {
                    tampildatapembelian();
                },
            });
        });
    });
    $(".smpntpmb").click(function () {
        $("#smpntpmb").attr("disabled", true);
        var vtmpopmb = $(".tmpopmb").val();
        var vtgltmpopmb = $(".tgltmpopmb").val();
        var vinvpmb = $(".invpmb").val();
        var vidsplpmb = $(".idsplpmb").val();
        var vsttlpmb = $(".sttlpmb").val();
        var a = document.getElementById("invpmb").value;
        var b = document.getElementById("idsplpmb").value;
        if (a == "") {
            $(".elortpmb").html("Invoice Harus Diisi");
            $("#smpntpmb").attr("disabled", false);
        } else if (b == "") {
            $(".elortpmb").html("Nama Supplier Harus Diisi");
            $("#smpntpmb").attr("disabled", false);
        } else {
            $.ajax({
                url: "/trs/pmb/inspym",
                type: "post",
                data: {
                    tmpopmb: vtmpopmb,
                    tgltmpopmb: vtgltmpopmb,
                    invpmb: vinvpmb,
                    idsplpmb: vidsplpmb,
                    sttlpmb: vsttlpmb,
                },
                success: function (data) {
                    var pmbform = document.pmbkform;
                    var pmbdataString = $(pmbform).serialize();
                    $.ajax({
                        url: "/trs/pmb/inspmb",
                        type: "post",
                        data: pmbdataString,
                        success: function (data) {
                            location.reload();
                        },
                    });
                },
            });
        }
    });
    function tampildataepenjualan() {
        var idpymhpnj = $(".idpympnj").val();
        $.ajax({
            type: "GET",
            url: "/hst/epnj/data/" + idpymhpnj,
            async: true,
            dataType: "json",
            success: function (data) {
                var html = "";
                var i;
                var jmlp;
                var disco;
                var har1;
                var harfix;
                var sumharfix = [];
                for (i = 0; i < data.length; i++) {
                    jmlp = data[i].price * data[i].qtyp;
                    disco = data[i].disc / 100;
                    har1 = jmlp * disco;
                    harfix = jmlp - har1;
                    sumharfix.push(harfix);
                    var no = i + 1;
                    var hrghpnj = harfix.toFixed(0);
                    var numstrhpnj = hrghpnj.toString(),
                        sisahpnj = numstrhpnj.length % 3,
                        rupiahpnj = numstrhpnj.substr(0, sisahpnj),
                        ribuanhpnj = numstrhpnj
                            .substr(sisahpnj)
                            .match(/\d{3}/g);
                    if (ribuanhpnj) {
                        separatorhpnj = sisahpnj ? "." : "";
                        rupiahpnj += separatorhpnj + ribuanhpnj.join(".");
                    }
                    var hrghpnj2 = data[i].price;
                    var numstrhpnj2 = hrghpnj2.toString(),
                        sisahpnj2 = numstrhpnj2.length % 3,
                        rupiahpnj2 = numstrhpnj2.substr(0, sisahpnj2),
                        ribuanhpnj2 = numstrhpnj2
                            .substr(sisahpnj2)
                            .match(/\d{3}/g);
                    if (ribuanhpnj2) {
                        separatorhpnj2 = sisahpnj2 ? "." : "";
                        rupiahpnj2 += separatorhpnj2 + ribuanhpnj2.join(".");
                    }
                    html +=
                        "<tr>" +
                        '<td style="text-align: center"><a href="#" class="hrgmhpnj" data-id="/hst/epnj/hrgmhpnj/' +
                        data[i].idp +
                        "/" +
                        data[i].idb +
                        '/">' +
                        no +
                        "</a></td>" +
                        '<td><input type="hidden" id="ihpnj" class="ihpnj' +
                        i +
                        '" name="ihpnj[]" value="' +
                        data[i].idp +
                        '"><a href="#" class="hrgmhpnj" data-id="/hst/epnj/hrgmhpnj/' +
                        data[i].idp +
                        "/" +
                        data[i].idb +
                        '/">' +
                        data[i].code_product +
                        "</a></td>" +
                        '<td><a href="#" class="hrgmhpnj" data-id="/hst/epnj/hrgmhpnj/' +
                        data[i].idp +
                        "/" +
                        data[i].idb +
                        '/">' +
                        data[i].name +
                        "</a></td>" +
                        '<td style="text-align: center"><a href="#" class="hrgmhpnj" data-id="/hst/epnj/hrgmhpnj/' +
                        data[i].idp +
                        "/" +
                        data[i].idb +
                        '/">' +
                        data[i].nameu +
                        "</a></td>" +
                        '<td style="text-align: center"><input type="number" class="form-control qhpnj' +
                        i +
                        '" id="qhpnj" name="qhpnj[]" data-input-id="' +
                        i +
                        '" onkeyup="getqhpnj(this)" onclick="setnolqhpnj(this)" value="' +
                        data[i].qtyp +
                        '"><input type="hidden" id="vqhpnj" class="vqhpnj" name="vqhpnj[]" value="' +
                        data[i].qtyp +
                        '"></td>' +
                        '<td style="text-align: center"><input type="text" class="form-control hhpnj' +
                        i +
                        '" id="hhpnj" name="hhpnj[]" data-input-id="' +
                        i +
                        '" onkeyup="gethhpnj(this)" onclick="setnolhhpnj(this)" value="' +
                        rupiahpnj2 +
                        '" autocomplete="off"></td>' +
                        '<td style="text-align: center"><input type="number" class="form-control dhpnj' +
                        i +
                        '" id="dhpnj" name="dhpnj[]" data-input-id="' +
                        i +
                        '" onkeyup="getdhpnj(this)" onclick="setnoldhpnj(this)" value="' +
                        data[i].disc +
                        '"></td>' +
                        '<td style="text-align:center"><b><span class="ghpnj' +
                        i +
                        '">' +
                        rupiahpnj +
                        '</span></b><input type="hidden" id="gthpnj" class="gthpnj' +
                        i +
                        '" value="' +
                        harfix +
                        '"></td>' +
                        '<td style="text-align:center"><a href="#" class="delhpnj" data-id="/hst/epnj/delhpnj/' +
                        data[i].idp +
                        '"><span class="fa fa-trash"></span></a></td>' +
                        "</tr>";
                }
                var sum = sumharfix.reduce(function (sumharfix, b) {
                    return sumharfix + b;
                }, 0);
                var hrghpnj2 = sum.toFixed(0);
                var numstrhpnj2 = hrghpnj2.toString(),
                    sisahpnj2 = numstrhpnj2.length % 3,
                    rupiahpnj2 = numstrhpnj2.substr(0, sisahpnj2),
                    ribuanhpnj2 = numstrhpnj2.substr(sisahpnj2).match(/\d{3}/g);
                if (ribuanhpnj2) {
                    separatorhpnj2 = sisahpnj2 ? "." : "";
                    rupiahpnj2 += separatorhpnj2 + ribuanhpnj2.join(".");
                }
                $(".ttlhpnj").html(rupiahpnj2);
                $(".sttlhpnj").val(sum);
                $("#showdataepnj").html(html);
            },
        });
    }
    $(".namebrghpnj").change(function () {
        tampildataepenjualan();
        $(this).val("");
    });
    $(function () {
        $(document).on("click", ".hrgmhpnj", function (e) {
            e.preventDefault();
            var idcus = $(".idcushpnj").val();
            var idml = $(this).attr("data-id") + idcus;
            $(".hrgmdlhpnj").modal("show");
            $(".modal-body").load(idml);
        });
    });
    $(function () {
        $(document).on("click", ".edthrgmhpnj", function (e) {
            e.preventDefault();
            var ud = $(this).attr("data-id");
            var od = $(this).attr("data-idd");
            $.ajax({
                type: "post",
                url: "/hst/epnj/edthrgmhpnj/" + ud,
                data: { ids: od },
                success: function () {
                    $(".hrgmdlhpnj").modal("hide");
                    tampildataepenjualan();
                },
            });
        });
    });
    $(function () {
        $(document).on("click", ".delhpnj", function (e) {
            e.preventDefault();
            var ud = $(this).attr("data-id");
            $.ajax({
                type: "get",
                url: ud,
                data: {},
                success: function () {
                    tampildataepenjualan();
                },
            });
        });
    });
    $(".smpnthpnj").click(function () {
        $("#smpnthpnj").attr("disabled", true);
        var vidpympnj = $(".idpympnj").val();
        var vidcushpnj = $(".idcushpnj").val();
        var vsttlhpnj = $(".sttlhpnj").val();
        var vtglaw = $(".tglaw").val();
        var vtglak = $(".tglak").val();
        var vtgl = $(".tgl").val();
        var vduedate = $(".htgltmpo").val();
        $.ajax({
            url: "/hst/epnj/inshtpnj",
            type: "post",
            data: {
                idpympnj: vidpympnj,
                sttlhpnj: vsttlhpnj,
                idcushpnj: vidcushpnj,
                duedate: vduedate,
            },
            success: function (data) {
                if (vtgl == vtglaw && vtgl == vtglak) {
                    window.location = "/hst/fpnj";
                } else {
                    window.location = "/hst/pnj/" + vtglaw + "/" + vtglak;
                }
            },
        });
    });
    $(".smpnprntthpnj").click(function () {
        $("#smpnprntthpnj").attr("disabled", true);
        var vidpympnj = $(".idpympnj").val();
        var vidcushpnj = $(".idcushpnj").val();
        var vsttlhpnj = $(".sttlhpnj").val();
        var vtglaw = $(".tglaw").val();
        var vtglak = $(".tglak").val();
        var vtgl = $(".tgl").val();
        var vduedate = $(".htgltmpo").val();
        $.ajax({
            url: "/hst/epnj/inshtpnj",
            type: "post",
            data: {
                idpympnj: vidpympnj,
                sttlhpnj: vsttlhpnj,
                idcushpnj: vidcushpnj,
                duedate: vduedate,
            },
            success: function (data) {
                window.open("/hst/epnj/inv/" + vidpympnj);
                if (vtgl == vtglaw && vtgl == vtglak) {
                    window.location = "/hst/fpnj";
                } else {
                    window.location = "/hst/pnj/" + vtglaw + "/" + vtglak;
                }
            },
        });
    });
    function tampildataepembelian() {
        var idpym = $(".idpympmb").val();
        $.ajax({
            type: "GET",
            url: "/hst/epmb/data/" + idpym,
            async: true,
            dataType: "json",
            success: function (data) {
                var html = "";
                var i;
                var jmlp;
                var dis;
                var dis2;
                var sumharfix = [];
                for (i = 0; i < data.length; i++) {
                    jmlp = data[i].price * data[i].quantity;
                    dis = (data[i].disc / 100) * jmlp;
                    dis2 = jmlp - dis;
                    sumharfix.push(dis2);
                    var no = i + 1;
                    var hrghpmb = dis2.toFixed(0);
                    var numstrhpmb = hrghpmb.toString(),
                        sisahpmb = numstrhpmb.length % 3,
                        rupiahpmb = numstrhpmb.substr(0, sisahpmb),
                        ribuanhpmb = numstrhpmb
                            .substr(sisahpmb)
                            .match(/\d{3}/g);
                    if (ribuanhpmb) {
                        separatorhpmb = sisahpmb ? "." : "";
                        rupiahpmb += separatorhpmb + ribuanhpmb.join(".");
                    }
                    var hrgf = data[i].price;
                    var numstrhpmb2 = hrgf.toString(),
                        sisahpmb2 = numstrhpmb2.length % 3,
                        rupiahpmb2 = numstrhpmb2.substr(0, sisahpmb2),
                        ribuanhpmb2 = numstrhpmb2
                            .substr(sisahpmb2)
                            .match(/\d{3}/g);
                    if (ribuanhpmb2) {
                        separatorhpmb2 = sisahpmb2 ? "." : "";
                        rupiahpmb2 += separatorhpmb2 + ribuanhpmb2.join(".");
                    }
                    html +=
                        "<tr>" +
                        '<td style="text-align: center">' +
                        no +
                        "</td>" +
                        '<td><input type="hidden" id="ihpmb" class="ihpmb' +
                        i +
                        '" name="ihpmb[]" value="' +
                        data[i].id +
                        '">' +
                        data[i].code_product +
                        "</td>" +
                        '<td><a href="#" class="hrgmhpmb" data-id="/hst/epmb/hrgmhpmb/' +
                        data[i].id +
                        "/" +
                        data[i].idb +
                        '/">' +
                        data[i].name +
                        "</td>" +
                        '<td style="text-align: center">' +
                        data[i].nameu +
                        "</td>" +
                        '<td style="text-align: center"><input type="number" class="form-control qhpmb' +
                        i +
                        '" id="qhpmb" name="qhpmb[]" data-input-id="' +
                        i +
                        '" onkeyup="getqhpmb(this)" onclick="setnolqhpmb(this)" value="' +
                        data[i].quantity +
                        '"></td>' +
                        '<td style="text-align: center"><input type="text" class="form-control hhpmb' +
                        i +
                        '" id="hhpmb" name="hhpmb[]" data-input-id="' +
                        i +
                        '" onkeyup="gethhpmb(this)" onclick="setnolhhpmb(this)" value="' +
                        rupiahpmb2 +
                        '" autocomplete="off"></td>' +
                        '<td style="text-align: center"><input type="number" class="form-control dhpmb' +
                        i +
                        '" id="dhpmb" name="dhpmb[]" data-input-id="' +
                        i +
                        '" onkeyup="getdhpmb(this)" onclick="setnoldhpmb(this)" value="' +
                        data[i].disc +
                        '"></td>' +
                        '<td style="text-align:center"><b><span class="ghpmb' +
                        i +
                        '">' +
                        rupiahpmb +
                        '</span></b><input type="hidden" id="gthpmb" class="gthpmb' +
                        i +
                        '" value="' +
                        dis2 +
                        '"></td>' +
                        '<td style="text-align:center"><a href="#" class="delhpmb" data-id="/hst/epmb/delhpmb/' +
                        data[i].id +
                        '"><span class="fa fa-trash"></span></a></td>' +
                        "</tr>";
                }
                var sum = sumharfix.reduce(function (sumharfix, b) {
                    return sumharfix + b;
                }, 0);
                var hrghpmb2 = sum.toFixed(0);
                var numstrhpmb2 = hrghpmb2.toString(),
                    sisahpmb2 = numstrhpmb2.length % 3,
                    rupiahpmb2 = numstrhpmb2.substr(0, sisahpmb2),
                    ribuanhpmb2 = numstrhpmb2.substr(sisahpmb2).match(/\d{3}/g);
                if (ribuanhpmb2) {
                    separatorhpmb2 = sisahpmb2 ? "." : "";
                    rupiahpmb2 += separatorhpmb2 + ribuanhpmb2.join(".");
                }
                $(".ttlhpmb").html(rupiahpmb2);
                $(".sttlhpmb").val(sum);
                $("#showdatahpmb").html(html);
            },
        });
    }
    $(".namebrghpmb").change(function () {
        tampildataepembelian();
        $(this).val("");
    });
    $(function () {
        $(document).on("click", ".hrgmhpmb", function (e) {
            e.preventDefault();
            var idspl = $(".idsplhpmb").val();
            var idml = $(this).attr("data-id") + idspl;
            $(".hrgmdlhpmb").modal("show");
            $(".modal-body").load(idml);
        });
    });
    $(function () {
        $(document).on("click", ".edthrgmhpmb", function (e) {
            e.preventDefault();
            var ud = $(this).attr("data-id");
            var od = $(this).attr("data-idd");
            $.ajax({
                type: "post",
                url: "/hst/epmb/edthrgmhpmb/" + ud,
                data: { idp: od },
                success: function () {
                    $(".hrgmdlhpmb").modal("hide");
                    tampildataepembelian();
                },
            });
        });
    });
    $(function () {
        $(document).on("click", ".delhpmb", function (e) {
            e.preventDefault();
            var ud = $(this).attr("data-id");
            $.ajax({
                type: "get",
                url: ud,
                data: {},
                success: function () {
                    tampildataepembelian();
                },
            });
        });
    });
    $(".smpnthstpmb").click(function () {
        $("#smpnthstpmb").attr("disabled", true);
        var vidpympmb = $(".idpympmb").val();
        var vsttlhpmb = $(".sttlhpmb").val();
        var vtglaw = $(".tglaw").val();
        var vtglak = $(".tglak").val();
        var vtgl = $(".tgl").val();
        var vduedate = $(".htgltmpopmb").val();
        $.ajax({
            url: "/hst/epmb/inshtpmb",
            type: "post",
            data: {
                idpympmb: vidpympmb,
                sttlhpmb: vsttlhpmb,
                duedate: vduedate,
            },
            success: function (data) {
                if (vtglaw == vtgl && vtglak == vtgl) {
                    window.location = "/hst/fpmb";
                } else {
                    window.location = "/hst/pmb/" + vtglaw + "/" + vtglak;
                }
            },
        });
    });
    $("#dtbrg thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#dtbrg thead");
    var table = $("#dtbrg").DataTable({
        bPaginate: false,
        bInfo: false,
        ordering: false,
        orderCellsTop: true,
        dom: "Bfrtip",
        buttons: ["excel"],
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
    });
    $("#dtsld thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#dtsld thead");
    var table = $("#dtsld").DataTable({
        bPaginate: false,
        bInfo: false,
        ordering: false,
        dom: "Bfrtip",
        buttons: ["excel"],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
    });
    $("#dtpsd thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#dtpsd thead");
    var table = $("#dtpsd").DataTable({
        bPaginate: false,
        bInfo: false,
        ordering: false,
        dom: "Bfrtip",
        buttons: ["excel"],
        columnDefs: [
            {
                targets: 6,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
    });
    $("#tblic thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#tblic thead");
    var table = $("#tblic").DataTable({
        bPaginate: false,
        ordering: false,
        dom: "Bfrtip",
        buttons: ["excel"],
        columnDefs: [
            {
                targets: 5,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
        footerCallback: function (row, data, start, end, display) {
            var numformat = $.fn.dataTable.render.number(
                ",",
                ".",
                0,
                ""
            ).display;
            var api = this.api(),
                data;
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };
            total = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal = api
                .column(5, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(5).footer()).html(numformat(pageTotal));
        },
    });
    $("#tblicdpnj thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#tblicdpnj thead");
    var table = $("#tblicdpnj").DataTable({
        bPaginate: false,
        ordering: false,
        dom: "Bfrtip",
        buttons: ["excel"],
        columnDefs: [
            {
                targets: 11,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
        footerCallback: function (row, data, start, end, display) {
            var numformat = $.fn.dataTable.render.number(
                ",",
                ".",
                0,
                ""
            ).display;
            var api = this.api(),
                data;
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };
            total = api
                .column(11)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal = api
                .column(11, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(11).footer()).html(numformat(pageTotal));
        },
    });
    $("#tblicpmb thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#tblicpmb thead");
    var table = $("#tblicpmb").DataTable({
        bPaginate: false,
        ordering: false,
        dom: "Bfrtip",
        buttons: ["excel"],
        columnDefs: [
            {
                targets: 4,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
        footerCallback: function (row, data, start, end, display) {
            var numformat = $.fn.dataTable.render.number(
                ",",
                ".",
                0,
                ""
            ).display;
            var api = this.api(),
                data;
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };
            total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal = api
                .column(4, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(4).footer()).html(numformat(pageTotal));
        },
    });
    $("#tblicdpmb thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#tblicdpmb thead");
    var table = $("#tblicdpmb").DataTable({
        bPaginate: false,
        ordering: false,
        dom: "Bfrtip",
        buttons: ["excel"],
        columnDefs: [
            {
                targets: 10,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
        footerCallback: function (row, data, start, end, display) {
            var numformat = $.fn.dataTable.render.number(
                ",",
                ".",
                0,
                ""
            ).display;
            var api = this.api(),
                data;
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };
            total = api
                .column(10)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal = api
                .column(10, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(10).footer()).html(numformat(pageTotal));
        },
    });
    $("#tblicrpnj thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#tblicrpnj thead");
    var table = $("#tblicrpnj").DataTable({
        bPaginate: false,
        ordering: false,
        dom: "Bfrtip",
        buttons: ["excel"],
        columnDefs: [
            {
                targets: 5,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
        footerCallback: function (row, data, start, end, display) {
            var numformat = $.fn.dataTable.render.number(
                ",",
                ".",
                0,
                ""
            ).display;
            var api = this.api(),
                data;
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };
            total = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal = api
                .column(5, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(5).footer()).html(numformat(pageTotal));
        },
    });
    $("#tblicrpmb thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#tblicrpmb thead");
    var table = $("#tblicrpmb").DataTable({
        bPaginate: false,
        ordering: false,
        dom: "Bfrtip",
        buttons: ["excel"],
        columnDefs: [
            {
                targets: 4,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
        footerCallback: function (row, data, start, end, display) {
            var numformat = $.fn.dataTable.render.number(
                ",",
                ".",
                0,
                ""
            ).display;
            var api = this.api(),
                data;
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };
            total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal = api
                .column(4, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(4).footer()).html(numformat(pageTotal));
        },
    });
    $("#tblicspl thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#tblicspl thead");
    var table = $("#tblicspl").DataTable({
        ordering: false,
        dom: "Bfrtip",
        buttons: ["csv"],
        columnDefs: [
            {
                targets: 9,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
        footerCallback: function (row, data, start, end, display) {
            var numformat = $.fn.dataTable.render.number(
                ",",
                ".",
                0,
                ""
            ).display;
            var api = this.api(),
                data;
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };
            total = api
                .column(9)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal = api
                .column(9, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(9).footer()).html(
                numformat(pageTotal) + " (" + numformat(total) + " Total)"
            );
        },
    });
    $("#tbliccus thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#tbliccus thead");
    var table = $("#tbliccus").DataTable({
        ordering: false,
        dom: "Bfrtip",
        buttons: ["csv"],
        columnDefs: [
            {
                targets: 9,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
        footerCallback: function (row, data, start, end, display) {
            var numformat = $.fn.dataTable.render.number(
                ",",
                ".",
                0,
                ""
            ).display;
            var api = this.api(),
                data;
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };
            total = api
                .column(9)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal = api
                .column(9, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(9).footer()).html(
                numformat(pageTotal) + " (" + numformat(total) + " Total)"
            );
        },
    });
    $("#tblicbrgpnj thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#tblicbrgpnj thead");
    var table = $("#tblicbrgpnj").DataTable({
        ordering: false,
        dom: "Bfrtip",
        buttons: ["csv"],
        columnDefs: [
            {
                targets: 10,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
        footerCallback: function (row, data, start, end, display) {
            var numformat = $.fn.dataTable.render.number(
                ",",
                ".",
                0,
                ""
            ).display;
            var api = this.api(),
                data;
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };
            total = api
                .column(10)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal = api
                .column(10, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(10).footer()).html(
                numformat(pageTotal) + " (" + numformat(total) + " Total)"
            );
        },
    });
    $("#tblrptpnj thead tr")
        .clone(true)
        .addClass("filters")
        .appendTo("#tblrptpnj thead");
    var table = $("#tblrptpnj").DataTable({
        bPaginate: false,
        ordering: false,
        dom: "Bfrtip",
        buttons: ["excel"],
        columnDefs: [
            {
                targets: 3,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
            {
                targets: 4,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
            {
                targets: 5,
                render: $.fn.dataTable.render.number(",", ".", 0, ""),
            },
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            api.columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $(".filters th").eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text"/>');
                    $(
                        "input",
                        $(".filters th").eq(
                            $(api.column(colIdx).header()).index()
                        )
                    )
                        .off("keyup change")
                        .on("keyup change", function (e) {
                            e.stopPropagation();
                            $(this).attr("title", $(this).val());
                            var regexr = "({search})";
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search(
                                    this.value != ""
                                        ? regexr.replace(
                                              "{search}",
                                              "(((" + this.value + ")))"
                                          )
                                        : "",
                                    this.value != "",
                                    this.value == ""
                                )
                                .draw();
                            $(this)
                                .focus()[0]
                                .setSelectionRange(
                                    cursorPosition,
                                    cursorPosition
                                );
                        });
                });
        },
        footerCallback: function (row, data, start, end, display) {
            var numformat = $.fn.dataTable.render.number(
                ",",
                ".",
                0,
                ""
            ).display;
            var api = this.api(),
                data;
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };
            total = api
                .column(3)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal = api
                .column(3, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total2 = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal2 = api
                .column(4, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total3 = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal3 = api
                .column(5, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(3).footer()).html(numformat(pageTotal));
            $(api.column(4).footer()).html(numformat(pageTotal2));
            $(api.column(5).footer()).html(numformat(pageTotal3));
        },
    });
});
function getqpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipmb = $(".ipmb" + inputId).val();
    var hpnj = $(".hpmb" + inputId).val();
    var dpnj = $(".dpmb" + inputId).val();
    var val2 = hpnj.replace(/[^,\d]/g, "").toString();
    if (val == "") {
        var qf = 0;
    } else {
        var qf = val;
    }
    if (val2 == "") {
        var hf = 0;
    } else {
        var hf = val2;
    }
    if (dpnj == "") {
        var df = 0;
    } else {
        var df = dpnj;
    }
    var jml = parseInt(qf) * parseInt(hf);
    var dis = parseInt(df) / 100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(),
        sisa = numstr.length % 3,
        rupiah = numstr.substr(0, sisa),
        ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }
    $(".gpmb" + inputId).html(rupiah);
    $(".gtpmb" + inputId).val(hrg);
    var sum = 0;
    $("#tbpnj tr").each(function () {
        $(this)
            .find('input[id="gtpmb"]')
            .each(function () {
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(),
        sisa2 = numstr2.length % 3,
        rupiah2 = numstr2.substr(0, sisa2),
        ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? "," : "";
        rupiah2 += separator2 + ribuan2.join(",");
    }
    $(".ttlpmb").html(rupiah2);
    $(".sttlpmb").val(sum.toFixed(0));
    $.ajax({
        url: "/trs/pmb/qtypmb",
        type: "post",
        data: { id: ipmb, qty: qf },
        success: function (data) {},
    });
}
function gethpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var val2 = val.replace(/[^,\d]/g, "").toString();
    var ipmb = $(".ipmb" + inputId).val();
    var qpnj = $(".qpmb" + inputId).val();
    var dpnj = $(".dpmb" + inputId).val();
    if (qpnj == "") {
        var qf = 0;
    } else {
        var qf = qpnj;
    }
    if (val2 == "") {
        var hf = 0;
    } else {
        var hf = val2;
    }
    if (dpnj == "") {
        var df = 0;
    } else {
        var df = dpnj;
    }
    var jml = parseInt(hf) * parseInt(qf);
    var dis = parseInt(df) / 100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(),
        sisa = numstr.length % 3,
        rupiah = numstr.substr(0, sisa),
        ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }
    $(".gpmb" + inputId).html(rupiah);
    $(".gtpmb" + inputId).val(hrg);
    var sum = 0;
    $("#tbpnj tr").each(function () {
        $(this)
            .find('input[id="gtpmb"]')
            .each(function () {
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(),
        sisa2 = numstr2.length % 3,
        rupiah2 = numstr2.substr(0, sisa2),
        ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? "," : "";
        rupiah2 += separator2 + ribuan2.join(",");
    }
    $(".ttlpmb").html(rupiah2);
    $(".sttlpmb").val(sum.toFixed(0));
    $(".hpmb" + inputId).val(formatRupiahx(val));
    $.ajax({
        url: "/trs/pmb/hrgpmb",
        type: "post",
        data: { id: ipmb, hrg: hf },
        success: function (data) {},
    });
}
function getdpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipmb = $(".ipmb" + inputId).val();
    var qpnj = $(".qpmb" + inputId).val();
    var hpnj = $(".hpmb" + inputId).val();
    var val2 = hpnj.replace(/[^,\d]/g, "").toString();
    if (qpnj == "") {
        var qf = 0;
    } else {
        var qf = qpnj;
    }
    if (val2 == "") {
        var hf = 0;
    } else {
        var hf = val2;
    }
    if (val == "") {
        var df = 0;
    } else {
        var df = val;
    }
    var jml = parseInt(hf) * parseInt(qf);
    var dis = parseInt(df) / 100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(),
        sisa = numstr.length % 3,
        rupiah = numstr.substr(0, sisa),
        ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }
    $(".gpmb" + inputId).html(rupiah);
    $(".gtpmb" + inputId).val(hrg);
    var sum = 0;
    $("#tbpnj tr").each(function () {
        $(this)
            .find('input[id="gtpmb"]')
            .each(function () {
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(),
        sisa2 = numstr2.length % 3,
        rupiah2 = numstr2.substr(0, sisa2),
        ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? "," : "";
        rupiah2 += separator2 + ribuan2.join(",");
    }
    $(".ttlpmb").html(rupiah2);
    $(".sttlpmb").val(sum.toFixed(0));
    $.ajax({
        url: "/trs/pmb/dispmb",
        type: "post",
        data: { id: ipmb, dis: df },
        success: function (data) {},
    });
}
function getbpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipmb = $(".ipmb" + inputId).val();
    $.ajax({
        url: "/trs/pmb/brtpmb",
        type: "post",
        data: { id: ipmb, brt: val },
        success: function (data) {},
    });
}
function getqpnj(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipnj = $(".ipnj" + inputId).val();
    var hpnj = $(".hpnj" + inputId).val();
    var dpnj = $(".dpnj" + inputId).val();
    var val2 = hpnj.replace(/[^,\d]/g, "").toString();
    if (val == "") {
        var qf = 0;
    } else {
        var qf = val;
    }
    if (val2 == "") {
        var hf = 0;
    } else {
        var hf = val2;
    }
    if (dpnj == "") {
        var df = 0;
    } else {
        var df = dpnj;
    }
    var jml = parseInt(qf) * parseInt(hf);
    var dis = parseInt(df) / 100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(),
        sisa = numstr.length % 3,
        rupiah = numstr.substr(0, sisa),
        ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }
    $(".gpnj" + inputId).html(rupiah);
    $(".gtpnj" + inputId).val(hrg);
    var sum = 0;
    $("#tblpnj tr").each(function () {
        $(this)
            .find('input[id="gtpnj"]')
            .each(function () {
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(),
        sisa2 = numstr2.length % 3,
        rupiah2 = numstr2.substr(0, sisa2),
        ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? "," : "";
        rupiah2 += separator2 + ribuan2.join(",");
    }

    $(".ttlpnj").html(rupiah2);
    $(".sttlpnj").val(sum.toFixed(0));
    $.ajax({
        url: "/trs/pnj/qtypnj",
        type: "post",
        data: { id: ipnj, qty: qf },
        success: function (data) {},
    });
}
function gethpnj(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipnj = $(".ipnj" + inputId).val();
    var qpnj = $(".qpnj" + inputId).val();
    var dpnj = $(".dpnj" + inputId).val();
    var val2 = val.replace(/[^,\d]/g, "").toString();
    if (qpnj == "") {
        var qf = 0;
    } else {
        var qf = qpnj;
    }
    if (val2 == "") {
        var hf = 0;
    } else {
        var hf = val2;
    }
    if (dpnj == "") {
        var df = 0;
    } else {
        var df = dpnj;
    }
    var jml = parseInt(hf) * parseInt(qf);
    var dis = parseInt(df) / 100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(),
        sisa = numstr.length % 3,
        rupiah = numstr.substr(0, sisa),
        ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }
    $(".gpnj" + inputId).html(rupiah);
    $(".gtpnj" + inputId).val(hrg);
    var sum = 0;
    $("#tblpnj tr").each(function () {
        $(this)
            .find('input[id="gtpnj"]')
            .each(function () {
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(),
        sisa2 = numstr2.length % 3,
        rupiah2 = numstr2.substr(0, sisa2),
        ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? "," : "";
        rupiah2 += separator2 + ribuan2.join(",");
    }

    $(".ttlpnj").html(rupiah2);
    $(".sttlpnj").val(sum.toFixed(0));
    $(".hpnj" + inputId).val(formatRupiahx(val));
    $.ajax({
        url: "/trs/pnj/hrgpnj",
        type: "post",
        data: { id: ipnj, hrg: hf },
        success: function (data) {},
    });
}
function getdpnj(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipnj = $(".ipnj" + inputId).val();
    var qpnj = $(".qpnj" + inputId).val();
    var hpnj = $(".hpnj" + inputId).val();
    var val2 = hpnj.replace(/[^,\d]/g, "").toString();
    if (qpnj == "") {
        var qf = 0;
    } else {
        var qf = qpnj;
    }
    if (val2 == "") {
        var hf = 0;
    } else {
        var hf = val2;
    }
    if (val == "") {
        var df = 0;
    } else {
        var df = val;
    }
    var jml = parseInt(hf) * parseInt(qf);
    var dis = parseInt(df) / 100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(),
        sisa = numstr.length % 3,
        rupiah = numstr.substr(0, sisa),
        ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }
    $(".gpnj" + inputId).html(rupiah);
    $(".gtpnj" + inputId).val(hrg);
    var sum = 0;
    $("#tblpnj tr").each(function () {
        $(this)
            .find('input[id="gtpnj"]')
            .each(function () {
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(),
        sisa2 = numstr2.length % 3,
        rupiah2 = numstr2.substr(0, sisa2),
        ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? "," : "";
        rupiah2 += separator2 + ribuan2.join(",");
    }

    $(".ttlpnj").html(rupiah2);
    $(".sttlpnj").val(sum.toFixed(0));
    $.ajax({
        url: "/trs/pnj/dispnj",
        type: "post",
        data: { id: ipnj, dis: df },
        success: function (data) {},
    });
}
function getqhpnj(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipnj = $(".ihpnj" + inputId).val();
    var hpnj = $(".hhpnj" + inputId).val();
    var dpnj = $(".dhpnj" + inputId).val();
    var val2 = hpnj.replace(/[^,\d]/g, "").toString();
    if (val == "") {
        var qf = 0;
    } else {
        var qf = val;
    }
    if (val2 == "") {
        var hf = 0;
    } else {
        var hf = val2;
    }
    if (dpnj == "") {
        var df = 0;
    } else {
        var df = dpnj;
    }
    var jml = parseInt(qf) * parseInt(hf);
    var dis = parseInt(df) / 100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(),
        sisa = numstr.length % 3,
        rupiah = numstr.substr(0, sisa),
        ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }
    $(".ghpnj" + inputId).html(rupiah);
    $(".gthpnj" + inputId).val(hrg);
    var sum = 0;
    $("#tblpnjhst tr").each(function () {
        $(this)
            .find('input[id="gthpnj"]')
            .each(function () {
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(),
        sisa2 = numstr2.length % 3,
        rupiah2 = numstr2.substr(0, sisa2),
        ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? "," : "";
        rupiah2 += separator2 + ribuan2.join(",");
    }
    $(".ttlhpnj").html(rupiah2);
    $(".sttlhpnj").val(sum.toFixed(0));
    $.ajax({
        url: "/hst/epnj/qtypnj",
        type: "post",
        data: { id: ipnj, qty: qf },
        success: function (data) {},
    });
}
function gethhpnj(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipnj = $(".ihpnj" + inputId).val();
    var qpnj = $(".qhpnj" + inputId).val();
    var dpnj = $(".dhpnj" + inputId).val();
    var val2 = val.replace(/[^,\d]/g, "").toString();
    if (qpnj == "") {
        var qf = 0;
    } else {
        var qf = qpnj;
    }
    if (val2 == "") {
        var hf = 0;
    } else {
        var hf = val2;
    }
    if (dpnj == "") {
        var df = 0;
    } else {
        var df = dpnj;
    }
    var jml = parseInt(hf) * parseInt(qf);
    var dis = parseInt(df) / 100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(),
        sisa = numstr.length % 3,
        rupiah = numstr.substr(0, sisa),
        ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }
    $(".ghpnj" + inputId).html(rupiah);
    $(".gthpnj" + inputId).val(hrg);
    var sum = 0;
    $("#tblpnjhst tr").each(function () {
        $(this)
            .find('input[id="gthpnj"]')
            .each(function () {
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(),
        sisa2 = numstr2.length % 3,
        rupiah2 = numstr2.substr(0, sisa2),
        ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? "," : "";
        rupiah2 += separator2 + ribuan2.join(",");
    }

    $(".ttlhpnj").html(rupiah2);
    $(".sttlhpnj").val(sum.toFixed(0));
    $(".hhpnj" + inputId).val(formatRupiahx(val));
    $.ajax({
        url: "/hst/epnj/hrgpnj",
        type: "post",
        data: { id: ipnj, hrg: hf },
        success: function (data) {},
    });
}
function getdhpnj(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipnj = $(".ihpnj" + inputId).val();
    var qpnj = $(".qhpnj" + inputId).val();
    var hpnj = $(".hhpnj" + inputId).val();
    var val2 = hpnj.replace(/[^,\d]/g, "").toString();
    if (qpnj == "") {
        var qf = 0;
    } else {
        var qf = qpnj;
    }
    if (val2 == "") {
        var hf = 0;
    } else {
        var hf = val2;
    }
    if (val == "") {
        var df = 0;
    } else {
        var df = val;
    }
    var jml = parseInt(hf) * parseInt(qf);
    var dis = parseInt(df) / 100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(),
        sisa = numstr.length % 3,
        rupiah = numstr.substr(0, sisa),
        ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }
    $(".ghpnj" + inputId).html(rupiah);
    $(".gthpnj" + inputId).val(hrg);
    var sum = 0;
    $("#tblpnjhst tr").each(function () {
        $(this)
            .find('input[id="gthpnj"]')
            .each(function () {
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(),
        sisa2 = numstr2.length % 3,
        rupiah2 = numstr2.substr(0, sisa2),
        ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? "," : "";
        rupiah2 += separator2 + ribuan2.join(",");
    }

    $(".ttlhpnj").html(rupiah2);
    $(".sttlhpnj").val(sum.toFixed(0));
    $.ajax({
        url: "/hst/epnj/dispnj",
        type: "post",
        data: { id: ipnj, dis: df },
        success: function (data) {},
    });
}
function getqhpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipmb = $(".ihpmb" + inputId).val();
    var hpmb = $(".hhpmb" + inputId).val();
    var dpmb = $(".dhpmb" + inputId).val();
    var val2 = hpmb.replace(/[^,\d]/g, "").toString();
    if (val == "") {
        var qf = 0;
    } else {
        var qf = val;
    }
    if (val2 == "") {
        var hf = 0;
    } else {
        var hf = val2;
    }
    if (dpmb == "") {
        var df = 0;
    } else {
        var df = dpmb;
    }
    var jml = parseInt(qf) * parseInt(hf);
    var dis = parseInt(df) / 100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(),
        sisa = numstr.length % 3,
        rupiah = numstr.substr(0, sisa),
        ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }
    $(".ghpmb" + inputId).html(rupiah);
    $(".gthpmb" + inputId).val(hrg);
    var sum = 0;
    $("#tbhstpnj tr").each(function () {
        $(this)
            .find('input[id="gthpmb"]')
            .each(function () {
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(),
        sisa2 = numstr2.length % 3,
        rupiah2 = numstr2.substr(0, sisa2),
        ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? "," : "";
        rupiah2 += separator2 + ribuan2.join(",");
    }
    $(".ttlhpmb").html(rupiah2);
    $(".sttlhpmb").val(sum.toFixed(0));
    $.ajax({
        url: "/hst/epmb/qtypmb",
        type: "post",
        data: { id: ipmb, qty: qf },
        success: function (data) {},
    });
}
function gethhpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipmb = $(".ihpmb" + inputId).val();
    var qpmb = $(".qhpmb" + inputId).val();
    var dpmb = $(".dhpmb" + inputId).val();
    var val2 = val.replace(/[^,\d]/g, "").toString();
    if (qpmb == "") {
        var qf = 0;
    } else {
        var qf = qpmb;
    }
    if (val2 == "") {
        var hf = 0;
    } else {
        var hf = val2;
    }
    if (dpmb == "") {
        var df = 0;
    } else {
        var df = dpmb;
    }
    var jml = parseInt(hf) * parseInt(qf);
    var dis = parseInt(df) / 100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(),
        sisa = numstr.length % 3,
        rupiah = numstr.substr(0, sisa),
        ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }
    $(".ghpmb" + inputId).html(rupiah);
    $(".gthpmb" + inputId).val(hrg);
    var sum = 0;
    $("#tbhstpnj tr").each(function () {
        $(this)
            .find('input[id="gthpmb"]')
            .each(function () {
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(),
        sisa2 = numstr2.length % 3,
        rupiah2 = numstr2.substr(0, sisa2),
        ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? "," : "";
        rupiah2 += separator2 + ribuan2.join(",");
    }

    $(".ttlhpmb").html(rupiah2);
    $(".sttlhpmb").val(sum.toFixed(0));
    $(".hhpmb" + inputId).val(formatRupiahx(val));
    $.ajax({
        url: "/hst/epmb/hrgpmb",
        type: "post",
        data: { id: ipmb, hrg: hf },
        success: function (data) {},
    });
}
function getdhpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    var ipmb = $(".ihpmb" + inputId).val();
    var qpmb = $(".qhpmb" + inputId).val();
    var hpmb = $(".hhpmb" + inputId).val();
    var val2 = hpmb.replace(/[^,\d]/g, "").toString();
    if (qpmb == "") {
        var qf = 0;
    } else {
        var qf = qpmb;
    }
    if (val2 == "") {
        var hf = 0;
    } else {
        var hf = val2;
    }
    if (val == "") {
        var df = 0;
    } else {
        var df = val;
    }
    var jml = parseInt(hf) * parseInt(qf);
    var dis = parseInt(df) / 100;
    var dis2 = parseInt(jml) * dis;
    let res = jml - dis2;
    res = isNaN(res) ? 0 : res;
    var hrg = res.toFixed(0);
    var numstr = hrg.toString(),
        sisa = numstr.length % 3,
        rupiah = numstr.substr(0, sisa),
        ribuan = numstr.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }
    $(".ghpmb" + inputId).html(rupiah);
    $(".gthpmb" + inputId).val(hrg);
    var sum = 0;
    $("#tbhstpnj tr").each(function () {
        $(this)
            .find('input[id="gthpmb"]')
            .each(function () {
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseInt(this.value);
                }
            });
    });
    var gt = sum.toFixed(0);
    var numstr2 = gt.toString(),
        sisa2 = numstr2.length % 3,
        rupiah2 = numstr2.substr(0, sisa2),
        ribuan2 = numstr2.substr(sisa2).match(/\d{3}/g);
    if (ribuan2) {
        separator2 = sisa2 ? "," : "";
        rupiah2 += separator2 + ribuan2.join(",");
    }
    $(".ttlhpmb").html(rupiah2);
    $(".sttlhpmb").val(sum.toFixed(0));
    $.ajax({
        url: "/hst/epmb/dispmb",
        type: "post",
        data: { id: ipmb, dis: df },
        success: function (data) {},
    });
}
function hpmbrf(element) {
    const val = element.value;
    $(".mhjbpmb").val(formatRupiahx(val));
}
function setnolqpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".qpmb" + inputId).val(h);
}
function setnolhpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".hpmb" + inputId).val(formatRupiahx(h));
}
function setnoldpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".dpmb" + inputId).val(h);
}
function setnolbpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".bpmb" + inputId).val(h);
}
function setnolqpnj(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".qpnj" + inputId).val(h);
}
function setnol(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".hpnj" + inputId).val(formatRupiahx(h));
}
function setnoldpnj(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".dpnj" + inputId).val(h);
}
function setnolqhpnj(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".qhpnj" + inputId).val(h);
}
function setnolhhpnj(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".hhpnj" + inputId).val(formatRupiahx(h));
}
function setnoldhpnj(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".dhpnj" + inputId).val(h);
}
function hpnjrf(element) {
    const val = element.value;
    $(".mhjhpnj").val(formatRupiahx(val));
}
function setnolqhpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".qhpmb" + inputId).val(h);
}
function setnolhhpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".hhpmb" + inputId).val(formatRupiahx(h));
}
function setnoldhpmb(element) {
    const inputId = element.dataset.inputId;
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".dhpmb" + inputId).val(h);
}
function formatRupiahx(angkax, prefixx) {
    var number_string3 = angkax.replace(/[^,\d]/g, "").toString(),
        split3 = number_string3.split(","),
        sisa3 = split3[0].length % 3,
        rupiah3 = split3[0].substr(0, sisa3),
        ribuan3 = split3[0].substr(sisa3).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan3) {
        separator3 = sisa3 ? "." : "";
        rupiah3 += separator3 + ribuan3.join(".");
    }

    rupiah3 = split3[1] != undefined ? rupiah3 + "," + split3[1] : rupiah3;
    return prefixx == undefined ? rupiah3 : rupiah3 ? rupiah3 : "";
}
function setnolwgbrg(element) {
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".idweight").val(h);
}
function setnolhubrg(element) {
    const val = element.value;
    if (val == 0) {
        var h = "";
    } else {
        var h = val;
    }
    $(".iddefprice").val(h);
}
function gethubrg(element) {
    const val = element.value;
    $(".iddefprice").val(formatRupiahx(val));
}
function gethutbrg(element) {
    const val = element.value;
    $(".defprice").val(formatRupiahx(val));
}
