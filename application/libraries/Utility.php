<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Utility {

    function format_rupiah($nilai) {
        $rupiahDesimal = '';
        if ( strpos( $nilai, "." ) !== false ) {
            $arrNilai = explode('.', $nilai);
            $nilai = $arrNilai[0];
            $rupiahDesimal = ','.$arrNilai[1];
        }
        $rupiah = "";
        $rp = strlen($nilai);
        while ($rp > 3) {
            $rupiah = "." . substr($nilai, -3) . $rupiah;
            $s = strlen($nilai) - 3;
            $nilai = substr($nilai, 0, $s);
            $rp = strlen($nilai);
        }
        $rupiah = "" . $nilai . $rupiah . "";
        if($rupiah == 0){
            return 0;
        }else{
            return $rupiah.$rupiahDesimal;
        }
    }

    function get_hari($params) {
        // params = 'yyyy-mm-dd'
        $hariEn = date_format(date_create($params), 'l');
        switch (strtolower($hariEn)) {
            case "monday":
                $hr = "Senin";
                break;
            case "tuesday":
                $hr = "Selasa";
                break;
            case "wednesday":
                $hr = "Rabu";
                break;
            case "thursday":
                $hr = "Kamis";
                break;
            case "friday":
                $hr = "Jumat";
                break;
            case "saturday":
                $hr = "Sabtu";
                break;
            case "sunday":
                $hr = "Minggu";
                break;
        }
        return $hr;
    }

    function bulan_angka($params) {
        switch (strtolower($params)) {
            case "januari":
                $bln = 1;
                break;
            case "februari":
                $bln = 2;
                break;
            case "maret":
                $bln = 3;
                break;
            case "april":
                $bln = 4;
                break;
            case "mei":
                $bln = 5;
                break;
            case "juni":
                $bln = 6;
                break;
            case "juli":
                $bln = 7;
                break;
            case "agustus":
                $bln = 8;
                break;
            case "september":
                $bln = 9;
                break;
            case "oktober":
                $bln = 10;
                break;
            case "nopember":
                $bln = 11;
                break;
            case "desember":
                $bln = 12;
                break;
                break;
        }
        return $bln;
    }

    function bulan($params) {
        switch ((int)$params) {
            case 1:
                $bln = "Januari";
                break;
            case 2:
                $bln = "Februari";
                break;
            case 3:
                $bln = "Maret";
                break;
            case 4:
                $bln = "April";
                break;
            case 5:
                $bln = "Mei";
                break;
            case 6:
                $bln = "Juni";
                break;
            case 7:
                $bln = "Juli";
                break;
            case 8:
                $bln = "Agustus";
                break;
            case 9:
                $bln = "September";
                break;
            case 10:
                $bln = "Oktober";
                break;
            case 11:
                $bln = "November";
                break;
            case 12:
                $bln = "Desember";
                break;
                break;
        }
        return $bln;
    }

    function bulan_singkat($params) {
        switch ($params) {
            case 1:
                $bln = "Jan";
                break;
            case 2:
                $bln = "Peb";
                break;
            case 3:
                $bln = "Mar";
                break;
            case 4:
                $bln = "Apr";
                break;
            case 5:
                $bln = "Mei";
                break;
            case 6:
                $bln = "Jun";
                break;
            case 7:
                $bln = "Jul";
                break;
            case 8:
                $bln = "Agu";
                break;
            case 9:
                $bln = "Sep";
                break;
            case 10:
                $bln = "Okt";
                break;
            case 11:
                $bln = "Nov";
                break;
            case 12:
                $bln = "Des";
                break;
                break;
        }
        return $bln;
    }

    function tanggal_sekarang() {
        $tglSekarang = date("d") . '&nbsp;' . $this->bulan(date("m")) . '&nbsp;' . date("Y");

        return $tglSekarang;
    }

    function tanggal_sekarang_singkat($pthn, $pbln, $ptgl) {
        $tglSekarang = date("d") . '&nbsp;' . $this->bulan_singkat(date("m")) . '&nbsp;' . date("Y");

        return $tglSekarang;
    }

    function tanggal_to_mysql($tanggal) {
        $arrTanggal = explode(' ', $tanggal);

        $hari = $arrTanggal[0];
        $bulan = $arrTanggal[1];
        $tahun = $arrTanggal[2];

        $result = $tahun . '-' . $this->bulan_angka($bulan) . '-' . $hari;

        return $result;
    }

    function mysql_to_tanggal($tanggal) {
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $tanggal)) {
            $arrTanggal = explode('-', $tanggal);
            $hari = $arrTanggal[2];
            $bulan = $arrTanggal[1];
            $tahun = $arrTanggal[0];

            $result = $hari . ' ' . $this->bulan($bulan) . ' ' . $tahun;
        } else {
            $result = null;
        }


        return $result;
    }

    function mysql_to_tanggal_long($waktu) {
        if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $waktu)) {
            $arrWaktu = explode(' ', $waktu);
            $arrTanggal = explode('-', $arrWaktu[0]);
            $arrJamMenit = explode(':', $arrWaktu[1]);

            $hari = $arrTanggal[2];
            $bulan = $arrTanggal[1];
            $tahun = $arrTanggal[0];
            $jam = $arrJamMenit[0];
            $menit = $arrJamMenit[1];

            $result = $hari . ' ' . $this->bulan($bulan) . ' ' . $tahun . ' &nbsp;' . $jam . ':' . $menit;
        } else {
            $result = null;
        }
        return $result;
    }

    function mysql_to_tanggal_short($tanggal) {
        $arrTanggal = explode('-', $tanggal);

        $hari = $arrTanggal[2];
        $bulan = $arrTanggal[1];
        $tahun = $arrTanggal[0];

        $strDateMySql = $hari . ' ' . $this->bulan_singkat($bulan) . ' ' . $tahun;

        return $strDateMySql;
    }

    function terbilang_rupiah($bilangan = '') {
        $angka = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0',
            '0', '0', '0');
        $kata = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh',
            'delapan', 'sembilan');
        $tingkat = array('', 'ribu', 'juta', 'milyar', 'triliun');

        $panjang_bilangan = strlen($bilangan);

        /* pengujian panjang bilangan */
        if ($panjang_bilangan > 15) {
            $kalimat = "Diluar Batas";
            return $kalimat;
        }

        /* mengambil angka-angka yang ada dalam bilangan,
          dimasukkan ke dalam array */
        for ($i = 1; $i <= $panjang_bilangan; $i++) {
            $angka[$i] = substr($bilangan, -($i), 1);
        }

        $i = 1;
        $j = 0;
        $kalimat = "";

        /* mulai proses iterasi terhadap array angka */
        while ($i <= $panjang_bilangan) {
            $subkalimat = "";
            $kata1 = "";
            $kata2 = "";
            $kata3 = "";

            /* untuk ratusan */
            if ($angka[$i + 2] != "0") {
                if ($angka[$i + 2] == "1") {
                    $kata1 = "seratus";
                } else {
                    $kata1 = $kata[$angka[$i + 2]] . " ratus";
                }
            }

            /* untuk puluhan atau belasan */
            if ($angka[$i + 1] != "0") {
                if ($angka[$i + 1] == "1") {
                    if ($angka[$i] == "0") {
                        $kata2 = "sepuluh";
                    } elseif ($angka[$i] == "1") {
                        $kata2 = "sebelas";
                    } else {
                        $kata2 = $kata[$angka[$i]] . " belas";
                    }
                } else {
                    $kata2 = $kata[$angka[$i + 1]] . " puluh";
                }
            }

            /* untuk satuan */
            if ($angka[$i] != "0") {
                if ($angka[$i + 1] != "1") {
                    $kata3 = $kata[$angka[$i]];
                }
            }

            /* pengujian angka apakah tidak nol semua,
              lalu ditambahkan tingkat */
            if (($angka[$i] != "0") or ($angka[$i + 1] != "0") or ($angka[$i + 2] != "0")) {
                $subkalimat = "$kata1 $kata2 $kata3 " . $tingkat[$j] . " ";
            }

            /* gabungkan variabe sub kalimat (untuk satu blok 3 angka)
              ke variabel kalimat */
            $kalimat = $subkalimat . $kalimat;
            $i = $i + 3;
            $j = $j + 1;
        }

        /* mengganti satu ribu jadi seribu jika diperlukan */
        if (($angka[5] == "0") and ($angka[6] == "0")) {
            $kalimat = str_replace("satu ribu", "seribu", $kalimat);
        }
        return $kalimat;
    }

    function lead_zero($lengthLead, $number = 0) {
        
        $result = str_pad($number, $lengthLead, '0', STR_PAD_LEFT);
        
        return $result;
    }
}

?>