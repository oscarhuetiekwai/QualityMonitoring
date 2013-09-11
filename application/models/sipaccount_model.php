<?php

class Sipaccount_model extends MY_Model {

	protected $_table = 'callcenter.sipaccounts';
	protected $primary_key = 'id';
	
	function sort_ext($tenant_id)
	{
		$this->db->where('tenantid',$tenant_id);
		$this->db->order_by('name', 'asc');
		return $this;
	}
}
?>