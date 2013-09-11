<?php
class Distributionqueue_model extends MY_Model {

	protected $_table = 'qm.dist_queue';
	protected $primary_key = 'dqid';

	function sort_date(){
		$this->db->order_by("date_created", "desc");
		return $this;
	}

	function get_dist($dist_id){

		$this->load->database('callcenter', TRUE);
		$this->db->join('callcenter.tenantqueues', 'qm.dist_queue.tenantqueueid = tenantqueues.tenantqueueid');
		$this->db->where('distid', $dist_id);
		return $this;
	}
	
	function get_all_queue($tenant_id)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('*');
		$this->db->from('callcenter.tenantqueues');
		$this->db->where('tenantid', $tenant_id);
		$this->db->order_by('queuename', 'ASC');	
		$query = $this->db->get();

		return $query->result();
	}

	function search_list($searchData=array(), $per_page=null, $current_page=null)
	{
		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_name'])){
			$this->db->where('criteria_title', $searchData['search_name']);
		}
		return $this;
	}

}
?>