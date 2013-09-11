<?php
class Distribution_model extends MY_Model {

	protected $_table = 'qm.dist_profile';
	protected $primary_key = 'distid';

	function sort_date(){
		$this->db->order_by("date_created", "desc");
		return $this;
	}

	function get_all_distribution($tenant_id){

		$this->load->database('callcenter', TRUE);

		$this->db->join('qm.dist_hr_freq', 'dist_profile.distid = dist_hr_freq.distid');

		$this->db->join('qm.dist_queue', 'dist_profile.distid = dist_queue.distid');

		$this->db->join('callcenter.tenantqueues', 'qm.dist_queue.tenantqueueid = tenantqueues.tenantqueueid');

		$this->db->join('qm.dist_wrapup', 'dist_profile.distid = dist_wrapup.distid');
		$this->db->join('callcenter.wrapups', 'dist_wrapup.wrapupid = wrapups.wrapupid');

/* 	 	$this->db->join('qm.dist_profile_agent', 'dist_profile.distid = dist_profile_agent.distid');
		$this->db->join('callcenter.users', 'dist_profile_agent.userid = users.userid');

		$this->db->where('callcenter.users.userlevel !=', 4);
		$this->db->where('callcenter.users.userlevel !=', 3);
 */
		$this->db->where('dist_profile.tenantid', $tenant_id);
		$this->db->group_by('dist_profile.distid');
		$this->db->order_by("datecreated", "desc");
		return $this;
	}

	function get_row_distribution($distid)
	{
		$this->load->database('callcenter', TRUE);

		$this->db->join('qm.dist_hr_freq', 'dist_profile.distid = dist_hr_freq.distid');

		$this->db->join('qm.dist_queue', 'dist_profile.distid = dist_queue.distid');

		$this->db->join('callcenter.tenantqueues', 'qm.dist_queue.tenantqueueid = tenantqueues.tenantqueueid');

		$this->db->join('qm.dist_wrapup', 'dist_profile.distid = dist_wrapup.distid');
		$this->db->join('callcenter.wrapups', 'dist_wrapup.wrapupid = wrapups.wrapupid');

	/* 	 	$this->db->join('qm.dist_profile_agent', 'dist_profile.distid = dist_profile_agent.distid');
			$this->db->join('callcenter.users', 'dist_profile_agent.userid = users.userid');

			$this->db->where('callcenter.users.userlevel !=', 4);

	 */
		$this->db->where('qm.dist_profile.distid =', $distid);
		$this->db->where('qm.dist_hr_freq.distid =', $distid);
		$this->db->where('qm.dist_queue.distid =', $distid);
		$this->db->where('qm.dist_wrapup.distid =', $distid);

		$this->db->group_by('dist_profile.distid');
		$this->db->order_by("datecreated", "desc");
		return $this;
	}

	function get_dist($dist_id){

		$this->db->where('distid', $dist_id);
		return $this;
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