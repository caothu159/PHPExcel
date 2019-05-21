<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
     * @param $year
     * @param $month
     */
    public function t($year = false, $month = false)
    {
        return $this->prepare($year, $month);
    }

    /**
     * @param $year
     */
    private function prepareHtml(
        $year = false,
        $month = false
    ) {
        $this->load->view('list', array(
            'years' => $this->thoiGian->years(),
            'year'  => $year,
            'month' => $month,
        ));
        if (!$year) {
            return;
        }
        if (!$month) {
            return;
        }
        $this->nhanSu = $this->data
            ->setYear($year)
            ->setMonth($month)
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
     * @param bool $year
     * @param bool $month
     */
    private function prepare($year = false, $month = false)
    {
        $this->load->view('header', array(
            'year' => $year,
        ));
        $this->prepareHtml($year, $month);
        $this->load->view('footer');
    }

    /**
     * @param $arg
     */
    private function debug($arg)
    {
//        echo '<pre>';
        //        print_r($arg);
        //        echo '</pre>';
    }
}
