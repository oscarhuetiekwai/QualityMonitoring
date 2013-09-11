<?php

class Wrapup_model extends MY_Model {

	protected $_table = 'callcenter.wrapups';
	protected $primary_key = 'wrapupid';
	
	function sort_wrapup($tenant_id)
	{
		$this->db->where('tenantid',$tenant_id);
		$this->db->order_by('wrapup', 'asc');
		return $this;
	}
}
?>