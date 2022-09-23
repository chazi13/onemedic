<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('format_number'))
{
	function format_number($num, $dec = 0, $locale = '')
	{
		$CI =& get_instance();
		if (empty($locale))
			$locale = $CI->load->get_var('lang');
		
		$decimal = '.';
		$thousands = ',';

		switch ($locale)
		{
			case 'id':
				$decimal = ',';
				$thousands = '.';
				break;
		}
		return number_format((float) $num, $dec, $decimal, $thousands);
	}
}

if ( !function_exists('terbilang'))
{
	function terbilang($angka) 
	{
        $angka = (float)$angka;
        $bilangan = array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas');
		if ($angka < 1) {
			if ($angka == 0) return '';
			$angka = round($angka, 2);
			$strangka = str_replace('0.', '', $angka);
			$hasil = 'Koma ';
			foreach(str_split($strangka) as $num) {
				if ($num == 0)
					$hasil .= 'Nol ';
				else
					$hasil .= $bilangan[$num] . ' ';
			}
			return trim($hasil);
		} elseif ($angka < 12) {
			$whole = floor($angka);
			$desimal = $angka - $whole;
            return sprintf('%s %s', $bilangan[$angka], terbilang($desimal));
        } elseif ($angka < 20) {
            return $bilangan[$angka - 10] . ' Belas';
        } elseif ($angka < 100) {
            $hasil_bagi = (int)($angka / 10);
            $hasil_mod = fmod($angka, 10);
            return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], terbilang($hasil_mod)));
        } elseif ($angka < 200) { 
			return sprintf('Seratus %s', terbilang($angka - 100));
        } elseif ($angka < 1000) { 
			$hasil_bagi = (int)($angka / 100); 
			$hasil_mod = fmod($angka, 100); 
			return trim(sprintf('%s Ratus %s', $bilangan[$hasil_bagi], terbilang($hasil_mod)));
        } elseif ($angka < 2000) { 
			return trim(sprintf('Seribu %s', terbilang($angka - 1000)));
        } elseif ($angka < 1000000) { 
			$hasil_bagi = (int)($angka / 1000); 
			$hasil_mod = fmod($angka, 1000); 
			return sprintf('%s Ribu %s', terbilang($hasil_bagi), terbilang($hasil_mod));
        } elseif ($angka < 1000000000) { 
			$hasil_bagi = (int)($angka / 1000000); 
			$hasil_mod = fmod($angka, 1000000); 
			return trim(sprintf('%s Juta %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
        } elseif ($angka < 1000000000000) { 
			$hasil_bagi = (int)($angka / 1000000000); 
			$hasil_mod = fmod($angka, 1000000000); 
			return trim(sprintf('%s Milyar %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
        } elseif ($angka < 1000000000000000) { 
			$hasil_bagi = $angka / 1000000000000; 
			$hasil_mod = fmod($angka, 1000000000000); 
			return trim(sprintf('%s Triliun %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
        } else {
            return 'Data Salah';
        }
    }
}