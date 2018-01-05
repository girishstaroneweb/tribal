<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('alldata', 'model');
        
    }

    public function index_old() {
        $this->load->view('header');
        $data['users'] = $this->model->getUsersListing();
        $this->load->view('user/user', $data);
        $this->load->view('footer');
        
        
        //extra test line added by girish 
        //extra test line added by girish 
        //extra test line added by vishal
	//extra test line added by girish ninama
        
        
    }

    public function index($offset = 0) {
        //$data['data']=$this->model->getDatamodel('tbl_village');

        $cnt = count($this->model->getDatamodel('tblusers'));
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'user/index/';
        $config['total_rows'] = $cnt;
        $config['per_page'] = 5;

        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $config['next_link'] = 'Next →';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '�? Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
//        $this->db->order_by("id", "desc");
        $data['users'] = $this->model->getUsersListing($config['per_page'], $offset);

        $this->load->view('header');
        $this->load->view('user/user', $data);
        $this->load->view('footer');
    }

    public function add() {
        if ($this->input->post('save') == 'save') {
            $dist = $this->input->post('dist');
            $city = $this->input->post('city');
            $vil = $this->input->post('vil');

            $name = $this->input->post('u_name');
            $type = $this->input->post('u_type');
            $email = $this->input->post('u_email');
            $pass = $this->model->generate_password();

            $to = $email;
            $subject = "New Registration";

            $msg = "
			<p style='color: #333 !important;border-bottom: 1px solid #BEDAF1;padding-bottom: 10px;'>You are registered in Gujarat Tribal Yojana as " . $type . ", Please login using following details.</p>
			<a href='#'>LINK</a>
			<table style='color: #333 !important;'>
			<tr>
			<td>Username :</td>
			<td>" . $name . "</td>
			</tr>	
			<tr>
			<td>Password :</td>
			<td>" . $pass . "</td>
			</tr>	
			</table>
			<p style='font-weight: bold;'>Please do not reply on this email.This email is notification email </p>
			";
            $this->model->emailsend($to, $subject, $msg);

            $insertdata = array(
                'dist' => $dist,
                'city' => $city,
                'vil' => $vil,
                'username' => $name,
                'email' => $email,
                'password' => md5($pass),
                'type' => $type,
                'created_date' => date('Y-m-d H:i:s'),
                'status' => 'active'
            );

            $this->model->insertData('tblusers', $insertdata);
            $this->session->set_flashdata('msg', ' <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button> <strong>Success!</strong>  User has been added. </div>');


            /* $this->load->view('header');
              $data['users']=$this->model->getDatamodel('tblusers');
              $this->load->view('user/user', $data);
              $this->load->view('footer'); */
            redirect('user');
        } else {
            $data['dist'] = $this->model->getDatamodel('tbl_dist');
            $this->load->view('header');
            $this->load->view('user/add_user', $data);
            $this->load->view('footer');
        }
    }

    public function edit($encrypted_string) {

        $id = $this->model->decryptdata($encrypted_string);
        $where = array('uid' => $id);
        if ($this->input->post('save') == 'save') {


//            echo'<pre>';
//            print_r($_POST);
//            print_r($id);
//            die;

            $dist = $this->input->post('dist');
            $city = $this->input->post('city');
            $vil = $this->input->post('vil');
            $name = $this->input->post('u_name');
            $type = $this->input->post('u_type');
            $email = $this->input->post('u_email');

            $insertdata = array(
                'dist' => $dist,
                'city' => $city,
                'vil' => $vil,
                'username' => $name,
                'type' => $type,
                'email' => $email
            );

            $this->model->UpdateData('tblusers', $insertdata, $where);
            $this->session->set_flashdata('msg', ' <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button> <strong>Success!</strong> User has been updated. </div>');

            redirect('user');
        } else {


            $data['dist'] = $this->model->getDatamodel('tbl_dist');
            $data['city'] = $this->model->getDatamodel('tbl_city');
            $data['village'] = $this->model->getDatamodel('tbl_village');
            $data['view'] = $this->model->DetailData('tblusers', $where);

//            echo '<pre>';
//            print_r($data['view']);
//            die;



            $this->load->view('header');
            $this->load->view('user/add_user', $data);
            $this->load->view('footer');
        }
    }

    public function deleteuser() {
        $ids = $this->input->post('ck');
        $n = count($ids);
        for ($i = 0; $i < $n; $i++) {
            $id = $ids[$i];
            $where = array('uid' => $id);
            $this->model->DeleteData('tblusers', $where);
        }

        $this->session->set_flashdata('msg', ' <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button> <strong>Success!</strong> Data has been deleted. </div>');
        redirect('user');
    }

    public function deactiveUser($id) {


        $id = $this->model->decryptdata($id);
        $data = array('status' => 'deactive');
        $id = array('uid' => $id);
        $this->model->updatedata('tblusers', $data, $id);
        $this->session->set_flashdata('msg', ' <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button> <strong>Success!</strong> User is deactivated.  </div>');
        redirect('user');
    }

    public function activeUser($id) {
        $id = $this->model->decryptdata($id);
        $data = array('status' => 'active');
        $id = array('uid' => $id);
        $this->model->updatedata('tblusers', $data, $id);
        $this->session->set_flashdata('msg', ' <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button> <strong>Success!</strong> User is activated.  </div>');
        redirect('user');
    }

    public function changepass($id) {
        $userdata = $this->session->userdata('userinfo');
        $email = $userdata[0]['email'];
        $name = $userdata[0]['username'];

        $data = array('password' => md5($this->input->post('new_pass')));
        $pass = $this->input->post('new_pass');
        $ids = array('uid' => $id);
        $conform = array('uid' => $id, 'password' => md5($this->input->post('old_pass')));
        $getuser = $this->db->get_where('tblusers', $conform)->num_rows();
        if ($getuser == 0) {
            $this->session->set_flashdata('msg', ' <div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button> <strong>Error!</strong>  Invalid old password. </div>');
            redirect('welcome/changepassword');
        } else {
            $to = $email;
            $subject = "New Password";
            $msg = "
			<p style='color: #333 !important;border-bottom: 1px solid #BEDAF1;padding-bottom: 10px;'>Hello " . $name . ", Your password has been updated, Please login using following password.</p>
			<a href='http://richainfosys.com/riims/login'>http://richainfosys.com/riims/login</a>
			<table style='color: #333 !important;'>
			<td>Password :</td>
			<td>" . $pass . "</td>
			</tr>	
			</table>
			<p style='font-weight: bold;'>Please do not reply on this email.This email is notification email </p>
			";
            $this->model->emailsend($to, $subject, $msg);

            $this->model->updatedata('tblusers', $data, $ids);
            $userdata['data'] = $this->model->getDatamodel('tblusers');
            $this->session->set_flashdata('msg', ' <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button> <strong>Success!</strong>  Password changed. </div>');
            $this->session->unset_userdata('userinfo');
            redirect(base_url() . 'login');

            //
        }
    }

    public function user_search($offset = 0) {
        $search = $this->input->post('search');
        $data['users'] = $this->model->user_search($search);
        $this->load->view('header');
        $this->load->view('user/user', $data);
        $this->load->view('footer');
    }

    public function Import_Excel() {

        $this->load->library('excel_reader');
        $this->excel_reader->read('./uploads/girish.xls');
        $worksheet = $this->excel_reader->worksheets[0];
        echo '<pre>';
        print_r($worksheet);
        print_r($worksheet);
        die;
        
    }

}

//End of class
