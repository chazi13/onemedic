<?php
defined('BASEPATH') OR exit('No direct script access allowed');


use Endroid\QrCode\Exception\GenerateImageException;
use Endroid\QrCode\Factory\QrCodeFactory;
use Endroid\QrCode\QrCode;
use PHPUnit\Framework\TestCase;
use Zxing\QrReader;


class Qr extends CI_Controller {

	function __construct ()
	{	
		parent::__construct();
	}

	public function build($text='', $isBarcode = false)
	{	
		$qrCode = new QrCode($text);

		header('Content-Type: '.$qrCode->getContentType());
		echo $qrCode->writeString();
	}

}
