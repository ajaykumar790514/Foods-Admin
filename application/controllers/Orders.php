<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Orders extends CI_Controller {
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


     public function index($action=null,$p1=null)
    {
       $view_dir = 'pages/orders/';
        switch ($action) {
           case null:
           $data['title'] 			= 'Manage Orders';
           $page 		                =  $view_dir.'index';
           $data['tb_url']	  		=  current_url().'/tb';
           $data['search']	 		=  $this->input->post('search');
           $data['status'] = $this->admin_model->getData('order_status_master',['is_deleted' => 'NOT_DELETED']);
           $data['mode'] = $this->admin_model->getData('payment_mode',['status' => '1']);
           $this->templete($page,$data);
           break;
           case 'tb':
           $data['search'] = '';
           $search='null';
           if($p1!=null)
            {
           $data['search'] = $p1;
           $search = $p1;
            }
           if (@$_POST['search']) {
           $data['search'] = $_POST['search'];
           $search=$_POST['search'];
                  
          }
           $this->load->library('pagination');

                $data['contant']        = $view_dir.'tb';
                $config = array();
                $config["base_url"]     = base_url()."orders/tb";
                $config["total_rows"]   = count($this->orders_model->orders());
                $data['total_rows']     = $config["total_rows"];
                $config["per_page"]     = 10;
                $config["uri_segment"]  = 2;
                $config['attributes']   = array('class' => 'pag-link');
                $this->pagination->initialize($config);
                $data['links']          = $this->pagination->create_links();
                $data['page']           = $page = ($p1!=null) ? $p1 : 0;
                $data['search']         = $this->input->post('search');
                $data['update_url']     = base_url('orders/create/');
                $data['delete_url']     = base_url('orders/delete/');
                $data['rows']           = $this->orders_model->orders($config["per_page"],$page);
                load_view($data['contant'],$data);
                break;
            case 'details':
                $data['title'] 			= 'Order Details';
                $page 		                =  $view_dir.'details';
                $data['orderData'] = $this->orders_model->getRowData($p1);
                $data['orderItems'] = $this->orders_model->getItems($data['orderData']->id);
                $this->templete($page,$data);
            break;   
            case 'updateOrderStatus':
                $oder_id = $_POST['item']['id'];
                $rs = $this->orders_model->get_row_order($oder_id);
                $checkExisting = $this->orders_model->getRows2($_POST['item']['id']);
                if($checkExisting!==FALSE){
                    $this->orders_model->updateRow($_POST['item']['id'],array('status'=>$_POST['item']['status']));
                    $logdata = array(
                        'status_id'=>$_POST['item']['status'],
                        'order_id'=>$_POST['item']['id'],
                    );
                    $this->orders_model->SaveLog($logdata);
                }
                return TRUE;
            break; 
            default:
            // code...
            break;
        }
    }





}