<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class offers_model extends CI_Model
{
    public function offers($limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*')
        ->from('coupons_and_offers t1')              
        ->where(['t1.is_deleted' => 'NOT_DELETED']);
        if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->like('t1.title', $_POST['search']);
            $this->db->where('t1.is_deleted','NOT_DELETED');
		}
        if($limit!=null)
        return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();
    }
	public function add_offer_coupon($data)
    {
		$config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'offers/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['photo']['name'])) {
            //upload images
            $_FILES['photos']['name'] = $_FILES['photo']['name'];
            $_FILES['photos']['type'] = $_FILES['photo']['type'];
            $_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'];
            $_FILES['photos']['size'] = $_FILES['photo']['size'];
            $_FILES['photos']['error'] = $_FILES['photo']['error'];

            if ($this->upload->do_upload('photos')) {
                $image_data = $this->upload->data();
                $fileName = "offers/" . $image_data['file_name'];
            }
            $data['photo'] = $fileName;
        } else {
            $data['photo'] = "";
        }
        return $this->db->insert('coupons_and_offers', $data);

    }
	public function offer($id)
    {
        $query = $this->db
        ->select('t1.*,t2.shop_name,t2.business_id')
        ->from('coupons_and_offers t1')       
        ->join('shops t2', 't2.id = t1.offer_created_by','left')  
		->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])    
        ->get();
		return $query->row();
    }
    public function edit_offer_coupon($data, $id)
    {
        // Initialize the upload library
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH . 'offers/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
    
        // Check if a new photo is selected
        if (!empty($_FILES['photo']['name'])) {
            // Upload the new photo
            if ($this->upload->do_upload('photo')) {
                $image_data = $this->upload->data();
                $data['photo'] = 'offers/' . $image_data['file_name'];
    
                // Delete the existing photo
                $data1['coupon_offer'] = $this->admin_model->get_row_data1('coupons_and_offers', 'id', $id);
                $coupon_offer_image = ltrim($data1['coupon_offer']->photo, '/');
                if (is_file(DELETE_PATH . $coupon_offer_image)) {
                    unlink(DELETE_PATH . $coupon_offer_image);
                }
            } else {
                // Handle upload errors if any
                $error = $this->upload->display_errors();
                // You may want to handle or log the error accordingly
                return false;
            }
        }
    
        // Update the data in the database
        return $this->db->where('id', $id)->update('coupons_and_offers', $data);
    }
    
    public function edit_shop_offers_cat($data,$id) 
    {
        return $this->db->where('offer_assosiated_id', $id)->update('shops_coupons_offers', $data);    
    }
    public function remove_offer($oid,$pid)
    {
        return $this->db->where(['offer_assosiated_id' => $oid,'product_id' =>$pid])->delete('shops_coupons_offers');
    }
    public function remove_offer_product($pid,$shop_id)
    {
        return $this->db->where(['product_id' =>$pid,'shop_id' =>$shop_id])->delete('shops_coupons_offers');
    }
    
    public function get_offers()
    {
        $query = $this->db
        ->select('t1.title,t2.*')
        ->from('coupons_and_offers t1')       
        ->join('shops_coupons_offers t2', 't2.offer_assosiated_id = t1.id','left')  
		->where(['t1.is_deleted' => 'NOT_DELETED'])    
        ->get();
		return $query->result();
    }
    public function fetch_offer_products($id)
    {
        $query = $this->db
        ->select('t1.*,t1.id as prod_id,t4.title,t4.value,t4.discount_type')
        ->from('products t1')          
        ->join('shops_coupons_offers t3', 't3.product_id = t1.id','left')           
        ->join('coupons_and_offers t4', 't4.id = t3.offer_assosiated_id','left')  
        ->join('cat_pro_maps t5', 't5.pro_id = t1.id','left')         
        ->where(['t5.cat_id' => $id,'t1.is_deleted' =>'NOT_DELETED'])
        ->get();
        return $query->result();
    }
    public function fetch_offer_products_search($id,$shopid)
    {
        
        $query = $this->db
        ->select('t1.*,t1.id as prod_id,t2.img,t4.title,t4.value,t4.discount_type')
        ->from('products_subcategory t1')
        ->join('products_photo t2', 't2.item_id = t1.id')           
        ->join('shops_coupons_offers t3', 't3.product_id = t1.id','left')           
        ->join('coupons_and_offers t4', 't4.id = t3.offer_assosiated_id','left')  
        ->join('cat_pro_maps t5', 't5.pro_id = t1.id','left')         
        ->where(['t1.id'=>$id,'t1.is_deleted' =>'NOT_DELETED']);
        return $query->get()->result();
    }
    public function check_offer($oid,$pid)
    {
        $query = $this->db->get_where('shops_coupons_offers', ['product_id' => $pid]);
        // print_r($query->num_rows());
        if($query->num_rows() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public function check_offer_cat($oid,$parent_cat_id)
    {
        $query = $this->db->get_where('shops_coupons_offers', ['category_id' => $parent_cat_id ]);
        // print_r($query->num_rows());
        if($query->num_rows() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public function check_offer_pro($oid,$prod_id,$shop_id)
    {
        $query = $this->db->get_where('shops_coupons_offers', ['product_id' => $prod_id , 'shop_id' => $shop_id]);
        // print_r($query->num_rows());
        if($query->num_rows() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public function remove_offer_cat($oid,$parent_cat_id)
    {
        return $this->db->where(['offer_assosiated_id' => $oid,'category_id' => $parent_cat_id])->delete('shops_coupons_offers');
    }
    public function remove_offer_pro($oid,$prod_id,$shop_id)
    {
        return $this->db->where(['offer_assosiated_id' => $oid,'product_id' => $prod_id,'shop_id' =>$shop_id])->delete('shops_coupons_offers');
    }
    public function remove_offer_similar($oid,$prod_id,$shop_id)
    {
        return $this->db->where(['offer_assosiated_id' => $oid,'product_id' => $prod_id,'shop_id' =>$shop_id])->delete('shops_coupons_offers');
    }
    public function fetch_offer_categories($pid,$shopid)
    {
        $query = $this->db
        ->select('t1.*,t1.id as prod_id,t3.title,t3.value,t3.discount_type')
        ->from('products_category t1')          
        ->join('shops_coupons_offers t2', 't2.product_id = t1.id','left')           
        ->join('coupons_and_offers t3', 't3.id = t2.offer_assosiated_id','left')         
        ->where(['t1.is_parent' => $pid,'t1.is_deleted' =>'NOT_DELETED','t2.shop_id' => $shopid])
        ->get();
        return $query->result();
    }

    public function delete_offer_products($data)
    {
        return $this->db->where(['product_id' => $data['product_id']])->delete('shops_coupons_offers');
    }
    
    public function fetch_products_new($id)
    {
        $query = $this->db
        ->select('t2.*,t2.id as prod_id')
        ->from('cat_pro_maps t1')          
        ->join('products t2', 't1.pro_id = t2.id','left')          
        ->where(['t1.cat_id' => $id,'t2.is_deleted' =>'NOT_DELETED'])
        ->get();
        return $query->result();
    }


    public function fetch_products($id)
    {
        $query = $this->db
        ->select('t1.*,t1.id as prod_id')
        ->from('products t1')          
        ->join('cat_pro_maps t3', 't3.pro_id = t1.id','left')          
        ->where(['t3.cat_id' => $id,'t1.is_deleted' =>'NOT_DELETED'])
        ->get();
        return $query->result();
    }

    public function fetch_products_search($search)
    {
        $query1 = $this->db
        ->select('t1.*')
        ->from('products t1')      
        ->where(['t1.is_deleted' =>'NOT_DELETED']);
        if ($search != 'null') {
            $this->db->group_start();
            $this->db->like('t1.pro_name', $search);
            $this->db->or_like('t1.pro_code', $search);
            $this->db->group_end();
        }
        $rs =  $query1->get()->row();
        $query = $this->db
        ->select('t1.*,t1.id as prod_id,t3.cat_id')
        ->from('products t1')          
        ->join('cat_pro_maps t3', 't3.pro_id = t1.id','left')            
        ->where(['t1.id' => @$rs->id,'t1.is_deleted' =>'NOT_DELETED'])
        ->group_by('t1.id')
        ->get();
        return $query->result();
      
    }





}
?>