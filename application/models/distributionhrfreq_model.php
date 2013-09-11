<?php
class Distributionhrfreq_model extends MY_Model {

	protected $_table = 'qm.dist_hr_freq';
	protected $primary_key = 'hfid';
	
	function sort_date(){
		$this->db->order_by("date_created", "desc"); 
		return $this;
	}
	
	function join_data(){
		$this->db->join('criteria', 'qm_form.criteria_id = criteria.criteria_id');
		$this->db->join('question', 'qm_form.question_id = question.question_id');
		//$this->db->where('tb_leave_application.staff_id', $staff_id);
		//$this->db->order_by("leave_status", "desc");
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