<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offers_coupons_admin extends CI_Controller {

 
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
        
    public function offers_coupons_remote($type,$id=null,$column='name')
    {
        if ($type=='offers') {
            $tb = 'coupons_and_offers';
        }
        elseif ($type=='coupons') {
            $tb ='coupons_and_offers';
        }
        
        else{

        }
        $this->db->where($column,$_GET[$column]);
        if($id!=NULL){
            $this->db->where('id != ',$id)->where('is_deleted','NOT_DELETED');
        }
        $count=$this->db->count_all_results($tb);
        if($count>0)
        {
            echo "false";
        }
        else
        {
            echo "true";
        }        
    }
    public function offers($action=null,$p1=null,$p2=null,$p3=null)
    {
        $view_dir = 'pages/offers_coupons/';
        switch ($action) {
            case null:
                $data['tb_url']         = base_url().'offers/tb';
                $data['new_url']        = base_url().'offers/create';
                $data['title'] = 'Offers';
                $page = 'pages/offers_coupons/index';
                $this->templete($page, $data);
                break;

                case 'tb':
                    $data['search'] = '';
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                    }
                    $this->load->library('pagination');
                    $data['contant']        = $view_dir.'tb';
                    $config = array();
                    $config["base_url"]     = base_url()."offers/tb";
                    $config["total_rows"]   = ($this->offers_model->offers());
                    $data['total_rows']     = $config["total_rows"];
                    $config["per_page"]     = 10;
                    $config["uri_segment"]  = 2;
                    $config['attributes']   = array('class' => 'pag-link');
                    $this->pagination->initialize($config);
                    $data['links']          = $this->pagination->create_links();
                    $data['page']           = $page = ($p1!=null) ? $p1 : 0;
                    $data['search']         = $this->input->post('search');
                    $data['update_url']     = base_url('offers/create/');
                    $data['delete_url']     = base_url('offers/delete/');
                    $data['rows']           = $this->offers_model->offers($config["per_page"],$page);
                    load_view($data['contant'],$data);
                    break;
                    case 'create':
                        $data['title'] 		= 'New Product';
                        $data['contant']      	= $view_dir.'create';
                        $data['action_url']         = base_url().'offers/save';
                        $data['remote']             = base_url().'/offers_coupons_remote/offers/';
                        if ($p1!=null) 
                        {
                        $data['contant']      	= $view_dir.'update';
                        $data['action_url']     = base_url().'offers/save/'.$p1;
                        $data['value']          = $this->admin_model->getRow('coupons_and_offers',['id'=>$p1]);
                        $data['remote']         = base_url().'offers_coupons_remote/offers/'.$p1;
                        }
                        $data['form_id']= uniqid();
                        load_view($data['contant'],$data);
            break;
            case 'save':
                $id = $p1;
                $return['res'] = 'error';
                $return['msg'] = 'Not Saved!';
            
                if ($this->input->server('REQUEST_METHOD') == 'POST') {
                    // Retrieve form data
                    $title = $this->input->post('title');
                    $description = $this->input->post('description');
                    $discount_type = $this->input->post('discount_type');
                    $value = $this->input->post('value');
                    $expiry_date = $this->input->post('expiry_date');
                    $start_date = $this->input->post('start_date');
            
                    // Perform server-side validation
                    $current_date = date('Y-m-d');
                    if (strtotime($start_date) < strtotime($current_date)) {
                        $return['res']='error';
                        $return['msg'] = 'Start date cannot be in the past.';
                    } elseif (strtotime($start_date) >= strtotime($expiry_date)) {
                        $return['res']='error';
                        $return['msg'] = 'Start date should be less than expiry date.';
                    } elseif (strtotime($expiry_date) <= strtotime($start_date)) {
                        $return['res']='error';
                        $return['msg'] = 'End date should be greater than start date.';
                    } else {
                        // Validation successful, proceed to save data
                        if ($id != null) {
                            $data = array(
                                'title' => $title,
                                'description' => $description,
                                'discount_type' => $discount_type,
                                'value' => $value,
                                'expiry_date' => $expiry_date,
                                'start_date' => $start_date,
                            );
                            if ($this->offers_model->edit_offer_coupon($data, $id)) {
                                $return['res'] = 'success';
                                $return['msg'] = 'Saved.';
                                $data1 = array(
                                    'discount_type' => $discount_type,
                                    'offer_associated' => $value,
                                    'offer_upto' => $value,
                                );
                                $this->offers_model->edit_shop_offers_cat($data1, $id);
                            }
                        } else {
                            $data = array(
                                'title' => $title,
                                'description' => $description,
                                'discount_type' => $discount_type,
                                'value' => $value,
                                'expiry_date' => $expiry_date,
                                'start_date' => $start_date,
                            );
                            if ($this->offers_model->add_offer_coupon($data)) {
                                $return['res'] = 'success';
                                $return['msg'] = 'Saved.';
                            }
                        }
                    }
                }
            
                echo json_encode($return);
                break;
                case 'delete':
                    $return['res'] = 'error';
                    $return['msg'] = 'Not Deleted!';
                    if ($p1!=null) {
                    if($this->admin_model->_delete('coupons_and_offers',['id'=>$p1])){
                            $saved = 1;
                            $return['res'] = 'success';
                            $return['msg'] = 'Successfully deleted.';
                    }
                    }
                    echo json_encode($return);
                    break;      
            default:
                # code...
                break;
        }
    }

    //COUPONS
    public function coupons($action=null,$p1=null,$p2=null,$p3=null)
    {
        
        switch ($action) {
            case null:
                $data['menu_id'] = $this->uri->segment(2);
                $data['title']          = 'Coupons';
                $data['tb_url']         = base_url().'coupons/tb';
                $data['new_url']        = base_url().'coupons/create';
                $page                   = 'admin/offers_coupons/coupons/index';
                $this->header_and_footer($page, $data);
                break;

                case 'tb':
                    $data['search'] = '';
                    if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                    }
                    
                    $this->load->library('pagination');
                    $config = array();
                    $config["base_url"]         = base_url()."coupons/tb/";
                    $config["total_rows"]       = $this->coupons_model->coupons();
                    $data['total_rows']         = $config["total_rows"];
                    $config["per_page"]         = 10;
                    $config["uri_segment"]      = 3;
                    $config['attributes']       = array('class' => 'pag-link');
                    $config['full_tag_open']    = "<div class='pag'>";
                    $config['full_tag_close']   = "</div>";
                    $config['first_link']       = '&lt;&lt;';
                    $config['last_link']        = '&gt;&gt;';
                    $this->pagination->initialize($config);
                    $data["links"]              = $this->pagination->create_links();
                    $data['page']               = $page = ($p1!=null) ? $p1 : 0;
                    $data['per_page']           = $config["per_page"];
                    $data['coupons']           = $this->coupons_model->coupons($config["per_page"],$page);
                    $data['update_url']         = base_url().'coupons/create/';
                    $page                       = 'admin/offers_coupons/coupons/tb';
                    $this->load->view($page, $data);
                    break;
                
                    case 'create':
                        $data['remote']             = base_url().'offers-coupons/offers_coupons_remote/coupons/';
                        $data['action_url']         = base_url().'coupons/save';
                        $data['business']  = $this->coupons_model->view_data('business');
                        $data['shops']  = $this->coupons_model->view_data('shops');
                        $page                       = 'admin/offers_coupons/coupons/create';
                        if ($p1!=null) {
                            $data['action_url']     = base_url().'coupons/save/'.$p1;
                            $data['business']  = $this->coupons_model->view_data('business');
                            $data['shops']  = $this->coupons_model->view_data('shops');
                            $data['value']          = $this->coupons_model->coupon($p1);
                            $data['remote']         = base_url().'offers-coupons/offers_coupons_remote/coupons/'.$p1;
                            $page                   = 'admin/offers_coupons/coupons/update';
                        }
                        $data['form_id']            = uniqid();
                        
                       
                        $this->load->view($page, $data);
                        break;

                        case 'save':
                            $id = $p1;
                            $return['res'] = 'error';
                            $return['msg'] = 'Not Saved!';
                            if ($this->input->server('REQUEST_METHOD')=='POST') {
                                if ($id!=null) {
                                    $data = array(
                                            'title'     => $this->input->post('title'),
                                            'description'              => $this->input->post('description'),
                                            'discount_type'      => $this->input->post('discount_type'),
                                            'value'        => $this->input->post('value'),
                                            'expiry_date'       => $this->input->post('expiry_date'),
                                            'start_date'       => $this->input->post('start_date'),
                                            'offer_created_by'       => $this->input->post('offer_created_by'),
                                            'code'       => $this->input->post('code'),
                                            'minimum_coupan_amount'       => $this->input->post('minimum_coupan_amount'),
                                            'maximum_coupan_discount_value'       => $this->input->post('maximum_coupan_discount_value'),
                                        );
                                    if($this->offers_model->edit_offer_coupon($data,$id)){
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }
                                }
                                else{
                                    $data = array(
                                            'title'     => $this->input->post('title'),
                                            'description'              => $this->input->post('description'),
                                            'discount_type'      => $this->input->post('discount_type'),
                                            'value'        => $this->input->post('value'),
                                            'expiry_date'       => $this->input->post('expiry_date'),
                                            'start_date'       => $this->input->post('start_date'),
                                            'offer_created_by'       => $this->input->post('offer_created_by'),'coupan_or_offer'       => '0',
                                            'code'       => $this->input->post('code'),
                                            'minimum_coupan_amount'       => $this->input->post('minimum_coupan_amount'),
                                            'maximum_coupan_discount_value'       => $this->input->post('maximum_coupan_discount_value'),
                                        );
                                    if ($this->offers_model->add_offer_coupon($data)) {
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Saved.';
                                    }
                                }
                            }
                            echo json_encode($return);
                            break;
                            case 'delete_coupon':
                                $id = $p1;
                                if($this->coupons_model->delete_data('coupons_and_offers',$id))
                                {
                                    $data1['coupon_offer'] = $this->admin_model->get_row_data1('coupons_and_offers','id',$id);
                                    $coupon_offer_image = ltrim($data1['coupon_offer']->photo, '/');
                                    if(is_file(DELETE_PATH.$coupon_offer_image))
                                    {
                                        unlink(DELETE_PATH.$coupon_offer_image);
                                    }
                                    $data['search'] = '';
                                    if (@$_POST['search']) {
                                        $data['search'] = $_POST['search'];
                                    }
                                    
                                    $this->load->library('pagination');
                                    $config = array();
                                    $config["base_url"]         = base_url()."coupons/tb/";
                                    $config["total_rows"]       = $this->coupons_model->coupons();
                                    $data['total_rows']         = $config["total_rows"];
                                    $config["per_page"]         = 20;
                                    $config["uri_segment"]      = 3;
                                    $config['attributes']       = array('class' => 'pag-link');
                                    $config['full_tag_open']    = "<div class='pag'>";
                                    $config['full_tag_close']   = "</div>";
                                    $config['first_link']       = '&lt;&lt;';
                                    $config['last_link']        = '&gt;&gt;';
                                    $this->pagination->initialize($config);
                                    $data["links"]              = $this->pagination->create_links();
                                    $data['page']               = $page = ($p2!=null) ? $p2 : 0;
                                    $data['per_page']           = $config["per_page"];
                                    $data['coupons']           = $this->coupons_model->coupons($config["per_page"],$page);
                                    $data['update_url']         = base_url().'coupons/create/';
                                    $page                       = 'admin/offers_coupons/coupons/tb';
                                    $this->load->view($page, $data);
                                }
                              
                                break;
            default:
                # code...
                break;
        }
    }
    //Apply Offer

    public function apply_offer()
    {
        $data['title'] = 'Apply Offer';
        $data['parent_cat'] = $this->admin_model->get_data('category','is_parent','0');
        $data['categories'] = $this->admin_model->get_data('category','is_parent !=','0');
        $page = 'pages/offers_coupons/apply_offer';
        $this->templete($page, $data);
    }
  
    public function fetch_products_search()
    {
        if($this->input->post('psearch'))
        {
            $psearch= $this->input->post('psearch');
            $shopid= $this->input->post('shop_id');
            $data['shop_id']= $shopid;
            $data['available_products'] = $this->admin_model->fetch_products_search($psearch);
            $data['catflag'] = '1';
            $this->load->view('admin/offers_coupons/offers_varient/available_search_products',$data);
        }
    }
   
    
    public function available_offers()
    {
        $pid = $this->input->post('pid');
        $data['pid'] = $this->input->post('pid');
        $data['offers'] = $this->offers_model->get_data('coupons_and_offers','is_deleted','NOT_DELETED');
        $data['offer_list'] = $this->offers_model->view_data('shops_coupons_offers');
        // print_r($data['offers']);
        $this->load->view('pages/offers_coupons/available_offers',$data);
       
    }
    public function add_offer()
    {
        $oid= $this->input->post('oid');
        $pid= $this->input->post('pid');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $parent_cat_id= $this->input->post('parent_cat_id');
        $parent_id= $this->input->post('parent_id');
        if($parent_cat_id=='')
        {
            $category=  $this->input->post('parent_id'); 
        }else{
            $category = $this->input->post('parent_cat_id');
        }
        $data = array(
            'offer_assosiated_id'     => $oid,
            'product_id'     => $pid,
            'offer_associated'     => $value,
            'offer_upto'     => $value,
            'discount_type'     => $discount_type,
            //'category_id'=>$category,
        );
        $deletedata = array(
            'product_id'     => $pid,
             //'category_id'=>$category,
        );
        $this->offers_model->delete_offer_products($deletedata);
        $check_offer = $this->offers_model->check_offer($oid,$pid);
        if($check_offer)
        {
            $data['add_offer'] = $this->offers_model->add_data('shops_coupons_offers',$data);
       
            $data['flg'] = '1';
            $data['oid'] = $oid;
            $data['value'] = $value;
            $data['discount_type'] = $discount_type;
            if($data['add_offer'])
            {
                // echo "success";
                $data['flg'] = '1';
                $this->load->view('pages/offers_coupons/offer_action',$data);
            }

        }
        else
        {
            echo "false";
        }
    }

    public function remove_offer()
    {
        $oid= $this->input->post('oid');
        $pid= $this->input->post('pid');
        $value= $this->input->post('value');
        $parent_cat_id= $this->input->post('parent_cat_id');
        $parent_id= $this->input->post('parent_id');
        if($parent_cat_id=='')
        {
            $category=  $this->input->post('parent_id'); 
        }else{
            $category = $this->input->post('parent_cat_id');
        }
        $discount_type= $this->input->post('discount_type');
        $data['flg'] = '0';
        $data['oid'] = $oid;
        $data['value'] = $value;
        $data['discount_type'] = $discount_type;
        if ($this->offers_model->remove_offer($oid,$pid)) {
            $this->load->view('pages/offers_coupons/offer_action',$data);
        } 
    }
    public function available_offers_cat()
    {
        $parent_cat_id = $this->input->post('parent_cat_id');
        $data['parent_cat_id'] = $this->input->post('parent_cat_id');
        $data['offers'] = $this->offers_model->get_data('coupons_and_offers','is_deleted','NOT_DELETED');
        $data['offer_list'] = $this->offers_model->view_data('shops_coupons_offers');
        $this->load->view('pages/offers_coupons/available_offers_cat',$data);
       
    }
  
    
   
    public function add_offer_cat()
    {
        $oid= $this->input->post('oid');
         $parent_cat_id= $this->input->post('parent_cat_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $check_offer = $this->offers_model->check_offer_cat($oid,$parent_cat_id);
        if($check_offer)
        {
            $data['get_products_by_category'] = $this->offers_model->fetch_products_new($parent_cat_id);
            //print_r($data['get_products_by_category']);
            foreach($data['get_products_by_category'] as $products)
            {
                $pro = $products->id;
                $data = array(
                    'offer_assosiated_id'     => $oid,
                    'category_id'     => $parent_cat_id,
                    'offer_associated'     => $value,
                    'offer_upto'     => $value,
                    'discount_type'     => $discount_type,
                    'product_id'     => $pro,
                );
                $this->offers_model->delete_offer_products($data);
                $data['add_offer'] = $this->offers_model->add_data('shops_coupons_offers',$data);
            }
            
       
            $data['flg'] = '1';
            $data['oid'] = $oid;
            $data['value'] = $value;
            $data['discount_type'] = $discount_type;
            if(@$data['add_offer'])
            {
                // echo "success";
                $this->load->view('pages/offers_coupons/offer_action_cat',$data);
            }else{
                $data1['flg'] = '0';
                $data1['oid'] = $oid;
                $data1['value'] = $value;
                $data1['discount_type'] = $discount_type;
                $this->load->view('pages/offers_coupons/offer_action_cat',$data1);
            }

        }
        else
        {
            echo "false";
        }
    }
    public function remove_on_cat()
    {
        $parent_cat_id= $this->input->post('parent_cat_id');
        $shop_id= $this->input->post('shop_id');
        $data['get_products_by_category'] = $this->admin_model->fetch_products($parent_cat_id);
        foreach($data['get_products_by_category'] as $products)
        {
            $pro = $products->id;
            $data = array(
                'shop_id'     => $shop_id,
                'product_id'     => $pro,
            );
            $data1['flg'] = '0';
            if($this->offers_model->delete_offer_products($data))
            {
                $this->load->view('pages/offers_coupons/offer_action_cat',$data1);
            }
        }
    }
    public function remove_offer_cat()
    {
        $delete=0;
        $oid= $this->input->post('oid');
        $parent_cat_id= $this->input->post('parent_cat_id');
        $value= $this->input->post('value');
        $discount_type= $this->input->post('discount_type');
        $data['get_products_by_category'] = $this->offers_model->fetch_products_new($parent_cat_id);
        foreach($data['get_products_by_category'] as $products)
        {
            $pro = $products->id;
            $data = array(
                'product_id'     => $pro,
            );
            $data1['flg'] = '0';
            $data1['oid'] = $oid;
            $data1['value'] = $value;
            $data1['discount_type'] = $discount_type;
            if($this->offers_model->delete_offer_products($data))
            {
                $delete=1;
            }
        }
       if($delete==1)
       {
        $this->load->view('pages/offers_coupons/offer_action_cat',$data1);
       }
    }
  
   
    
    
   
    public function fetch_products()
    {
        if($this->input->post('parent_cat_id'))
        {
            $id= $this->input->post('parent_cat_id');
            $data['available_products'] = $this->offers_model->fetch_products_new($id);
            $data['offer_products'] = $this->offers_model->fetch_offer_products($id);
           
            $this->load->view('pages/offers_coupons/available_products',$data);
        }
    }
    
}