
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Orders_model extends CI_Model
{
    function __construct(){
        $this->tbl2 = 'orders';
		$this->tbl1 = 'order_status_master';
		$this->tbl3 = 'order_status_log';
		$this->load->database();
	}
    public function orders($limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('orders a')
		->select('a.*,b.fname,b.lname,b.email,b.mobile,d.name as mode,c.name as status_name')
        ->join('customers b','b.id=a.user_id','left')
        ->join('order_status_master c','c.id=a.status','left')
        ->join('payment_mode d','d.id=a.payment_mode','left')
		->order_by('a.added','desc');					
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			$this->db->like('a.orderid',$_POST['search']);
            $this->db->or_like('b.fname',$_POST['search']);
            $this->db->or_like('b.email',$_POST['search']);
            $this->db->or_like('b.mobile',$_POST['search']);
			$this->db->group_end();
		}
        
        if (@$_POST['mode']) {
			$this->db->where('a.payment_mode',$_POST['mode']);
		}
        if (@$_POST['status']) {
			$this->db->where('a.status',$_POST['status']);
		}
		if (@$_POST['start_date']) {
			$start_date = $_POST['start_date'] .' 00:00:00';    
			$this->db->where('a.order_date >=',$start_date);
		}

		if (@$_POST['end_date']) {
			$end_date = $_POST['end_date'] . ' 23:59:59';
			$this->db->where('a.order_date <=',$end_date);
		}


		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();
	}
    public function getRowData($id)
	{
		$this->db
		->from('orders a')
		->select('a.*,b.fname,b.lname,b.email,b.mobile,d.name as mode,c.name as status_name')
        ->join('customers b','b.id=a.user_id','left')
        ->join('order_status_master c','c.id=a.status','left')
        ->join('payment_mode d','d.id=a.payment_mode','left')
		->where('a.orderid',$id);
        return $this->db->get()->row();
    }
    
    public function getItems($id)
	{
		$this->db
        ->from('orders a')
		->select('e.*,f.*,b.fname,b.lname,b.email,b.mobile,d.name as mode,c.name as status_name')
        ->join('customers b','b.id=a.user_id','left')
        ->join('order_status_master c','c.id=a.status','left')
        ->join('payment_mode d','d.id=a.payment_mode','left')
        ->join('order_items e','e.order_id=a.id','left')
        ->join('products f','f.id=e.product_id','left')
		->where('a.id',$id);
        return $this->db->get()->result_array();	
    }
    
	function getCurrentStatus($id){
		$this->db->select("t2.order");
		$this->db->from('orders t1');
		$this->db->join('order_status_master t2 ', 't2.id=t1.status');
		$this->db->where('t1.id',$id);
		$query = $this->db->get()->row();
		return $query;
	}

    function getRowsNew($order){
		$this->db->select("*");
		$this->db->from($this->tbl1);
		$this->db->where('active','1');
		$this->db->where('order >=',$order);
		$this->db->order_by('order','ASC');
		$query = $this->db->get();
		$result = ($query->num_rows() > 0)?$query->result():FALSE;
		return $result;
	}

    function get_row_order($oid){
		$this->db
		 ->select('t1.*,t3.mobile as alternate_mobile')
		 ->from('orders t1')       
		 ->join('customers t3', 't3.id = t1.user_id','left') 
		 ->where(['t1.id'=>$oid])  ;
	 
		 $query = $this->db->get()->row();
		 return $query;
	 }

     function getRows2($oid){
		$this->db
		 ->select('t1.*,t3.mobile as alternate_mobile')
		 ->from('orders t1')       
		 ->join('customers t3', 't3.id = t1.user_id','left') 
		 ->where(['t1.id'=>$oid])  ;
		 $query = $this->db->get();
		 $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		 return $result;
	 }
     function updateRow($id,$data = array()){
		$this->db->where($this->tbl2.'.'.'id',$id);
		$result = $this->db->update($this->tbl2,$data);
		return $result;
	}
    function SaveLog($data = array()){
		$result = $this->db->insert($this->tbl3,$data);
		return $result;
	}
}
?>   