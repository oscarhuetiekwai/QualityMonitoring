<?php
class Distributionagent_model extends MY_Model {

	protected $_table = 'qm.dist_profile_agent';
	//protected $primary_key = 'hfid';

	function sort_date(){
		$this->db->order_by("date_created", "desc");
		return $this;
	}

	function get_dist($dist_id)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->join('callcenter.users', 'qm.dist_profile_agent.userid = callcenter.users.userid');
		$this->db->where('distid', $dist_id);
		return $this;
	}

	function get_all_agent()
	{
		$tenantid = $this->session->userdata('tenant_id');
		$this->load->database('callcenter', TRUE);
		$this->db->select('*');
		$this->db->from('callcenter.users');
		$this->db->join('callcenter.userteams', 'callcenter.users.userid = callcenter.userteams.userid');
		$this->db->join('callcenter.teams', 'callcenter.userteams.teamid = callcenter.teams.teamid');
		$this->db->order_by('teams.name', 'ASC');
		$this->db->where('users.tenantid', $tenantid);
		$this->db->where('userlevel !=', 4);
		$this->db->where('userlevel !=', 3);
		$query = $this->db->get();
		return $query->result();
	}
}
?>