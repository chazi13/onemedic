<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Jenssegers\Date\Date;

if (!function_exists('datetostr')) {

    function datetostr($timestamp = FALSE, $format = 'd/m/Y') {
        $CI = & get_instance();

        Date::setLocale($CI->load->get_var('lang'));
        if ($timestamp === FALSE)
            $date = Date::create();
        elseif ($timestamp == '0000-00-00')
            return '';
        else
            $date = Date::parse($timestamp);

        return $date->format($format);
    }
}
if (!function_exists('dateinputtodate')) {

    function dateinputtodate($date = FALSE, $format = "d/m/Y") {
        if ($format == "d/m/Y") {
            $date = str_ireplace("/", "-", $date);
        }
        $timestamp = strtotime($date);
        return date("Y-m-d", $timestamp);
    }
}
if (!function_exists('datetodateinput')) {

    function datetodateinput($date = FALSE, $format = "d/m/Y") {
		if($date =='' || $date =='0000-00-00') return '';
        $timestamp = strtotime($date);
        return date($format, $timestamp);
    }

}
if ( !function_exists('date_display'))
{
	function date_display($date_str, $format = 'j F Y', $locale = 'id')
	{
		Date::setLocale($locale);
		$date = Date::parse($date_str);
		return $date->format($format);
	}
}

