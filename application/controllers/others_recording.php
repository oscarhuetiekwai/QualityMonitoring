<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//this controllar is proceed all the view and pagination
class Others_recording extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->permission->is_logged_in();
		//load model
		$this->load->helper('url');
		$this->load->model('otherrecording_model');
		$this->load->model('recording_model');
		$this->load->model('qm_model');
		$this->load->model('criteria_model');
		$this->load->model('question_model');
		$this->load->model('recqm_model');
		$this->load->model('user_model');
		$this->load->database('qm', TRUE);

		//$this->load->database('crud', TRUE);
	}

	function index()
	{
		$data = array();
		$data['page'] = 'others_recordings';
		$userid = $this->session->userdata('userid');
		$datetime = date('Y-m-d');
		// get this week range
		$date = $this->x_week_range($datetime);
		// get this week date
		$one_week_date = $this->createDateRangeArray($date[0],$date[1]);
		//var_dump($one_week_date);
		$data['current_week'] = $one_week_date;


		$data['main'] = 'recording/others_index';
		$data['js_function'] = array('other_recording');
		$this->load->view('template/template',$data);
	}

	function assign_form_agent()
	{
		$data = array();
		$data['page'] = 'assign_form_agent';
		$userid = $this->session->userdata('userid');
		$record_id = $this->uri->segment(3);
		$data['record_id'] = $record_id;
		$datetime = date('Y-m-d');
		$tenant_id = $this->session->userdata('tenant_id');
		if($query2 = $this->user_model->sort_by_supervisor($tenant_id,$userid)->get_all())
		{
			$data['user_record'] = $query2;
		}

		if($query = $this->qm_model->group_by_qm_title($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		$data['main'] = 'recording/assign_form_agent';
		$data['js_function'] = array('other_recording');
		$this->load->view('template/template',$data);
	}


	function submit_form()
	{
		//$record_id = $this->input->post('record_id');
		$qm_id = $this->input->post('qm_id');
		$userid = $this->input->post('userid');
		$supervisor_id = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$datetime = date('Y-m-d h:i:s');

		$recording_data = array (
			'record_id'=>'',
			'record_filename'=>'',
			'userid'=>$userid,
			'unique_id'=>'',
			'supervisor_id'=>$supervisor_id,
			'date_created'=>$datetime,
			'status'=>'3',
			'recording_type'=>'3',
			'others_recording'=>'',
			'tenantid'=>$tenant_id
		);

		$this->otherrecording_model->insert($recording_data);
		$record_id = $this->db->insert_id();

		$data = array (
			'record_id'=>$record_id,
			'qm_id'=>$qm_id,
		);

		$this->recqm_model->insert($data);

		$this->session->set_flashdata('success', 'You have successfully assign the form');

		redirect("qm/qm_form/$record_id/$userid");
	}


	function search_recording()
	{
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/others_recording/search_recording';

		$search_param = array();

		foreach($this->session->userdata('search') as $key => $value)
		{
			$search_param = $search_param + array($key=>$value);
		}

		$config['total_rows'] = count($this->otherrecording_model->search_list($tenant_id,$userid, $search_param, null, null)->get_all());
		$content_data['total_rows'] = count($this->otherrecording_model->search_list($tenant_id,$userid, $search_param, null, null)->get_all());

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->otherrecording_model->search_list($tenant_id,$userid, $search_param, $config['per_page'], $this->uri->segment(3))->get_all())
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->otherrecording_model->get_agent($tenant_id, $userid)->get_all())
		{
			$content_data['get_agent_records'] = $query;
		}
		$content_data['page'] = 'others_recordings2';
		$content_data['main'] = 'recording/others_index';
		$content_data['js_function'] = array('other_recording');
		$this->load->view('template/template', $content_data);
	}


	function x_week_range($date) {
		$ts = strtotime($date);
		$start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
		return array(date('Y-m-d', $start),
					 date('Y-m-d', strtotime('next saturday', $start)));
	}

	function createDateRangeArray($strDateFrom,$strDateTo)
	{
		// takes two dates formatted as YYYY-MM-DD and creates an
		// inclusive array of the dates between the from and to dates.

		// could test validity of dates here but I'm already doing
		// that in the main script

		$aryRange=array();

		$iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
		$iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

		if ($iDateTo>=$iDateFrom)
		{
			array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
			while ($iDateFrom<$iDateTo)
			{
				$iDateFrom+=86400; // add 24 hours
				array_push($aryRange,date('Y-m-d',$iDateFrom));
			}
		}
		return $aryRange;
	}

	function pagination_config()
	{
		$this->load->library('pagination');
		$config['per_page'] =100;
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