<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//this controllar is proceed all the view and pagination
class Voice_logger extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->permission->is_logged_in();
		//load model
		$this->load->helper('url');
		$this->load->model('qm_model');
		$this->load->model('callcontactsdetails_model');
		$this->load->model('user_model');
		$this->load->model('sipaccount_model');
		$this->load->model('wrapup_model');
		$this->load->model('recording_model');
		$this->load->model('recqm_model');
		$this->load->database('qm', TRUE);
	}

	function index()
	{
		$data = array();
		$data['page'] = 'voice_logger';
		$tenant_id = $this->session->userdata('tenant_id');
		if($query = $this->user_model->sort_user($tenant_id)->get_all())
		{
			$data['user_record'] = $query;
		}

		if($query = $this->sipaccount_model->sort_ext($tenant_id)->get_all())
		{
			$data['ext_record'] = $query;
		}

		if($query = $this->recording_model->get_all())
		{
			$data['recording_record'] = $query;
		}

		if($query = $this->qm_model->group_by_qm_title($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		$data['main'] = 'voice_logger/index';
		$data['js_function'] = array('voice_logger');
		$this->load->view('template/template',$data);
	}

	function search_voice_logger()
	{
		$userid = $this->session->userdata('userid');
		//set the search data
		$this->load->library('searchdata');

		$this->searchdata->_set();

		$content_data = array();

		//Pagination

		$config = $this->pagination_config();

		$config['base_url'] = site_url().'/voice_logger/search_voice_logger';

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
				redirect('voice_logger/index');
				exit;
			}

		}else{
			$this->session->set_flashdata('error', 'Please select the date range before to search');
			redirect('voice_logger/index');
			exit;
		}
		################## End check date 6 months ###########################
		
		$tenant_id = $this->session->userdata('tenant_id');
		$config['total_rows'] = count($this->callcontactsdetails_model->search_list($tenant_id, $search_param, null, null)->get_all());
		$content_data['total_rows'] = count($this->callcontactsdetails_model->search_list($tenant_id, $search_param, null, null)->get_all());

		$this->pagination->initialize($config);
		// end Pagination

		if($query = $this->callcontactsdetails_model->search_list($tenant_id, $search_param, $config['per_page'], $this->uri->segment(3))->get_all())
		{
			$content_data['data_records'] = $query;
		}

		if($query = $this->user_model->sort_user($tenant_id)->get_all())
		{
			$content_data['user_record'] = $query;
		}

		if($query = $this->sipaccount_model->sort_ext($tenant_id)->get_all())
		{
			$content_data['ext_record'] = $query;
		}

		if($query = $this->qm_model->group_by_qm_title($tenant_id)->get_all())
		{
			$content_data['qm_record'] = $query;
		}

		if($recording_query = $this->recording_model->get_all())
		{
			$content_data['recording_record'] = $recording_query;
			foreach($recording_query as $recording_row){
				$recording_result = $this->callcontactsdetails_model->get_callcontactsdetails($recording_row->unique_id)->get_all();
				$content_data['recording_result'] = $recording_result;
			}
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
		
		$content_data['page'] = 'voice_logger';
		$content_data['main'] = 'voice_logger/index';
		$content_data['js_function'] = array('voice_logger');
		$this->load->view('template/template', $content_data);
	}

	function submit_form()
	{
		$callcontactsdetail_id = $this->input->post('id');
		$qm_id = $this->input->post('qm_id');
		$query_callcontactsdetail = $this->callcontactsdetails_model->get($callcontactsdetail_id);
		$unique_id = $query_callcontactsdetail->callid;
		$queuename = $query_callcontactsdetail->queuename;
		$record_filename_mp3 = $queuename."-".$unique_id.".mp3";
		$record_filename_wav = $queuename."-".$unique_id.".wav";
		$tenant_id = $this->session->userdata('tenant_id');
		## check the file is mp3 or wav ##
		$file = '/var/spool/asterisk/monitor/'.$record_filename_mp3;

		$newfile = '/var/www/html/qm/file/'.$record_filename_mp3;

		$copyfile = copy($file, $newfile);
		if($copyfile == true){
			$record_filename = $record_filename_mp3;
		}else{
			$file = '/var/spool/asterisk/monitor/'.$record_filename_wav;

			$newfile = '/var/www/html/qm/file/'.$record_filename_wav;

			$copyfile = copy($file, $newfile);
			$record_filename = $record_filename_wav;
		}

		$userid = $query_callcontactsdetail->userid;
		$supervisor_id = $this->session->userdata('userid');
		$date_created = date('Y-m-d h:i:s');
		$status = 3;
		$recording_type = 1;
		## insert recording ##
		$recording_data = array (
			'record_id'=>'',
			'record_filename'=>$record_filename,
			'userid'=>$userid,
			'unique_id'=>$unique_id,
			'supervisor_id'=>$supervisor_id,
			'date_created'=>$date_created,
			'status'=>$status,
			'recording_type'=>$recording_type,
			'others_recording'=>'',
			'recover'=>0,
			'monitoring_type'=>'',
			'tenantid'=>$tenant_id
		);

		$this->recording_model->insert($recording_data);
		$record_id = $this->db->insert_id();
		## get recording last id ##

		$data = array (
			'record_id'=>$record_id,
			'qm_id'=>$qm_id
		);

		$this->recqm_model->insert($data);

		$this->session->set_flashdata('success', 'You have successfully assign the form');

		redirect("qm/qm_form/$record_id/$userid");
	}

	function pagination_config()
	{
		$this->load->library('pagination');
		$config['per_page'] =10;
		$config['num_links'] = 5;
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