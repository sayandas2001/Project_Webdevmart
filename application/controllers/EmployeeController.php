<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeController extends CI_Controller {

    private $upload_path = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('Employee_model');
        $this->load->helper(array('url', 'form'));
        $this->upload_path = FCPATH . 'assets/employee/';
        $this->load->library(array('upload', 'image_lib', 'session', 'form_validation'));
    }

    public function index() {
        if ($this->session->userdata('employee_name')) {
            redirect('EmployeeController/dashboard');
        }
        $this->load->view('employee/login');
    }

    public function login() {
        $user_name = $this->input->post('user_name');
        $password = $this->input->post('password');

        $user = $this->Employee_model->check_login($user_name, $password);

        if ($user) {
            $this->session->set_userdata('employee_name', $user->name);
            redirect('EmployeeController/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('EmployeeController');
        }
    }

    public function dashboard() {
        if (!$this->session->userdata('employee_name')) {
            redirect('EmployeeController');
        }
        $data['employees'] = $this->Employee_model->get_all_employees();
        $data['name'] = $this->session->userdata('employee_name');
        $this->load->view('employee/dashboard', $data);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('EmployeeController');
    }

    public function list_employees() {
        if (!$this->session->userdata('employee_name')) {
            redirect('EmployeeController');
        }
        $data['employees'] = $this->Employee_model->get_all_employees();
        $this->load->view('employee/list_employee', $data);
    }

    public function add_employee() {
        if (!$this->session->userdata('employee_name')) {
            redirect('EmployeeController');
        }
        $this->load->view('employee/add_employee');
    }

    public function insert_employee() {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $upload_file = '';
            if(isset($_FILES['picture']) && $_FILES['picture']['name']!=""){
                $config['upload_path']   = $this->upload_path."original/";
                $config['allowed_types'] = "jpg|jpeg|gif|png|pdf|doc|docx";
                $config['max_size']      = '1000000';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if(!$this->upload->do_upload('picture')){
                    $msg = $this->upload->display_errors();
                } else {
                    $upload_file_data = $this->upload->data();
                    $upload_file = $upload_file_data['file_name'];
                }

            }

            $data = [
                'name'        => $this->input->post('name'),
                'address'     => $this->input->post('address'),
                'designation' => $this->input->post('designation'),
                'salary'      => $this->input->post('salary'),
                'picture'     => $upload_file
            ];
            //print_r($data); die;
            $this->Employee_model->insert_employee($data);
            redirect('EmployeeController/list_employees');
        } else {
            $this->session->set_flashdata('error_msg', validation_errors());
            redirect('EmployeeController/add_employee');
        }
    }

    public function edit_employee($id) {
        if (!$this->session->userdata('employee_name')) {
            redirect('EmployeeController');
        }
        $data['employee'] = $this->Employee_model->get_employee_by_id($id);
        $this->load->view('employee/edit_employee', $data);
    }

    public function update_employee($id) {
        $employee = $this->Employee_model->get_employee_by_id($id);
        $upload_file = $employee->picture;

        if(isset($_FILES['picture']) && $_FILES['picture']['name'] != ""){
            $config['upload_path']   = $this->upload_path . "original/";
            $config['allowed_types'] = "jpg|jpeg|gif|png|pdf|doc|docx";
            $config['max_size']      = '1000000';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('picture')) {
                $msg = $this->upload->display_errors();
                $this->session->set_flashdata('error_msg', $msg);
                redirect('EmployeeController/edit_employee/'.$id);
            } else {
                // Optionally delete the old image file
                if (!empty($employee->picture) && file_exists($this->upload_path . 'original/' . $employee->picture)) {
                    unlink($this->upload_path . 'original/' . $employee->picture);
                }
                $upload_file_data = $this->upload->data();
                $upload_file = $upload_file_data['file_name'];
            }
        }

        $data = [
            'name' => $this->input->post('name'),
            'address' => $this->input->post('address'),
            'designation' => $this->input->post('designation'),
            'salary' => $this->input->post('salary'),
            'picture'     => $upload_file
        ];

        $this->Employee_model->update_employee($id, $data);
        redirect('EmployeeController/list_employees');
    }

    public function delete_employee($id) {
        $this->Employee_model->delete_employee($id);
        redirect('EmployeeController/list_employees');
    }
}
