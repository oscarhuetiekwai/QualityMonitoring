<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//this controllar is proceed all the view and pagination
class Distribution extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->permission->is_logged_in();
		//load model
		$this->load->helper('url');
		$this->load->model('criteria_model');
		$this->load->model('question_model');
		$this->load->model('qm_model');
		$this->load->model('user_model');

		$this->load->model('distribution_model');
		$this->load->model('distributionhrfreq_model');
		$this->load->model('distributionqueue_model');
		$this->load->model('distributionwrapup_model');
		$this->load->model('distributionagent_model');

		$DB1 = $this->load->database('qm', TRUE);
		//$DB2 = $this->load->database('reportcallcenter', TRUE);
	}


	function index()
	{
		$data = array();
		$data['page'] = 'distribution';
		$tenant_id = $this->session->userdata('tenant_id');
		if($query = $this->distribution_model->get_all_distribution($tenant_id)->get_all())
		{
			$data['data_record'] = $query;
		}
		if($query2 = $this->user_model->get_agent()->get_all())
		{
			$data['user_record'] = $query2;
		}

		if($get_agent_record_query = $this->distributionagent_model->get_all_agent())
		{
			$data['get_agent_record'] = $get_agent_record_query;
		}

		/* if($agent_record_query = $this->distributionagent_model->get_dist($dist_id)->get_all())
		{
			$data['agent_record'] = $agent_record_query;
		} */
		$data['main'] = 'distribution/index';
		$data['js_function'] = array('distribution');
		$this->load->view('template/template',$data);
	}

	function assign_agent()
	{
		$data = array();
		$data['page'] = 'distribution';
		$dist_id = $this->uri->segment(3);
		$tenant_id = $this->session->userdata('tenant_id');
		if($query = $this->distribution_model->get_all_distribution($tenant_id)->get_all())
		{
			$data['data_record'] = $query;
		}
		if($query2 = $this->user_model->get_agent()->get_all())
		{
			$data['user_record'] = $query2;
		}

		if($get_agent_record_query = $this->distributionagent_model->get_all_agent())
		{
			$data['get_agent_record'] = $get_agent_record_query;
		}

		if($agent_record_query = $this->distributionagent_model->get_dist($dist_id)->get_all())
		{
			$data['agent_record'] = $agent_record_query;
		}

		$data['main'] = 'distribution/assign_agent';
		$data['js_function'] = array('distribution');
		$data['dist_id'] = $dist_id;
		$this->load->view('template/template',$data);
	}

	function submit_hr_freq()
	{
		$data = array();
		$starttime = $this->input->post('starttime');
		$endtime = $this->input->post('endtime');
		$frequency = $this->input->post('frequency');
		$distid = $this->input->post('distid');

		$profile_name1 = $this->input->post('profile_name1');
		$profile_description1 = $this->input->post('profile_description1');

		if(!empty($profile_name1) && !empty($profile_description1)){

			$this->distribution_model->update($distid, array('profile'=>$profile_name1,'profile_description'=>$profile_description1));
		}

		$starttime2 = date('H:i:s', strtotime($starttime));

		$endtime2 = 	date('H:i:s', strtotime($endtime));
		//$distid = $this->db->insert_id();

		$data = array(
			'distid'=>$distid,
			'starttime'=>$starttime2,
			'endtime'=>$endtime2,
			'freq'=>$frequency
		);

		$this->distributionhrfreq_model->insert($data);

		//$msg = site_url("distribution/add_distribution/$distid");
		redirect("distribution/add_distribution/$distid#hr");
	}

	function submit_hr_freq_edit()
	{
		$data = array();
		$starttime = $this->input->post('starttime');
		$endtime = $this->input->post('endtime');
		$frequency = $this->input->post('frequency');
		$distid = $this->input->post('distid');

		$profile_name1 = $this->input->post('profile_name1');
		$profile_description1 = $this->input->post('profile_description1');

		if(!empty($profile_name1) && !empty($profile_description1)){

			$this->distribution_model->update($distid, array('profile'=>$profile_name1,'profile_description'=>$profile_description1));
		}

		$starttime2 = date('H:i:s', strtotime($starttime));

		$endtime2 = 	date('H:i:s', strtotime($endtime));
		//$distid = $this->db->insert_id();

		$data = array(
			'distid'=>$distid,
			'starttime'=>$starttime2,
			'endtime'=>$endtime2,
			'freq'=>$frequency
		);

		$this->distributionhrfreq_model->insert($data);

		//$msg = site_url("distribution/add_distribution/$distid");
		redirect("distribution/edit_distribution/$distid#hr");
	}

	function submit_id()
	{
		$tenant_id = $this->session->userdata('tenant_id');
		$data = array(
			'distid'=>'',
			'profile'=>'',
			'profile_description'=>'',
			'datecreated'=>'',
			'tenantid'=>$tenant_id
		);
		$this->distribution_model->insert($data);
		$last_id = $this->db->insert_id();

		$msg = $last_id;
		echo json_encode($msg);
	}

	function submit_queues()
	{
		$data = array();
		$distid = $this->input->post('distid');
		$profile_name2 = $this->input->post('profile_name2');
		$profile_description2 = $this->input->post('profile_description2');

		if(!empty($profile_name2) && !empty($profile_description2)){
			$this->distribution_model->update($distid, array('profile'=>$profile_name2,'profile_description'=>$profile_description2));
		}
		$this->distributionqueue_model->delete_by( array('distid'=>$distid));
		foreach($this->input->post('check_queue') as $queue_row)
		{
			$data = array(
				'dqid'=>'',
				'distid'=>$distid,
				'tenantqueueid'=>$queue_row
			);
			$this->distributionqueue_model->insert($data);
		}
		redirect("distribution/add_distribution/$distid#queues");
	}

	function submit_queues_edit()
	{
		$data = array();
		$distid = $this->input->post('distid');
		$profile_name2 = $this->input->post('profile_name2');
		$profile_description2 = $this->input->post('profile_description2');

		if(!empty($profile_name2) && !empty($profile_description2)){
			$this->distribution_model->update($distid, array('profile'=>$profile_name2,'profile_description'=>$profile_description2));
		}
		$this->distributionqueue_model->delete_by( array('distid'=>$distid));
		foreach($this->input->post('check_queue') as $queue_row)
		{
			$data = array(
				'dqid'=>'',
				'distid'=>$distid,
				'tenantqueueid'=>$queue_row
			);
			$this->distributionqueue_model->insert($data);
		}
		redirect("distribution/edit_distribution/$distid#queues");
	}

	function submit_wrapup_edit()
	{
		$data = array();
		$distid = $this->input->post('distid');
		$profile_name3 = $this->input->post('profile_name3');
		$profile_description3 = $this->input->post('profile_description3');
		if(!empty($profile_name3) && !empty($profile_description3)){
			$this->distribution_model->update($distid, array('profile'=>$profile_name3,'profile_description'=>$profile_description3));
		}
		$this->distributionwrapup_model->delete_by( array('distid'=>$distid));
		foreach($this->input->post('check_wrapup') as $queue_row)
		{
			$data = array(
				'dwid'=>'',
				'distid'=>$distid,
				'wrapupid'=>$queue_row
			);
			$this->distributionwrapup_model->insert($data);
		}
		redirect("distribution/edit_distribution/$distid#wrapup");
	}

	function submit_wrapup()
	{
		$data = array();
		$distid = $this->input->post('distid');
		$profile_name3 = $this->input->post('profile_name3');
		$profile_description3 = $this->input->post('profile_description3');
		if(!empty($profile_name3) && !empty($profile_description3)){
			$this->distribution_model->update($distid, array('profile'=>$profile_name3,'profile_description'=>$profile_description3));
		}
		$this->distributionwrapup_model->delete_by( array('distid'=>$distid));
		foreach($this->input->post('check_wrapup') as $queue_row)
		{
			$data = array(
				'dwid'=>'',
				'distid'=>$distid,
				'wrapupid'=>$queue_row
			);
			$this->distributionwrapup_model->insert($data);
		}
		redirect("distribution/add_distribution/$distid#wrapup");
	}

	function submit_assign_agent()
	{
		$data = array();
		$distid = $this->input->post('distid');
		$profile_name4 = $this->input->post('profile_name4');
		$profile_description4 = $this->input->post('profile_description4');
		if(!empty($profile_name4) && !empty($profile_description4)){
			$this->distribution_model->update($distid, array('profile'=>$profile_name4,'profile_description'=>$profile_description4));
		}
		$this->distributionagent_model->delete_by( array('distid'=>$distid));
		foreach($this->input->post('check_agent') as $queue_row)
		{
			$data = array(
				'distid'=>$distid,
				'userid'=>$queue_row
			);
			$this->distributionagent_model->insert($data);
		}
		redirect("distribution/add_distribution/$distid");
	}

	function submit_assign_agent2()
	{
		$data = array();
		$distid = $this->input->post('distid');


		$this->distributionagent_model->delete_by( array('distid'=>$distid));
		foreach($this->input->post('check_agent') as $queue_row)
		{
			$data = array(
				'distid'=>$distid,
				'userid'=>$queue_row
			);
			$this->distributionagent_model->insert($data);
		}
		redirect("distribution/index");
	}


	function add_distribution()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('profile_name', 'Profile Name', 'required|trim');
		$this->form_validation->set_rules('profile_description', 'Profile Description', 'required|trim');

		$this->form_validation->set_message('is_unique', 'The %s already exist.');
		$tenant_id = $this->session->userdata('tenant_id');
		if ($this->form_validation->run() === TRUE)
		{
			$profile_name = $this->input->post('profile_name');
			$profile_description = $this->input->post('profile_description');
			$distid = $this->input->post('distid');
			$current_datetime =  date("Y-m-d H:i:s");
			$data = array();
			$data = array(
				'profile'=>$profile_name,
				'profile_description'=>$profile_description,
				'datecreated'=>$current_datetime,
				'active'=>1
			);
			if ($this->distribution_model->update($distid, $data))
			{
				$this->session->set_flashdata('success', 'Your profile have been successfully added');
				redirect('distribution/index');
			}
			else
			{
				$this->session->set_flashdata('error', 'Error. Please try again.');
				redirect('distribution/index');
			}

		}
		else
		{
			$data = array();
			$data['page'] = 'add_distribution';
			$dist_id = $this->uri->segment(3);
			if($query = $this->distribution_model->get($dist_id))
			{
				$data['data_record'] = $query;
			}



			if($get_queue_record_query = $this->distributionqueue_model->get_all_queue($tenant_id))
			{
				$data['get_queue_record'] = $get_queue_record_query;
			}

			if($get_wrapup_record_query = $this->distributionwrapup_model->get_all_wrapup($tenant_id))
			{
				$data['get_wrapup_record'] = $get_wrapup_record_query;
			}


			if($hour_freq_record_query = $this->distributionhrfreq_model->get_dist($dist_id)->get_all())
			{
				$data['hour_freq_record'] = $hour_freq_record_query;
			}

			if($queue_record_query = $this->distributionqueue_model->get_dist($dist_id)->get_all())
			{
				$data['queue_record'] = $queue_record_query;
			}

			if($wrapup_record_query = $this->distributionwrapup_model->get_dist($dist_id)->get_all())
			{
				$data['wrapup_record'] = $wrapup_record_query;
			}

			if($get_agent_record_query = $this->distributionagent_model->get_all_agent())
			{
				$data['get_agent_record'] = $get_agent_record_query;
			}

			if($agent_record_query = $this->distributionagent_model->get_dist($dist_id)->get_all())
			{
				$data['agent_record'] = $agent_record_query;
			}

			$data['main'] = 'distribution/add_distribution';
			$data['js_function'] = array('distribution');
			$data['dist_id'] = $dist_id;
			$this->load->view('template/template',$data);
		}
	}

	function edit_distribution()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('profile_name', 'Profile Name', 'required|trim');
		$this->form_validation->set_rules('profile_description', 'Profile Description', 'required|trim');

		$this->form_validation->set_message('is_unique', 'The %s already exist.');
		$tenant_id = $this->session->userdata('tenant_id');
		if ($this->form_validation->run() === TRUE)
		{
			$profile_name = $this->input->post('profile_name');
			$profile_description = $this->input->post('profile_description');
			$distid = $this->input->post('distid');
			$current_datetime =  date("Y-m-d H:i:s");
			$data = array();
			$data = array(
				'profile'=>$profile_name,
				'profile_description'=>$profile_description,
				'datecreated'=>$current_datetime
			);
			if ($this->distribution_model->update($distid, $data))
			{
				$this->session->set_flashdata('success', 'Your profile have been successfully added');
				redirect('distribution/index');
			}
			else
			{
				$this->session->set_flashdata('error', 'Error. Please try again.');
				redirect('distribution/index');
			}

		}
		else
		{
			$data = array();
			$data['page'] = 'edit_distribution';
			$dist_id = $this->uri->segment(3);
			if($query = $this->distribution_model->get($dist_id))
			{
				$data['data_record'] = $query;
			}

			if($get_agent_record_query = $this->distributionagent_model->get_all_agent())
			{
				$data['get_agent_record'] = $get_agent_record_query;
			}

			if($get_queue_record_query = $this->distributionqueue_model->get_all_queue($tenant_id))
			{
				$data['get_queue_record'] = $get_queue_record_query;
			}

			if($get_wrapup_record_query = $this->distributionwrapup_model->get_all_wrapup($tenant_id))
			{
				$data['get_wrapup_record'] = $get_wrapup_record_query;
			}

			if($hour_freq_record_query = $this->distributionhrfreq_model->get_dist($dist_id)->get_all())
			{
				$data['hour_freq_record'] = $hour_freq_record_query;
			}

			if($queue_record_query = $this->distributionqueue_model->get_dist($dist_id)->get_all())
			{
				$data['queue_record'] = $queue_record_query;
			}

			if($wrapup_record_query = $this->distributionwrapup_model->get_dist($dist_id)->get_all())
			{
				$data['wrapup_record'] = $wrapup_record_query;
			}

			if($agent_record_query = $this->distributionagent_model->get_dist($dist_id)->get_all())
			{
				$data['agent_record'] = $agent_record_query;
			}

			$data['main'] = 'distribution/edit_distribution';
			$data['js_function'] = array('distribution');
			$data['dist_id'] = $dist_id;
			$this->load->view('template/template',$data);
		}
	}

	## Delete notification ##
	function ajax_delete_row()
	{
		$dist_id = $this->input->post('dist_id');

		if($this->distribution_model->delete_by(array('distid'=>$dist_id))){
			if($this->distributionqueue_model->delete_by(array('distid'=>$dist_id))){
				if($this->distributionwrapup_model->delete_by(array('distid'=>$dist_id))){
					if($this->distributionhrfreq_model->delete_by(array('distid'=>$dist_id))){
						if($this->distributionagent_model->delete_by(array('distid'=>$dist_id))){
							$msg = "success";
							echo json_encode($msg);
						}
					}
				}
			}
		}
		else
		{
			$msg = "error";
			echo json_encode($msg);
		}
	}

		## Delete notification ##
	function ajax_delete_hr_row()
	{
		$hfid = $this->input->post('hfid');

		if($this->distributionhrfreq_model->delete($hfid)){

					$msg = "success";
					echo json_encode($msg);

		}
		else
		{
			$msg = "error";
			echo json_encode($msg);
		}
	}

	## Delete notification ##
	function ajax_delete_queue_row()
	{
		$dqid = $this->input->post('dqid');

		if($this->distributionqueue_model->delete($dqid)){
			$msg = "success";
			echo json_encode($msg);
		}
		else
		{
			$msg = "error";
			echo json_encode($msg);
		}
	}

	## Delete notification ##
	function ajax_delete_wrapup_row()
	{
		$dwid = $this->input->post('dwid');

		if($this->distributionwrapup_model->delete($dwid)){
			$msg = "success";
			echo json_encode($msg);
		}
		else
		{
			$msg = "error";
			echo json_encode($msg);
		}
	}

		## Delete notification ##
	function ajax_delete_agent_row()
	{
		$dist_id = $this->input->post('dist_id');
		$agent_id = $this->input->post('agent_id');

		if($this->distributionagent_model->delete_by( array('distid'=>$dist_id,'userid'=>$agent_id))){
			$msg = "success";
			echo json_encode($msg);
		}
		else
		{
			$msg = "error";
			echo json_encode($msg);
		}
	}


	function change_status_to_complete()
	{

		$record_id = $this->input->post('record_id');
		$data = array(
			'status'=>'4'
		);
		$this->recording_model->update($record_id,$data);

		$msg = site_url("qm/qm_form_complete/$record_id");
		echo json_encode($msg);

	}

## Delete notification ##
	function active_row()
	{
		$distid = $this->input->post('distid');
		$activity = $this->input->post('activity');

		$data = array(
			'active'=>$activity
		);

		if($this->distribution_model->update($distid,$data)){
			$msg = "success";
			echo json_encode($msg);
		}
		else
		{
			$msg = "error";
			echo json_encode($msg);
		}
	}

	## Duplicate ##
	function ajax_duplicate_row()
	{
		$qm_id = $this->input->post('qm_id');
		//$qm_id = 1;
		$this->load->model('criteriaandquestion_model');
		$this->load->model('qmandcriteria_model');

		// insert to qm 1st
		$query = $this->qm_model->get_by('qm_id',$qm_id);

		$qm_title = $query->qm_title;

		$data = array(
			'qm_title'=>$qm_title
		);
		$this->qm_model->insert($data);
		$last_qm_id = $this->db->insert_id();
		//$last_qm_id = 10;
		// insert to qm_and_criteria
		$query = $this->qmandcriteria_model->get_qmandcriteria($qm_id);

		foreach($query as $row){
			$criteria_id = $row->criteria_id;
			$data_qmandcriteria = array(
				'qm_id'=>$last_qm_id,
				'criteria_id'=>$criteria_id
			);
			$check = $this->qmandcriteria_model->insert($data_qmandcriteria);
		}

		// insert to qm_and_criteria
		$query2 = $this->criteriaandquestion_model->get_criteriaandquestion($qm_id);
		foreach($query2 as $row2){

			$criteria_id2 = $row2->criteria_id;
			$question_id2 = $row2->question_id;
			$data_criteriaandquestion = array(
				'qm_id'=>$last_qm_id,
				'criteria_id'=>$criteria_id2,
				'question_id'=>$question_id2
			);
			$this->criteriaandquestion_model->insert($data_criteriaandquestion);
		}

		$msg = "success";
		echo json_encode($msg);
	}

	function preview_profile()
	{
		$num1 = 1;
		$num2 = 1;
		$num3 = 1;
		$num4 = 1;
		$distid = $this->input->post('distid');
		//$query2 = $this->user_model->get_agent()->get_all();

		//$qm_id = 1;
		$warpup = $this->distributionwrapup_model->get_dist($distid)->get_all();
		$queue = $this->distributionqueue_model->get_dist($distid)->get_all();
		$hr_freq = $this->distributionhrfreq_model->get_dist($distid)->get_all();
		$profile = $this->distribution_model->get_dist($distid)->get_all();
		$agent = $this->distributionagent_model->get_dist($distid)->get_all();



			$table = "<div class='offset4' style='text-decoration:underline;'><h2>".$profile[0]->profile."</h2></div>";
			//$table .= "<div class='offset4' style='text-decoration:underline;'><h2>".$query[0]->profile_description."</h2></div>";
			$table .= "<div class='span7 offset1'>";

			$table .= "<table class='table table-bordered table-hover'>";
			$table .= "<thead><tr><th>No</th><th>Start</th><th>End</th><th>Frequency</th></tr></thead><tbody>";
			foreach($hr_freq as $hr_freq_row){
				$table .= "<tr><td>".$num1."</td><td>".$hr_freq_row->starttime."</td><td>".$hr_freq_row->endtime."</td><td>".$hr_freq_row->freq."</td></tr>";
				$num1++;
			}
			$table .= "</table>";
			$table .= "<table class='table table-bordered table-hover'>";
			$table .= "<thead><tr><th>No</th><th>Queues</th></tr></thead><tbody>";
			foreach($queue as $queue_row){

				$table .= "<tr><td>".$num2."</td><td class='span8'>".$queue_row->queuename."</td></tr>";
				$num2++;
			}

			$table .= "</table>";
			$table .= "<table class='table table-bordered table-hover'>";
			$table .= "<thead><tr><th>No</th><th>Wrap Ups</th></tr></thead><tbody>";
			foreach($warpup as $warpup_row){
				$table .= "<tr><td>".$num3."</td><td class='span8'>".$warpup_row->wrapup."</td></tr>";
				$num3++;
			}
			$table .= "</table>";

			$table .= "</table>";
			$table .= "<table class='table table-bordered table-hover'>";
			$table .= "<thead><tr><th>No</th><th>Agent</th></tr></thead><tbody>";
			foreach($agent as $agent_row){
				$table .= "<tr><td>".$num4."</td><td class='span8'>".$agent_row->username."</td></tr>";
				$num4++;
			}
			$table .= "</table>";

			$table .= "</div>";

			echo $table;

	}
}//end of class
?>