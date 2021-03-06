<?php

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('usersModel');
        $data['content'] = $this->usersModel->getAll();
        $this->load->view('users', $data);
        // echo 'hrhr';
    }

    public function get($id)
    {
        $id = intval($id);
        if ($id != 0) {
            $this->load->model('usersModel');
            $data['content'] = $this->users->get($id);
            $this->load->view('users', $data);
        } else {
            redirect(site_url(), 'refresh');
        }
    }

    public function add()
    {
        $this->form_validation->set_rules('element', 'Element label', 'trim|required');
        if ($this->form_validation->run() === false) {
            $data['input_element'] = array('name' => 'element', 'id' => 'element', 'value' => set_value('element'));
            $this->load->view('users', $data);
        } else {
            $field = $this->input->post('element');
            $this->load->model('usersModel');
            if ($this->users_model->add(array('field_name' => $field))) {
                $this->load->view('users_success_page');
            } else {
                $this->load->view('users_error_page');
            }
        }
    }

    public function edit()
    {
        $this->form_validation->set_rules('element', 'Element label', 'trim|required');
        $this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
        if ($this->form_validation->run() === false) {
            if (!$this->input->post()) {
                $id = intval($this->uri->segment($this->uri->total_segments()));
            } else {
                $id = set_value('id');
            }
            $data['input_element'] = array('name' => 'element', 'id' => 'element', 'value' => set_value('element'));
            $data['hidden']        = array('id' => set_value('id', $id));
            $this->load->view('users', $data);
        } else {
            $element = $this->input->post('element');
            $id      = $this->input->post('id');
            $this->load->model('usersModel');
            if ($this->users_model->update(array('element' => $element), array('id' => $id))) {
                $this->load->view('users_success_page', $data);
            } else {
                $this->load->view('users_error_page');
            }
        }
    }
    public function delete($id)
    {
        $id = intval($id);
        if ($id != 0) {
            $this->load->model('usersModel');
            $data['content'] = $this->users->delete();
            $this->load->view('users', $data);
        } else {
            redirect(site_url(), 'refresh');
        }
    }
}
/* End of file '/Users.php' */
/* Location: ./application/controllers//Users.php */
