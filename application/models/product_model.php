<?php

class Product_model extends CI_Model {

	function __construct()
    {
       parent::__construct();
	   $this->load->database();
    }
	
	function lookup($product_type)
	{
		if ($product_type == null || $product_type == '')
		{
			return false;
		}
		
		$this->db->where('product_type', $product_type);
		$res = $this->db->get('products');
		$data = array();
		foreach($res->result() as $row)
		{
			$entry = array();
			$entry['product_name'] = $row->product_name;
			$data[] = $entry;
		}
		return $data;
	}

	/*public function lookup($productType) {
	
	$console = array("PS3","XBOX360","Wii");
	$camera = array("Kodak", "Samsung", "Sony");
	
		if ($productType == 'camera') {
			echo $camera[0] . '<br />' . $camera[1] . '<br />' . $camera[2];
			
		}
		
		else if ($productType == 'console') {
			echo $console[0] . '<br />' . $console[1] . '<br />' . $console[2];
		}
	}*/

}

?>