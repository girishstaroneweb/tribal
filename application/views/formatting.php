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
        $config['next_link'] = 'Next â†’';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'â†? Previous';
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

//            $msg = "
//			<p style='color: #333 !important;border-bottom: 1px solid #BEDAF1;padding-bottom: 10px;'>You are registered in Gujarat Tribal Yojana as " . $type . ", Please login using following details.</p>
//			<a href='#'>LINK</a>
//			<table style='color: #333 !important;'>
//			<tr>
//			<td>Username :</td>
//			<td>" . $name . "</td>
//			</tr>	
//			<tr>
//			<td>Password :</td>
//			<td>" . $pass . "</td>
//			</tr>	
//			</table>
//			<p style='font-weight: bold;'>Please do not reply on this email.This email is notification email </p>
//			";


            $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family:Helvetica Neue, Helvetica, Arial, sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" >
    <head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <meta name="viewport" content="width=device-width">
            
                <title>Alerts e.g. approaching your limit</title>


                <style type="text/css">
                </style>
                </head>

                <body itemscope="" itemtype="http://schema.org/EmailMessage"  bgcolor="#f6f6f6" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;height:100%;line-height:1.6em;background-color:#f6f6f6;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;width:100%;" >

                    <table class="body-wrap"  bgcolor="#f6f6f6" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;width:100%;background-color:#f6f6f6;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ><tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ><td  valign="top" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ></td>
                            <td class="container" width="600"  valign="top" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;display:block !important;max-width:600px !important;clear:both !important;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;" >
                                <div class="content" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;max-width:600px;display:block;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;" >
                                    <table class="main" width="100%" cellpadding="0" cellspacing="0"  bgcolor="#fff" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;border-radius:3px;background-color:#fff;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;border-width:1px;border-style:solid;border-color:#e9e9e9;" >
                                        <tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ><td class="alert alert-warning"  align="center" bgcolor="#5e9de8" valign="top" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:16px;vertical-align:top;color:#fff;font-weight:500;text-align:center;border-radius:3px 3px 0 0;background-color:#5e9de8;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;" >
                                               Gujarat Tribal Yojana
                                            </td>
                                        </tr>
                                        <tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ><td class="content-wrap"  valign="top" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;" >
                                                <table width="100%" cellpadding="0" cellspacing="0" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ><tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ><td class="content-block"  valign="top" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:20px;padding-right:0;padding-left:0;" >
                                                            You are registered in Gujarat Tribal Yojana as 
                                                            <strong style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" >
                                                               ' . $type . ',
                                                            </strong> 
                                                             Please login using following details.
                                                             
                                                            <br/>    
                                                            <br/>
                                                            USERNAME : <strong style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" >' . $name . '</strong> 
                                                            <br/>
                                                            PASSWORD : <strong style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" >' . $pass . '</strong> 
                                                        </td>
                                                    </tr>
                                                    <tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ><td class="content-block"  valign="top" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:20px;padding-right:0;padding-left:0;" >

                                                        </td>
                                                    </tr>
            <!--                                        <tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ><td class="content-block"  valign="top" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:20px;padding-right:0;padding-left:0;" >
                                                            <a href="http://www.mailgun.com" class="btn-primary" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;color:#FFF;text-decoration:none;line-height:2em;font-weight:bold;text-align:center;cursor:pointer;display:inline-block;border-radius:5px;text-transform:capitalize;background-color:#348eda;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;border-color:#348eda;border-style:solid;border-width:10px 20px;" >Upgrade my account</a>
                                                        </td>
                                                    </tr>-->
                                                    <tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ><td class="content-block"  valign="top" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:20px;padding-right:0;padding-left:0;" >
                                                            
                                                        </td>
                                                    </tr></table></td>
                                        </tr></table><div class="footer" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;width:100%;clear:both;color:#999;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;" >
                                        <table width="100%" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ><tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ><td class="aligncenter content-block"  align="center" valign="top" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:12px;vertical-align:top;color:#999;text-align:center;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:20px;padding-right:0;padding-left:0;" ><a href="http://www.mailgun.com" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:12px;color:#999;text-decoration:underline;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" >Unsubscribe</a> from these alerts.</td>
                                            </tr></table></div></div>
                            </td>
                            <td  valign="top" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" ></td>
                        </tr></table></body>
                </html>';
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

            redirect("user");
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


    public function user_search($offset = 0) {
        $search = $this->input->post('search');
        $data['users'] = $this->model->user_search($search);
        $this->load->view('header');
        $this->load->view('user/user', $data);
        $this->load->view('footer');
    }

	
	public function change_pass($id="NULL"){
		if($this->input->post('save')=='save')
		{
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
				redirect('user/changepass');
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
		else
		{
			$this->load->view('header');
			$this->load->view('user/change_pass');
			$this->load->view('footer');
		}
	}

}

//End of class
