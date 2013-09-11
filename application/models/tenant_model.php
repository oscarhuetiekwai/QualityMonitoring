<?php
class Tenant_model extends MY_Model {

	protected $_table = 'callcenter.tenants';
	protected $primary_key = 'tenantid';

	function get_tenant($tenant_id)
	{
		$this->db->where('tenants.tenantid',$tenant_id);
		return $this;
	}
}
?>