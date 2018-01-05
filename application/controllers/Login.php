<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent:: __construct();
        $this->load->model('alldata', 'model');
    }

    public function index() {
        $data['dist'] = $this->model->getDatamodel('tbl_dist');
        $this->load->view('login', $data);
    }

    public function getcity($dist) {
        $where = array('dist_id' => $dist);
        $city = $this->model->DetailData('tbl_city', $where);
        echo ' <option value=""> --SELECT CITY-- </option>';

        foreach ($city as $key) {
            echo '<option value="' . $key['id'] . '">' . $key['city_name'] . '</option>';
        }
    }

    public function get_village($city) {
        $where = array('city_id' => $city);
        $vil = $this->model->DetailData('tbl_village', $where);
        echo ' <option value=""> --SELECT VILLAGE-- </option>';

        foreach ($vil as $key) {
            echo '<option value="' . $key['id'] . '">' . $key['vil_name'] . '</option>';
        }
    }

    function chkLogin() {


        $dist = $this->input->post("dist");
        if ($dist != '') {
            $city = $this->input->post('city');
            $vil = $this->input->post('vil');

            $this->db->where("dist", $dist);
            $this->db->where("city", $city);
            $this->db->where("vil", $vil);
        }

        $pass = md5($this->input->post("pass"));
        $this->db->where("username", $this->input->post("uname"));
        $this->db->where("password", $pass);
        $this->db->where("status", 'active');
        //$this->db->where("type", $this->input->post("type"));
        $query = $this->db->get("tblusers");
        
//        $lastQuery = $this->db->last_query();
//        echo $lastQuery  ;die;
        $logindata = $query->result_array();

        if ($query->num_rows() == 1) {
            $this->session->set_userdata('userinfo', $logindata);
            $user = $this->input->post("uname");
            $where = array('username' => $user);
            $insertdata = array('last_login' => date("Y-m-d H:i:s"));
            $this->model->UpdateData('tblusers', $insertdata, $where);
            redirect('welcome');
        }


        $this->session->set_flashdata('msg', ' <div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button> <strong>Error!</strong> Wrong User name OR Password. </div>');
        redirect('login');
    }

    function logout() {
        $userdata = $this->session->userdata('userinfo');
        $where = array('username' => $user);
        $insertdata = array('last_login' => date("Y-m-d H:i:s"));
        $this->model->UpdateData('tblusers', $insertdata, $where);

        $this->session->unset_userdata('userinfo');
        redirect('login');
    }

}
