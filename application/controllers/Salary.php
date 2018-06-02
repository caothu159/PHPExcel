<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Salary
 */
class Salary extends CI_Controller
{
	/**
	 * @var array
	 */
	private $nhanSu = array();
	/**
	 * @var array
	 */
	private $nangsuat = array();
	/**
	 * @var array
	 */
	private $chamcong = array();
	/**
	 * @var array
	 */
	private $phancong = array();

	/**
	 * Salary constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('data');
	}

	/**
	 *
	 */
	public function index()
	{
		return $this->prepare();
	}

	/**
	 * @param $time
	 */
	public function time($time)
	{
		return $this->prepare($time);
	}

	/**
	 * @param $time
	 */
	private function prepareHtml($time)
	{
		$this->load->view('list', array(
			'list' => array(),
		));
		if (!$time) {
			return;
		}
		$this->data->setTime($time);
		$this->nhanSu   = $this->data->getNhanSu();
		$this->nangsuat = $this->data->nangsuat();
		$this->chamcong = $this->data->chamcong();
		$this->phancong = $this->data->phancong();
		$this->load->view('salary');

		$this->debug($this->nhanSu);

		$this->debug($this->chamcong);
		$this->debug($this->phancong);
		$this->debug($this->nangsuat);
	}

	/**
	 * @param bool $time
	 */
	private function prepare($time = false)
	{
		$this->load->view('header');
		$this->prepareHtml($time);
		$this->load->view('footer');
	}

	/**
	 * @param $arg
	 */
	private function debug($arg)
	{
		echo '<pre>';
		print_r($arg);
		echo '</pre>';
	}
}
