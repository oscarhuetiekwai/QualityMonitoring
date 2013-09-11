<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//this controllar is proceed all the view and pagination
class Report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->permission->is_logged_in();
		//load model
		$this->load->helper('url');
		$this->load->model('otherrecording_model');
		$this->load->model('chatrecording_model');
		$this->load->model('recording_model');
		$this->load->model('qm_model');
		$this->load->model('criteria_model');
		$this->load->model('question_model');
		$this->load->model('recqm_model');
		$this->load->model('user_model');
		$this->load->model('report_model');
		$this->load->model('callcontactsdetails_model');
		$this->load->model('qm_level_rate_model');

		$this->load->database('qm', TRUE);

		//$this->load->database('crud', TRUE);
	}

	################################ CARE LINE START HERE #########################################

	####################### start category_pass_fail_ratio #######################################
	function category_pass_fail_ratio()
	{
		$data = array();
		$data['page'] = 'category_pass_fail_ratio';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->qm_model->report_criteria($tenant_id))
		{
			$data['criteria_record'] = $query;
		}

		$data['main'] = 'report/category_pass_fail_ratio';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}

	function search_category_pass_fail_ratio()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_category_pass_fail_ratio';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################
		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/category_pass_fail_ratio');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/category_pass_fail_ratio');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_category_pass_fail_ratio($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_category_pass_fail_ratio($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_category_pass_fail_ratio($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->qm_model->report_criteria($tenant_id))
		{
			$content_data['criteria_record'] = $query;
		}

		if($query = $this->report_model->total_pass2($tenant_id,$search_param))
		{
			$content_data['total_pass'] = $query;
		}

		if($query = $this->report_model->total_fail2($tenant_id,$search_param))
		{
			$content_data['total_fail'] = $query;
		}

		if($query = $this->report_model->total_na2($tenant_id,$search_param))
		{
			$content_data['total_na'] = $query;
		}


		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_criteriaid'])){
			$content_data['criteria_id'] = $search_param['search_criteriaid'];
		}

		$content_data['page'] = 'category_pass_fail_ratio';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/category_pass_fail_ratio';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_category_pass_fail_ratio_excel()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_category_pass_fail_ratio($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_pass2($tenant_id,$search_param))
		{
			$data['total_pass'] = $query;
		}

		if($query = $this->report_model->total_fail2($tenant_id,$search_param))
		{
			$data['total_fail'] = $query;
		}

		if($query = $this->report_model->total_na2($tenant_id,$search_param))
		{
			$data['total_na'] = $query;
		}


		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		if(isset( $search_param['search_formtype'])){
			$data['formtype'] = $search_param['search_formtype'];
		}

		$this->load->view('excel/category_pass_fail_ratio_excel',$data);
	}
	####################### end category_pass_fail_ratio #######################################


	####################### start agent_performance #######################################
	function agent_performance()
	{
		$data = array();
		$data['page'] = 'agent_performance';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		$data['main'] = 'report/agent_performance';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}


	function search_agent_performance()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_agent_performance';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################

		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/agent_performance');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/agent_performance');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_agent_performance($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_agent_performance($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_agent_performance($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$content_data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$content_data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_fail($tenant_id,$search_param))
		{
			$content_data['total_fail'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_userid'])){
			$content_data['userid'] = $search_param['search_userid'];
		}
		if(isset( $search_param['search_supervisorid'])){
			$content_data['supervisor_id'] = $search_param['search_supervisorid'];
		}

		$content_data['page'] = 'agent_performance';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/agent_performance';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_agent_performance_excel()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_agent_performance($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$data['user_record'] = $query;
		}

		if($query = $this->report_model->total_fail($tenant_id,$search_param))
		{
			$data['total_fail'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		$this->load->view('excel/agent_performance_excel',$data);
	}
	####################### end agent_performance #######################################

	####################### start qm_form_pass_fail_ratio #######################################
	function qm_form_pass_fail_ratio()
	{
		$data = array();
		$data['page'] = 'qm_form_pass_fail_ratio';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		$data['main'] = 'report/qm_form_pass_fail_ratio';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}

	function search_qm_form_pass_fail_ratio()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_qm_form_pass_fail_ratio';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################

		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/qm_form_pass_fail_ratio');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/qm_form_pass_fail_ratio');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_qm_form_pass_fail_ratio($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_qm_form_pass_fail_ratio($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_qm_form_pass_fail_ratio($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$content_data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_pass($tenant_id,$search_param))
		{
			$content_data['total_pass'] = $query;
		}

		if($query = $this->report_model->total_fail($tenant_id,$search_param))
		{
			$content_data['total_fail'] = $query;
		}

		if($query = $this->report_model->total_na($tenant_id,$search_param))
		{
			$content_data['total_na'] = $query;
		}


		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_qmid'])){
			$content_data['qm_id'] = $search_param['search_qmid'];
		}

		if(isset( $search_param['search_formtype'])){
			$content_data['formtype'] = $search_param['search_formtype'];
		}

		$content_data['page'] = 'qm_form_pass_fail_ratio';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/qm_form_pass_fail_ratio';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_qm_form_pass_fail_ratio_excel()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_qm_form_pass_fail_ratio($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_pass($tenant_id,$search_param))
		{
			$data['total_pass'] = $query;
		}

		if($query = $this->report_model->total_fail($tenant_id,$search_param))
		{
			$data['total_fail'] = $query;
		}

		if($query = $this->report_model->total_na($tenant_id,$search_param))
		{
			$data['total_na'] = $query;
		}

		if($query = $this->report_model->total_pending2($tenant_id))
		{
			$data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		if(isset( $search_param['search_formtype'])){
			$data['formtype'] = $search_param['search_formtype'];
		}

		$this->load->view('excel/qm_form_pass_fail_ratio_excel',$data);
	}
	####################### end qm_form_pass_fail_ratio #######################################

	####################### start qm_report_by_department #######################################
	function qm_report_by_department_datacom()
	{
		$data = array();
		$data['page'] = 'qm_report_by_department_datacom';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		$data['main'] = 'report/qm_report_by_department_datacom';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}

	function search_qm_report_by_department_datacom()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_qm_report_by_department_datacom';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################
		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/qm_report_by_department_datacom');
				exit;
			}
		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/qm_report_by_department_datacom');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_qm_report_by_department_datacom($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_qm_report_by_department_datacom($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_qm_report_by_department_datacom($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$content_data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_cb_score($tenant_id,$search_param))
		{
			$content_data['total_cb_score'] = $query;
		}

		if($query = $this->report_model->total_cc_score($tenant_id,$search_param))
		{
			$content_data['total_cc_score'] = $query;
		}

		if($query = $this->report_model->total_nc_score($tenant_id,$search_param))
		{
			$content_data['total_nc_score'] = $query;
		}

		if($query = $this->report_model->total_defect($tenant_id,$search_param))
		{
			$content_data['total_defect_score'] = $query;
		}

		if($query = $this->report_model->total_pending2($tenant_id))
		{
			$content_data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_qmid'])){
			$content_data['qm_id'] = $search_param['search_qmid'];
		}

		$content_data['page'] = 'qm_report_by_department_datacom';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/qm_report_by_department_datacom';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_qm_report_by_department_excel_datacom()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_qm_report_by_department_datacom($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_cb_score($tenant_id,$search_param))
		{
			$data['total_cb_score'] = $query;
		}

		if($query = $this->report_model->total_cc_score($tenant_id,$search_param))
		{
			$data['total_cc_score'] = $query;
		}

		if($query = $this->report_model->total_nc_score($tenant_id,$search_param))
		{
			$data['total_nc_score'] = $query;
		}

		if($query = $this->report_model->total_defect($tenant_id,$search_param))
		{
			$data['total_defect_score'] = $query;
		}

		if($query = $this->report_model->total_pending2($tenant_id))
		{
			$data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		$this->load->view('excel/qm_report_by_department_excel_datacom',$data);
	}
	####################### end qm_report_by_department #######################################

	####################### start qm_report_by_campaign #######################################
	function qm_report_by_campaign_datacom()
	{
		$data = array();
		$data['page'] = 'qm_report_by_campaign_datacom';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->report_model->join_callcontactsdetails($tenant_id))
		{
			$data['campaign_record'] = $query;
		}

		$data['main'] = 'report/qm_report_by_campaign_datacom';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}

	function search_qm_report_by_campaign_datacom()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_qm_report_by_campaign_datacom';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################

		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/qm_report_by_campaign_datacom');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/qm_report_by_campaign_datacom');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_qm_report_by_campaign_datacom($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_qm_report_by_campaign_datacom($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_qm_report_by_campaign_datacom($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$content_data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_cb_score2($tenant_id,$search_param))
		{
			$content_data['total_cb_score'] = $query;

		}

		if($query = $this->report_model->total_cc_score2($tenant_id,$search_param))
		{
			$content_data['total_cc_score'] = $query;
		}

		if($query = $this->report_model->total_nc_score2($tenant_id,$search_param))
		{
			$content_data['total_nc_score'] = $query;
		}

		if($query = $this->report_model->total_pending3($tenant_id))
		{
			$content_data['total_pending'] = $query;
		}

		if($query = $this->report_model->join_callcontactsdetails($tenant_id))
		{
			$content_data['campaign_record'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_uniqueid'])){
			$content_data['unique_id'] = $search_param['search_uniqueid'];
		}

		$content_data['page'] = 'qm_report_by_campaign_datacom';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/qm_report_by_campaign_datacom';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_qm_report_by_campaign_excel_datacom()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_qm_report_by_campaign_datacom($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_cb_score2($tenant_id,$search_param))
		{
			$data['total_cb_score'] = $query;
		}

		if($query = $this->report_model->total_cc_score2($tenant_id,$search_param))
		{
			$data['total_cc_score'] = $query;
		}

		if($query = $this->report_model->total_nc_score2($tenant_id,$search_param))
		{
			$data['total_nc_score'] = $query;
		}

		if($query = $this->report_model->total_pending3($tenant_id))
		{
			$data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		$this->load->view('excel/qm_report_by_campaign_excel_datacom',$data);
	}
	####################### end qm_report_by_campaign #######################################

	####################### start qm_report_by_qa #######################################
	function qm_report_by_qa_datacom()
	{
		$data = array();
		$data['page'] = 'qm_report_by_qa_datacom';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		$data['main'] = 'report/qm_report_by_qa_datacom';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}


	function search_qm_report_by_qa_datacom()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_qm_report_by_qa_datacom';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################

		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/qm_report_by_qa_datacom');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/qm_report_by_qa_datacom');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_qm_report_by_qa_datacom($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_qm_report_by_qa_datacom($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_qm_report_by_qa_datacom($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$content_data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$content_data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_cb_score($tenant_id,$search_param))
		{
			$content_data['total_cb_score'] = $query;
		}

		if($query = $this->report_model->total_cc_score($tenant_id,$search_param))
		{
			$content_data['total_cc_score'] = $query;
		}

		if($query = $this->report_model->total_nc_score($tenant_id,$search_param))
		{
			$content_data['total_nc_score'] = $query;
		}

		if($query = $this->report_model->total_pending($tenant_id))
		{
			$content_data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_userid'])){
			$content_data['userid'] = $search_param['search_userid'];
		}
		if(isset( $search_param['search_supervisorid'])){
			$content_data['supervisor_id'] = $search_param['search_supervisorid'];
		}

		$content_data['page'] = 'qm_report_by_qa_datacom';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/qm_report_by_qa_datacom';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_qm_report_by_qa_excel_datacom()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_qm_report_by_qa_datacom($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_cb_score($tenant_id,$search_param))
		{
			$data['total_cb_score'] = $query;
		}

		if($query = $this->report_model->total_cc_score($tenant_id,$search_param))
		{
			$data['total_cc_score'] = $query;
		}

		if($query = $this->report_model->total_nc_score($tenant_id,$search_param))
		{
			$data['total_nc_score'] = $query;
		}

		if($query = $this->report_model->total_pending($tenant_id))
		{
			$data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		$this->load->view('excel/qm_report_by_qa_excel_datacom',$data);
	}
	####################### end qm_report_by_qa #######################################

	####################### start qm_report_by_section #######################################
	function qm_report_by_section_datacom()
	{
		$data = array();
		$data['page'] = 'qm_report_by_section_datacom';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		$data['main'] = 'report/qm_report_by_section_datacom';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}

	function search_qm_report_by_section_datacom()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_qm_report_by_section_datacom';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################

		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/qm_report_by_section_datacom');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/qm_report_by_section_datacom');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_qm_report_by_section_datacom($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_qm_report_by_section_datacom($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_qm_report_by_section_datacom($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$content_data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_cb_score($tenant_id,$search_param))
		{
			$content_data['total_cb_score'] = $query;
		}

		if($query = $this->report_model->total_cc_score($tenant_id,$search_param))
		{
			$content_data['total_cc_score'] = $query;
		}

		if($query = $this->report_model->total_nc_score($tenant_id,$search_param))
		{
			$content_data['total_nc_score'] = $query;
		}

		if($query = $this->report_model->total_pending2($tenant_id))
		{
			$content_data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_qmid'])){
			$content_data['qm_id'] = $search_param['search_qmid'];
		}

		$content_data['page'] = 'qm_report_by_section_datacom';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/qm_report_by_section_datacom';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_qm_report_by_section_excel_datacom()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_qm_report_by_section_datacom($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_cb_score($tenant_id,$search_param))
		{
			$data['total_cb_score'] = $query;
		}

		if($query = $this->report_model->total_cc_score($tenant_id,$search_param))
		{
			$data['total_cc_score'] = $query;
		}

		if($query = $this->report_model->total_nc_score($tenant_id,$search_param))
		{
			$data['total_nc_score'] = $query;
		}

		if($query = $this->report_model->total_pending2($tenant_id))
		{
			$data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		$this->load->view('excel/qm_report_by_section_excel_datacom',$data);
	}
	####################### end qm_report_by_section #######################################

	####################### start qm_report_by_agent #######################################
	function qm_report_by_agent_datacom()
	{
		$data = array();
		$data['page'] = 'qm_report_by_agent_datacom';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		$data['main'] = 'report/qm_report_by_agent_datacom';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}


	function search_qm_report_by_agent_datacom()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_qm_report_by_agent_datacom';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################

		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/qm_report_by_agent_datacom');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/qm_report_by_agent_datacom');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_qm_report_by_agent_datacom($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_qm_report_by_agent_datacom($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_qm_report_by_agent_datacom($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$content_data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$content_data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_cb_score($tenant_id,$search_param))
		{
			$content_data['total_cb_score'] = $query;
		}

		if($query = $this->report_model->total_cc_score($tenant_id,$search_param))
		{
			$content_data['total_cc_score'] = $query;
		}

		if($query = $this->report_model->total_nc_score($tenant_id,$search_param))
		{
			$content_data['total_nc_score'] = $query;
		}

		if($query = $this->report_model->total_pending($tenant_id))
		{
			$content_data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_userid'])){
			$content_data['userid'] = $search_param['search_userid'];
		}
		if(isset( $search_param['search_supervisorid'])){
			$content_data['supervisor_id'] = $search_param['search_supervisorid'];
		}

		$content_data['page'] = 'qm_report_by_agent_datacom';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/qm_report_by_agent_datacom';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_qm_report_by_agent_excel_datacom()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_qm_report_by_agent_datacom($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_cb_score($tenant_id,$search_param))
		{
			$data['total_cb_score'] = $query;
		}

		if($query = $this->report_model->total_cc_score($tenant_id,$search_param))
		{
			$data['total_cc_score'] = $query;
		}

		if($query = $this->report_model->total_nc_score($tenant_id,$search_param))
		{
			$data['total_nc_score'] = $query;
		}


		if($query = $this->report_model->total_pending($tenant_id))
		{
			$data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		$this->load->view('excel/qm_report_by_agent_excel_datacom',$data);
	}
	####################### end qm_report_by_agent #######################################

	####################### start agent Score #######################################
	function agent_score_datacom()
	{
		$data = array();
		$data['page'] = 'agent_score_datacom';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		$data['main'] = 'report/agent_score_datacom';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}

	function search_agent_score_datacom()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_agent_score_datacom';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################

		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/agent_score_datacom');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/agent_score_datacom');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_agent_score_datacom($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_agent_score_datacom($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_agent_score_datacom($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$content_data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$content_data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_pending($tenant_id))
		{
			$content_data['total_pending'] = $query;
		}

		if($query = $this->callcontactsdetails_model->report_callcontactsdetails())
		{
			$content_data['callcontactsdetails'] = $query;
		}

		if($qm_level_rate_query = $this->qm_level_rate_model->sort_level()->get_all())
		{
			$content_data['qm_level_rate_record'] = $qm_level_rate_query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_userid'])){
			$content_data['userid'] = $search_param['search_userid'];
		}
		if(isset( $search_param['search_supervisorid'])){
			$content_data['supervisor_id'] = $search_param['search_supervisorid'];
		}

		$content_data['page'] = 'agent_score_datacom';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/agent_score_datacom';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_agent_score_excel_datacom()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_pending($tenant_id))
		{
			$data['total_pending'] = $query;
		}

		if($query = $this->callcontactsdetails_model->report_callcontactsdetails())
		{
			$data['callcontactsdetails'] = $query;
		}

		if($qm_level_rate_query = $this->qm_level_rate_model->sort_level()->get_all())
		{
			$data['qm_level_rate_record'] = $qm_level_rate_query;
		}

		if($query = $this->report_model->search_agent_score($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}


		$this->load->view('excel/agent_score_excel_datacom',$data);
	}
	####################### end agent Score #######################################

	############ start overall_summary_for_department ############
	function overall_summary_for_department()
	{
		$data = array();
		$data['page'] = 'overall_summary_for_department';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$data['user_record'] = $query;
		}

		$data['main'] = 'report/overall_summary_for_department';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}

	function search_overall_summary_for_department()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_overall_summary_for_department';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		$config['total_rows'] = count($this->report_model->search_overall_summary_for_department($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_overall_summary_for_department($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query_report = $this->report_model->search_overall_summary_for_department($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query_report;
		}

		if($query_count_question = $this->report_model->count_cb_question($tenant_id))
		{
			$content_data['count_records'] = $query_count_question;
		}

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$content_data['user_record'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		$content_data['page'] = 'overall_summary_for_department';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/overall_summary_for_department';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_overall_summary_for_department_excel()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_overall_summary_for_department($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		$this->load->view('excel/overall_summary_for_department_excel',$data);
	}
	############ end overall_summary_for_department ############



	#################################################### CARE LINE END HERE #############################################################


	#################################################### DIRECT SALE START HERE #############################################################

	####################### start qm_report_by_campaign #######################################
	function qm_report_by_campaign()
	{
		$data = array();
		$data['page'] = 'qm_report_by_campaign';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->report_model->join_callcontactsdetails($tenant_id))
		{
			$data['campaign_record'] = $query;
		}

		$data['main'] = 'report/qm_report_by_campaign';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}

	function search_qm_report_by_campaign()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_qm_report_by_campaign';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################

		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/qm_report_by_campaign');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/qm_report_by_campaign');
			exit;
		}

		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_qm_report_by_campaign($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_qm_report_by_campaign($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_qm_report_by_campaign($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$content_data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_score3($tenant_id,$search_param))
		{
			$content_data['total_record'] = $query;
		}

		if($query = $this->report_model->total_pending3($tenant_id))
		{
			$content_data['total_pending'] = $query;
		}

		if($query = $this->report_model->join_callcontactsdetails($tenant_id))
		{
			$content_data['campaign_record'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_uniqueid'])){
			$content_data['unique_id'] = $search_param['search_uniqueid'];
		}

		$content_data['page'] = 'qm_report_by_campaign';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/qm_report_by_campaign';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_qm_report_by_campaign_excel()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_qm_report_by_campaign($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_score3($tenant_id,$search_param))
		{
			$data['total_record'] = $query;
		}

		if($query = $this->report_model->total_pending3($tenant_id))
		{
			$data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		$this->load->view('excel/qm_report_by_campaign_excel',$data);
	}
	####################### end qm_report_by_campaign #######################################

	####################### start qm_report_by_section #######################################
	function qm_report_by_section()
	{
		$data = array();
		$data['page'] = 'qm_report_by_section';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		$data['main'] = 'report/qm_report_by_section';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}

	function search_qm_report_by_section()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_qm_report_by_section';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################

		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/search_qm_report_by_section');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/search_qm_report_by_section');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_qm_report_by_section($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_qm_report_by_section($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_qm_report_by_section($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$content_data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_score2($tenant_id,$search_param))
		{
			$content_data['total_record'] = $query;
		}

		if($query = $this->report_model->total_pending2($tenant_id))
		{
			$content_data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_qmid'])){
			$content_data['qm_id'] = $search_param['search_qmid'];
		}

		$content_data['page'] = 'qm_report_by_section';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/qm_report_by_section';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_qm_report_by_section_excel()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_qm_report_by_section($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		if($query = $this->report_model->total_score2($tenant_id,$search_param))
		{
			$data['total_record'] = $query;
		}

		if($query = $this->report_model->total_pending2($tenant_id))
		{
			$data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		$this->load->view('excel/qm_report_by_section_excel',$data);
	}
	####################### end qm_report_by_section #######################################

	####################### start qm_report_by_qa #######################################
	function qm_report_by_qa()
	{
		$data = array();
		$data['page'] = 'qm_report_by_qa';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		$data['main'] = 'report/qm_report_by_qa';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}


	function search_qm_report_by_qa()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_qm_report_by_qa';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################

		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/qm_report_by_qa');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/qm_report_by_qa');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_qm_report_by_qa($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_qm_report_by_qa($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_qm_report_by_qa($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$content_data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$content_data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_score($tenant_id,$search_param))
		{
			$content_data['total_record'] = $query;
		}

		if($query = $this->report_model->total_pending($tenant_id))
		{
			$content_data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_userid'])){
			$content_data['userid'] = $search_param['search_userid'];
		}
		if(isset( $search_param['search_supervisorid'])){
			$content_data['supervisor_id'] = $search_param['search_supervisorid'];
		}

		$content_data['page'] = 'qm_report_by_qa';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/qm_report_by_qa';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_qm_report_by_qa_excel()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_qm_report_by_qa($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_score($tenant_id,$search_param))
		{
			$data['total_record'] = $query;
		}

		if($query = $this->report_model->total_pending($tenant_id))
		{
			$data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		$this->load->view('excel/qm_report_by_qa_excel',$data);
	}
	####################### end qm_report_by_qa #######################################

	####################### start qm_report_by_agent #######################################
	function qm_report_by_agent()
	{
		$data = array();
		$data['page'] = 'qm_report_by_agent';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		$data['main'] = 'report/qm_report_by_agent';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}


	function search_qm_report_by_agent()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_qm_report_by_agent';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################

		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/qm_report_by_agent');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/qm_report_by_agent');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_qm_report_by_agent($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_qm_report_by_agent($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_qm_report_by_agent($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$content_data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$content_data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_score($tenant_id,$search_param))
		{
			$content_data['total_record'] = $query;
		}

		if($query = $this->report_model->total_pending($tenant_id))
		{
			$content_data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_userid'])){
			$content_data['userid'] = $search_param['search_userid'];
		}
		if(isset( $search_param['search_supervisorid'])){
			$content_data['supervisor_id'] = $search_param['search_supervisorid'];
		}

		$content_data['page'] = 'qm_report_by_agent';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/qm_report_by_agent';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_qm_report_by_agent_excel()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->report_model->search_qm_report_by_agent($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_score($tenant_id,$search_param))
		{
			$data['total_record'] = $query;
		}

		if($query = $this->report_model->total_pending($tenant_id))
		{
			$data['total_pending'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}

		$this->load->view('excel/qm_report_by_agent_excel',$data);
	}
	####################### end qm_report_by_agent #######################################

	####################### start agent Score #######################################
	function agent_score()
	{
		$data = array();
		$data['page'] = 'agent_score';
		$data['report'] = 'report';
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d');

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		$data['main'] = 'report/agent_score';
		$data['js_function'] = array('report');
		$this->load->view('template/template',$data);
	}

	function search_agent_score()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/report/search_agent_score';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		################## Start check date 6 months ###########################

		if(!empty($search_param['search_start_date']) && !empty($search_param['search_end_date'])){

			$date1 = DateTime::createFromFormat('Y-m-d', $search_param['search_start_date']);
			$date2 = DateTime::createFromFormat('Y-m-d', $search_param['search_end_date']);

			$interval = $date1->diff($date2);
			$diff = $interval->format('%m');

			if($diff > 6){
				$this->session->set_flashdata('error', 'Error, Your start date and end date unable more than 6 months.');
				redirect('report/agent_score');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('report/agent_score');
			exit;
		}
		################## End check date 6 months ###########################

		$config['total_rows'] = count($this->report_model->search_agent_score($tenant_id,$userid, $search_param, null, null));
		$content_data['total_rows'] = count($this->report_model->search_agent_score($tenant_id,$userid, $search_param, null, null));

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->report_model->search_agent_score($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3)))
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$content_data['user_record'] = $query;
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$content_data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_pending($tenant_id))
		{
			$content_data['total_pending'] = $query;
		}

		if($query = $this->callcontactsdetails_model->report_callcontactsdetails())
		{
			$content_data['callcontactsdetails'] = $query;
		}

		if(isset( $search_param['search_start_date'])){
			$content_data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$content_data['end_date'] = $search_param['search_end_date'];
		}
		if(isset( $search_param['search_userid'])){
			$content_data['userid'] = $search_param['search_userid'];
		}
		if(isset( $search_param['search_supervisorid'])){
			$content_data['supervisor_id'] = $search_param['search_supervisorid'];
		}

		$content_data['page'] = 'agent_score';
		$content_data['report'] = 'report';
		$content_data['main'] = 'report/agent_score';
		$content_data['js_function'] = array('report');
		$this->load->view('template/template', $content_data);
	}

	function search_agent_score_excel()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');

		$this->load->library('searchdata');

		//set the search data

		$this->searchdata->_set();

		$data = array();

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		if($query = $this->user_model->sort_qa($tenant_id)->get_all())
		{
			$data['qa_record'] = $query;
		}

		if($query = $this->report_model->total_pending($tenant_id))
		{
			$data['total_pending'] = $query;
		}

		if($query = $this->report_model->search_agent_score($tenant_id,$userid, $search_param, null, null))
		{
			$data['data_records'] = $query;
		}
		else
		{
			$data['data_records'] = array();
		}

		if(isset( $search_param['search_start_date'])){
			$data['start_date'] = $search_param['search_start_date'];
		}
		if(isset( $search_param['search_end_date'])){
			$data['end_date'] = $search_param['search_end_date'];
		}


		$this->load->view('excel/agent_score_excel',$data);
	}
	####################### end agent Score #######################################

	################################  DIRECT SALE END HERE ###########################################

	## PAGINATION ##
	function pagination_config()
	{
		$this->load->library('pagination');
		$config['per_page'] =10;
		$config['num_links'] = 2;
		$config['first_link'] = false;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['last_link'] = false;
		$config['full_tag_open'] = '<div class="pagination pagination-centered"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>;';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		return $config;

	}
}//end of class
?>