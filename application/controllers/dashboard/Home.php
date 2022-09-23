<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Jenssegers\Date\Date;

/**
 * Home controller.
 *
 * @package App
 * @category Controller
 * @author Ardi Soebrata
 */
class Home extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('poli_model');

		$this->module = "dashboard";
		$this->controller = $this->module."/home";

		$this->title = 'Dashboard';
		$this->icon = 'fa fa-tachometer-alt';

		$this->data['icon'] = $this->icon;
		$this->data['title'] = $this->title;
		$this->data['module_url']= $this->controller;
	}

	public function index()
	{
		Date::setLocale('id');
		$poliklinik = $this->poli_model->get_all();
		$this->data['poliklinik'] = $poliklinik;
		$this->template
			->set_title('Home')
			->set_js('plugins/visualization/echarts/echarts.min', false)
			->build('dashboard/index', $this->data);
	}
}
