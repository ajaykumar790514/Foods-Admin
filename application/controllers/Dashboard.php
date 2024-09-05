<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $admin = $this->session->userdata('MUserId');
        if(empty($admin))
        {
            $this->session->set_flashdata('msg', 'Your session has been expired');
            redirect(base_url().'login/index');
        }
    }
	public function templete($page, $data)
    {
        $this->load->view('templete/header',$data);
        $this->load->view($page);
        $this->load->view('templete/footer',$data);
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $page = 'pages/dashboard';
        $this->templete($page, $data);
    }


    public function change_status()
    {
        if ($this->input->is_ajax_request()) {
            $data = explode(',',$_POST['data']);
            $id     = $data[0];
            $tb     = $data[1];
            $id_column  = $data[2];
            $val_column  = $data[3];
            $update = array($val_column => $_POST['value'] );
            $cond = [$id_column => $id];
            $column = "column='$id_column'";
            
            $this->admin_model->Update($tb,$update,$cond);
            $status = $this->admin_model->getRow($tb,$cond)->$val_column;

            if ($status==1) {
                echo "<span class='changeStatus'  style='font-size:1.3rem' data-toggle='change-status' value='0' data='".$_POST['data']."' title='Click for chenage status' ><i class='ti-check-box text-success'></i></span>";
            } 
            else{
                echo "<span style='font-size:1.3rem' class='changeStatus' data-toggle='change-status' value='1' data='".$_POST['data']."'  title='Click for chenage status'><i class='ti-na text-danger'></i></span>";
            }   
        }
    }

}