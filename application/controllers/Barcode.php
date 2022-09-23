<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode extends CI_Controller {

	function __construct ()
	{	
		parent::__construct();
	}

	public function build($text='')
	{	
		$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
		echo $generator->getBarcode('081231723897', $generator::TYPE_CODE_128,2,60);
	}

}
