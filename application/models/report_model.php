<?php
class Report_model extends MY_Model {

	protected $_table = 'qm.recordings';
	protected $primary_key = 'record_id';

	################################ CARE LINE START HERE #########################################

	function total_cb_score2($tenant_id,$search_param)
	{
		$this->db->select('callcontactsdetails.queuename,callcontactsdetails.callid,recordings_and_qm.qm_id,recordings.record_id,recordings.userid,final_score,recordings.supervisor_id,rate_info_question.question_cb_total',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		$this->db->join('reportcallcenter.callcontactsdetails', 'recordings.unique_id = callcontactsdetails.callid');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_uniqueid'])){
			$or_where = "";
			foreach($search_param['search_uniqueid'] as $unique_id) {
				$or_where .= "callcontactsdetails.queuename = '$unique_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		$this->db->where('rate_info_question.question_cb_total IS NOT NULL', NULL, false);
		$this->db->group_by("rate_info_question.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_cc_score2($tenant_id,$search_param)
	{
		$this->db->select('callcontactsdetails.queuename,callcontactsdetails.callid,recordings_and_qm.qm_id,recordings.record_id,recordings.userid,final_score,recordings.supervisor_id,rate_info_question.question_cc_total',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		$this->db->join('reportcallcenter.callcontactsdetails', 'recordings.unique_id = callcontactsdetails.callid');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_uniqueid'])){
			$or_where = "";
			foreach($search_param['search_uniqueid'] as $unique_id) {
				$or_where .= "callcontactsdetails.queuename = '$unique_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		$this->db->where('rate_info_question.question_cc_total IS NOT NULL', NULL, false);
		$this->db->group_by("rate_info_question.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_nc_score2($tenant_id,$search_param)
	{
		$this->db->select('callcontactsdetails.queuename,callcontactsdetails.callid,recordings_and_qm.qm_id,recordings.record_id,recordings.userid,final_score,recordings.supervisor_id,rate_info_question.question_nc_total',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		$this->db->join('reportcallcenter.callcontactsdetails', 'recordings.unique_id = callcontactsdetails.callid');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_uniqueid'])){
			$or_where = "";
			foreach($search_param['search_uniqueid'] as $unique_id) {
				$or_where .= "callcontactsdetails.queuename = '$unique_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		$this->db->where('rate_info_question.question_nc_total IS NOT NULL', NULL, false);
		$this->db->group_by("rate_info_question.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_cb_score($tenant_id,$search_param)
	{
		$this->db->select('recordings_and_qm.qm_id,recordings.record_id,recordings.userid,final_score,recordings.supervisor_id,rate_info_question.question_cb_total',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_supervisorid'])){
			$or_where = "";
			foreach($search_param['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_userid'])){
			$or_where = "";
			foreach($search_param['search_userid'] as $userid) {
				$or_where .= "recordings.userid = '$userid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_qmid'])){
			$or_where = "";
			foreach($search_param['search_qmid'] as $qm_id) {
				$or_where .= "recordings_and_qm.qm_id = '$qm_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		$this->db->where('rate_info_question.question_cb_total IS NOT NULL', NULL, false);
		$this->db->group_by("rate_info_question.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_cc_score($tenant_id,$search_param)
	{
		$this->db->select('recordings_and_qm.qm_id,recordings.record_id,recordings.userid,final_score,recordings.supervisor_id,rate_info_question.question_cc_total',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_supervisorid'])){
			$or_where = "";
			foreach($search_param['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_userid'])){
			$or_where = "";
			foreach($search_param['search_userid'] as $userid) {
				$or_where .= "recordings.userid = '$userid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_qmid'])){
			$or_where = "";
			foreach($search_param['search_qmid'] as $qm_id) {
				$or_where .= "recordings_and_qm.qm_id = '$qm_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		$this->db->where('rate_info_question.question_cc_total IS NOT NULL', NULL, false);
		$this->db->group_by("rate_info_question.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_nc_score($tenant_id,$search_param)
	{
		$this->db->select('recordings_and_qm.qm_id,recordings.record_id,recordings.userid,final_score,recordings.supervisor_id,rate_info_question.question_nc_total',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_supervisorid'])){
			$or_where = "";
			foreach($search_param['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_userid'])){
			$or_where = "";
			foreach($search_param['search_userid'] as $userid) {
				$or_where .= "recordings.userid = '$userid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_qmid'])){
			$or_where = "";
			foreach($search_param['search_qmid'] as $qm_id) {
				$or_where .= "recordings_and_qm.qm_id = '$qm_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		$this->db->where('rate_info_question.question_nc_total IS NOT NULL', NULL, false);
		$this->db->group_by("rate_info_question.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_defect($tenant_id,$search_param)
	{
		$this->db->select('recordings_and_qm.qm_id,recordings.record_id,recordings.userid,final_score,recordings.supervisor_id,rate_info_question.question_nc_total,count(*) as total_question_nc',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_supervisorid'])){
			$or_where = "";
			foreach($search_param['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_userid'])){
			$or_where = "";
			foreach($search_param['search_userid'] as $userid) {
				$or_where .= "recordings.userid = '$userid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

/* 		if (isset($search_param['search_qmid'])){
			$or_where = "";
			foreach($search_param['search_qmid'] as $qm_id) {
				$or_where .= "recordings_and_qm.qm_id = '$qm_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		} */

		$this->db->where('rate_info_question.question_nc_total IS NOT NULL', NULL, false);
		$this->db->group_by("rate_info_question.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$this->db->where('rate_info_question.question_nc', 0);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_pass($tenant_id,$search_param)
	{
		## if critical ##

		$this->db->select('question.question_format,rate_info_question.question_nc,rate_info_question.question_cc,rate_info_question.question_cb,rate_info_question.question_id,recordings_and_qm.qm_id,recordings.record_id,recordings.userid,recordings.supervisor_id',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_qmid'])){
			$this->db->where('recordings_and_qm.qm_id', $search_param['search_qmid']);
		}

		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();

		return $query->result();
	}
	
	function total_fail($tenant_id,$search_param)
	{
		## if critical ##

		$this->db->select('question.question_format,rate_info_question.question_nc,rate_info_question.question_cc,rate_info_question.question_cb,rate_info_question.question_id,recordings_and_qm.qm_id,recordings.record_id,recordings.userid,recordings.supervisor_id',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_qmid'])){
			$this->db->where('recordings_and_qm.qm_id', $search_param['search_qmid']);
		}

		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();

		return $query->result();
	}
	
	function total_na($tenant_id,$search_param)
	{
		## if critical ##

		$this->db->select('question.question_format,rate_info_question.question_nc,rate_info_question.question_cc,rate_info_question.question_cb,rate_info_question.question_id,recordings_and_qm.qm_id,recordings.record_id,recordings.userid,recordings.supervisor_id,',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_qmid'])){
			$this->db->where('recordings_and_qm.qm_id', $search_param['search_qmid']);
		}

		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();

		return $query->result();
	}
	
	function total_pass2($tenant_id,$search_param)
	{
		## if critical ##

		$this->db->select('question.question_format,rate_info_question.question_nc,rate_info_question.question_cc,rate_info_question.question_cb,rate_info_question.question_id,recordings_and_qm.qm_id,recordings.record_id,recordings.userid,recordings.supervisor_id,rate_info_criteria.criteria_id,rate_info_criteria.criteria_title,rate_info_criteria.record_id',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_criteria', 'recordings.record_id = rate_info_criteria.record_id');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_qmid'])){
			$this->db->where('recordings_and_qm.qm_id', $search_param['search_qmid']);
		}

		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();

		return $query->result();
	}
	
	function total_fail2($tenant_id,$search_param)
	{
		## if critical ##

		$this->db->select('question.question_format,rate_info_question.question_nc,rate_info_question.question_cc,rate_info_question.question_cb,rate_info_question.question_id,recordings_and_qm.qm_id,recordings.record_id,recordings.userid,recordings.supervisor_id,rate_info_criteria.criteria_id,rate_info_criteria.criteria_title,rate_info_criteria.record_id',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_criteria', 'recordings.record_id = rate_info_criteria.record_id');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');

		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_qmid'])){
			$this->db->where('recordings_and_qm.qm_id', $search_param['search_qmid']);
		}

		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();

		return $query->result();
	}
	
	function total_na2($tenant_id,$search_param)
	{
		## if critical ##

		$this->db->select('question.question_format,rate_info_question.question_nc,rate_info_question.question_cc,rate_info_question.question_cb,rate_info_question.question_id,recordings_and_qm.qm_id,recordings.record_id,recordings.userid,recordings.supervisor_id,rate_info_criteria.criteria_id,rate_info_criteria.criteria_title,rate_info_criteria.record_id',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_criteria', 'recordings.record_id = rate_info_criteria.record_id');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_qmid'])){
			$this->db->where('recordings_and_qm.qm_id', $search_param['search_qmid']);
		}

		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();

		return $query->result();
	}
	
	function search_category_pass_fail_ratio($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('rate_info_criteria.criteria_id,rate_info_criteria.criteria_title,rate_info_question.question_id,rate_info.qm_id,rate_info.qm_title,rate_info.record_id,recordings.record_id,rate_info_question.question_title,rate_info.record_id',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		$this->db->join('qm.rate_info_criteria', 'recordings.record_id = rate_info_criteria.record_id');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_criteriaid'])){
			$this->db->where('rate_info_criteria.criteria_id', $searchData['search_criteriaid']);
		}

		//$this->db->group_by("qm_form.qm_id");

		//$this->db->group_by("rate_info.qm_id");
		//$this->db->group_by("rate_info_question.question_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("rate_info_question.criteria_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("recordings.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);

		$this->db->order_by('question.question_title','asc');
		$this->db->limit(1);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}
	
	function search_agent_performance($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('rate_info_question.question_id,rate_info_question.question_title,recordings.record_id,recordings.supervisor_id,users.username,recordings.userid',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_userid'])){
			 $or_where = "";
			 foreach($searchData['search_userid'] as $userid) {
				 $or_where .= "recordings.userid = '$userid' OR ";
			 }
			 $or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		 }

		if (isset($searchData['search_supervisorid'])){
			$or_where = "";
			foreach($searchData['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$this->db->where('rate_info_question.question_nc =', 0);
		$this->db->or_where('rate_info_question.question_cc =', 0); 

		$this->db->or_where('rate_info_question.question_cb =', 0);

		$this->db->order_by('users.username','asc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function search_qm_form_pass_fail_ratio($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('rate_info_question.question_id,rate_info.qm_id,rate_info.qm_title,rate_info.record_id,recordings.record_id,rate_info_question.question_title',FALSE);
		$this->db->from('qm.recordings');
	 	$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		//$this->db->join('qm.rate_info_criteria', 'rate_info.record_id = rate_info_criteria.record_id');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_qmid'])){
			$this->db->where('rate_info.qm_id', $searchData['search_qmid']);
		}

		if (isset($searchData['search_formtype'])){

			if($searchData['search_formtype'] == 1){
				$this->db->where('question.question_format !=',1);
				$this->db->where('question.question_format !=',2);
				$this->db->where('question.question_format !=',3);
				$this->db->where('question.question_format !=',6);
			}else{
				$this->db->where('question.question_format !=',1);
				$this->db->where('question.question_format !=',2);
				$this->db->where('question.question_format !=',3);
				$this->db->where('question.question_format !=',4);
				$this->db->where('question.question_format !=',5);
			}
		}
		//$this->db->group_by("qm_form.qm_id");

		//$this->db->group_by("rate_info.qm_id");
		$this->db->group_by("rate_info_question.question_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("rate_info_question.criteria_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("recordings.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);

		$this->db->order_by('question.question_title','asc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function search_qm_report_by_department_datacom($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('rate_info.qm_id,rate_info.qm_title,rate_info.record_id,recordings.record_id, sum(if(`monitoring_type` = 1,1,0)) AS independent,sum(if(`monitoring_type` = 2,1,0)) AS buddy,count(*) AS TM,sum(if(`recover` = 1,1,0)) AS total_recover',FALSE);
		$this->db->from('qm.recordings');
	 	$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		//$this->db->join('qm.rate_info_criteria', 'rate_info.record_id = rate_info_criteria.record_id');
		//$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		//$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_qmid'])){
			$or_where = "";
			foreach($searchData['search_qmid'] as $qm_id) {
				$or_where .= "rate_info.qm_id = '$qm_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($searchData['search_supervisorid'])){
			$or_where = "";
			foreach($searchData['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}
		//$this->db->group_by("qm_form.qm_id");

		$this->db->group_by("rate_info.qm_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("rate_info_question.criteria_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("recordings.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);

		$this->db->order_by('recordings.date_complete','desc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function search_qm_report_by_campaign_datacom($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->load->database('reportcallcenter', TRUE);
		$this->db->select('callcontactsdetails.queuename,callcontactsdetails.callid,recordings.unique_id,rate_info.qm_id,rate_info.qm_title,rate_info.record_id,recordings.record_id, sum(if(`monitoring_type` = 1,1,0)) AS independent,sum(if(`monitoring_type` = 2,1,0)) AS buddy,count(*) AS TM,sum(if(`recover` = 1,1,0)) AS total_recover',FALSE);
		$this->db->from('qm.recordings');
	 	$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		$this->db->join('reportcallcenter.callcontactsdetails', 'recordings.unique_id = callcontactsdetails.callid');
		//$this->db->join('qm.rate_info_criteria', 'rate_info.record_id = rate_info_criteria.record_id');
		//$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		//$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_uniqueid'])){
			$or_where = "";
			foreach($searchData['search_uniqueid'] as $unique_id) {
				$or_where .= "callcontactsdetails.queuename = '$unique_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($searchData['search_supervisorid'])){
			$or_where = "";
			foreach($searchData['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}
		//$this->db->group_by("qm_form.qm_id");
		$this->db->group_by("callcontactsdetails.queuename");
		//$this->db->group_by("rate_info_question.criteria_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("recordings.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$names = array('COMPLETECALLER', 'COMPLETEAGENT');
		$this->db->where_in('callcontactsdetails.lastevent', $names);
		$this->db->order_by('recordings.date_complete','desc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function search_qm_report_by_qa_datacom($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('*, sum(if(`monitoring_type` = 1,1,0)) AS independent,sum(if(`monitoring_type` = 2,1,0)) AS buddy,count(*) AS TM,sum(if(`recover` = 1,1,0)) AS total_recover',FALSE);
		$this->db->from('qm.recordings');
	 	$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		//$this->db->join('qm.rate_info_criteria', 'rate_info.record_id = rate_info_criteria.record_id');
		//$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		//$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');
		//$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		//$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		//$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		//$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		//$this->db->join('qm.criteria_and_question', 'qm_form.qm_id = criteria_and_question.qm_id');
		//$this->db->join('callcenter.tenants', 'recordings.tenantid = tenants.tenantid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		// if (isset($searchData['search_userid'])){
			// $or_where = "";
			// foreach($searchData['search_userid'] as $userid) {
				// $or_where .= "recordings.userid = '$userid' OR ";
			// }
			// $or_where2 = substr($or_where, 0, -3);
			// $this->db->where($or_where2);
		// }

		if (isset($searchData['search_supervisorid'])){
			$or_where = "";
			foreach($searchData['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}
		//$this->db->group_by("qm_form.qm_id");

		$this->db->group_by("recordings.supervisor_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("rate_info_question.criteria_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("recordings.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
	//	$this->db->order_by('recordings.date_complete','desc');
		$this->db->order_by('recordings.supervisor_id','asc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function search_qm_report_by_section_datacom($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('rate_info.qm_id,rate_info.qm_title,rate_info.record_id,recordings.record_id, sum(if(`monitoring_type` = 1,1,0)) AS independent,sum(if(`monitoring_type` = 2,1,0)) AS buddy,count(*) AS TM,sum(if(`recover` = 1,1,0)) AS total_recover',FALSE);
		$this->db->from('qm.recordings');
	 	$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		//$this->db->join('qm.rate_info_criteria', 'rate_info.record_id = rate_info_criteria.record_id');
		//$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		//$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_qmid'])){
			$or_where = "";
			foreach($searchData['search_qmid'] as $qm_id) {
				$or_where .= "rate_info.qm_id = '$qm_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($searchData['search_supervisorid'])){
			$or_where = "";
			foreach($searchData['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}
		//$this->db->group_by("qm_form.qm_id");

		$this->db->group_by("rate_info.qm_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("rate_info_question.criteria_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("recordings.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);

		$this->db->order_by('recordings.date_complete','desc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function search_qm_report_by_agent_datacom($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('*, sum(if(`monitoring_type` = 1,1,0)) AS independent,sum(if(`monitoring_type` = 2,1,0)) AS buddy,count(*) AS TM,sum(if(`recover` = 1,1,0)) AS total_recover',FALSE);
		$this->db->from('qm.recordings');
	 	//$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		//$this->db->join('qm.rate_info_criteria', 'rate_info.record_id = rate_info_criteria.record_id');
		//$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		//$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');
		//$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		//$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		//$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		//$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		//$this->db->join('qm.criteria_and_question', 'qm_form.qm_id = criteria_and_question.qm_id');
		//$this->db->join('callcenter.tenants', 'recordings.tenantid = tenants.tenantid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_userid'])){
			$or_where = "";
			foreach($searchData['search_userid'] as $userid) {
				$or_where .= "recordings.userid = '$userid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($searchData['search_supervisorid'])){
			$or_where = "";
			foreach($searchData['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}
		//$this->db->group_by("qm_form.qm_id");

		$this->db->group_by("recordings.userid");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("rate_info_question.criteria_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("recordings.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$this->db->order_by('recordings.supervisor_id','asc');
		//$this->db->order_by('recordings.date_complete','desc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function search_agent_score_datacom($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('users.username,recordings.status,recordings.userid,rate_info_question.question_cb_total,rate_info_question.question_cc_total,rate_info_question.question_nc_total,recordings.record_id,rate_info.qm_id,rate_info.qm_title,recordings.supervisor_id,recordings.unique_id,recordings.date_complete',FALSE);
		$this->db->from('qm.recordings');
	 	$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		//$this->db->join('qm.rate_info_criteria', 'rate_info.record_id = rate_info_criteria.record_id');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		//$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');
		//$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		//$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		//$this->db->join('qm.criteria_and_question', 'qm_form.qm_id = criteria_and_question.qm_id');
		//$this->db->join('callcenter.tenants', 'recordings.tenantid = tenants.tenantid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_userid'])){
			$or_where = "";
			foreach($searchData['search_userid'] as $userid) {
				$or_where .= "recordings.userid = '$userid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($searchData['search_supervisorid'])){
			$or_where = "";
			foreach($searchData['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		$this->db->group_by("rate_info_question.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		//$this->db->order_by('recordings.date_complete','desc');

		$this->db->order_by('recordings.supervisor_id','asc');
		$this->db->order_by('recordings.date_complete','desc');

		//$this->db->order_by('users.username','asc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function search_overall_summary_for_department($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('qm_form.qm_id, recordings.record_id,rate_info.record_id, sum(if(`monitoring_type` = 1,1,0)) AS independent,sum(if(`monitoring_type` = 2,1,0)) AS buddy,count(*) AS TM, rate_info.qm_title, qm.fnGetQuestionsCount(qm_form.qm_id, 4) AS totalcb, qm.fnGetQuestionSuccessCount(qm_form.qm_id, 4) AS totalcbsuccess,  qm.fnGetQuestionsCount(qm_form.qm_id, 5) AS totalcc, qm.fnGetQuestionSuccessCount(qm_form.qm_id, 5) AS totalccsuccess, qm.fnGetQuestionsCount(qm_form.qm_id, 6) AS totalnc, qm.fnGetQuestionSuccessCount(qm_form.qm_id, 6) AS totalncsuccess',FALSE);
		$this->db->from('qm.recordings');
	 	$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		//$this->db->join('qm.rate_info_criteria', 'recordings.record_id = rate_info_criteria.record_id');
		//$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		//$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		//$this->db->join('callcenter.users', 'recordings.userid = users.userid');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		//$this->db->join('qm.criteria_and_question', 'qm_form.qm_id = criteria_and_question.qm_id');
		//$this->db->join('callcenter.tenants', 'recordings.tenantid = tenants.tenantid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		/* if (isset($searchData['search_userid'])){
			$this->db->where('recordings.status', $searchData['search_status']);
		} */
		$this->db->group_by("qm_form.qm_id");
		$this->db->where('qm_form.tenant_id', $tenant_id);
		$this->db->where('recordings.status', 4);
		/* 		$this->db->where('rate_info_question.question_cb !=', 9911);
		$this->db->where('rate_info_question.question_cc !=', 9911);
		$this->db->where('rate_info_question.question_nc !=', 9911); */
		$this->db->order_by('date_complete','desc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function count_cb_question($tenant_id)
	{
		//$this->load->database('callcenter', TRUE);
		$this->db->select('question_cb,qm_id,question_cb_total,recordings.record_id',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->where('question.question_format', 4);
		$this->db->where('recordings.tenantid', $tenant_id);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}
	################################ CARE LINE END HERE #########################################


	################################ DIRECT SALE START HERE #########################################
	function search_agent_score($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{

		$this->load->database('callcenter', TRUE);
		$this->db->select('*',FALSE);
		$this->db->from('qm.recordings');
	 	$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		//$this->db->join('qm.rate_info_criteria', 'rate_info.record_id = rate_info_criteria.record_id');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		//$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');
		//$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		//$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		//$this->db->join('qm.criteria_and_question', 'qm_form.qm_id = criteria_and_question.qm_id');
		//$this->db->join('callcenter.tenants', 'recordings.tenantid = tenants.tenantid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_userid'])){
			$or_where = "";
			foreach($searchData['search_userid'] as $userid) {
				$or_where .= "recordings.userid = '$userid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($searchData['search_supervisorid'])){
			$or_where = "";
			foreach($searchData['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		$this->db->group_by("rate_info_question.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		//$this->db->order_by('recordings.date_complete','desc');
		//$this->db->order_by('recordings.supervisor_id','asc');


		$this->db->order_by('recordings.supervisor_id','asc');
		$this->db->order_by('recordings.date_complete','desc');
		//$this->db->order_by('users.username','asc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function search_qm_report_by_agent($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('*, sum(if(`monitoring_type` = 1,1,0)) AS independent,sum(if(`monitoring_type` = 2,1,0)) AS buddy,count(*) AS TM,sum(if(`recover` = 1,1,0)) AS total_recover',FALSE);
		$this->db->from('qm.recordings');
	 	//$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		//$this->db->join('qm.rate_info_criteria', 'rate_info.record_id = rate_info_criteria.record_id');
		//$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		//$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');
		//$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		//$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		//$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		//$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		//$this->db->join('qm.criteria_and_question', 'qm_form.qm_id = criteria_and_question.qm_id');
		//$this->db->join('callcenter.tenants', 'recordings.tenantid = tenants.tenantid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_userid'])){
			$or_where = "";
			foreach($searchData['search_userid'] as $userid) {
				$or_where .= "recordings.userid = '$userid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($searchData['search_supervisorid'])){
			$or_where = "";
			foreach($searchData['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}
		//$this->db->group_by("qm_form.qm_id");

		$this->db->group_by("recordings.userid");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("rate_info_question.criteria_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("recordings.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		//$this->db->order_by('recordings.date_complete','desc');
		$this->db->order_by('recordings.supervisor_id','asc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function search_qm_report_by_qa($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('*, sum(if(`monitoring_type` = 1,1,0)) AS independent,sum(if(`monitoring_type` = 2,1,0)) AS buddy,count(*) AS TM,sum(if(`recover` = 1,1,0)) AS total_recover',FALSE);
		$this->db->from('qm.recordings');
	 	$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		//$this->db->join('qm.rate_info_criteria', 'rate_info.record_id = rate_info_criteria.record_id');
		//$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		//$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');
		//$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		//$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		//$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		//$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		//$this->db->join('qm.criteria_and_question', 'qm_form.qm_id = criteria_and_question.qm_id');
		//$this->db->join('callcenter.tenants', 'recordings.tenantid = tenants.tenantid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_userid'])){
			$or_where = "";
			foreach($searchData['search_userid'] as $userid) {
				$or_where .= "recordings.userid = '$userid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($searchData['search_supervisorid'])){
			$or_where = "";
			foreach($searchData['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}
		//$this->db->group_by("qm_form.qm_id");

		$this->db->group_by("recordings.supervisor_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("rate_info_question.criteria_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("recordings.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$this->db->order_by('recordings.date_complete','desc');
		$this->db->order_by('recordings.supervisor_id','asc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function search_qm_report_by_section($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->db->select('rate_info.qm_id,rate_info.qm_title,rate_info.record_id,recordings.record_id, sum(if(`monitoring_type` = 1,1,0)) AS independent,sum(if(`monitoring_type` = 2,1,0)) AS buddy,count(*) AS TM,sum(if(`recover` = 1,1,0)) AS total_recover',FALSE);
		$this->db->from('qm.recordings');
	 	$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		//$this->db->join('qm.rate_info_criteria', 'rate_info.record_id = rate_info_criteria.record_id');
		//$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		//$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_qmid'])){
			$or_where = "";
			foreach($searchData['search_qmid'] as $qm_id) {
				$or_where .= "rate_info.qm_id = '$qm_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($searchData['search_supervisorid'])){
			$or_where = "";
			foreach($searchData['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}
		//$this->db->group_by("qm_form.qm_id");

		$this->db->group_by("rate_info.qm_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("rate_info_question.criteria_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("recordings.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$this->db->order_by('recordings.date_complete','desc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function search_qm_report_by_campaign($tenant_id,$userid, $searchData=array(), $per_page=null, $current_page=null)
	{
		$this->load->database('callcenter', TRUE);
		$this->load->database('reportcallcenter', TRUE);
		$this->db->select('callcontactsdetails.queuename,callcontactsdetails.callid,recordings.unique_id,rate_info.qm_id,rate_info.qm_title,rate_info.record_id,recordings.record_id, sum(if(`monitoring_type` = 1,1,0)) AS independent,sum(if(`monitoring_type` = 2,1,0)) AS buddy,count(*) AS TM,sum(if(`recover` = 1,1,0)) AS total_recover',FALSE);
		$this->db->from('qm.recordings');
	 	$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		$this->db->join('reportcallcenter.callcontactsdetails', 'recordings.unique_id = callcontactsdetails.callid');
		//$this->db->join('qm.rate_info_criteria', 'rate_info.record_id = rate_info_criteria.record_id');
		//$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		//$this->db->join('qm.question', 'rate_info_question.question_id = question.question_id');
		$this->db->join('callcenter.users', 'recordings.userid = users.userid');

		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}

		if (isset($searchData['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $searchData['search_start_date']);
		}

		if (isset($searchData['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $searchData['search_end_date']);
		}

		if (isset($searchData['search_uniqueid'])){
			$or_where = "";
			foreach($searchData['search_uniqueid'] as $unique_id) {
				$or_where .= "callcontactsdetails.queuename = '$unique_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($searchData['search_supervisorid'])){
			$or_where = "";
			foreach($searchData['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}
		//$this->db->group_by("qm_form.qm_id");
		$this->db->group_by("callcontactsdetails.queuename");
		//$this->db->group_by("rate_info_question.criteria_id");
		//$this->db->group_by("rate_info_question.record_id");
		//$this->db->group_by("recordings.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$names = array('COMPLETECALLER', 'COMPLETEAGENT');
		$this->db->where_in('callcontactsdetails.lastevent', $names);
		$this->db->order_by('recordings.date_complete','desc');
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_score3($tenant_id,$search_param)
	{
		$this->load->database('reportcallcenter', TRUE);
		$this->db->select('callcontactsdetails.queuename,callcontactsdetails.callid,recordings.unique_id,rate_info.qm_id,recordings.record_id,recordings.userid,final_score,recordings.supervisor_id,MAX(final_score) AS highest_score,MIN(final_score) AS lowest_score',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('reportcallcenter.callcontactsdetails', 'recordings.unique_id = callcontactsdetails.callid');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_supervisorid'])){
			$or_where = "";
			foreach($search_param['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_userid'])){
			$or_where = "";
			foreach($search_param['search_userid'] as $userid) {
				$or_where .= "recordings.userid = '$userid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_qmid'])){
			$or_where = "";
			foreach($search_param['search_qmid'] as $qm_id) {
				$or_where .= "rate_info.qm_id = '$qm_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_uniqueid'])){
			$or_where = "";
			foreach($search_param['search_uniqueid'] as $unique_id) {
				$or_where .= "callcontactsdetails.queuename = '$unique_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		$this->db->where('rate_info_question.final_score IS NOT NULL', NULL, false);
		$this->db->group_by("rate_info_question.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_pending3($tenant_id)
	{
		$this->load->database('reportcallcenter', TRUE);
		$this->db->select('callcontactsdetails.queuename,callcontactsdetails.callid,recordings.unique_id,recordings_and_qm.qm_id,recordings.record_id,recordings.userid,recordings.supervisor_id,recordings.status',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		$this->db->join('reportcallcenter.callcontactsdetails', 'recordings.unique_id = callcontactsdetails.callid');
		//$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		$this->db->where('recordings.status !=', 4);
		$this->db->where('recordings.status !=', 1);
		$this->db->where('recordings.status !=', 2);
		$this->db->where('recordings.status !=', 2);
		$this->db->where('recordings.tenantid', $tenant_id);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_score2($tenant_id,$search_param)
	{
		$this->db->select('rate_info.qm_id,recordings.record_id,recordings.userid,final_score,recordings.supervisor_id,MAX(final_score) AS highest_score,MIN(final_score) AS lowest_score',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info', 'recordings.record_id = rate_info.record_id');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_supervisorid'])){
			$or_where = "";
			foreach($search_param['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_userid'])){
			$or_where = "";
			foreach($search_param['search_userid'] as $userid) {
				$or_where .= "recordings.userid = '$userid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_qmid'])){
			$or_where = "";
			foreach($search_param['search_qmid'] as $qm_id) {
				$or_where .= "rate_info.qm_id = '$qm_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_uniqueid'])){
			$or_where = "";
			foreach($search_param['search_uniqueid'] as $unique_id) {
				$or_where .= "callcontactsdetails.queuename = '$unique_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		$this->db->where('rate_info_question.final_score IS NOT NULL', NULL, false);
		$this->db->group_by("rate_info_question.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_pending2($tenant_id)
	{
		$this->db->select('recordings_and_qm.qm_id,recordings.record_id,recordings.userid,recordings.supervisor_id,recordings.status',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		//$this->db->join('qm.qm_form', 'recordings_and_qm.qm_id = qm_form.qm_id');
		$this->db->where('recordings.status !=', 4);
		$this->db->where('recordings.status !=', 1);
		$this->db->where('recordings.status !=', 2);
		$this->db->where('recordings.tenantid', $tenant_id);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_score($tenant_id,$search_param)
	{
		$this->db->select('recordings.record_id,recordings.userid,final_score,recordings.supervisor_id,MAX(final_score) AS highest_score,MIN(final_score) AS lowest_score',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('qm.rate_info_question', 'recordings.record_id = rate_info_question.record_id');
		$this->db->join('qm.recordings_and_qm', 'recordings.record_id = recordings_and_qm.record_id');
		$this->db->where('rate_info_question.final_score IS NOT NULL', NULL, false);

		if (isset($search_param['search_start_date'])){
			$this->db->where('date(`recordings`.`date_complete`) >=  ', $search_param['search_start_date']);
		}

		if (isset($search_param['search_end_date'])){
			$this->db->where('date(`recordings`.`date_complete`) <=  ', $search_param['search_end_date']);
		}

		if (isset($search_param['search_supervisorid'])){
			$or_where = "";
			foreach($search_param['search_supervisorid'] as $supervisorid) {
				$or_where .= "recordings.supervisor_id = '$supervisorid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_userid'])){
			$or_where = "";
			foreach($search_param['search_userid'] as $userid) {
				$or_where .= "recordings.userid = '$userid' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_qmid'])){
			$or_where = "";
			foreach($search_param['search_qmid'] as $qm_id) {
				$or_where .= "recordings_and_qm.qm_id = '$qm_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		if (isset($search_param['search_uniqueid'])){
			$or_where = "";
			foreach($search_param['search_uniqueid'] as $unique_id) {
				$or_where .= "callcontactsdetails.queuename = '$unique_id' OR ";
			}
			$or_where2 = substr($or_where, 0, -3);
			$this->db->where($or_where2);
		}

		$this->db->group_by("rate_info_question.record_id");
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->where('recordings.status', 4);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result();
	}

	function total_pending($tenant_id)
	{
		$this->db->select('recordings.record_id,recordings.userid,recordings.supervisor_id,recordings.status',FALSE);
		$this->db->from('qm.recordings');
		$this->db->where('recordings.status !=', 4);
		$this->db->where('recordings.status !=', 1);
		$this->db->where('recordings.status !=', 2);
		$this->db->where('recordings.tenantid', $tenant_id);
		$query = $this->db->get();
		return $query->result();
	}

	function join_callcontactsdetails($tenant_id)
	{
		$this->load->database('reportcallcenter', TRUE);
		$this->db->select('callcontactsdetails.queuename,recordings.unique_id,callcontactsdetails.callid',FALSE);
		$this->db->from('qm.recordings');
		$this->db->join('reportcallcenter.callcontactsdetails', 'recordings.unique_id = callcontactsdetails.callid');
		$this->db->where('recordings.tenantid', $tenant_id);
		$this->db->group_by("callcontactsdetails.queuename");
		$query = $this->db->get();
		return $query->result();
	}
	################################  DIRECT SALE END HERE ###########################################
}
?>