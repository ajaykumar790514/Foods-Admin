<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends CI_Controller {
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

        public function category($action=null,$p1=null,$p2=null,$p3=null)
        {
                $view_dir = 'pages/master/category/';
                switch ($action) {
                case null:
                $data['title'] 			= 'Category Master';
                $page 		= $view_dir.'index';
                $data['tb_url']	  		= current_url().'/tb';
                $data['new_url']		=  current_url().'/create';
                $data['search']	 		= $this->input->post('search');
                $data['parent_cat'] = $this->admin_model->getData('category',['is_parent'=>'0']);
                $data['parent_cat_list'] = $this->admin_model->get_parent_cat_list();
                $this->templete($page,$data);
                break;
                case 'fetch_sub_categories':
                        if($this->input->post('parent_id'))
                        {
                                $parent_id= $this->input->post('parent_id');
                                $this->admin_model->fetch_sub_categories($parent_id);
                        }
                        break;
                case 'tb':
                        $data['search'] = '';
                        $data['cat_id'] = '';
                        $data['parent_id'] = '';
                        //below variable section used for models and other places
                        $cat_id='null';
                        $parent_id='null';
                        $search='null';
                        //get section intiliazation
                         if($p2!=null){
                        $data['parent_id'] = $p1;
                        $data['cat_id'] = $p2;
                        $parent_id = $p1;
                        $cat_id = $p2;
                        $data['sub_cat'] = $this->db->get_where('category',['is_parent' => $p1 , 'is_deleted' => 'NOT_DELETED'])->result();
                                }
                                //end of section
                            
                        if (@$_POST['parent_id']) {
                        $data['parent_id'] = $_POST['parent_id'];
                        $parent_id = $_POST['parent_id'];
                                }
                        if (@$_POST['cat_id']) {
                        $data['cat_id'] = $_POST['cat_id'];
                        $cat_id = $_POST['cat_id'];
                        $data['sub_cat'] = $this->db->get_where('category',['is_parent' => $_POST['parent_id'] , 'is_deleted' => 'NOT_DELETED'])->result();
                                }
                        if($p3!=null)
                                {
                        $data['search'] = $p3;
                        $search = $p3;
                                }
                                //end of section
                        if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                        $search=$_POST['search'];
                               
                                }
                $this->load->library('pagination');

                $data['contant']        = $view_dir.'tb';
                $config = array();
                $config["base_url"]     = base_url()."manage-category/tb";
                $config["total_rows"]   = count($this->admin_model->category_master($parent_id,$cat_id,$search));
                $data['total_rows']     = $config["total_rows"];
                $config["per_page"]     = 10;
                $config["uri_segment"]  = 2;
                $config['attributes']   = array('class' => 'pag-link');
                $this->pagination->initialize($config);
                $data['links']          = $this->pagination->create_links();
                $data['page']           = $page = ($p1!=null) ? $p1 : 0;
                $data['parent_cat_list'] = $this->admin_model->get_parent_cat_list();
                $data['search']         = $this->input->post('search');
                $data['update_url']     = base_url('manage-category/create/');
                $data['delete_url']     = base_url('manage-category/delete/');
                $data['rows']           = $this->admin_model->category_master($parent_id,$cat_id,$search,$config["per_page"],$page);
                $data['parent_cat']     = $this->admin_model->get_parent_cat($parent_id,$cat_id,$config["per_page"],$page);
                $data['categories'] = $this->admin_model->get_categories($parent_id,$cat_id);
                load_view($data['contant'],$data);
                break;

                case 'create':
                $data['remote']         = base_url().'society_remote/unit/';
                $data['title'] 		= 'New Category';
                $data['contant']      	= $view_dir.'create';
                $data['action_url']	= base_url('manage-category/save');
                $data['parent_cat']     = $this->admin_model->getData('category',['is_deleted'=>'NOT_DELETED','is_parent'=>'0']);
                $data['count']=0;
                if ($p1!=null) 
                {
                        $data['action_url']     = base_url().'manage-category/save/'.$p1;
                        $data['value']          = $this->admin_model->getRow('category',['id'=>$p1]);
                        $data['count']=1;
                }
                $data['form_id']= uniqid();
                load_view($data['contant'],$data);
                break;

                case 'save':
                $id = $p1;
                $return['res'] = 'error';
                $return['msg'] = 'Not Saved!';

                if ($this->input->server('REQUEST_METHOD')=='POST') {
                if ($id!=null) {
                if($this->input->post('parent_id'))
                {
                        $is_parent = $this->input->post('parent_id');
                        }
                        else
                        {
                        $is_parent = '0';
                        }
                        $data = array(
                        'name'     => $this->input->post('name'),
                        'is_parent'     => $is_parent,
                        'description'     => $this->input->post('description'),
                        'seq'     => $this->input->post('seq'),
                        );
                if($this->admin_model->edit_category($data,$id)){
                $return['res'] = 'success';
                $return['msg'] = 'Saved.';
                                        }
                }
                else{
                if($this->input->post('parent_id'))
                        {
                $is_parent = $this->input->post('parent_id');
                }
                else
                {
                $is_parent = '0';
                }
                $namepro=$this->input->post('name');
                $convertedName =  $this->url_character_remove($namepro);
                $data = array(
                'url'=>$convertedName,
                'header_type'=>$this->input->post('header_type'),    
                'is_parent'     => $is_parent,
                'name'     => $this->input->post('name'),
                'description'     => $this->input->post('description'),
                'seq'     => $this->input->post('seq'),
                );
                                        
                if ($this->admin_model->add_category($data)) {
                $return['res'] = 'success';
                $return['msg'] = 'Saved.';
                                        }
                                }
                        }
                echo json_encode($return);
                break;

                case 'delete':
                $return['res'] = 'error';
                $return['msg'] = 'Not Deleted!';
                if ($p1!=null) {
                    if($this->admin_model->_delete('category',['id'=>$p1])){
                            $saved = 1;
                            $return['res'] = 'success';
                            $return['msg'] = 'Successfully deleted.';
                    }
                }
                echo json_encode($return);
                break;
                                
        default:
        // code...
        break;
		}
    }
    public function products($action=null,$p1=null,$p2=null,$p3=null,$p4=null,$p5=null)
    {
       
                $view_dir = 'pages/master/product/';
                switch ($action) {
                        case null:
                        $data['title'] 			= 'Product Master';
                        $page 		                =  $view_dir.'index';
                        $data['tb_url']	  		=  current_url().'/tb';
                        $data['new_url']		=  current_url().'/create';
                        $data['search']	 		=  $this->input->post('search');
                        $data['parent_cat'] = $this->admin_model->getData('category',['is_parent'=>'0']);
                        $this->templete($page,$data);
                break;
                case 'fetch_sub_categories':
                    if($this->input->post('parent_id'))
                    {
                        $parent_id= $this->input->post('parent_id');
                        $this->admin_model->fetch_sub_categories($parent_id);
                    }
                    break;
                case 'tb':
                        $data['search'] = '';
                        $data['cat_id'] = '';
                        $data['parent_id'] = '';
                        $data['child_cat_id'] = '';
                        //below variable section used for models and other places
                        $cat_id='null';
                        $parent_id='null';
                        $search='null';
                        $child_cat_id='null';
                        $pro_id = array();
                        //get section intiliazation
    
                        if($p1!=null)
                        {
                            $data['cat_id'] = $p2;
                            $data['parent_id'] = $p1;
                            $cat_id = $p2;
                            $parent_id = $p1;
                            $data['sub_cat'] = $this->db->get_where('category',['is_parent' => $p1 , 'is_deleted' => 'NOT_DELETED'])->result();
                            $pro_id = array();
                            $get_proid = $this->db->get_where('cat_pro_maps',['cat_id' => $p1])->result();
                            foreach($get_proid as $row){
                                $pro_id[] = $row->pro_id;
                            }
                        }
                        if($p2!=null)
                        {
                        
                            $data['cat_id'] = $p2;
                            $data['parent_id'] = $p1;
                            $cat_id = $p2;
                            $parent_id = $p1;
                            $data['sub_cat'] = $this->db->get_where('category',['is_parent' => $p1 , 'is_deleted' => 'NOT_DELETED'])->result();
                            $pro_id = array();
                            $get_proid = $this->db->get_where('cat_pro_maps',['cat_id' => $p2])->result();
                            foreach($get_proid as $row){
                                $pro_id[] = $row->pro_id;
                            }
                        }
                        if($p3!=null)
                        {
                            $data['search'] = $p3;
                            $search = $p3;
                        }
                        //end of section
              
              
                        if (@$_POST['search']) {
                            $data['search'] = $_POST['search'];
                            $search=$_POST['search'];
                       
                        }
                        if (@$_POST['parent_id']) {
                            $data['cat_id'] = $_POST['cat_id'];
                            $data['parent_id'] = $_POST['parent_id'];
                            $cat_id = $_POST['cat_id'];
                            $parent_id = $_POST['parent_id'];
                            $data['sub_cat'] = $this->db->get_where('category',['is_parent' => $_POST['parent_id'] , 'is_deleted' => 'NOT_DELETED'])->result();
                            $pro_id = array();
                            $get_proid = $this->db->get_where('cat_pro_maps',['cat_id' => $_POST['parent_id']])->result();
                            foreach($get_proid as $row){
                                $pro_id[] = $row->pro_id;
                            }
                        }
                        if (@$_POST['cat_id']) {
                            $data['cat_id'] = $_POST['cat_id'];
                            $data['parent_id'] = $_POST['parent_id'];
                            $cat_id = $_POST['cat_id'];
                            $parent_id = $_POST['parent_id'];
                            $data['sub_cat'] = $this->db->get_where('category',['is_parent' => $_POST['parent_id'] , 'is_deleted' => 'NOT_DELETED'])->result();
                            $pro_id = array();
                            $get_proid = $this->db->get_where('cat_pro_maps',['cat_id' => $_POST['cat_id']])->result();
                            foreach($get_proid as $row){
                                $pro_id[] = $row->pro_id;
                            }
                        }    
                $this->load->library('pagination');

                $data['contant']        = $view_dir.'tb';
                $config = array();
                $config["base_url"]         = base_url()."manage-product/tb/".$parent_id."/".$cat_id."/".$search;
                $config["total_rows"]   = ($this->admin_model->product_master($pro_id,$parent_id,$cat_id,$search));
                $data['total_rows']     = $config["total_rows"];
                $config["per_page"]     = 10;
                $config["uri_segment"]  = 2;
                $config['attributes']   = array('class' => 'pag-link');
                $this->pagination->initialize($config);
                $data['links']          = $this->pagination->create_links();
                $data['page']           = $page = ($p1!=null) ? $p1 : 0;
                $data['parent_cat_list'] = $this->admin_model->get_parent_cat_list();
                $data['search']         = $this->input->post('search');
                $data['update_url']     = base_url('manage-product/create/');
                $data['delete_url']     = base_url('manage-product/delete/');
                $data['map_url']            = base_url().'manage-product/map-product/';
                $data['products']           = $this->admin_model->product_master($pro_id,$parent_id,$cat_id,$search,$config["per_page"],$page);
                $data['parent_cat']     = $this->admin_model->get_parent_cat($parent_id,$cat_id,$config["per_page"],$page);
                $data['categories'] = $this->admin_model->get_categories($parent_id,$cat_id);
                $data['cat_pro_map']         = $this->admin_model->get_cat_pro_map_for_product_list();
                // print_r($get_proid); die;
                if (@$_POST['cat_id']) {
                    if (empty($pro_id)) {
                        $config["total_rows"] = array();
                        $data['products'] = array();
                    }
                }
                load_view($data['contant'],$data);
                break;
                  case 'create':
                        $data['title'] 		= 'New Product';
                        $data['contant']      	= $view_dir.'create';
                        $data['action_url']	= base_url('manage-product/save');
                        $data['parent_cat']     = $this->admin_model->getData('category',['is_deleted'=>'NOT_DELETED','is_parent'=>'0']);
                        $data['count']=0;
                        if ($p1!=null) 
                        {
                                $data['action_url']     = base_url().'manage-product/save/'.$p1;
                                $data['value']          = $this->admin_model->getRow('products',['id'=>$p1]);
                                $data['count']=1;
                                $data['cat_pro_map']    = $this->admin_model->get_cat_pro_map($p1);
                                $data['contant']      	= $view_dir.'update';
                        }
                        $data['form_id']= uniqid();
                        $data['categories'] = $this->admin_model->get_data('category','is_parent !=','0');
                        load_view($data['contant'],$data);
                        break;
                case 'save':
                        $id = $p1;
                        $return['res'] = 'error';
                        $return['msg'] = 'Not Saved!';
        
                        if ($this->input->server('REQUEST_METHOD')=='POST') {
                        if ($id!=null) 
                        {
                                if($this->input->post('selling_price') <= $this->input->post('mrp')){
                                 $cat_id = count($this->input->post('cat_id'));
                                 $this->db->delete('cat_pro_maps', array('pro_id' => $id));
                                $data = array(
                                        'cat_id'     => $this->input->post('category'),
                                        'sub_cat_id'     => $this->input->post('subcat_id'),
                                        'pro_name'     => $this->input->post('pro_name'),
                                        'mrp'     => $this->input->post('mrp'),
                                        'selling_rate'     => $this->input->post('selling_price'),
                                        'pro_tax'     => $this->input->post('tax'),
                                        'description'     => $this->input->post('description'),
                                        'meta_title'     => $this->input->post('meta_title'),
                                        'meta_keyword'     => $this->input->post('meta_key'),
                                        'meta_description'     => $this->input->post('meta_desc'),
                                        ); 
                                if($this->admin_model->edit_product($data,$id))
                                {
                                        for ($i=0; $i < $cat_id; $i++) { 
                                                $data_cat_id = array(
                                                    'pro_id'=>$id,
                                                    'cat_id'=>$this->input->post('cat_id')[$i],
                                                );
                                                $this->admin_model->add_cat_pro_map($data_cat_id);
                                            }
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Product updated.';
                                }
                             }else{
                                $return['res'] = 'error';
                                $return['msg'] = 'Sorry you are not enter selling rate grater than mrp';
                             }
                        }
                        else
                        {
                                if($this->input->post('selling_price') <= $this->input->post('mrp')){
                                $cat_id = count($this->input->post('cat_id'));
                                $namepro=$this->input->post('pro_name');
                                $convertedName =  $this->url_character_remove($namepro);
                                $data = array(
                                'url'=>$convertedName,    
                                'pro_name'     => $this->input->post('pro_name'),
                                'mrp'     => $this->input->post('mrp'),
                                'selling_rate'     => $this->input->post('selling_price'),
                                'pro_tax'     => $this->input->post('tax'),
                                'description'     => $this->input->post('description'),
                                'meta_title'     => $this->input->post('meta_title'),
                                'meta_keyword'     => $this->input->post('meta_key'),
                                'meta_description'     => $this->input->post('meta_desc'),
                                );            
                                if ($result = $this->admin_model->add_product($data))
                                {
                                $prefix = 'PRO';
                                $formatted_id = sprintf('%05d', $result);
                                $uniqueCode = $prefix . $formatted_id;
                                $update['pro_code'] = $uniqueCode;
                                $this->admin_model->Update('products',$update,['id'=>$result]);
                                for ($i=0; $i < $cat_id; $i++) { 
                                $data_cat_id = array(
                                'pro_id'=>$result,
                                'cat_id'=>$this->input->post('cat_id')[$i],
                                );
                                $this->admin_model->add_cat_pro_map($data_cat_id);
                                    }
                                $return['res'] = 'success';
                                $return['msg'] = 'Product added successfully.';
                                }
                             }else{
                                $return['res'] = 'error';
                                $return['msg'] = 'Sorry you are not enter selling rate grater than mrp';
                             }
                        }
                }
                        echo json_encode($return);
                        break;
                        case 'delete':
                                $return['res'] = 'error';
                                $return['msg'] = 'Not Deleted!';
                                if ($p1!=null) {
                                if($this->admin_model->_delete('products',['id'=>$p1])){
                                        $saved = 1;
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Successfully deleted.';
                                }
                                }
                                echo json_encode($return);
             break;
             case 'map-product':
                $data['product_id'] = $p1;
                $data['parent_cat'] = $this->admin_model->get_data('category','is_parent','0');
                $data['products'] = $this->admin_model->get_map_products($p1);
                $page                       = 'pages/master/product/map_product';
                $this->load->view($page,$data);
            break; 
            
            case 'fetch_products':
                $psearch= 'null';
                $data['psearch'] = '';
                $parent_id= 'null';
                $data['parent_id'] = '';
                $pro_id = array();

                if (@$_POST['psearch']) {
                    $data['psearch'] = $_POST['psearch'];
                    $psearch=$_POST['psearch'];
               
                }

                if(@$_POST['parent_id'])
                {
                    $data['parent_id'] = $_POST['parent_id'];
                    $parent_id=$_POST['parent_id'];

                    $pro_id = array();
                    $get_proid = $this->db->get_where('cat_pro_maps',['cat_id' => $_POST['parent_id']])->result();
                    foreach($get_proid as $row){
                        $pro_id[] = $row->pro_id;
                    }
                }
                if(@$_POST['parent_cat_id'])
                {
                    $data['parent_id'] = $_POST['parent_cat_id'];
                    $parent_id=$_POST['parent_cat_id'];

                    $pro_id = array();
                    $get_proid = $this->db->get_where('cat_pro_maps',['cat_id' => $_POST['parent_cat_id']])->result();
                    foreach($get_proid as $row){
                        $pro_id[] = $row->pro_id;
                    }
                }

                if(@$_POST['cat_id'])
                {
                    $pro_id = array();
                    $get_proid = $this->db->get_where('cat_pro_maps',['cat_id' => $_POST['cat_id']])->result();
                    foreach($get_proid as $row){
                        $pro_id[] = $row->pro_id;
                    }                            
                }
                    $product_id= $this->input->post('product_id');

                    $data['product_id'] = $product_id;
                    $data['available_products'] = $this->admin_model->get_products($pro_id,$psearch);
                    $data['product_mapping'] = $this->admin_model->get_mapped_data($product_id);

                    if (@$_POST['parent_cat_id'] || @$_POST['cat_id']) {
                        if (empty($pro_id)) {
                            $data["available_products"] = array();
                            //$data['products'] = array();
                        }
                    }
                    $this->load->view('pages/master/product/available_products',$data);


            break;
            
            case 'map_product':
                $pid= $this->input->post('pid');
                $product_id= $this->input->post('product_id');
                $data1['flg'] = '1';
                $data1['pid'] = $pid;
                $data = array(
                        'pro_id'     => $product_id,
                        'map_pro_id'     => $pid,
                );
                $rev_data = array(
                        'pro_id'     => $pid,
                        'map_pro_id'     => $product_id,
                );
                $count = $this->admin_model->Counter('products_mapping', array('pro_id'=> $pid, 'map_pro_id' => $product_id ));
                if($count==0){
                $getmapdata =  $this->db->where(['pro_id'=>$product_id, 'map_pro_id'=>$pid])->get('products_mapping')->result();
                if(!empty($getmapdata))
                {
                foreach($getmapdata as $map_data)
                {
                $rev_map_data = array(
                        'map_pro_id'     => $map_data->map_pro_id,
                        'pro_id'     => $pid,
                );
                $map_data = array(
                        'pro_id'     => $map_data->map_pro_id,
                        'map_pro_id'     => $pid,
                );
                $this->admin_model->Save('products_mapping',$map_data);
                $this->admin_model->Save('products_mapping',$rev_map_data);
                }
                }else{
                if($this->admin_model->Save('products_mapping',$data) && $this->admin_model->add_data('products_mapping',$rev_data))          
                {
                $this->load->view('pages/master/product/map_unmap',$data1);

                }
                }
                }
                else{

                }

                break;
                case 'remove_map_product':
						
                        $pid = $this->input->post('pid');
                        $product_id = $this->input->post('product_id');
                        $data['pid'] = $pid;
                        $data['flg'] = '0';
                        if ($this->db->where('map_pro_id', $pid)->delete('products_mapping') && $this->db->where('pro_id', $pid)->delete('products_mapping')) {
                            $this->db->where(['map_pro_id' => $pid,'pro_id' =>$product_id])->delete('products_mapping');
                            $this->load->view('pages/master/product/map_unmap',$data);
                        } 
                        
              break;
            default:
            // code...
            break;
        }
    }
    public function loadSubcategories()
    {
        $catId = $this->input->post('category_id');
        $subcatId = $this->input->post('sub_cat_id');
        $selected='';

        $subcategories  = $this->admin_model->getData('category',['is_parent'=>$catId]);
        echo "<option value=''>Select Sub Category</option>";
        foreach($subcategories as $val)
        {
                echo "<option value='" . $val->id . "' " . $selected . ">" . $val->name . "</option>";
        }
    }
   public function Customers($action=null,$p1=null)
        {
                $view_dir = 'pages/master/customers/';
                switch ($action) {
                case null:
                $data['title']                  = 'Manage Customers';
                $page                           = $view_dir.'index';
                $data['tb_url']                 = current_url().'/tb';
                $data['search']                 = $this->input->post('search');
                $data['parent_cat'] = $this->admin_model->getData('category',['is_parent'=>'0']);
                $this->templete($page,$data);
                break;
                case 'tb':
                $this->load->library('pagination');

                $data['contant']        = $view_dir.'tb';
                $config = array();
                $config["base_url"]     = base_url()."manage-customers/tb";
                $config["total_rows"]   = count($this->admin_model->customer_master());
                $data['total_rows']     = $config["total_rows"];
                $config["per_page"]     = 10;
                $config["uri_segment"]  = 2;
                $config['attributes']   = array('class' => 'pag-link');
                $this->pagination->initialize($config);
                $data['links']          = $this->pagination->create_links();
                $data['page']           = $page = ($p1!=null) ? $p1 : 0;
                $data['search']         = $this->input->post('search');
                $data['rows']           = $this->admin_model->customer_master($config["per_page"],$page);
                load_view($data['contant'],$data);
                break;
                
        default:
        // code...
        break;
                }
    }
    //Home Header

    public function home_header()
    {
        $data['title'] = 'Home Header';
        $data['home_header']  = $this->admin_model->view_home_header();
        $data['shops']  = $this->admin_model->view_data('admins');
        $page = 'pages/master/home_header/home_header';
        $this->templete($page, $data);
    }

    public function add_home_header()
    {

        $data = array(
            'title'     => $this->input->post('title'),
            'type'     => $this->input->post('type'),
            'colorcode'     => $this->input->post('colorcode'),
            'seq'     => $this->input->post('seq'),
        );
        if ($this->admin_model->add_data('home_headers',$data)) {
            $this->session->set_flashdata('success', 'Home Header Added Successfully');
            redirect(base_url('home-header'));
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
             redirect(base_url('home-header'));
        }
    }
    public function edit_home_header()
    {
        $id = $this->uri->segment(2);

        $data = array(
            'title'     => $this->input->post('title'),
            'type'     => $this->input->post('type'),
            'colorcode'     => $this->input->post('colorcode'),
            'seq'     => $this->input->post('seq'),
        );

        if ($this->admin_model->edit_data('home_headers',$id,$data)) {
            $this->session->set_flashdata('success', 'Data Updated Successfully');
             redirect(base_url('home-header'));
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
             redirect(base_url('home-header'));
        }
    }
    public function delete_home_header()
    {
        $id = $this->uri->segment(2);
        if ($this->admin_model->delete_data('home_headers',$id)) {
            $this->session->set_flashdata('success', 'Data Deleted Successfully ');
             redirect(base_url('home-header'));
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
             redirect(base_url('home-header'));
        }
}
    //Category Headers Mapping
   public function cat_headers_mapping()
    {
        $data['title'] = 'Category Headers Mapping';
        $id = $this->uri->segment(2);
        $data['headerid'] = $id;
        $data['category_mapping'] = $this->admin_model->get_category_mapping($id);
        $page = 'pages/master/home_header/category_mapping';
        $this->templete($page, $data);
    }
    public function add_cat_mapping()
    {
        $data['headerid'] = $this->input->post('headerid');
         $headerid = $data['headerid'];
        $data['parent_cat'] = $this->admin_model->getData('category',['is_parent'=>'0','is_deleted'=>'NOT_DELETED','active'=>'1']);
        $data['headers_mapping'] = $this->admin_model->get_category_mapping($headerid);
        $data['parent_cat_list'] = $this->admin_model->get_parent_cat_list();
        $this->load->view('pages/master/home_header/add_cat_mapping',$data);
       
    }
     //Fetch Sub categories
     public function fetch_sub_categories()
     {
         if($this->input->post('parent_id'))
         {
             $parent_id= $this->input->post('parent_id');
             $this->admin_model->fetch_sub_categories($parent_id);
         }
     }
    public function delete_cat_header_mapping()
    {
        $id = $this->uri->segment(2);
    if ($this->admin_model->delete_category_map($id)) {
        $this->session->set_flashdata('success', 'Data Deleted Successfully ');
        redirect(base_url('home-header'));
    } else {
        $this->session->set_flashdata('error', 'Something Went Wrong!!');
        redirect(base_url('home-header'));
    }
    }
    public function available_category()
    {
        if($this->input->post('parent_cat_id'))
        {  
            $id= $this->input->post('parent_cat_id');
            $cat_id= $this->input->post('cat_id');
            $headerid= $this->input->post('headerid');
            $data['headerid'] = $headerid;;
            if($cat_id==''){
            $data['parent_cat'] = $this->admin_model->getData('category',['id'=>$id,'is_deleted'=>'NOT_DELETED','active'=>'1']);
            $data['headers_mapping'] = $this->admin_model->get_category_mapping($headerid);
            }else
            {
                $data['parent_cat'] = $this->admin_model->getData('category',['id'=>$cat_id,'is_deleted'=>'NOT_DELETED','active'=>'1']);  
                $data['headers_mapping'] = $this->admin_model->get_category_mapping($headerid);
            }
           
            $this->load->view('pages/master/home_header/available_category',$data);
        }
    }
    public function map_category()
    {
        $cid= $this->input->post('cid');
        $headerid= $this->input->post('headerid');
        $data = array(
            'header_id'     => $headerid,
            'value'     => $cid,
        );
        // $count = $this->admin_model->Counter('home_headers_mapping', array('header_id'=>$headerid));
        // if($count ==0){
        $data['category_mapping'] = $this->admin_model->add_data('home_headers_mapping',$data);
        // }else{
        // $data['category_mapping']= $this->db->where('header_id', $headerid)->update('home_headers_mapping', $data);
        // }
        $data['flg'] = '1';
        $data['cid'] = $cid;
        if($data['category_mapping'])
        {
            $this->load->view('pages/master/home_header/cat_map_unmap',$data);
        }
    }
    public function remove_map_category()
    {
        $cid= $this->input->post('cid');
        $headerid= $this->input->post('headerid');
        $data['flg'] = '0';
        $data['cid'] = $cid;
        if ($this->admin_model->delete_category_mapping($cid,$headerid)) {
            $this->load->view('pages/master/home_header/cat_map_unmap',$data);
        } 
    }

    public function product_headers_mapping()
    {
        $data['title'] = 'Products Headers Mapping';
        $id = $this->uri->segment(2);
        $data['headerid'] = $id;
        $data['headers_mapping'] = $this->admin_model->get_headers_mapping($id);
        $page = 'pages/master/home_header/headers_mapping';
        $this->templete($page, $data);
        
       
    }
    public function add_mapping()
    {
        $data['headerid'] = $this->input->post('headerid');
        $data['parent_cat'] = $this->admin_model->getData('category',['is_parent'=>'0','active'=>'1','is_deleted'=>'NOT_DELETED']);
        $data['categories'] = $this->admin_model->getData('category',['is_parent !='=>'0','active'=>'1','is_deleted'=>'NOT_DELETED']);
        $this->load->view('pages/master/home_header/add_mapping',$data);
       
    }
       //Fetch Products
       public function fetch_products()
       {
           if($this->input->post('parent_cat_id'))
           {
               $id= $this->input->post('parent_cat_id');
               
               $headerid= $this->input->post('headerid');
               $data['headerid'] = $headerid;
               $data['available_products'] = $this->admin_model->fetch_products($id);
               $data['headers_mapping'] = $this->admin_model->get_headers_mapping($headerid);
               // print_r($data['headers_mapping']);
               $this->load->view('pages/master/home_header/available_products',$data);
           }
       }

       public function map_product()
       {
           $pid= $this->input->post('pid');
           $headerid= $this->input->post('headerid');
           $data = array(
               'header_id'     => $headerid,
               'value'     => $pid,
           );
           $data['headers_mapping'] = $this->admin_model->add_data('home_headers_mapping',$data);
           $data['flg'] = '1';
           $data['pid'] = $pid;
           if($data['headers_mapping'])
           {
               $this->load->view('pages/master/home_header/map_unmap',$data);
           }
       }
       public function remove_map_product()
       {
           $pid= $this->input->post('pid');
           $headerid= $this->input->post('headerid');
           $data['flg'] = '0';
           $data['pid'] = $pid;
           if ($this->admin_model->delete_header_mapping($pid,$headerid)) {
               $this->load->view('pages/master/home_header/map_unmap',$data);
           } 
    }
    public function delete_header_mapping()
    {
            $id = $this->uri->segment(2);
        if ($this->admin_model->delete_header_map($id)) {
            $this->session->set_flashdata('success', 'Data Deleted Successfully ');
            redirect(base_url('home-header'));
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong!!');
            redirect(base_url('home-header'));
        }
    }

    public function Pincode($action=null,$p1=null)
    {
       
                $view_dir = 'pages/master/pincode/';
                switch ($action) {
                        case null:
                        $data['title'] 			= 'Pincode Master';
                        $page 		                =  $view_dir.'index';
                        $data['tb_url']	  		=  current_url().'/tb';
                        $data['new_url']		=  current_url().'/create';
                        $data['search']	 		=  $this->input->post('search');
                        $data['pincode'] = $this->admin_model->getData('pincodes_criteria',['is_deleted' => 'NOT_DELETED']);
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
                                //end of section
                        if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                        $search=$_POST['search'];
                               
                                }
                $this->load->library('pagination');

                $data['contant']        = $view_dir.'tb';
                $config = array();
                $config["base_url"]     = base_url()."manage-pincode/tb";
                $config["total_rows"]   = count($this->admin_model->pincode_master());
                $data['total_rows']     = $config["total_rows"];
                $config["per_page"]     = 10;
                $config["uri_segment"]  = 2;
                $config['attributes']   = array('class' => 'pag-link');
                $this->pagination->initialize($config);
                $data['links']          = $this->pagination->create_links();
                $data['page']           = $page = ($p1!=null) ? $p1 : 0;
                $data['parent_cat_list'] = $this->admin_model->get_parent_cat_list();
                $data['search']         = $this->input->post('search');
                $data['update_url']     = base_url('manage-pincode/create/');
                $data['delete_url']     = base_url('manage-pincode/delete/');
                $data['pincode']           = $this->admin_model->pincode_master($config["per_page"],$page);
                load_view($data['contant'],$data);
                break;
                  case 'create':
                        $data['title'] 		= 'New Product';
                        $data['contant']      	= $view_dir.'create';
                        $data['action_url']	= base_url('manage-pincode/save');
                        $data['count']=0;
                        if ($p1!=null) 
                        {
                                $data['action_url']     = base_url().'manage-pincode/save/'.$p1;
                                $data['value']          = $this->admin_model->getRow('pincodes_criteria',['id'=>$p1]);
                                $data['count']=1;
                        }
                        $data['form_id']= uniqid();
                        load_view($data['contant'],$data);
                        break;
                default:
                case 'save':
                        $id = $p1;
                        $return['res'] = 'error';
                        $return['msg'] = 'Not Saved!';
        
                        if ($this->input->server('REQUEST_METHOD')=='POST') {
                        if ($id!=null) 
                        {
                                $data = array(
                                        'pincode'     => $this->input->post('pincode'),
                                        'price'     => $this->input->post('price'),
                                        'kilometer'     => $this->input->post('km'),
                                        ); 
                                if($this->admin_model->Update('pincodes_criteria', $data,['id'=>$id]))
                                {
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Pincode updated.';
                                }
                        }
                        else
                        {
                                $data = array(
                                'pincode'     => $this->input->post('pincode'),
                                'price'     => $this->input->post('price'),
                                'kilometer'     => $this->input->post('km'),
                                );            
                                if ($this->admin_model->Save('pincodes_criteria', $data))
                                {
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Pincode added successfully.';
                                }
                            
                        }
                }
                        echo json_encode($return);
                        break;
                        case 'delete':
                                $return['res'] = 'error';
                                $return['msg'] = 'Not Deleted!';
                                if ($p1!=null) {
                                if($this->admin_model->_delete('pincodes_criteria',['id'=>$p1])){
                                        $saved = 1;
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Successfully deleted.';
                                }
                                }
                                echo json_encode($return);
                                break;
        
            // code...
            break;
        }
    }





    public function banner($action=null,$p1=null)
    {
       
                $view_dir = 'pages/master/banner/';
                switch ($action) {
                        case null:
                        $data['title']          = 'Banner Master';
                        $page                       =  $view_dir.'index';
                        $data['tb_url']         =  current_url().'/tb';
                        $data['new_url']        =  current_url().'/create';
                        $data['search']         =  $this->input->post('search');
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
                                //end of section
                        if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                        $search=$_POST['search'];
                               
                                }
                $this->load->library('pagination');

                $data['contant']        = $view_dir.'tb';
                $config = array();
                $config["base_url"]     = base_url()."manage-banner/tb";
                $config["total_rows"]   = count($this->admin_model->banner_master());
                $data['total_rows']     = $config["total_rows"];
                $config["per_page"]     = 10;
                $config["uri_segment"]  = 2;
                $config['attributes']   = array('class' => 'pag-link');
                $this->pagination->initialize($config);
                $data['links']          = $this->pagination->create_links();
                $data['page']           = $page = ($p1!=null) ? $p1 : 0;
                $data['parent_cat_list'] = $this->admin_model->get_parent_cat_list();
                $data['search']         = $this->input->post('search');
                $data['update_url']     = base_url('manage-banner/create/');
                $data['delete_url']     = base_url('manage-banner/delete/');
                $data['rows']           = $this->admin_model->banner_master($config["per_page"],$page);
                load_view($data['contant'],$data);
                break;
                  case 'create':
                        $data['title']      = 'New Banner';
                        $data['contant']        = $view_dir.'create';
                        $data['action_url'] = base_url('manage-banner/save');
                        $data['count']=0;
                        if ($p1!=null) 
                        {
                                $data['action_url']     = base_url().'manage-banner/save/'.$p1;
                                $data['value']          = $this->admin_model->getRow('home_banners',['id'=>$p1]);
                                $data['count']=1;
                        }
                        $data['form_id']= uniqid();
                        load_view($data['contant'],$data);
                        break;
                case 'save':
                        $id = $p1;
                        $return['res'] = 'error';
                        $return['msg'] = 'Not Saved!';
        
                        if ($this->input->server('REQUEST_METHOD')=='POST') {
                        if ($id!=null) 
                        {
                           if($this->admin_model->edit_home_banner($_POST,$id))
                           {
                           $return['res'] = 'success';
                           $return['msg'] = 'Banner updated.';
                           }
                        }
                        else
                        {
                          if ($this->admin_model->add_home_banner($_POST))
                          {
                          $return['res'] = 'success';
                          $return['msg'] = 'Banner added successfully.';
                          }
                            
                        }
                }
                        echo json_encode($return);
                        break;
                        case 'delete':
                                $return['res'] = 'error';
                                $return['msg'] = 'Not Deleted!';
                                if ($p1!=null) {
                                if($this->admin_model->_delete('home_banners',['id'=>$p1])){
                                        $saved = 1;
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Successfully deleted.';
                                }
                                }
                                echo json_encode($return);
                                break;
         default:
            // code...
            break;
        }
    }

function url_character_remove($text)
{
    // replace non-alphanumeric characters with -
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text);

    // trim
    $text = trim($text, '-');

    // lowercase
    $text = strtolower($text);

    return $text;
}



     public function SuperOffer($action=null,$p1=null)
    {
       
                $view_dir = 'pages/master/SuperOffer/';
                switch ($action) {
                        case null:
                        $data['title']          = 'Super Offer Master';
                        $page                       =  $view_dir.'index';
                        $data['tb_url']         =  current_url().'/tb';
                        $data['new_url']        =  current_url().'/create';
                        $data['search']         =  $this->input->post('search');
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
                                //end of section
                        if (@$_POST['search']) {
                        $data['search'] = $_POST['search'];
                        $search=$_POST['search'];
                               
                                }
                $this->load->library('pagination');

                $data['contant']        = $view_dir.'tb';
                $config = array();
                $config["base_url"]     = base_url()."manage-super-offer/tb";
                $config["total_rows"]   = count($this->admin_model->super_offer());
                $data['total_rows']     = $config["total_rows"];
                $config["per_page"]     = 10;
                $config["uri_segment"]  = 2;
                $config['attributes']   = array('class' => 'pag-link');
                $this->pagination->initialize($config);
                $data['links']          = $this->pagination->create_links();
                $data['page']           = $page = ($p1!=null) ? $p1 : 0;
                $data['parent_cat_list'] = $this->admin_model->get_parent_cat_list();
                $data['search']         = $this->input->post('search');
                $data['update_url']     = base_url('manage-super-offer/create/');
                $data['delete_url']     = base_url('manage-super-offer/delete/');
                $data['rows']           = $this->admin_model->super_offer($config["per_page"],$page);
                load_view($data['contant'],$data);
                break;
                  case 'create':
                        $data['title']      = 'New Banner';
                        $data['contant']        = $view_dir.'create';
                        $data['action_url'] = base_url('manage-super-offer/save');
                        $data['products']   = $this->admin_model->getData('products',['is_deleted'=>'NOT_DELETED']);
                        $data['count']=0;
                        if ($p1!=null) 
                        {
                                 $data['products']   = $this->admin_model->getData('products',['is_deleted'=>'NOT_DELETED']);
                                $data['action_url']     = base_url().'manage-super-offer/save/'.$p1;
                                $data['value']          = $this->admin_model->getRow('super_offer',['id'=>$p1]);
                                $data['count']=1;
                        }
                        $data['form_id']= uniqid();
                        load_view($data['contant'],$data);
                        break;
               
                case 'save':
                        $id = $p1;
                        $return['res'] = 'error';
                        $return['msg'] = 'Not Saved!';
        
                        if ($this->input->server('REQUEST_METHOD')=='POST') {
                        if ($id!=null) 
                        {
                           if($this->admin_model->edit_super_offer($_POST,$id))
                           {
                           $return['res'] = 'success';
                           $return['msg'] = 'Offer updated.';
                           }
                        }
                        else
                        {
                          if ($this->admin_model->add_super_offer($_POST))
                          {
                          $return['res'] = 'success';
                          $return['msg'] = 'Offer added successfully.';
                          }
                            
                        }
                }
                        echo json_encode($return);
                        break;
                        case 'delete':
                                $return['res'] = 'error';
                                $return['msg'] = 'Not Deleted!';
                                if ($p1!=null) {
                                if($this->admin_model->_delete('super_offer',['id'=>$p1])){
                                        $saved = 1;
                                        $return['res'] = 'success';
                                        $return['msg'] = 'Successfully deleted.';
                                }
                                }
                                echo json_encode($return);
                                break;
         default:
            // code...
            break;
        }
    }



}