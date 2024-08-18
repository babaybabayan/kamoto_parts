<?php

function dateformatted($date){
    return date('d-m-Y', strtotime($date));
}

function convertToIdr ($angka) {
    return number_format($angka, 0, ',', '.');
}

function rupiah($angka){
    $hasil_rupiah = number_format($angka, 0, ',', ',');
    return $hasil_rupiah;
}

function idrToStringDesc ($angka) {
    $angka = abs($angka);
    $baca  = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
    $terbilang = '';

    if ($angka < 12) { // 0 - 11
        $terbilang = ' ' . $baca[$angka];
    } elseif ($angka < 20) { // 12 - 19
        $terbilang = idrToStringDesc($angka -10) . ' belas';
    } elseif ($angka < 100) { // 20 - 99
        $terbilang = idrToStringDesc($angka / 10) . ' puluh' . idrToStringDesc($angka % 10);
    } elseif ($angka < 200) { // 100 - 199
        $terbilang = ' seratus' . idrToStringDesc($angka -100);
    } elseif ($angka < 1000) { // 200 - 999
        $terbilang = idrToStringDesc($angka / 100) . ' ratus' . idrToStringDesc($angka % 100);
    } elseif ($angka < 2000) { // 1.000 - 1.999
        $terbilang = ' seribu' . idrToStringDesc($angka -1000);
    } elseif ($angka < 1000000) { // 2.000 - 999.999
        $terbilang = idrToStringDesc($angka / 1000) . ' ribu' . idrToStringDesc($angka % 1000);
    } elseif ($angka < 1000000000) { // 1000000 - 999.999.990
        $terbilang = idrToStringDesc($angka / 1000000) . ' juta' . idrToStringDesc($angka % 1000000);
    }

    return $terbilang;
}
