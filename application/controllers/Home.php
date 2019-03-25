<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Class Salary
 */
class Home extends CI_Controller
{
	/**
	 * @var array
	 */
	private $nhanSu = array();

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
	 * @param $time
	 */
	public function time(
		$time
	) {
		return $this->prepare($time);
	}

	/**
	 * @param $time
	 */
	private function prepareHtml(
		$time = false
	) {
		$this->load->view('list', array(
			'list' => $this->thoiGian->list(),
			'time' => $time,
		));
		if (!$time) {
			return;
		}
		$this->nhanSu = $this->data
			->setTime($time)
			->getNhanSu();

		$nhanSu = array();
		foreach ($this->nhanSu as $name => $ns) {
			$ns->setCongNhat($this->data->chamcong())
			   ->setTuyen($this->data->phancong())
			   ->setNangSuat($this->data->nangsuat());
			$nhanSu[$name] = $ns;
		}

		$this->load->view('salary', array(
			'salary' => $nhanSu,
		));
	}

	/**
	 * @param bool $time
	 */
	private function prepare(
		$time = false
	) {
		$this->load->view('header', array(
			'time' => $time,
		));
		$this->prepareHtml($time);
		$this->load->view('footer');
	}

	/**
	 * @param $arg
	 */
	private function debug(
		$arg
	) {
//		echo '<pre>';
//		print_r($arg);
//		echo '</pre>';
	}
}
