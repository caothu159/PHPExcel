<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Salary.
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

    public function index()
    {
        return $this->prepare();
    }

    private function prepareHtml()
    {
        $this->load->view('list', [
            'years' => $this->thoiGian->years(),
            'year'  => false,
        ]);
    }

    private function prepare()
    {
        $this->load->view('header', [
            'year' => false,
        ]);
        $this->prepareHtml();
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
