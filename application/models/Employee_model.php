
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    public function check_login($user_name, $password) {
        $this->db->where('user_name', $user_name);
        $this->db->where('password', $password);
        $query = $this->db->get('login_details');

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    
    public function insert_employee($data) {
        return $this->db->insert('emp_details', $data);
    }

    public function get_all_employees() {
        return $this->db->get('emp_details')->result();
    }

    public function get_employee_by_id($id) {
        return $this->db->get_where('emp_details', ['id' => $id])->row();
    }

    public function update_employee($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('emp_details', $data);
    }

    public function delete_employee($id) {
        return $this->db->delete('emp_details', ['id' => $id]);
    }
}