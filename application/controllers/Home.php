<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Class Salary
 */
class Home extends CI_Controller
{

	/**
	 * Salary constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('data');
		$this->load->model('thoiGian');
	}

	/**
	 *
	 */
	public function index()
	{
		return $this->prepare();
	}

	/**
	 *
	 */
	private function prepareHtml()
	{
		$this->load->view('list', array(
			'years' => $this->thoiGian->years(),
			'year'  => false,
		));

		return;
	}

	/**
	 *
	 */
	private function prepare()
	{
		$this->load->view('header', array(
			'year' => false,
		));
		$this->prepareHtml();
		$this->load->view('footer');

		return;
	}

	/**
	 * @param $arg
	 */
	private function debug($arg)
	{
//		echo '<pre>';
//		print_r($arg);
//		echo '</pre>';
	}
}
