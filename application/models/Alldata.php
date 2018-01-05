<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Alldata extends CI_Model {

    public function insertData($table, $data) {
        $dates = array('lasttime' => date("Y-m-d H:i:s"));
        $this->db->update('lastmodifytime', $dates);
        $query = $this->db->insert($table, $data);
        /* if(!$query)
          {
          //redirect('welcome/errorpage');
          show_error("ERROR", 500 );
          exit;
          } */
    }

    public function getDatamodel($table) {

        $query = $this->db->get($table);
        if (!$query) {
            //redirect('welcome/errorpage');
            show_error("ERROR", 500);
            exit;
        }
        return $query->result_array();
    }

    public function DeleteData($table, $where) {

        $query = $this->db->delete($table, $where);
        if (!$query) {
            //redirect('welcome/errorpage');
            show_error("ERROR", 500);
            exit;
        }
    }

    public function DetailData($table, $where) {

        $result = $this->db->get_where($table, $where);
        if (!$result) {
            //redirect('welcome/errorpage');
            show_error("ERROR", 500);
            exit;
        }
        return $result->result_array();
    }

    public function UpdateData($table, $data, $where) {
        $dates = array('lasttime' => date("Y-m-d H:i:s"));
        $this->db->update('lastmodifytime', $dates);

        $query = $this->db->update($table, $data, $where);
        if (!$query) {
            //redirect('welcome/errorpage');
            show_error("ERROR", 500);
            exit;
        }
    }

    public function generate_password($length = 8) {

        $chars = 'abcdefghijklmnopqrstuvwxyz' .
                '0123456789';

        $str = '';

        $max = strlen($chars) - 1;



        for ($i = 0; $i < $length; $i++)
            $str .= $chars[mt_rand(0, $max)];



        return $str;
    }

    public function decryptdata($sData) {

        $url_id = base64_decode($sData);

        $id = (double) $url_id / 6752415;

        return $id;
    }

    public function encryptdata($sData) {

        $id = (double) $sData * 6752415;

        return base64_encode($id);
    }

    public function sortingdata($selectdata, $table, $order) {

        $this->db->select($selectdata);

        $this->db->from($table);

        $this->db->order_by($order);

        return $this->db->get()->result_array();
    }

    //=============== CREATED BY NIKITA PRAJAPATI ============================== 
    public function sortingWheredata($selectdata, $table, $where, $order_id, $order) {
        //$this->db->_protect_identifiers = FALSE;
        if ($where != "null") {

            $this->db->where($where);
        }
        $sel = $this->db->select($selectdata, false);
        $this->db->from($table);
        $this->db->order_by($order_id, $order);

        return $this->db->get()->result_array();
        echo "<pre>";

        print_r($sel);
        echo "</pre>";
    }

    public function sortingWheredata_OR($selectdata, $table, $where, $order_id, $order) {
        if ($where != "null") {
            $this->db->or_where($where);
        }
        $this->db->select($selectdata, false);
        $this->db->from($table);
        $this->db->order_by($order_id, $order);

        return $this->db->get()->result_array();
    }

    public function LimitWheredata($selectdata, $table, $where, $order_id, $order, $lmt) {
        if ($where != "null") {
            $this->db->where($where);
        }
        $this->db->select($selectdata);
        $this->db->from($table);
        $this->db->order_by($order_id, $order);
        $this->db->limit($lmt);
        return $this->db->get()->result_array();
    }

    public function containdetail($where) {
        $session_data = $this->session->all_userdata();
        $lang = $session_data['flang'];
        $this->db->order_by("menu_position", "asc");
        $sel = $this->db->select('*');
        $this->db->from($lang . 'tblmenu');
        $this->db->where($where);
        $this->db->join($lang . 'tblcontent', $lang . 'tblmenu.menu_content = ' . $lang . 'tblcontent.content_id', 'left');
        $this->db->join('tblbanners', 'tblbanners.banner_id =' . $lang . 'tblcontent.banner_id', 'left');
        return $this->db->get()->result_array();

        /*  $query=$this->db->get();
          if(!$query)
          {
          //redirect('welcome/errorpage');
          show_error("ERROR", 500 );
          exit;
          }
          return $query->result_array();
         */
    }

    //page view in backend...........
    public function pagedetail($where) {
        $session_data = $this->session->all_userdata();
        $lang = $session_data['flang'];
        $sel = $this->db->select('*');
        $this->db->from($lang . 'tblcontent');
        $this->db->where($where);
        $this->db->join('tblbanners', 'tblbanners.banner_id =' . $lang . 'tblcontent.banner_id', 'left');
        return $this->db->get()->result_array();
    }

    public function portfolio_model($where = 'NULL') {

        $session_data = $this->session->all_userdata();
        $lang = $session_data['flang'];
        if ($where != 'NULL') {
            $this->db->where($where);
        }
        $this->db->from($lang . 'tbl_portfolio as p1');

        $this->db->join('tbl_portfolio_category as p2', 'p2.portfolio_cat_id = p1.portfolio_cat_id', 'left');
        $this->db->order_by("portfolio_id", "desc");
        return $this->db->get()->result_array();
    }

    //send Feedback email //
    public function emailsend($to, $subject, $msg) {
        $email_config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'cp-dd-us-3.webhostbox.net',
            'smtp_port' => '465',
            'smtp_user' => 'noreply@starprojects.in',
            'smtp_pass' => '12noreply34',
            'mailtype' => 'html',
            'starttls' => true,
            'newline' => "\r\n"
        );
        $this->load->library('email', $email_config);
        $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
        $this->email->set_header('Content-type', 'text/html');
        $this->email->from('noreply@starprojects.in', 'RIIMS');
        $this->email->to($to);
        //$this->email->cc('vishal.panara@staroneweb.co.in');
        $this->email->subject($subject);
        $this->email->message($msg);
        $this->email->send();
        /* echo $this->email->print_debugger();  */
    }

    public function emailSendFormat($emailID, $sub, $msg_send, $regard = 'Au pair Just 4 You', $topmenu = 'not') {
        $contact_logo = $this->setting_model(array('other_cat' => 'logo'));

        $msg = '';
        $msg.="<div style='font-size:13px;'>
                        
                       
            
                        <div class='logo-head' style='border-top: 1px solid #70B3D0;border-bottom: 1px solid #70B3D0;border-left: 1px solid #70B3D0;border-right: 1px solid #70B3D0; background:#70B3D0;'>
                        <img src='" . base_url() . "bootstrap/images/" . $contact_logo[0]["other_image"] . "' class='img-rounded' alt='Logo' style='width: 150px;padding:1.5% 0 1.5% 1px;'> <small style='color: #d7d7d7;
    display: inline-block;
    vertical-align: bottom;
    margin: 0px 0 27px 17px;
    padding: 0px 0 5px 11px;
    border-left: 1px solid #e9eff2;
   
    font-style: italic;'><i>Au pair, Nanny, Caregiver, Housekeeper<i></small>  </div>
                        
                        <div class='data' style='border-bottom: 3px solid #70B3D0;border-left: 1px solid #70B3D0;border-right: 1px solid #70B3D0;padding:1%;background:#fff;color: #333 !important;'>
                        <!----------- Start: content -------------->";
        $msg.=$msg_send;
        if ($regard != 'NULL') {
            $msg.="    <!----------- END: content -------------->
                        <p style='margin-top:50px;color: #333 !important;'>Regards,<br />
                          " . $regard . "</p>";
        }

        $msg.=" </div>
                    </div>
                    ";
        echo $msg;

        $SEND_EMAIL = $this->emailsend($emailID, $sub, $msg);
        // $SEND_EMAIL_my=$this->emailsend('nikita.prajapati@staroneweb.co.in',$sub."[dev]",$emailID."=>".$msg); 
    }

    public function pagesesstion() {
        //----- send link session -----
        //set a 404 page
        if ($this->uri->segment(3) === FALSE) {
            $id = "";
        } else {
            $id = urldecode($this->uri->segment(3));
        }
        if ($id != "") {
            $where = array('slug' => $id);
            $this->session->set_userdata('flang', '');
        }
    }

    public function Captchaimage() {
        $randomnr = rand(1000, 9999);
        $this->session->set_userdata('ramdom', md5($randomnr));

        $im = imagecreatetruecolor(100, 38);

        $white = imagecolorallocate($im, 255, 255, 255);
        $grey = imagecolorallocate($im, 150, 150, 150);
        $black = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 200, 35, $grey);

        //path to font - this is just an example you can use any font you like:

        $font = 'fontcaptcha/arial.ttf';

        imagettftext($im, 20, 4, 22, 30, $black, $font, $randomnr);

        imagettftext($im, 20, 4, 15, 32, $white, $font, $randomnr);

        //prevent caching on client side:
        header("Expires: Wed, 1 Jan 2997 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        header("Content-type: image/gif");
        imagegif($im);
        imagedestroy($im);
    }

    public function menugroupdata($id) {
        $where1 = array('menushortcode' => $id);
        $view = $this->model->DetailData('tblmenugroup', $where1);
        $this->db->order_by("menu_position", "asc");
        $this->db->select('*');
        $this->db->from('tblmenu');
        $where = array('menugroup' => $view[0]['menugroup_id']);
        $this->db->where($where);
        $this->db->join('tblcontent', 'tblcontent.content_id = tblmenu.menu_content', 'left');
        $this->db->join('tblbanners', 'tblbanners.banner_id = tblcontent.banner_id', 'left');
        return $qry = $this->db->get()->result_array();
        //echo "<pre>";
        //print_r($qry);
    }

    public function setting_model($where = 'null', $order_by = 'null', $order = 'null') {

        if ($where != 'null') {
            $this->db->where($where);
        }
        if ($order_by != "null") {
            $this->db->order_by($order_by, $order);
        }
        $this->db->from('tbl_other_detail as o1');
        $this->db->join('tblcontent as c', 'o1.other_link = c.content_id', 'left');
        $query = $this->db->get(); //->result_array();
        if (!$query) {
            show_error("ERROR", 500);
            exit;
        } else {
            return $query->result_array();
        }
    }

    public function createSlug($slug) {

        $lettersNumbersSpacesHyphens = '/[^\-\s\pN\pL]+/u';
        $spacesDuplicateHypens = '/[\-\s]+/';

        $slug = preg_replace($lettersNumbersSpacesHyphens, '', $slug);
        $slug = preg_replace($spacesDuplicateHypens, '-', $slug);

        $slug = trim($slug, '-');

        return mb_strtolower($slug, 'UTF-8');
    }

    public function chklogin_fun($email, $pwd) {
        return $this->db->query("SELECT  `cr_id` AS reg_id ,  `email_address`,password,activation_code,'tbl_candidate_registration' AS `tbl`,'cr_id' AS `id`,'candidate' AS type
              FROM  `tbl_candidate_registration` 
              where email_address='" . $email . "' AND password ='" . $pwd . "'
              UNION 
              SELECT  `r_id` AS reg_id ,  `email_address`,password,activation_code,'tbl_registation' AS `tbl`,'r_id' AS `id`,'family' AS type
              FROM tbl_registation where email_address='" . $email . "' AND password ='" . $pwd . "'")->result_array();
    }

    public function record_count() {
        $session_data = $this->session->all_userdata();
        $lang = $session_data['lang'];
        return $this->db->count_all_results($lang . "tblposts");
    }

    Public function get_pagination($table, $limit, $offset) {
        $query = $this->db->get($table, $limit, $offset);
        return $query->result_array();
    }

    Public function get_rmpagination($table, $limit, $offset, $where) {
        $this->db->where($where);
        $query = $this->db->get($table, $limit, $offset)->result_array();
        return $query;
    }

    public function items($where) {
        $this->db->select('it.*,info.*,cat.*, it.createdby as createdby_it');
        // $this->db->from();
        $this->db->where($where);
        $this->db->join('item_cat_master as cat', 'cat.cat_id = it.cat_id', 'left');
        $this->db->join('item_info_master as info', 'info.i_id = it.i_id', 'left');
        return $this->db->get('item_master as it')->result_array();
        //$get['item']= $this->db->get('item_master as it')->result_array();  
    }

    public function iw() {
        $this->db->select('it.*,iw.*,ven.*,iit.*');
        $this->db->join('vender_master as ven', 'ven.ven_id = iw.ven_name', 'left');
        $this->db->join('item_master as it', 'it.i_id = iw.item_name', 'left');
        $this->db->join('item_info_master as iit', 'iit.i_info_id = iw.model_name', 'left');
        return $this->db->get('tbl_inward as iw')->result_array();
        //$get['item']= $this->db->get('item_master as it')->result_array();  
    }

    public function ow() {
        $this->db->select('it.*,ow.*,del.*');
        // $this->db->from();
        //$this->db->where($where);
        $this->db->join('dealer_master as del', 'del.del_id = ow.del_name', 'left');
        $this->db->join('item_master as it', 'it.i_id = ow.item_name', 'left');
        return $this->db->get('tbl_outward as ow')->result_array();
    }

    public function view_vender($where) {
        $this->db->select('it.*,ven.*');
        $this->db->where($where);
        $this->db->join('item_cat_master as it', 'it.cat_id = ven.cat_id', 'left');
        return $this->db->get('vender_master as ven')->result_array();
    }

    public function rm() {
        $this->db->select('it.*,rm.*,del.*');
        //$this->db->where($where);
        $this->db->join('dealer_master as del', 'del.del_id = rm.del_name', 'left');
        $this->db->join('item_master as it', 'it.i_id = rm.item_name', 'left');
        return $this->db->get('tbl_rm as rm')->result_array();
    }

    public function view_rm($where) {
        $this->db->select('info.*,rm.*');
        $this->db->where($where);
        $this->db->join('tbl_rm_info as info', 'info.rmid = rm.rm_id', 'left');
        return $this->db->get('tbl_rm as rm')->result_array();
    }

    public function wrn_data($where) {
        $this->db->select('ow.*,rm.*');
        $this->db->where($where);
        $this->db->join('tbl_outward as ow', 'ow.model_name = rm.item_name', 'left');
        return $this->db->get('tbl_rm as rm')->result_array();
    }

    public function viewpo($where) {
        $this->db->select('info.*,po.*');
        $this->db->where($where);
        $this->db->join('item_info_master as info', 'info.i_info_id = po.model', 'left');
        return $this->db->get('tbl_po as po')->result_array();
    }

    public function viewPoinfo($where) {
        $this->db->select('info.*,po.*,iinfo.*,ven.*');
        $this->db->where($where);
        $this->db->join('tbl_po_info as info', 'info.poid = po.po_id', 'left');
        $this->db->join('item_info_master as iinfo', 'iinfo.i_info_id = info.model', 'left');
        $this->db->join('vender_master as ven', 'ven.ven_id = po.po_to', 'left');
        return $this->db->get('tbl_po as po')->result_array();
    }

    public function viewIntPoinfo($where) {
        $this->db->select('info.*,po.*,iinfo.*');
        $this->db->where($where);
        $this->db->join('tbl_int_po_info as info', 'info.poid = po.po_id', 'left');
        $this->db->join('item_info_master as iinfo', 'iinfo.i_info_id = info.model', 'left');
        return $this->db->get('tbl_int_po as po')->result_array();
    }

    /* $this->db->select('*');
      $this->db->from('item_master as it');
      $this->db->where($where);
      $this->db->join('item_cat_master as cat', 'cat.cat_id = it.cat_id','left');
      return $this->db->get()->result_array(); */

    Public function get_iw($limit, $offset, $where) {
        $this->db->select('iw.*, ven.*, iw.createdby as createdby_iw');
        $this->db->where($where);
        $this->db->join('vender_master as ven', 'ven.ven_id = iw.ven_name', 'left');
        $query = $this->db->get('tbl_inward as iw', $limit, $offset);
        return $query->result_array();
    }

    Public function get_iw_search($search, $where) {

        $this->db->select('iw.*, ven.*, iw.createdby as createdby_iw');
        $this->db->where($where);
        $this->db->like('ven_cmp_name', $search);
        $this->db->or_like('ven_chal_num', $search);
        $this->db->or_like('ven_inv_num', $search);
        $this->db->or_like('inw_date', $search);
        $this->db->join('vender_master as ven', 'ven.ven_id = iw.ven_name', 'left');
        $query = $this->db->get('tbl_inward as iw');
        return $query->result_array();
    }

    public function view_iw($where) {
        $this->db->select('iw.*,iinfo.*,ven.*');
        $this->db->where($where);
        $this->db->join('tbl_inward_info as iinfo', 'iinfo.iwid = iw.inw_id', 'left');
        $this->db->join('vender_master as ven', 'ven.ven_id = iw.ven_name', 'left');
        return $this->db->get('tbl_inward as iw')->result_array();
    }

    Public function get_ow($limit, $offset, $where) {
        $this->db->select('ow.*, del.*, ow.createdby as createdby_ow');
        $this->db->where($where);
        $this->db->join('dealer_master as del', 'del.del_id = ow.del_name', 'left');
        $query = $this->db->get('tbl_outward as ow', $limit, $offset);
        return $query->result_array();
    }

    Public function get_ow_search($search, $where) {
        $this->db->select('ow.*, del.*, ow.createdby as createdby_ow');
        $this->db->where($where);
        $this->db->like('del_cmp_name', $search);
        $this->db->or_like('cust_name', $search);
        $this->db->or_like('chal_num', $search);
        $this->db->join('dealer_master as del', 'del.del_id = ow.del_name', 'left');
        $query = $this->db->get('tbl_outward as ow');
        return $query->result_array();
    }

    Public function get_ow_msearch($search, $where) {
        $this->db->select('ow.*, del.*, ow.createdby as createdby_ow');
        $this->db->or_like('chal_date', $search);
        $this->db->where($where);
        $this->db->join('dealer_master as del', 'del.del_id = ow.del_name', 'left');
        $query = $this->db->get('tbl_outward as ow');
        return $query->result_array();
    }

    public function view_ow($where) {
        $this->db->select('ow.*,del.*');
        $this->db->where($where);
        $this->db->join('dealer_master as del', 'del.del_id = ow.del_name', 'left');
        return $this->db->get('tbl_outward as ow')->result_array();
    }

    Public function get_so($limit, $offset, $where) {
        $this->db->select('so.*, del.*,so.createdby as createdby_so');
        $this->db->where($where);
        $this->db->join('dealer_master as del', 'del.del_id = so.so_to_del', 'left');
        $query = $this->db->get('tbl_so as so', $limit, $offset);
        return $query->result_array();
    }

    Public function get_so_search($where) {
        $this->db->select('so.*,so.createdby as createdby_so, del.*');
        $this->db->where($where);
        $this->db->join('dealer_master as del', 'del.del_id = so.so_to_del', 'left');
        $query = $this->db->get('tbl_so as so');
        return $query->result_array();
    }

    public function viewSoinfo($where) {
        $this->db->select('info.*,so.*,iinfo.*,del.*');
        $this->db->where($where);
        $this->db->join('tbl_so_info as info', 'info.soid = so.so_id', 'left');
        $this->db->join('item_info_master as iinfo', 'iinfo.i_info_id = info.model', 'left');
        $this->db->join('dealer_master as del', 'del.del_id = so.so_to_del', 'left');
        return $this->db->get('tbl_so as so')->result_array();
    }

    public function getiwItem() {
        $this->db->select('it.*,iw.*');
        $this->db->join('item_info_master as it', 'it.i_info_id = iw.model_name', 'left');
        return $this->db->get('tbl_inward_info as iw')->result_array();
    }

    public function getiwVen() {
        $this->db->select('ven.*,iw.*');
        $this->db->group_by('ven_cmp_name');
        $this->db->join('vender_master as ven', 'ven.ven_id = iw.ven_name', 'left');
        return $this->db->get('tbl_inward as iw')->result_array();
    }

    public function getIwModel($where) {
        $this->db->select('info.*,iw.*');
        $this->db->group_by('model_name');
        $this->db->where($where);
        $this->db->join('item_info_master as info', 'info.i_info_id = iw.model_name', 'left');
        return $this->db->get('tbl_inward_info as iw')->result_array();
    }

    /* public function getLowStock($st_value){
      $this->db->where('iw_qty <=', $st_value);
      $this->db->select('info.*,iw.*,ven.*');
      $this->db->join('item_info_master as info', 'info.i_info_id = iw.model_name','left');
      $this->db->join('vender_master as ven', 'ven.ven_id = iw.vender','left');
      return $this->db->get('tbl_inward_info as iw')->result_array();
      } */

    public function getLowStock($st_value) {
        $this->db->where('open_stock_qty <=', $st_value);
        return $this->db->get('item_info_master')->result_array();
    }

    public function view_lead($where) {
        $this->db->select('lead.*,status.*,ls.*');
        $this->db->where($where);
        $this->db->join('tbl_lead_status as status', 'status.sid = lead.lead_status', 'left');
        $this->db->join('tbl_ls as ls', 'ls.ls_id = lead.lsid', 'left');
        return $this->db->get('tbl_lead as lead')->result_array();
    }

    Public function get_lead($limit, $offset) {
        $this->db->select('lead.*, status.*');
        $this->db->join('tbl_lead_status as status', 'status.sid = lead.lead_status', 'left');
        $query = $this->db->get('tbl_lead as lead', $limit, $offset);
        return $query->result_array();
    }

    Public function get_lead_search($search, $where) {
        $this->db->where($where);
        $this->db->like('f_name', $search);
        //$this->db->or_like('l_name', $search);
        //$this->db->or_like('company', $search);
        $this->db->or_like('lead_status', $search);
        $this->db->join('tbl_lead_status as status', 'status.sid = lead.lead_status', 'left');
        $query = $this->db->get('tbl_lead as lead');
        return $query->result_array();
    }

    Public function get_lead_search_admin($search) {
        $this->db->like('f_name', $search);
        $this->db->or_like('l_name', $search);
        $this->db->or_like('company', $search);
        $this->db->or_like('lead_status', $search);
        $this->db->join('tbl_lead_status as status', 'status.sid = lead.lead_status', 'left');
        $query = $this->db->get('tbl_lead as lead');
        return $query->result_array();
    }

    Public function get_sales($limit, $offset) {
        $this->db->select('sales.*, lead.*');
        $this->db->join('tbl_lead as lead', 'lead.lid = sales.to', 'left');
        $query = $this->db->get('tbl_lead_sales as sales', $limit, $offset);
        return $query->result_array();
    }

    Public function get_dash_sales() {
        $this->db->where('ow_status =', 0);
        $this->db->select('sales.*, lead.*');
        $this->db->join('tbl_lead as lead', 'lead.lid = sales.to', 'left');
        $query = $this->db->get('tbl_lead_sales as sales');
        return $query->result_array();
    }

    Public function get_sales_search($where) {
        $this->db->where($where);
        $this->db->join('tbl_lead as lead', 'lead.lid = sales.to', 'left');
        $query = $this->db->get('tbl_lead_sales as sales');
        return $query->result_array();
    }

    public function viewSalesinfo($where) {
        $this->db->select('info.*,lead.*,iinfo.*,mylead.*');
        $this->db->where($where);
        $this->db->join('tbl_lead_sales_info as info', 'info.s_id = lead.sid', 'left');
        $this->db->join('item_info_master as iinfo', 'iinfo.i_info_id = info.model', 'left');
        $this->db->join('tbl_lead as mylead', 'mylead.lid = lead.to', 'left');
        return $this->db->get('tbl_lead_sales as lead')->result_array();
    }

    /* public function viewreport($where){
      $this->db->select('si.*,s.*,user.*,mod.*,del.*,del.del_id as did');
      $this->db->where($where);
      $this->db->join('dealer_master as del', 'del.del_id = si.del_id','left');
      $this->db->join('item_info_master as mod', 'mod.i_info_id = si.model','left');
      $this->db->join('tblusers as user', 'user.uid = si.created_by','left');
      $this->db->join('tbl_lead_sales as s', 's.sid = si.sinfo_id','left');
      return $this->db->get('tbl_lead_sales_info as si')->result_array();
      } */

    public function viewreport($where) {
        $this->db->select('si.*,s.*,user.*,mod.*,mylead.*');
        $this->db->where($where);
        $this->db->join('tbl_lead as mylead', 'mylead.lid = si.to', 'left');
        $this->db->join('item_info_master as mod', 'mod.i_info_id = si.model', 'left');
        $this->db->join('tblusers as user', 'user.uid = si.created_by', 'left');
        $this->db->join('tbl_lead_sales as s', 's.sid = si.s_id', 'left');
        return $this->db->get('tbl_lead_sales_info as si')->result_array();
    }

    Public function getTargetUser($limit, $offset) {
        $this->db->select('target.*, user.*');
        $this->db->join('tblusers as user', 'user.uid = target.u_id', 'left');
        $query = $this->db->get('tbl_user_target as target', $limit, $offset);
        return $query->result_array();
    }

    Public function getTargetUser_dash() {
        $this->db->select('target.*, user.*');
        $this->db->join('tblusers as user', 'user.uid = target.u_id', 'left');
        $query = $this->db->get('tbl_user_target as target');
        return $query->result_array();
    }

    Public function get_pi($limit, $offset) {
        $this->db->select('pi.*, del.*,pi.createdby as createdby_so');
        $this->db->join('dealer_master as del', 'del.del_id = pi.so_to_del', 'left');
        $query = $this->db->get('tbl_perfoma_inv as pi', $limit, $offset);
        return $query->result_array();
    }

    Public function get_pi_search($where) {
        $this->db->select('pi.*, del.*,pi.createdby as createdby_so');
        $this->db->where($where);
        $this->db->join('dealer_master as del', 'del.del_id = pi.so_to_del', 'left');
        $query = $this->db->get('tbl_perfoma_inv as pi');
        return $query->result_array();
    }

    public function viewPiinfo($where) {
        $this->db->select('info.*,pi.*,iinfo.model_num,iinfo.hsn_code,iinfo.i_id,del.*');
        $this->db->where($where);
        $this->db->join('tbl_perfoma_inv_info as info', 'info.piid = pi.pi_id', 'left');
        $this->db->join('item_info_master as iinfo', 'iinfo.i_info_id = info.model', 'left');
        $this->db->join('dealer_master as del', 'del.del_id = pi.so_to_del', 'left');
        return $this->db->get('tbl_perfoma_inv as pi')->result_array();
    }

    Public function get_ow_ri($where) {
        $this->db->select('ow.*, del.*, ow.createdby as createdby_ow');
        $this->db->where($where);
        $this->db->join('dealer_master as del', 'del.del_id = ow.del_name', 'left');
        $query = $this->db->get('tbl_outward as ow');
        return $query->result_array();
    }

    Public function get_ow_dc($limit, $offset) {
        $this->db->select('dc.as,dc.owid,dc.dc_id,dc.createdon, ow.*, del.*,c.city');
        $this->db->join('tbl_outward as ow', 'ow.ow_id = dc.owid', 'left');
        $this->db->join('dealer_master as del', 'del.del_id = ow.del_name', 'left');
        $this->db->join('city_master as c', 'c.cid = dc.city', 'left');
        $query = $this->db->get('tbl_dc as dc', $limit, $offset);
        return $query->result_array();
    }

    Public function rm_model() {
        $this->db->select('ow.*, item.*');
        $this->db->join('item_info_master as item', 'item.i_info_id = ow.model_name', 'left');
        $query = $this->db->get('tbl_outward_info as ow');
        return $query->result_array();
    }

    Public function getrmDel() {
        $this->db->select('ow.*, del.*');
        $this->db->join('dealer_master as del', 'del.del_id = ow.del_name', 'left');
        $query = $this->db->get('tbl_outward as ow');
        return $query->result_array();
    }

    Public function get_rm($limit, $offset) {
        $this->db->select('rm.*, ow.install_date,ow.chal_num,ow.chal_date,ow.del_name,ow.cust_name');
        $this->db->join('tbl_outward as ow', 'ow.ow_id = rm.owid', 'left');
        //$this->db->join('tbl_outward_info as info', 'info.ow_id = rm.owid','left');
        $query = $this->db->get('tbl_rm as rm', $limit, $offset);
        return $query->result_array();
    }

    Public function getrm_ow($where) {
        $this->db->select('rm.*, ow.*');
        $this->db->where($where);
        $this->db->join('tbl_outward as ow', 'ow.ow_id = rm.owid', 'left');
        $query = $this->db->get('tbl_rm as rm');
        return $query->result_array();
    }

    Public function get_rm_search($where) {
        $this->db->select('rm.*, ow.*');
        $this->db->where($where);
        $this->db->join('tbl_outward as ow', 'ow.ow_id = rm.owid', 'left');
        //$this->db->join('tbl_outward_info as info', 'info.ow_id = rm.owid','left');
        $query = $this->db->get('tbl_rm as rm');
        return $query->result_array();
    }

//For AMC

    public function expire_this_month($where) {
        $this->db->limit(10);
        $this->db->where($where);
        $this->db->where('info.del_status', 'not_deleted');
        $this->db->select('ow.*,info.*,mod.*,del.*,ven.*');
        $this->db->join('tbl_outward as ow', 'ow.ow_id = info.ow_id', 'left');
        $this->db->join('item_info_master as mod', 'mod.i_info_id = info.model_name', 'left');
        $this->db->join('dealer_master as del', 'del.del_id = info.dealer', 'left');
        $this->db->join('vender_master as ven', 'ven.ven_id = info.vender', 'left');
        return $this->db->get('tbl_outward_info as info')->result_array();
    }

    public function expire_this_day($where) {
        $this->db->limit(10);
        $this->db->where($where);
        $this->db->where('info.del_status', 'not_deleted');
        $this->db->select('ow.*,info.*,mod.*,del.*,ven.*');
        $this->db->join('tbl_outward as ow', 'ow.ow_id = info.ow_id', 'left');
        $this->db->join('item_info_master as mod', 'mod.i_info_id = info.model_name', 'left');
        $this->db->join('dealer_master as del', 'del.del_id = info.dealer', 'left');
        $this->db->join('vender_master as ven', 'ven.ven_id = info.vender', 'left');
        return $this->db->get('tbl_outward_info as info')->result_array();
    }

    public function expire_this_month_all($where, $limit, $offset) {
        $this->db->where($where);
        $this->db->where('info.del_status', 'not_deleted');
        $this->db->select('ow.*,info.*,mod.*,del.*,ven.*');
        $this->db->join('tbl_outward as ow', 'ow.ow_id = info.ow_id', 'left');
        $this->db->join('item_info_master as mod', 'mod.i_info_id = info.model_name', 'left');
        $this->db->join('dealer_master as del', 'del.del_id = info.dealer', 'left');
        $this->db->join('vender_master as ven', 'ven.ven_id = info.vender', 'left');
        return $this->db->get('tbl_outward_info as info', $limit, $offset)->result_array();
    }

    public function expire_this_day_all($where, $limit, $offset) {
        $this->db->where($where);
        $this->db->where('info.del_status', 'not_deleted');
        $this->db->select('ow.*,info.*,mod.*,del.*,ven.*');
        $this->db->join('tbl_outward as ow', 'ow.ow_id = info.ow_id', 'left');
        $this->db->join('item_info_master as mod', 'mod.i_info_id = info.model_name', 'left');
        $this->db->join('dealer_master as del', 'del.del_id = info.dealer', 'left');
        $this->db->join('vender_master as ven', 'ven.ven_id = info.vender', 'left');
        return $this->db->get('tbl_outward_info as info', $limit, $offset)->result_array();
    }

    public function amc_expire_this_month($where) {
        $this->db->limit(10);
        $this->db->where($where);
        $this->db->select('a.*');
        return $this->db->get('tbl_amc as a')->result_array();
    }

    public function amc_expire_this_day($where) {
        $this->db->limit(10);
        $this->db->where($where);
        $this->db->select('a.*');
        return $this->db->get('tbl_amc as a')->result_array();
    }

    public function amc_expire_this_month_all($where, $limit, $offset) {
        $this->db->where($where);
        $this->db->select('a.*');
        return $this->db->get('tbl_amc as a', $limit, $offset)->result_array();
    }

    public function amc_expire_this_day_all($where, $limit, $offset) {
        $this->db->where($where);
        $this->db->select('a.*');
        return $this->db->get('tbl_amc as a', $limit, $offset)->result_array();
    }

    Public function getow_amc($where) {
        $this->db->select('ow.*, item.*');
        $this->db->where($where);
        $this->db->join('item_info_master as item', 'item.i_info_id = ow.model_name', 'left');
        $query = $this->db->get('tbl_outward_info as ow');
        return $query->result_array();
    }

    Public function get_amc($limit, $offset) {
        $this->db->group_by('amc_id');
        $this->db->select('amc.*,info.*');
        $this->db->join('tbl_amc_info as info', 'info.amcid = amc.amc_id', 'left');
        $query = $this->db->get('tbl_amc as amc', $limit, $offset);
        return $query->result_array();
    }

    Public function viewamc($where) {
        $this->db->select('amc.*, info.*, ow.*,oi.vender,oi.ven_inv,v.ven_cmp_name,v.ven_con_per_name,v.ven_con_per_num,v.ven_email,d.del_cmp_name,d.del_email,d.del_con_per_name,d.del_con_per_num');
        $this->db->where($where);
        $this->db->join('tbl_amc_info as info', 'info.amcid = amc.amc_id', 'left');
        $this->db->join('tbl_outward as ow', 'ow.ow_id = info.owid', 'left');
        $this->db->join('tbl_outward_info as oi', 'oi.ow_id = ow.ow_id', 'left');
        $this->db->join('vender_master as v', 'v.ven_id = oi.vender', 'left');
        $this->db->join('dealer_master as d', 'd.del_id = ow.del_name', 'left');
        $query = $this->db->get('tbl_amc as amc');
        return $query->result_array();
    }

    Public function getact_amc($where) {
        $this->db->select('amc.*, item.*');
        $this->db->where($where);
        $this->db->join('item_info_master as item', 'item.i_info_id = amc.model', 'left');
        $query = $this->db->get('tbl_amc_info as amc');
        return $query->result_array();
    }

    Public function get_iw_export($newdate = "NULL") {
        $this->db->select('iw.createdby,ven_chal_num,ven_inv_num,inw_date, ven.ven_cmp_name,ven_num,ven_con_per_name,ven_con_per_num,iw_qty,iw_log_qty,item_value,it.i_name,item.model_num,ser.serial,ser.status,iw.del_status,iw.inw_for');
        if ($newdate != "NULL") {
            $this->db->like('inw_date', $newdate);
        }
        $this->db->group_by('ser.sid');
        $this->db->join('vender_master as ven', 'ven.ven_id = iw.ven_name', 'left');
        $this->db->join('tbl_inward_info as info', 'info.iwid = iw.inw_id', 'left');
        $this->db->join('item_info_master as item', 'item.i_info_id = info.model_name', 'left');
        $this->db->join('item_master as it', 'it.i_id = item.i_id', 'left');
        $this->db->join('tbl_iwinfo_serial as ser', 'ser.iw_info_id = info.iw_info_id', 'left');
        $query = $this->db->get('tbl_inward as iw');
        return $query->result_array();
    }

    Public function get_ow_export($newdate = "NULL") {
        $this->db->select('ow.createdby,ow_date,chal_num,chal_date,ven.ven_cmp_name,ven_adrs,ven_num,ven_email,ven_website,ven_con_per_name,ven_con_per_num,ven_inv,ow.cust_name,cust_mobile,cust_email, del.del_cmp_name,del_num,del_con_per_name,del_con_per_num,it.i_name,item.model_num,warranty,info.item_value,ow_qty,info.serial,info.del_status');
        if ($newdate != "NULL") {
            $this->db->like('chal_date', $newdate);
        }

        $this->db->join('tbl_outward_info as info', 'info.ow_id = ow.ow_id', 'left');
        $this->db->join('dealer_master as del', 'del.del_id = info.dealer', 'left');
        $this->db->join('vender_master as ven', 'ven.ven_id = info.vender', 'left');
        $this->db->join('item_info_master as item', 'item.i_info_id = info.model_name', 'left');
        $this->db->join('item_master as it', 'it.i_id = item.i_id', 'left');
        //$this->db->join('tbl_inward as iw', 'iw.ven_inv_num = info.ven_inv','left');
        //$this->db->join('tbl_inward_info as iwi', 'iwi.ven_invoice = info.ven_inv','left');
        $query = $this->db->get('tbl_outward as ow');
        return $query->result_array();
    }

    Public function get_so_export($newdate = "NULL") {
        $this->db->select('so.createdby,so_no,so_date,so_desc,so_note,so_to_cust,cust_mobile,cust_email,cust_address,del.del_cmp_name,del_num,del_con_per_name,del_con_per_num,item.model_num,,it.i_name,info.prod_qty,u_price,info.cgst as cg,info.sgst as sg,info.igst as ig,b_amt,info.del_status');
        if ($newdate != "NULL") {
            $this->db->like('so_date', $newdate);
        }
        $this->db->join('tbl_so_info as info', 'info.soid = so.so_id', 'left');
        $this->db->join('dealer_master as del', 'del.del_id = so.so_to_del', 'left');
        $this->db->join('item_info_master as item', 'item.i_info_id = info.model', 'left');
        $this->db->join('item_master as it', 'it.i_id = item.i_id', 'left');
        $query = $this->db->get('tbl_so as so');
        return $query->result_array();
    }

    Public function get_so_month($search, $where) {
        $this->db->select('so.*,so.createdby as createdby_so, del.*');
        $this->db->where($where);
        $this->db->like('so_date', $search);
        $this->db->join('dealer_master as del', 'del.del_id = so.so_to_del', 'left');
        $query = $this->db->get('tbl_so as so');
        return $query->result_array();
    }

    Public function get_po_export($newdate = "NULL") {
        $this->db->select('po.createdby,po_no,po_date,po_desc,po_note,tax,delivery,warranty,bil_add,ven.ven_cmp_name,ven.ven_adrs,ven.ven_num,ven.ven_email,ven.ven_website,ven.ven_con_per_name,ven.ven_con_per_num,item.model_num,,it.i_name,info.prod_qty,u_price,info.cgst as cg,info.sgst as sg,info.igst as ig,b_amt,info.del_status');
        if ($newdate != "NULL") {
            $this->db->like('po_date', $newdate);
        }

        $this->db->join('tbl_po_info as info', 'info.poid = po.po_id', 'left');
        $this->db->join('item_info_master as item', 'item.i_info_id = info.model', 'left');
        $this->db->join('item_master as it', 'it.i_id = item.i_id', 'left');
        $this->db->join('vender_master as ven', 'ven.ven_id = po.po_to', 'left');
        $query = $this->db->get('tbl_po as po');
        return $query->result_array();
    }

    Public function get_intpo_export($newdate = "NULL") {
        $this->db->select('po.createdby,po_no,po_date,po_desc,po_note,item.model_num,,it.i_name,info.prod_qty,u_price,info.cgst as cg,info.sgst as sg,info.igst as ig,b_amt,info.del_status');
        if ($newdate != "NULL") {
            $this->db->like('po_date', $newdate);
        }

        $this->db->join('tbl_int_po_info as info', 'info.poid = po.po_id', 'left');
        $this->db->join('item_info_master as item', 'item.i_info_id = info.model', 'left');
        $this->db->join('item_master as it', 'it.i_id = item.i_id', 'left');
        $query = $this->db->get('tbl_int_po as po');
        return $query->result_array();
    }

    Public function get_pi_month($search) {
        $this->db->select('pi.*, del.*,pi.createdby as createdby_so');
        $this->db->like('pi_date', $search);
        $this->db->join('dealer_master as del', 'del.del_id = pi.so_to_del', 'left');
        $query = $this->db->get('tbl_perfoma_inv as pi');
        return $query->result_array();
    }

    Public function get_pi_export($newdate = "NULL") {
        $this->db->select('pi.createdby,pi_no,pi_date,deli_note,mt_payment,f_hsn,f_amount,f_cgst,f_sgst,supp_ref,other_ref,buy_ord_no,buy_ord_date,dis_doc_no,deli_note_date,dis_thr,desti,tod,so_to_cust,cust_mobile,cust_email,cust_address,gstin_uin,del.del_cmp_name,del_num,del_con_per_name,del_con_per_num,item.model_num,it.i_name,info.prod_qty,u_price,info.cgst as cg,info.sgst as sg,info.igst as ig,tax,b_amt');
        if ($newdate != "NULL") {
            $this->db->like('pi_date', $newdate);
        }
        $this->db->join('tbl_perfoma_inv_info as info', 'info.piid = pi.pi_id', 'left');
        $this->db->join('item_info_master as item', 'item.i_info_id = info.model', 'left');
        $this->db->join('item_master as it', 'it.i_id = item.i_id', 'left');
        $this->db->join('dealer_master as del', 'del.del_id = pi.so_to_del', 'left');
        $query = $this->db->get('tbl_perfoma_inv as pi');
        return $query->result_array();
    }

    Public function get_rm_month($search) {
        $this->db->select('rm.*, ow.*');
        $this->db->like('rm.ret_date', $search);
        $this->db->join('tbl_outward as ow', 'ow.ow_id = rm.owid', 'left');
        //$this->db->join('tbl_outward_info as info', 'info.ow_id = rm.owid','left');
        $query = $this->db->get('tbl_rm as rm');
        return $query->result_array();
    }

    Public function get_rm_export($newdate = "NULL") {
        $export = explode("-", $newdate);
        $this->db->select('rm.createdby,rm.ret_date,rm.remark,model.model_num,item.i_name,info.qty,info.serial as ser,info.type,owin.ven_inv owinv,owin.ow_qty,owin.serial,owin.item_value,ow.chal_num,ow.chal_date,ow.ow_date,owin.warranty,ow.cust_name,ow.cust_mobile,ow.cust_email,ow.cust_address,del.del_cmp_name,del.del_adrs,del.del_num,del.del_email,del.del_con_per_name,del.del_con_per_num,ven.ven_cmp_name,ven.ven_adrs,ven.ven_num,ven.ven_email,ven.ven_website,ven.ven_con_per_name,ven.ven_con_per_num');
        if ($newdate != "NULL") {
            // $this->db->like('rm.ret_date', $newdate);
            $this->db->where('MONTH(rm.ret_date)', $export[1]);
            $this->db->where('YEAR(rm.ret_date)', $export[0]);
        }

        $this->db->join('tbl_rm_info as info', 'info.rmid = rm.rm_id', 'left');
        $this->db->join('tbl_outward_info as owin', 'owin.ow_info_id = info.model', 'left');
        $this->db->join('tbl_outward as ow', 'ow.ow_id = owin.ow_id', 'left');
        $this->db->join('dealer_master as del', 'del.del_id = owin.dealer', 'left');
        $this->db->join('vender_master as ven', 'ven.ven_id = owin.vender', 'left');
        $this->db->join('item_info_master as model', 'model.i_info_id = owin.model_name', 'left');
        $this->db->join('item_master as item', 'item.i_id = model.i_id', 'left');
        $query = $this->db->get('tbl_rm as rm');
        return $query->result_array();
    }

    Public function get_del_data($del, $from = "NULL", $to = "NULL") {
        $this->db->select('ow.createdby,del.del_cmp_name,del.del_adrs,del.del_num,del.del_email,del.del_website,del.del_con_per_name,del.del_con_per_num,ow.chal_num,ow.chal_date,ow.ow_date,ow.install_date,ow.remark,info.ven_inv,model_desc.i_name,model.model_num,model.hsn_code,info.ow_qty,info.serial,info.item_value,info.warranty,info.item_remark,ven.ven_cmp_name,ven.ven_adrs,ven.ven_num,ven.ven_email,ven.ven_website,ven.ven_con_per_name,ven.ven_con_per_num,info.del_status');

        $this->db->where('dc_status', 1);
        $this->db->where('ow.del_status', 'not_deleted');
        $this->db->where('info.del_status', 'not_deleted');
        $this->db->where('del_name', $del);

        if ($from != "NULL" && $to != "NULL") {
            $this->db->where('install_date >=', $from);
            $this->db->where('install_date <=', $to);
        }


        $this->db->join('tbl_outward_info as info', 'info.ow_id = ow.ow_id', 'left');
        $this->db->join('dealer_master as del', 'del.del_id = info.dealer', 'left');
        $this->db->join('vender_master as ven', 'ven.ven_id = info.vender', 'left');
        $this->db->join('item_info_master as model', 'model.i_info_id = info.model_name', 'left');
        $this->db->join('item_master as model_desc', 'model_desc.i_id = model.i_id', 'left');
        $query = $this->db->get('tbl_outward as ow');
        return $query->result_array();
    }

    Public function get_sales_export($new_uid = "NULL") {
        $this->db->select('sales.from,sales.date,lead.f_name,lead.l_name,lead.mobile,sales.s_desc,sales.s_remark,model.model_num,model.hsn_code,model_desc.i_name,info.prod_qty,info.u_price,info.b_amt');
        if ($new_uid != "NULL") {
            $this->db->where('info.user', $new_uid);
        }
        $this->db->join('tbl_lead_sales_info as info', 'info.s_id = sales.sid', 'left');
        $this->db->join('tbl_lead as lead', 'lead.lid = info.to', 'left');
        $this->db->join('item_info_master as model', 'model.i_info_id = info.model', 'left');
        $this->db->join('item_master as model_desc', 'model_desc.i_id = model.i_id', 'left');
        $query = $this->db->get('tbl_lead_sales as sales');
        return $query->result_array();
    }

    public function gropby_fun($table, $where, $group_by) {
        $this->db->group_by($group_by);
        $result = $this->db->get_where($table, $where);
        return $result->result_array();
    }

    /* Public function get_stock_data(){
      $this->db->select('iw.createdby,ven.ven_cmp_name,ven.ven_adrs,ven.ven_num,ven.ven_email,ven.ven_website,ven.ven_con_per_name,ven.ven_con_per_num,iw.ven_chal_num,iw.ven_inv_num,iw.inw_date,mod.model_num,mod.hsn_code,mod_desc.i_name,iwinfo.iw_qty,iwinfo.iw_log_qty,iwinfo.item_value,iwinfo.remark,oi.ow_qty,oi.serial,oi.ran_serial_num');

      $this->db->group_by('oi.ow_info_id');
      $this->db->join('tbl_inward_info as iwinfo', 'iwinfo.iwid = iw.inw_id','left');
      $this->db->join('vender_master as ven', 'ven.ven_id = iwinfo.vender','left');
      $this->db->join('item_info_master as mod', 'mod.i_info_id = iwinfo.model_name','left');
      $this->db->join('item_master as mod_desc', 'mod_desc.i_id = mod.i_id','left');

      $this->db->join('tbl_outward_info as oi', 'oi.ven_inv = iwinfo.ven_invoice','left');

      $query = $this->db->get('tbl_inward as iw');
      return $query->result_array();
      } */

    Public function get_stock_data($from = "NULL", $to = "NULL") {
        $this->db->select('md.createdby,m.model_num,md.i_name,m.hsn_code,m.open_stock_qty,m.new_pur_price,m.sel_price,m.cgst,m.sgst,m.igst,sum(ii.iw_log_qty),sum(ii.iw_qty),(SELECT sum(o.ow_qty) from `tbl_outward_info` as o where o.model_name=`m`.`i_info_id` AND o.del_status="not_deleted") as ttl_out');

        if ($from != "NULL" || $to != "NULL") {
            $this->db->where('i.inw_date >=', $from);
            $this->db->where('i.inw_date <=', $to);
        }
        $this->db->where('ii.del_status', 'not_deleted');

        $this->db->group_by('m.i_info_id');
        $this->db->join('item_master as md', 'md.i_id = m.i_id', 'left');
        $this->db->join('tbl_inward_info as ii', 'ii.model_name = m.i_info_id', 'left');
        $this->db->join('tbl_inward as i', 'i.inw_id = ii.iwid', 'left');

        $query = $this->db->get('item_info_master as m');
        return $query->result_array();
    }

    Public function get_ven_data($vender, $from = "NULL", $to = "NULL") {
        $this->db->select('iw.createdby,ven.ven_cmp_name,ven.ven_adrs,ven.ven_num,ven.ven_email,ven.ven_website,ven.ven_con_per_name,ven.ven_con_per_num,ven.ven_vat,ven.ven_gst,ven.ven_pan,iw.ven_chal_num,iw.ven_inv_num,iw.inw_date,model.model_num,model.hsn_code,model_desc.i_name,model_desc.brand_name,info.iw_qty,info.iw_log_qty,info.item_value');
        $this->db->where('iw.del_status', 'not_deleted');
        $this->db->where('info.del_status', 'not_deleted');
        $this->db->where('iw.ven_name', $vender);

        if ($from != "NULL" && $to != "NULL") {
            $this->db->where('inw_date >=', $from);
            $this->db->where('inw_date <=', $to);
        }


        $this->db->join('tbl_inward_info as info', 'info.iwid = iw.inw_id', 'left');
        $this->db->join('vender_master as ven', 'ven.ven_id = info.vender', 'left');
        $this->db->join('item_info_master as model', 'model.i_info_id = info.model_name', 'left');
        $this->db->join('item_master as model_desc', 'model_desc.i_id = model.i_id', 'left');
        $query = $this->db->get('tbl_inward as iw');
        return $query->result_array();
    }

//    ***********   CODE BY GIRISH ON  04-JAN-2018 :-  *************




    public function getUsersListing($limit, $offset) {
        $this->db->select('A.*,B.dist_name,C.city_name,D.vil_name');
        $this->db->join('tbl_dist B', 'A.dist = B.id', 'LEFT');
        $this->db->join('tbl_city C', 'A.city = C.id', 'LEFT');
        $this->db->join('tbl_village D', 'A.vil = D.id', 'LEFT');
        $query = $this->db->get('tblusers A', $limit, $offset)->result_array();
        return $query;
    }

    public function user_search($search) {

//        $this->db->select('A.*,B.dist_name');
//        $this->db->join('tbl_dist B', 'A.dist = B.id', 'LEFT');
//        $this->db->or_like('A.username', $search);
//        $this->db->or_like('A.email', $search);
//        $this->db->or_like('B.dist_name', $search);
//        $query = $this->db->get('tblusers A')->result_array();
        
        
        
        
        $this->db->select('A.*,B.dist_name,C.city_name,D.vil_name');
        $this->db->join('tbl_dist B', 'A.dist = B.id', 'LEFT');
        $this->db->join('tbl_city C', 'A.city = C.id', 'LEFT');
        $this->db->join('tbl_village D', 'A.vil = D.id', 'LEFT');
        $this->db->or_like('A.username', $search);
        $this->db->or_like('A.email', $search);
        $this->db->or_like('B.dist_name', $search);
        $this->db->or_like('C.city_name', $search);
        $this->db->or_like('D.vil_name', $search);
        $query = $this->db->get('tblusers A')->result_array();
       
        return $query;
    }

}
