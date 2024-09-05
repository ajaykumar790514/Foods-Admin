<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	// BY AJAY KUMAR
      /*
     *  Select Records From Table
     */
    public function Select($Table, $Fields = '*', $Where = 1)
    {
        /*
         *  Select Fields
         */
        if ($Fields != '*') {
            $this->db->select($Fields);
        }
        /*
         *  IF Found Any Condition
         */
        if ($Where != 1) {
            $this->db->where($Where);
        }
        /*
         * Select Table
         */
        $query = $this->db->get($Table);

        /*
         * Fetch Records
         */

        return $query->result();
    }
   /*
     * Count No Rows in Table
     */
 
    public function Counter($Table, $Where = 1)
    {
        $rows = $this->Select($Table, '*', $Where);

        return count($rows);
    }
    public function getByUsername($username)
    {
        $this->db->where('username', $username);
        $admin = $this->db->get('admins')->row_array();
        return $admin;
    }
    function Save($tb,$data){
		if($this->db->insert($tb,$data)){
			return $this->db->insert_id();
		}
		return false; 
	}
    
	function getData($tb,$data=0,$order=null,$order_by=null,$limit=null,$start=null) {

		if ($order!=null) {
			if ($order_by!=null) {
				$this->db->order_by($order_by,$order);
			}
			else{
				$this->db->order_by('id',$order);
			}
		}

		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}

		if ($data==0 or $data==null) {
			return $this->db->get($tb)->result();
		}
		if (@$data['search']) {
			$search = $data['search'];
			unset($data['search']);
		}
		return $this->db->get_where($tb,$data)->result();
	}



	function getRow($tb,$data=0) {
		if ($data==0) {
			if($data=$this->db->get($tb)->row()){
				return $data;
			}
			else {
				return false;
			}
		}
		elseif(is_array($data)) {
			if($data=$this->db->get_where($tb, $data)){
				return $data->row();
			}
			else {
				return false;
			}
		}
		else {
			if($data=$this->db->get_where($tb,array('id'=>$data))){
				return $data->row();
			}
			else {
				return false;
			}
		}
	}

	function Update($tb,$data,$cond) {
		$this->db->where($cond);
	 	if($this->db->update($tb,$data)) {
	 		return true;
	 	}
	 	return false;
	}
    function _delete($tb,$data) {
		if (is_array($data)){
			$this->db->where($data);
			if($this->db->update($tb,['is_deleted'=>'DELETED'])){
				return true;
			}
		}
		else{
			$this->db->where('id',$data);
			if($this->db->update($tb,['is_deleted'=>'DELETED'])){
				return true;
			}
		}
		return false;
	}
// by AJAY KUMAR

	   public function add_category($data)
		{
			$config['file_name'] = rand(10000, 10000000000);
			$config['upload_path'] = UPLOAD_PATH.'category/';
			$config['allowed_types'] = 'jpg|jpeg|png|webp|avif';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
	
			if (!empty($_FILES['icon']['name'])) {
	
				//upload images
				$_FILES['icons']['name'] = $_FILES['icon']['name'];
				$_FILES['icons']['type'] = $_FILES['icon']['type'];
				$_FILES['icons']['tmp_name'] = $_FILES['icon']['tmp_name'];
				$_FILES['icons']['size'] = $_FILES['icon']['size'];
				$_FILES['icons']['error'] = $_FILES['icon']['error'];
	
				if ($this->upload->do_upload('icons')) {
			
			   
					$image_data = $this->upload->data();
					
					if($_FILES['icons']['type']=='image/webp')
					{
							$img =  imagecreatefromwebp(UPLOAD_PATH.'category/'. $image_data['file_name']);
							imagewebp($img, UPLOAD_PATH.'category/thumbnail/'. $image_data['file_name'], 80);
							imagedestroy($img);
					}
					else
					{
							
							$config2 = array(
								'image_library' => 'gd2', //get original image
								'source_image' =>   UPLOAD_PATH.'category/'. $image_data['file_name'],
								'width' => 640,
								'height' => 360,
								'new_image' =>  UPLOAD_PATH.'category/thumbnail/'. $image_data['file_name'],
			
							);
							$this->load->library('image_lib');
							$this->image_lib->initialize($config2);
							$this->image_lib->resize();
							$this->image_lib->clear();
					}
					$fileName = "category/" . $image_data['file_name'];
					$fileName2 = "category/thumbnail/" . $image_data['file_name'];
				}
				$data['icon'] = $fileName;
				$data['thumbnail'] = $fileName2;
			} else {
				$data['icon'] = "";
			}
		   
				return $this->db->insert('category', $data);
			
			
		}
		
		public function edit_category($data,$id)
		{
			$config['file_name'] = rand(10000, 10000000000);
			$config['upload_path'] = UPLOAD_PATH.'category/';
			$config['allowed_types'] = 'jpg|jpeg|png|webp|avif';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
	
			if (!empty($_FILES['icon']['name'])) {
				//upload images
				$_FILES['icons']['name'] = $_FILES['icon']['name'];
				$_FILES['icons']['type'] = $_FILES['icon']['type'];
				$_FILES['icons']['tmp_name'] = $_FILES['icon']['tmp_name'];
				$_FILES['icons']['size'] = $_FILES['icon']['size'];
				$_FILES['icons']['error'] = $_FILES['icon']['error'];
	
				if ($this->upload->do_upload('icons')) {
			
					$image_data = $this->upload->data();
					
					if($_FILES['icons']['type']=='image/webp')
					{
							$img =  imagecreatefromwebp(UPLOAD_PATH.'category/'. $image_data['file_name']);
							imagepalettetotruecolor($img);
	//                        imagealphablending($img, true);
	//                        imagesavealpha($img, true);
							imagewebp($img, UPLOAD_PATH.'category/thumbnail/'. $image_data['file_name']);
							imagedestroy($img);
					}
					else
					{
							
							$config2 = array(
								'image_library' => 'gd2', //get original image
								'source_image' =>   UPLOAD_PATH.'category/'. $image_data['file_name'],
								'width' => 640,
								'height' => 360,
								'new_image' =>  UPLOAD_PATH.'category/thumbnail/'. $image_data['file_name'],
			
							);
							$this->load->library('image_lib');
							$this->image_lib->initialize($config2);
							$this->image_lib->resize();
							$this->image_lib->clear();
					}
					$fileName = "category/" . $image_data['file_name'];
					$fileName2 = "category/thumbnail/" . $image_data['file_name'];
				}
				$data['icon'] = $fileName;
				$data['thumbnail'] = $fileName2;
				
	
				if (!empty($fileName) && !empty($fileName2))    
				{
					$data1['cat_images'] = $this->admin_model->getRow('category',['id'=>$id]);
					$cat_image = @ltrim($data1['cat_images']->icon, '/');
					$cat_thumb = @ltrim($data1['cat_images']->thumbnail, '/');
					if(is_file(DELETE_PATH.$cat_image))
					{
						unlink(DELETE_PATH.$cat_image);
					}
					if(is_file(DELETE_PATH.$cat_thumb))
					{
						unlink(DELETE_PATH.$cat_thumb); 
					}
				}
			}
	
				return $this->db->where('id', $id)->update('category', $data); 
	
			
		}
public function abs($search,$limit=null,$start=null)
{
	if ($limit!=null) {
		$this->db->limit($limit, $start);
	}
	$this->db
	->from('category u')
	->select('u.*')
	->where('u.is_deleted','NOT_DELETED') 
	->order_by('u.id','desc');					
	if (@$_POST['search']) {
		$data['search'] = $_POST['search'];
		$this->db->group_start();
		$this->db->like('u.name',$_POST['search']);
		$this->db->group_end();
	}
	if($limit!=null)
		return $this->db->get()->result();
	else
	return $this->db->get()->result();
}
	public function category_master($parent_id,$cat_id,$search,$limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->where(['is_deleted' => 'NOT_DELETED', 'is_parent' => '0']);
		if ($parent_id!='null') {
			$this->db->like('id', $parent_id);
			$this->db->where('is_deleted','NOT_DELETED');
		}
		if ($search != 'null'  && $cat_id =='null' || $search != 'null') {
            $this->db->group_start();
			$this->db->like('name', $search);
			$this->db->or_like('is_parent', $cat_id);
            $this->db->group_end();
		}
		return $this->db->get('category')->result();
	}
	public function fetch_sub_categories($parent_id)
	{
		
		$data = $this->db->get_where('category',['is_parent' => $parent_id , 'is_deleted' => 'NOT_DELETED'])->result();
		echo "<option value=''>Select Sub Category</option>";
		foreach($data as $val)
		{
			echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
		}

	}
	public function delete_category_mapping($cid,$headerid)
	{
		return $this->db->where(['value' => $cid,'header_id' =>$headerid])->delete('home_headers_mapping');
	}
	public function get_parent_cat_list()
	{
		$this->db->where(['is_deleted' => 'NOT_DELETED', 'is_parent' => '0']);

		return $this->db->get('category')->result();
	}
 	public function get_parent_category()
 	{
	 $query = $this->db->get_where('category', ['is_deleted' => 'NOT_DELETED', 'is_parent' => '0', 'active' => '1']);
	 return $query->result();
 	}
 	public function get_parent_cat($parent_id,$cat_id,$limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->where(['is_deleted' => 'NOT_DELETED', 'is_parent' => '0']);
		if ($parent_id!='null') {
			$this->db->like('id', $parent_id);
			$this->db->where('is_deleted','NOT_DELETED');
		}
		return $this->db->get('category')->result();
	}
	public function get_categories($parent_id,$cat_id)
	{
		$this->db->order_by('seq','asc')->where(['is_deleted' => 'NOT_DELETED']);
        if ($cat_id!=='null') {
            $this->db->group_start();
			$this->db->like('id', $cat_id);
			$this->db->or_like('is_parent', $cat_id);
            $this->db->where('is_deleted','NOT_DELETED');
            $this->db->group_end();
            
		}
		return $this->db->get('category')->result();
	}
	public function add_product($data)
	{
		$config['file_name'] = rand(10000, 10000000000);
		$config['upload_path'] = UPLOAD_PATH.'product/';
		$config['allowed_types'] = 'jpg|jpeg|png|webp|avif';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!empty($_FILES['icon']['name'])) {

			//upload images
			$_FILES['icons']['name'] = $_FILES['icon']['name'];
			$_FILES['icons']['type'] = $_FILES['icon']['type'];
			$_FILES['icons']['tmp_name'] = $_FILES['icon']['tmp_name'];
			$_FILES['icons']['size'] = $_FILES['icon']['size'];
			$_FILES['icons']['error'] = $_FILES['icon']['error'];

			if ($this->upload->do_upload('icons')) {
		
		   
				$image_data = $this->upload->data();
				
				if($_FILES['icons']['type']=='image/webp')
				{
						$img =  imagecreatefromwebp(UPLOAD_PATH.'product/'. $image_data['file_name']);
						imagewebp($img, UPLOAD_PATH.'product/thumbnail/'. $image_data['file_name'], 80);
						imagedestroy($img);
				}
				else
				{
						
						$config2 = array(
							'image_library' => 'gd2', //get original image
							'source_image' =>   UPLOAD_PATH.'product/'. $image_data['file_name'],
							'width' => 640,
							'height' => 360,
							'new_image' =>  UPLOAD_PATH.'product/thumbnail/'. $image_data['file_name'],
		
						);
						$this->load->library('image_lib');
						$this->image_lib->initialize($config2);
						$this->image_lib->resize();
						$this->image_lib->clear();
				}
				$fileName = "product/" . $image_data['file_name'];
				$fileName2 = "product/thumbnail/" . $image_data['file_name'];
			}
			$data['icon'] = $fileName;
			$data['thumbnail'] = $fileName2;
		} else {
			$data['icon'] = "";
		}
			$this->db->insert('products', $data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
	}
	public function get_product_list()
	{
		$this->db->where(['is_deleted' => 'NOT_DELETED', '']);

		return $this->db->get('products')->result();
	}
	public function product_master($pro_id,$parent_id,$cat_id,$search,$limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
        ->select('t1.*')
        ->from('products t1')
        ->where(['t1.is_deleted' => 'NOT_DELETED'])
        ->order_by('t1.added','asc');
        if ($search != 'null'  && $cat_id =='null' || $search != 'null') {
            $this->db->group_start();
			$this->db->like('t1.pro_name', $search);
            $this->db->or_like('t1.pro_code', $search);
            $this->db->group_end();
		}
        if (!empty($pro_id)) {
            $this->db->where_in('t1.id',$pro_id);
            $this->db->where('t1.is_deleted','NOT_DELETED');    
		}
		if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();
	}
	public function edit_product($data,$id)
		{

			$config['file_name'] = rand(10000, 10000000000);
			$config['upload_path'] = UPLOAD_PATH.'product/';
			$config['allowed_types'] = 'jpg|jpeg|png|webp|avif';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
	
			if (!empty($_FILES['icon']['name'])) {
				//upload images
				$_FILES['icons']['name'] = $_FILES['icon']['name'];
				$_FILES['icons']['type'] = $_FILES['icon']['type'];
				$_FILES['icons']['tmp_name'] = $_FILES['icon']['tmp_name'];
				$_FILES['icons']['size'] = $_FILES['icon']['size'];
				$_FILES['icons']['error'] = $_FILES['icon']['error'];
	
				if ($this->upload->do_upload('icons')) {
			
					$image_data = $this->upload->data();
					
					if($_FILES['icons']['type']=='image/webp')
					{
							$img =  imagecreatefromwebp(UPLOAD_PATH.'product/'. $image_data['file_name']);
							imagepalettetotruecolor($img);
	//                        imagealphablending($img, true);
	//                        imagesavealpha($img, true);
							imagewebp($img, UPLOAD_PATH.'product/thumbnail/'. $image_data['file_name']);
							imagedestroy($img);
					}
					else
					{
							$config2 = array(
								'image_library' => 'gd2', //get original image
								'source_image' =>   UPLOAD_PATH.'product/'. $image_data['file_name'],
								'width' => 640,
								'height' => 360,
								'new_image' =>  UPLOAD_PATH.'product/thumbnail/'. $image_data['file_name'],
							);
							$this->load->library('image_lib');
							$this->image_lib->initialize($config2);
							$this->image_lib->resize();
							$this->image_lib->clear();
					}
					$fileName = "product/" . $image_data['file_name'];
					$fileName2 = "product/thumbnail/" . $image_data['file_name'];
				}
				$data['icon'] = $fileName;
				$data['thumbnail'] = $fileName2;
				
	
				if (!empty($fileName) && !empty($fileName2))    
				{
					$data1['cat_images'] = $this->admin_model->getRow('products',['id'=>$id]);
					$cat_image = @ltrim($data1['cat_images']->icon, '/');
					$cat_thumb = @ltrim($data1['cat_images']->thumbnail, '/');
					if(is_file(DELETE_PATH.$cat_image))
					{
						unlink(DELETE_PATH.$cat_image);
					}
					if(is_file(DELETE_PATH.$cat_thumb))
					{
						unlink(DELETE_PATH.$cat_thumb); 
					}
				}
			}
	
				return $this->db->where('id', $id)->update('products', $data); 
		}
		

public function customer_master($limit=null,$start=null)
{
	
    if ($limit!=null) {
        $this->db->limit($limit, $start);
    }
    $this->db
    ->from('customers a')
    ->select('a.*,b.*')
    ->join('customers_address b', 'b.customer_id = a.id', 'left')
    ->where(['a.is_deleted'=>'NOT_DELETED','b.is_default'=>'1'])
    ->order_by('a.added','desc');					
    if (@$_POST['search']) {
         $data['search'] = $_POST['search'];
        $this->db->group_start();
        $this->db->like('a.fname',$_POST['search']);
        $this->db->like('a.lname',$_POST['search']);
        $this->db->like('a.mobile',$_POST['search']);
        $this->db->like('a.email',$_POST['search']);
        $this->db->group_end();
    }
  if (@$_POST['start_date']) {
    $start_date = $_POST['start_date'];
    $this->db->where('DATE(a.added) >=', $start_date);
}

if (@$_POST['end_date']) {
    $end_date = $_POST['end_date'];
    $this->db->where('DATE(a.added) <=', $end_date);
}
    if($limit!=null)
        return $this->db->get()->result();
    else
    return $this->db->get()->result();
}
public function view_home_header()
{
	$query = $this->db
	->select('t1.*')
	->from('home_headers t1')      
	->where(['t1.is_deleted' => 'NOT_DELETED'])
	->order_by('t1.seq','asc')
	->get();
	return $query->result();
}
   //Category Header Mapping
   public function get_category_mapping($id)
   {
	   $query = $this->db
	   ->select('t1.*,t2.name,t2.icon,t2.id as catid,t3.title')
	   ->from('home_headers_mapping t1')
	   ->join('category t2', 't2.id = t1.value') 
	   ->join('home_headers t3', 't3.id = t1.header_id')        
	   ->where(['t1.header_id' => $id])
	   ->get();
	   return $query->result();
   }
   public function delete_category_map($id)
   {
	   return $this->db->where('id', $id)->delete('home_headers_mapping');
   }
   public function get_headers_mapping($id)
   {
	   $query = $this->db
	   ->select('t1.*,t2.id as prod_id,t2.pro_code,t2.pro_name as prod_name,t3.title,t2.icon,t2.thumbnail')
	   ->from('home_headers_mapping t1')
	   ->join('products t2', 't2.id = t1.value')        
	   ->join('home_headers t3', 't3.id = t1.header_id')        
	   ->where(['t1.header_id' => $id])
	   ->get();
	   return $query->result();
   }

   public function fetch_products_id($id)
        {
            
            $query = $this->db
            ->select('t1.*,t1.id as prod_id,t1.icon,t1.thumbnail')
            ->from('products_mapping map')
            ->join('products t1', 't1.id = map.map_pro_id','left')         
            ->where(['map.pro_id' => $id,'t1.is_deleted' =>'NOT_DELETED'])
            ->group_by('map.map_pro_id')
            ->get();
            return $query->result();
	}
        public function fetch_products($id)
        {
            $query = $this->db
            ->select('t1.*,t1.id as prod_id,t1.icon,t1.thumbnail')
            ->from('products t1')          
            ->join('cat_pro_maps t3', 't3.pro_id = t1.id','left')          
            ->where(['t3.cat_id' => $id,'t1.is_deleted' =>'NOT_DELETED'])
            ->get();
            return $query->result();
        }
	// public function fetch_products($id)
	// {
	// 	$query = $this->db
	// 	->select('t1.*,t1.id as prod_id,t1.icon,t1.thumbnail')
	// 	->from('products t1')      
	// 	->where(['t1.sub_cat_id' => $id,'t1.is_deleted' =>'NOT_DELETED'])
	// 	->get();
	// 	return $query->result();
	// }
	public function delete_header_map($id)
	{
		return $this->db->where('id', $id)->delete('home_headers_mapping');
	}
	public function delete_header_mapping($pid,$headerid)
	{
		return $this->db->where(['value' => $pid,'header_id' =>$headerid])->delete('home_headers_mapping');
	}

	public function pincode_master($limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('pincodes_criteria a')
		->select('a.*')
		->where(['a.is_deleted'=>'NOT_DELETED'])
		->order_by('a.added','desc');					
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			$this->db->like('a.pincode',$_POST['search']);
			$this->db->group_end();
		}
		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();
	}
	public function get_map_products($pid)
	{
		$query = $this->db

		->select('t1.id as pm_id,t2.pro_name as product_name,t2.pro_code,t2.id as pid,t2.thumbnail')
		->from('products_mapping t1')                                         
		->join('products t2', 't2.id = t1.map_pro_id','left')                          
		->where('t1.pro_id' , $pid)
		->where('t2.is_deleted' , 'NOT_DELETED')
		->get();
		return $query->result();

	}
	public function get_cat_pro_map($id)
    {
        $query = $this->db
        ->select('t1.*,t2.*')
        ->from('cat_pro_maps t1')
        ->join('category t2', 't2.id = t1.cat_id','left')
        ->where(['t1.pro_id'=>$id])
        ->get();
        return $query->result();
    }
	public function get_cat_pro_map_for_product_list(){
        $this->db
        ->select('t1.*, t2.*')
        ->from('cat_pro_maps t1')
        ->join('category t2', 't2.id = t1.cat_id')
        ->where(['t2.is_deleted'=>'NOT_DELETED','t2.active'=>'1']);
        return $this->db->get()->result();
    }
	public function add_cat_pro_map($data_cat_id){
        $this->db->insert('cat_pro_maps', $data_cat_id);
    }
    public function get_products($pro_id,$psearch)
        {
            $query = $this->db
            ->select('t1.*,t1.id as prod_id')
            ->from('products t1')   
            ->where(['t1.is_deleted' =>'NOT_DELETED']);
            if ($psearch !='null') {
                $this->db->group_start();
                $this->db->like('t1.pro_name', $psearch);
                $this->db->or_like('t1.pro_code', $psearch);
                $this->db->group_end();
            }
            if (!empty($pro_id)) {
                $this->db->where_in('t1.id', $pro_id);
            }
            return $query->get()->result();
    
}
public function get_mapped_data($product_id)
{
	$query = $this->db
	->select('t1.*')
	->from('products_mapping t1')    
	->where('t1.map_pro_id',$product_id)   
	->or_where('t1.pro_id',$product_id)
	->get();
	return $query->result();
}

    //Home Banner
        public function add_home_banner($data)
        {
            $config['file_name'] = rand(10000, 10000000000);
            $config['upload_path'] = UPLOAD_PATH.'banners/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp|svg|avif';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
    
            if (!empty($_FILES['img']['name'])) {
                //upload images
                $_FILES['imgs']['name'] = $_FILES['img']['name'];
                $_FILES['imgs']['type'] = $_FILES['img']['type'];
                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];
                $_FILES['imgs']['size'] = $_FILES['img']['size'];
                $_FILES['imgs']['error'] = $_FILES['img']['error'];
    
                if ($this->upload->do_upload('imgs')) {
                    $image_data = $this->upload->data();
                    $fileName = "banners/" . $image_data['file_name'];
                }
                $data['img'] = $fileName;
            } else {
                $data['img'] = "";
            }
            return $this->db->insert('home_banners', $data);
        }

    public function edit_home_banner($data,$id)
        {
            $config['file_name'] = rand(10000, 10000000000);
            $config['upload_path'] = UPLOAD_PATH.'banners/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|avif|webp|svg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            if (!empty($_FILES['img']['name'])) {
                //upload images
                $_FILES['imgs']['name'] = $_FILES['img']['name'];
                $_FILES['imgs']['type'] = $_FILES['img']['type'];
                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];
                $_FILES['imgs']['size'] = $_FILES['img']['size'];
                $_FILES['imgs']['error'] = $_FILES['img']['error'];
    
                if ($this->upload->do_upload('imgs')) {
                    $image_data = $this->upload->data();
                    $fileName = "banners/" . $image_data['file_name'];
                }
    
                if (!empty($fileName)) 
                {
                    $data2 = $this->db->get_where('home_banners', ['id' =>$id])->row();
                    if (!empty($data2->img))
                    {
                        if(is_file(DELETE_PATH.$data2->img))
                        {
                            unlink(DELETE_PATH.$data2->img);
                        }
                    }
                    $data['img'] = $fileName;
                } 
                
            }
            
            return $this->db->where('id', $id)->update('home_banners', $data); 
        }

        public function add_super_offer($data)
        {
            $config['file_name'] = rand(10000, 10000000000);
            $config['upload_path'] = UPLOAD_PATH.'super_offer/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp|svg|avif';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
    
            if (!empty($_FILES['img']['name'])) {
                //upload images
                $_FILES['imgs']['name'] = $_FILES['img']['name'];
                $_FILES['imgs']['type'] = $_FILES['img']['type'];
                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];
                $_FILES['imgs']['size'] = $_FILES['img']['size'];
                $_FILES['imgs']['error'] = $_FILES['img']['error'];
    
                if ($this->upload->do_upload('imgs')) {
                    $image_data = $this->upload->data();
                    $fileName = "super_offer/" . $image_data['file_name'];
                }
                $data['img'] = $fileName;
            } else {
                $data['img'] = "";
            }
            return $this->db->insert('super_offer', $data);
        }

    public function edit_super_offer($data,$id)
        {
            $config['file_name'] = rand(10000, 10000000000);
            $config['upload_path'] = UPLOAD_PATH.'super_offer/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|avif|webp|svg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            if (!empty($_FILES['img']['name'])) {
                //upload images
                $_FILES['imgs']['name'] = $_FILES['img']['name'];
                $_FILES['imgs']['type'] = $_FILES['img']['type'];
                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];
                $_FILES['imgs']['size'] = $_FILES['img']['size'];
                $_FILES['imgs']['error'] = $_FILES['img']['error'];
    
                if ($this->upload->do_upload('imgs')) {
                    $image_data = $this->upload->data();
                    $fileName = "super_offer/" . $image_data['file_name'];
                }
    
                if (!empty($fileName)) 
                {
                    $data2 = $this->db->get_where('super_offer', ['id' =>$id])->row();
                    if (!empty($data2->img))
                    {
                        if(is_file(DELETE_PATH.$data2->img))
                        {
                            unlink(DELETE_PATH.$data2->img);
                        }
                    }
                    $data['img'] = $fileName;
                } 
                
            }
            
            return $this->db->where('id', $id)->update('super_offer', $data); 
        }

      

	public function banner_master($limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('home_banners a')
		->select('a.*')
		->where(['a.is_deleted'=>'NOT_DELETED'])
		->order_by('a.seq','asc');					
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			$this->db->like('a.banner_title',$_POST['search']);
			$this->db->group_end();
		}
		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();
	}
	public function super_offer($limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('super_offer a')
		->select('a.*,a.img as thumbnail,b.pro_name,b.pro_code')
		->join('products b','b.id=a.product_id','left')
		->where(['a.is_deleted'=>'NOT_DELETED','b.is_deleted'=>'NOT_DELETED'])
		->order_by('a.seq','asc');					
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			$this->db->like('a.title',$_POST['search']);
			$this->db->group_end();
		}
		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();
	}



}

?>