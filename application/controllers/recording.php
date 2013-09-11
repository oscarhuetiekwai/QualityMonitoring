<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recording extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->permission->is_logged_in();
		//load model
		$this->load->helper('url');
		$this->load->model('recording_model');
		$this->load->model('qm_model');
		$this->load->model('criteria_model');
		$this->load->model('question_model');
		$this->load->model('recqm_model');
		$this->load->database('qm', TRUE);
	}

	function index()
	{
		$data = array();
		$data['page'] = 'recordings';
		$userid = $this->session->userdata('userid');
		$datetime = date('Y-m-d');
		$tenant_id = $this->session->userdata('tenant_id');
		// get this week range
		$date = $this->x_week_range($datetime);
		// get this week date
		$one_week_date = $this->createDateRangeArray($date[0],$date[1]);

		$data['current_week'] = $one_week_date;
		if($query = $this->recording_model->join_user_current_week($tenant_id,$userid)->get_all())
		{
			$data['data_record'] = $query;
		}

		if($query = $this->qm_model->group_by_qm_title($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		// get status count
		$current_week_news_status = $this->recording_model->get_current_week_status_count($tenant_id,$date[0],$date[1])->count_by('status', '1');
		$current_week_expired_status = $this->recording_model->get_current_week_status_count($tenant_id,$date[0],$date[1])->count_by('status', '2');
		$current_week_pending_status = $this->recording_model->get_current_week_status_count($tenant_id,$date[0],$date[1])->count_by('status', '3');
		$current_week_pending_status2 = $this->recording_model->get_current_week_status_count($tenant_id,$date[0],$date[1])->count_by('status', '5');
		$current_week_complete_status = $this->recording_model->get_current_week_status_count($tenant_id,$date[0],$date[1])->count_by('status', '4');

		$total_current_week_pending = $current_week_pending_status + $current_week_pending_status2;

		$old_news_status = $this->recording_model->get_older_news_status_count($tenant_id,$date[0])->count_by('status', '1');
		$old_expired_status = $this->recording_model->get_older_news_status_count($tenant_id,$date[0])->count_by('status', '2');
		$old_pending_status = $this->recording_model->get_older_news_status_count($tenant_id,$date[0])->count_by('status', '3');
		$old_pending_status2 = $this->recording_model->get_older_news_status_count($tenant_id,$date[0])->count_by('status', '5');
		$total_old_pending = $old_pending_status + $old_pending_status2;
		$old_complete_status = $this->recording_model->get_older_news_status_count($tenant_id,$date[0])->count_by('status', '4');

		$data['current_week_news_status'] = $current_week_news_status;
		$data['current_week_expired_status'] = $current_week_expired_status;
		$data['current_week_pending_status'] = $total_current_week_pending;
		$data['current_week_complete_status'] = $current_week_complete_status;
		$data['old_news_status'] = $old_news_status;
		$data['old_expired_status'] = $old_expired_status;
		$data['old_pending_status'] = $total_old_pending;
		$data['old_complete_status'] = $old_complete_status;

		$data['main'] = 'recording/index';
		$data['js_function'] = array('recording');
		$this->load->view('template/template',$data);
	}

	function assign_form()
	{
		$data = array();
		$data['page'] = 'assign_form';
		$userid = $this->session->userdata('userid');
		$record_id = $this->uri->segment(3);
		$data['record_id'] = $record_id;
		$datetime = date('Y-m-d');
		$tenant_id = $this->session->userdata('tenant_id');
		if($query = $this->qm_model->group_by_qm_title($tenant_id)->get_all())
		{
			$data['qm_record'] = $query;
		}

		$data['main'] = 'recording/assign_form';
		$data['js_function'] = array('recording');
		$this->load->view('template/template',$data);
	}


	function submit_form()
	{
		$record_id = $this->input->post('record_id');
		$qm_id = $this->input->post('qm_id');

		$data = array (
			'record_id'=>$record_id,
			'qm_id'=>$qm_id,
		);
		$record_id = $this->input->post('record_id');

		$query = $this->recording_model->get($record_id);

		$userid = $query->userid;
		$tenant_id = $this->session->userdata('tenant_id');
		$supervisor_id = $this->session->userdata('userid');

		$this->recqm_model->insert($data);
		$this->recording_model->update($record_id,array('status'=>'3','tenantid'=>$tenant_id,'supervisor_id'=>$supervisor_id));
		$this->session->set_flashdata('success', 'You have successfully assign the form');

		redirect("qm/qm_form/$record_id/$userid");
	}

	function preview_recording()
	{
		$num = 0;
		$no = 0;
		$date = $this->input->post('date');
		$tenant_id = $this->session->userdata('tenant_id');
		$userid = $this->session->userdata('userid');

		$query = $this->recording_model->preview_recording($tenant_id, $date,$userid)->get_all();

		$prev = null;
		$table2 = "";
		if(!empty($query)){
			$len = count($query);
			$table2 .= "<p><h5>Total Of Row(s) : ".$len."</h5></p>";
			$i = 0;
			$username = array();
			$table2 .= "<table class='table table-bordered table-hover'>";
			foreach($query as $row){

				$num++;
				$date = date( 'Y-m-d', strtotime($row->connecttime));
				$time = date( 'H:i:s a', strtotime($row->connecttime));
				if($row->status == 1){
					$status = "<span class='label label-inverse'>New</span>";
				}else if($row->status == 2){
					$status = "<span class='label label-important'>Expired</span>";
				}else if($row->status == 3){
					$status = "<span class='label label-warning'>Pending</span>";
				}else if($row->status == 4){
					$status = "<span class='label label-success'>Complete</span>";
				}else if($row->status == 5){
					$status = "<span class='label label-warning'>Pending</span>";
				}

				$username[$i] = $row->username;
				  if($i > 0){
					  if ($username[$i] != $username[$i-1]){
					  	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
						$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Action</th>";
						$table2 .= "</tr>";

					   }
				   } else {
				   	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
						$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Action</th>";
						$table2 .= "</tr>";
				   }

				$table2 .= "<tr>";
				$table2 .= "<td>";
				$table2 .=  $date;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $time;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->queuename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->record_filename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $status;
				$table2 .= "</td>";
				$table2 .= "<td>";
				if($row->status == 1){
					$assign_form_url = site_url('recording/assign_form/'.$row->record_id.'/');
					$table2 .=  "<a href='".$assign_form_url."'   class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form<a>";
				}else if($row->status == 4){
					$url = site_url('qm/qm_form_complete/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}else if($row->status == 5){
					$url = site_url('qm/qm_form_pending_save/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
				}else if($row->status == 3){
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
				}else{
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}
				$table2 .= "</td>";
				$table2 .= "</tr>";
				$i++;
			}
		}else{
			echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>No Records Found!</h4></div>";
		}
		$table2 .= "</table>";
		echo $table2;
	}

	function search_recordings()
	{
		$num = 0;
		$no = 0;
		$agent_name = $this->input->post('agent_name');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$status = $this->input->post('status');
		$check_old_date = $this->input->post('check_old_date');
		$search_type = $this->input->post('search_type');
		$userid = $this->session->userdata('userid');
		$recover = $this->input->post('recover');
		$tenant_id = $this->session->userdata('tenant_id');
		if($search_type == 1){
			$datetime = date('Y-m-d');
			// get this week range
			$date = $this->x_week_range($datetime);
			$first_date_current_week = $date[0];
			$end_date_current_week = $date[1];
			$query = $this->recording_model->search_recording($tenant_id,$agent_name,$first_date_current_week,$end_date_current_week,$status,$userid,$check_old_date,$recover)->get_all();
		}else if($search_type == 2){
			// current month
			$month_start = strtotime('first day of this month', time());
			$month_end = strtotime('last day of this month', time());
			$first_date_current_month = date('Y-m-d', $month_start).'<br/>';
			$end_date_current_month = date('Y-m-d', $month_end).'<br/>';
			$query = $this->recording_model->search_recording($tenant_id,$agent_name,$first_date_current_month,$end_date_current_month,$status,$userid,$check_old_date,$recover)->get_all();
		}else{
			$query = $this->recording_model->search_recording2($tenant_id,$agent_name,$start_date,$end_date,$status,$userid,$check_old_date,$recover)->get_all();
		}

		$prev = null;
		$table2 = "";
		if(!empty($query)){
			$len = count($query);
			$table2 .= "<p><h5>Total Of Row(s) : ".$len."</h5></p>";
			$i = 0;
			$username = array();
			$table2 .= "<table class='table table-bordered table-hover' id='dt_e'>";
			foreach($query as $row){

				$num++;
				$date = date( 'Y-m-d', strtotime($row->connecttime));
				$time = date( 'H:i:s a', strtotime($row->connecttime));
				if($row->status == 1){
					$status = "<span class='label label-inverse'>New</span>";
				}else if($row->status == 2){
					$status = "<span class='label label-important'>Expired</span>";
				}else if($row->status == 3){
					$status = "<span class='label label-warning'>Pending</span>";
				}else if($row->status == 4){
					$status = "<span class='label label-success'>Complete</span>";
				}else if($row->status == 5){
					$status = "<span class='label label-warning'>Pending</span>";
				}

				if($row->recover == 1){
					$recover = "Yes";
				}else{
					$recover = "No";
				}

				$username[$i] = $row->username;
				if($i > 0){
				  if ($username[$i] != $username[$i-1]){
					$table2 .= "<tr>";
					$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
					$table2 .= "</tr>";
					$table2 .= "<tr>";
					$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Recovery</th><th>Action</th>";
					$table2 .= "</tr>";
				   }
				} else {
				$table2 .= "<tr>";
					$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
					$table2 .= "</tr>";
					$table2 .= "<tr>";
					$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Recovery</th><th>Action</th>";
					$table2 .= "</tr>";
				}

				$table2 .= "<tr>";
				$table2 .= "<td>";
				$table2 .=  $date;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $time;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->queuename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->record_filename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $status;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $recover;
				$table2 .= "</td>";
				$table2 .= "<td>";
				if($row->status == 1){
					$assign_form_url = site_url('recording/assign_form/'.$row->record_id.'/');
					$table2 .=  "<a href='".$assign_form_url."'   class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form<a>";
				}else if($row->status == 4){
					$url = site_url('qm/qm_form_complete/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}else if($row->status == 5){
					$url = site_url('qm/qm_form_pending_save/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
				}else if($row->status == 3){
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
				}else{
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}

				$table2 .= "</td>";
				$table2 .= "</tr>";
				$i++;
			}
		}else{
		 echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>No Records Found!</h4></div>";
		}
		$table2 .= "</table>";
		echo $table2;
	}


	function search_recording()
	{
		$num = 0;
		$no = 0;
		$agent_name = $this->input->post('agent_name');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$status2 = $this->input->post('status');
		$check_old_date = $this->input->post('check_old_date');
		$search_type = $this->input->post('search_type');
		$userid = $this->session->userdata('userid');
		$tenant_id = $this->session->userdata('tenant_id');
		$recover = $this->input->post('recover');

		if($search_type == 1){

			$datetime = date('Y-m-d');
			// get this week range
			$date = $this->x_week_range($datetime);
			$first_date_current_week = $date[0];
			$end_date_current_week = $date[1];
			$query = $this->recording_model->search_recording($tenant_id,$agent_name,$first_date_current_week,$end_date_current_week,$status2,$userid,$check_old_date,$recover)->get_all();

		}else if($search_type == 2){
			// current month
			$month_start = strtotime('first day of this month', time());
			$month_end = strtotime('last day of this month', time());

			## get 1st date current month ##
			$first_date_current_month = date('Y-m-d', $month_start).'<br/>';

			## get last date current month ##
			$end_date_current_month = date('Y-m-d', $month_end).'<br/>';
			$query = $this->recording_model->search_recording($tenant_id,$agent_name,$first_date_current_month,$end_date_current_month,$status2,$userid,$check_old_date,$recover)->get_all();
		}else{
			$query = $this->recording_model->search_recording2($tenant_id,$agent_name,$start_date,$end_date,$status2,$userid,$check_old_date,$recover)->get_all();
		}

		$prev = null;
		$table2 = "";
		if(!empty($query)){
			$len = count($query);
			$table2 .= "<p><h5>Total Of Row(s) : ".$len."</h5></p>";

			$i = 0;
			$username = array();

			$table2 .= "<table class='table table-bordered table-hover' id='dt_e'>";
			foreach($query as $row){
				$num++;
				$date = date( 'Y-m-d', strtotime($row->connecttime));
				$time = date( 'H:i:s a', strtotime($row->connecttime));
				if($row->status == 1){
					$status = "<span class='label label-inverse'>New</span>";
				}else if($row->status == 2){
					$status = "<span class='label label-important'>Expired</span>";
				}else if($row->status == 3){
					$status = "<span class='label label-warning'>Pending</span>";
				}else if($row->status == 4){
					$status = "<span class='label label-success'>Complete</span>";
				}else if($row->status == 5){
					$status = "<span class='label label-warning'>Pending</span>";
				}

				$username[$i] = $row->username;
				  if($i > 0){
					  if ($username[$i] != $username[$i-1]){
					  	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
						$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Action</th>";
						$table2 .= "</tr>";

					   }
				   } else {
				   	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
						$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Action</th>";
						$table2 .= "</tr>";
				   }

				$table2 .= "<tr>";
				$table2 .= "<td>";
				$table2 .=  $date;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $time;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->queuename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->record_filename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $status;
				$table2 .= "</td>";
				$table2 .= "<td>";
				if($row->status == 1){
					$assign_form_url = site_url('recording/assign_form/'.$row->record_id.'/');
					$table2 .=  "<a href='".$assign_form_url."'   class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form<a>";
				}else if($row->status == 4){
					$url = site_url('qm/qm_form_complete/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}else if($row->status == 5){
					$url = site_url('qm/qm_form_pending_save/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
				}else if($row->status == 3){
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
				}else{
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}

				$table2 .= "</td>";
				$table2 .= "</tr>";
				$i++;
			}


		}else{
		 echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>No Records Found!</h4></div>";
		}
		$table2 .= "</table>";
		echo $table2;
	}

	############################################ Current week only########################################################################
	function current_week_complete()
	{
		$num = 0;
		$no = 0;
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$tenant_id = $this->session->userdata('tenant_id');
		$userid = $this->session->userdata('userid');

		$query = $this->recording_model->current_week_complete($tenant_id,$start_date,$end_date,$userid)->get_all();

		$prev = null;
		$table2 = "";
		if(!empty($query)){
			$len = count($query);
			$table2 .= "<p><h5>Total Of Row(s) : ".$len."</h5></p>";
			$i = 0;
			$username = array();
			$table2 .= "<table class='table table-bordered table-hover'>";
			foreach($query as $row){

				$num++;
				$date = date( 'Y-m-d', strtotime($row->connecttime));
				$time = date( 'H:i:s a', strtotime($row->connecttime));
				if($row->status == 1){
					$status = "<span class='label label-inverse'>New</span>";
				}else if($row->status == 2){
					$status = "<span class='label label-important'>Expired</span>";
				}else if($row->status == 3){
					$status = "<span class='label label-warning'>Pending</span>";
				}else if($row->status == 4){
					$status = "<span class='label label-success'>Complete</span>";
				}else if($row->status == 5){
					$status = "<span class='label label-warning'>Pending</span>";
				}

				$username[$i] = $row->username;
				  if($i > 0){
					  if ($username[$i] != $username[$i-1]){
					  	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";

					   }
				   } else {
				   	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";
				   }
				$table2 .= "<tr>";
				$table2 .= "<td>";
				$table2 .=  $date;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $time;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->queuename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->record_filename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $status;
				$table2 .= "</td>";
				$table2 .= "<td>";
				if($row->status == 1){
					$assign_form_url = site_url('recording/assign_form/'.$row->record_id.'/');
					$table2 .=  "<a href='".$assign_form_url."'   class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form<a>";
				}else if($row->status == 4){
					$url = site_url('qm/qm_form_complete/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}else if($row->status == 5){
					$url = site_url('qm/qm_form_pending_save/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
				}else if($row->status == 3){
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
				}else{
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}

				$table2 .= "</td>";
				$table2 .= "</tr>";
				$i++;
			}


		}else{
		 echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>No Records Found!</h4></div>";
		}
		$table2 .= "</table>";
		echo $table2;
	}

	function current_week_expired()
	{
		$num = 0;
		$no = 0;
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$tenant_id = $this->session->userdata('tenant_id');
		$userid = $this->session->userdata('userid');

		$query = $this->recording_model->current_week_expired($tenant_id,$start_date,$end_date,$userid)->get_all();

		$prev = null;
		$table2 = "";
		if(!empty($query)){
			$len = count($query);
			$table2 .= "<p><h5>Total Of Row(s) : ".$len."</h5></p>";
			$i = 0;
			$username = array();

			$table2 .= "<table class='table table-bordered table-hover'>";
			foreach($query as $row){

				$num++;
				$date = date( 'Y-m-d', strtotime($row->connecttime));
				$time = date( 'H:i:s a', strtotime($row->connecttime));
				if($row->status == 1){
					$status = "<span class='label label-inverse'>New</span>";
				}else if($row->status == 2){
					$status = "<span class='label label-important'>Expired</span>";
				}else if($row->status == 3){
					$status = "<span class='label label-warning'>Pending</span>";
				}else if($row->status == 4){
					$status = "<span class='label label-success'>Complete</span>";
				}else if($row->status == 5){
					$status = "<span class='label label-warning'>Pending</span>";
				}

				$username[$i] = $row->username;
				  if($i > 0){
					  if ($username[$i] != $username[$i-1]){
					  	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";

					   }
				   } else {
				   	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";
				   }

				$table2 .= "<tr>";
				$table2 .= "<td>";
				$table2 .=  $date;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $time;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->queuename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->record_filename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $status;
				$table2 .= "</td>";
				$table2 .= "<td>";
				if($row->status == 1){
					$assign_form_url = site_url('recording/assign_form/'.$row->record_id.'/');
					$table2 .=  "<a href='".$assign_form_url."'   class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form<a>";
				}else if($row->status == 4){
					$url = site_url('qm/qm_form_complete/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}else if($row->status == 5){
					$url = site_url('qm/qm_form_pending_save/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
				}else if($row->status == 3){
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
				}else{
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}

				$table2 .= "</td>";
				$table2 .= "</tr>";
				$i++;
			}


		}else{
		 echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>No Records Found!</h4></div>";
		}
		$table2 .= "</table>";
		echo $table2;
	}

	function current_week_new()
	{
		$num = 0;
		$no = 0;
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$tenant_id = $this->session->userdata('tenant_id');
		//$query = $this->qm_model->join_all_for_preview($date);

		$userid = $this->session->userdata('userid');

		$query = $this->recording_model->current_week_new($tenant_id,$start_date,$end_date,$userid)->get_all();

		$prev = null;
		$table2 = "";
		if(!empty($query)){
			$len = count($query);
			$table2 .= "<p><h5>Total Of Row(s) : ".$len."</h5></p>";
			$i = 0;
			$username = array();
				//$table2 .= "<p><h4>".$row->username."</h4></p>";


			$table2 .= "<table class='table table-bordered table-hover'>";
			foreach($query as $row){

				$num++;
				$date = date( 'Y-m-d', strtotime($row->connecttime));
				$time = date( 'H:i:s a', strtotime($row->connecttime));
				if($row->status == 1){
					$status = "<span class='label label-inverse'>New</span>";
				}else if($row->status == 2){
					$status = "<span class='label label-important'>Expired</span>";
				}else if($row->status == 3){
					$status = "<span class='label label-warning'>Pending</span>";
				}else if($row->status == 4){
					$status = "<span class='label label-success'>Complete</span>";
				}else if($row->status == 5){
					$status = "<span class='label label-warning'>Pending</span>";
				}

					  $username[$i] = $row->username;
				  if($i > 0){
					  if ($username[$i] != $username[$i-1]){
					  	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";

					   }
				   } else {
				   	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";
				   }

				$table2 .= "<tr>";
				$table2 .= "<td>";
				$table2 .=  $date;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $time;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->queuename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->record_filename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $status;
				$table2 .= "</td>";
				$table2 .= "<td>";
				if($row->status == 1){
					$assign_form_url = site_url('recording/assign_form/'.$row->record_id.'/');
					$table2 .=  "<a href='".$assign_form_url."'   class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form<a>";
				}else if($row->status == 4){
					$url = site_url('qm/qm_form_complete/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}else if($row->status == 5){
					$url = site_url('qm/qm_form_pending_save/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
				}else if($row->status == 3){
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
				}else{
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}

				$table2 .= "</td>";
				$table2 .= "</tr>";
				$i++;
			}


		}else{
		 echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>No Records Found!</h4></div>";
		}
		$table2 .= "</table>";
		echo $table2;
	}

	function current_week_pending()
	{
		$num = 0;
		$no = 0;
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$tenant_id = $this->session->userdata('tenant_id');
		$userid = $this->session->userdata('userid');

		$query = $this->recording_model->current_week_pending($tenant_id,$start_date,$end_date,$userid)->get_all();

		$prev = null;
		$table2 = "";
		if(!empty($query)){
			$len = count($query);
			$table2 .= "<p><h5>Total Of Row(s) : ".$len."</h5></p>";
			$i = 0;
			$username = array();
			$table2 .= "<table class='table table-bordered table-hover'>";
			foreach($query as $row){
				$num++;
				$date = date( 'Y-m-d', strtotime($row->connecttime));
				$time = date( 'H:i:s a', strtotime($row->connecttime));
				if($row->status == 1){
					$status = "<span class='label label-inverse'>New</span>";
				}else if($row->status == 2){
					$status = "<span class='label label-important'>Expired</span>";
				}else if($row->status == 3){
					$status = "<span class='label label-warning'>Pending</span>";
				}else if($row->status == 4){
					$status = "<span class='label label-success'>Complete</span>";
				}else if($row->status == 5){
					$status = "<span class='label label-warning'>Pending</span>";
				}
				$username[$i] = $row->username;
				if($i > 0){
					if ($username[$i] != $username[$i-1]){
					  	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
						$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";
					}
				} else {
				   	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
						$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";
				}
				$table2 .= "<tr>";
				$table2 .= "<td>";
				$table2 .=  $date;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $time;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->queuename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->record_filename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $status;
				$table2 .= "</td>";
				$table2 .= "<td>";
				if($row->status == 1){
					$assign_form_url = site_url('recording/assign_form/'.$row->record_id.'/');
					$table2 .=  "<a href='".$assign_form_url."' class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form<a>";
				}else if($row->status == 4){
					$url = site_url('qm/qm_form_complete/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}else if($row->status == 5){
					$url = site_url('qm/qm_form_pending_save/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
				}else if($row->status == 3){
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
				}else{
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}
				$table2 .= "</td>";
				$table2 .= "</tr>";
				$i++;
			}
		}else{
			echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>No Records Found!</h4></div>";
		}
		$table2 .= "</table>";
		echo $table2;
	}

	############################################ Older week only ########################################################################
	function older_week_complete()
	{
		$num = 0;
		$no = 0;
		$start_date = $this->input->post('start_date');
		$tenant_id = $this->session->userdata('tenant_id');
		$userid = $this->session->userdata('userid');

		$query = $this->recording_model->older_week_complete($tenant_id,$start_date,$userid)->get_all();

		$prev = null;
		$table2 = "";
		if(!empty($query)){
			$len = count($query);
			$table2 .= "<p><h5>Total Of Row(s) : ".$len."</h5></p>";
			$i = 0;
			$username = array();

			$table2 .= "<table class='table table-bordered table-hover'>";
			foreach($query as $row){

				$num++;
				$date = date( 'Y-m-d', strtotime($row->connecttime));
				$time = date( 'H:i:s a', strtotime($row->connecttime));
				if($row->status == 1){
					$status = "<span class='label label-inverse'>New</span>";
				}else if($row->status == 2){
					$status = "<span class='label label-important'>Expired</span>";
				}else if($row->status == 3){
					$status = "<span class='label label-warning'>Pending</span>";
				}else if($row->status == 4){
					$status = "<span class='label label-success'>Complete</span>";
				}else if($row->status == 5){
					$status = "<span class='label label-warning'>Pending</span>";
				}
				$username[$i] = $row->username;
				  if($i > 0){
					  if ($username[$i] != $username[$i-1]){
					  	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";
					   }
				   } else {
				   	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";
				   }

				$table2 .= "<tr>";
				$table2 .= "<td>";
				$table2 .=  $date;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $time;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->queuename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->record_filename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $status;
				$table2 .= "</td>";
				$table2 .= "<td>";
				if($row->status == 1){
					$assign_form_url = site_url('recording/assign_form/'.$row->record_id.'/');
					$table2 .=  "<a href='".$assign_form_url."'   class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form<a>";
				}else if($row->status == 4){
					$url = site_url('qm/qm_form_complete/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}else if($row->status == 5){
					$url = site_url('qm/qm_form_pending_save/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
				}else if($row->status == 3){
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
				}else{
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}
				$table2 .= "</td>";
				$table2 .= "</tr>";
				$i++;
			}


		}else{
		 echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>No Records Found!</h4></div>";
		}
		$table2 .= "</table>";
		echo $table2;
	}

	function older_week_expired()
	{
		$num = 0;
		$no = 0;
		$start_date = $this->input->post('start_date');
		$tenant_id = $this->session->userdata('tenant_id');
		$userid = $this->session->userdata('userid');

		$query = $this->recording_model->older_week_expired($tenant_id,$start_date,$userid)->get_all();

		$prev = null;
		$table2 = "";
		if(!empty($query)){
			$len = count($query);
			$table2 .= "<p><h5>Total Of Row(s) : ".$len."</h5></p>";
			$i = 0;
			$username = array();

			$table2 .= "<table class='table table-bordered table-hover'>";
			foreach($query as $row){

				$num++;
				$date = date( 'Y-m-d', strtotime($row->connecttime));
				$time = date( 'H:i:s a', strtotime($row->connecttime));
				if($row->status == 1){
					$status = "<span class='label label-inverse'>New</span>";
				}else if($row->status == 2){
					$status = "<span class='label label-important'>Expired</span>";
				}else if($row->status == 3){
					$status = "<span class='label label-warning'>Pending</span>";
				}else if($row->status == 4){
					$status = "<span class='label label-success'>Complete</span>";
				}else if($row->status == 5){
					$status = "<span class='label label-warning'>Pending</span>";
				}

				  $username[$i] = $row->username;
				  if($i > 0){
					  if ($username[$i] != $username[$i-1]){
					  	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";

					   }
				   } else {
				   	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";
				   }

				$table2 .= "<tr>";
				$table2 .= "<td>";
				$table2 .=  $date;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $time;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->queuename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->record_filename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $status;
				$table2 .= "</td>";
				$table2 .= "<td>";
				if($row->status == 1){
					$assign_form_url = site_url('recording/assign_form/'.$row->record_id.'/');
					$table2 .=  "<a href='".$assign_form_url."'   class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form<a>";
				}else if($row->status == 4){
					$url = site_url('qm/qm_form_complete/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}else if($row->status == 5){
					$url = site_url('qm/qm_form_pending_save/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
				}else if($row->status == 3){
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
				}else{
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}

				$table2 .= "</td>";
				$table2 .= "</tr>";
				$i++;
			}
		}else{
		 echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>No Records Found!</h4></div>";
		}
		$table2 .= "</table>";
		echo $table2;
	}

	function older_week_new()
	{
		$num = 0;
		$no = 0;
		$start_date = $this->input->post('start_date');
		$tenant_id = $this->session->userdata('tenant_id');
		$userid = $this->session->userdata('userid');

		$query = $this->recording_model->older_week_new($tenant_id,$start_date,$userid)->get_all();

		$prev = null;
		$table2 = "";
		if(!empty($query)){
			$len = count($query);
			$table2 .= "<p><h5>Total Of Row(s) : ".$len."</h5></p>";
			$i = 0;
			$username = array();
			//$table2 .= "<p><h4>".$row->username."</h4></p>";

			$table2 .= "<table class='table table-bordered table-hover'>";
			foreach($query as $row){

				$num++;
				$date = date( 'Y-m-d', strtotime($row->connecttime));
				$time = date( 'H:i:s a', strtotime($row->connecttime));
				if($row->status == 1){
					$status = "<span class='label label-inverse'>New</span>";
				}else if($row->status == 2){
					$status = "<span class='label label-important'>Expired</span>";
				}else if($row->status == 3){
					$status = "<span class='label label-warning'>Pending</span>";
				}else if($row->status == 4){
					$status = "<span class='label label-success'>Complete</span>";
				}else if($row->status == 5){
					$status = "<span class='label label-warning'>Pending</span>";
				}

				 $username[$i] = $row->username;
				  if($i > 0){
					  if ($username[$i] != $username[$i-1]){
					  	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";

					   }
				   } else {
				   	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";
				   }

				$table2 .= "<tr>";
				$table2 .= "<td>";
				$table2 .=  $date;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $time;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->queuename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->record_filename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $status;
				$table2 .= "</td>";
				$table2 .= "<td>";
				if($row->status == 1){
					$assign_form_url = site_url('recording/assign_form/'.$row->record_id.'/');
					$table2 .=  "<a href='".$assign_form_url."'   class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form<a>";
				}else if($row->status == 4){
					$url = site_url('qm/qm_form_complete/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}else if($row->status == 5){
					$url = site_url('qm/qm_form_pending_save/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
				}else if($row->status == 3){
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
				}else{
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}

				$table2 .= "</td>";
				$table2 .= "</tr>";
				$i++;
			}


		}else{
		 echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>No Records Found!</h4></div>";
		}
		$table2 .= "</table>";
		echo $table2;
	}

	function older_week_pending()
	{
		$num = 0;
		$no = 0;
		$start_date = $this->input->post('start_date');
		$tenant_id = $this->session->userdata('tenant_id');
		//$query = $this->qm_model->join_all_for_preview($date);

		$userid = $this->session->userdata('userid');

		$query = $this->recording_model->older_week_pending($tenant_id,$start_date,$userid)->get_all();

		$prev = null;
		$table2 = "";
		if(!empty($query)){
			$len = count($query);
			$table2 .= "<p><h5>Total Of Row(s) : ".$len."</h5></p>";
			$i = 0;
			$username = array();
				//$table2 .= "<p><h4>".$row->username."</h4></p>";


			$table2 .= "<table class='table table-bordered table-hover'>";
			foreach($query as $row){

				$num++;
				$date = date( 'Y-m-d', strtotime($row->connecttime));
				$time = date( 'H:i:s a', strtotime($row->connecttime));
				if($row->status == 1){
					$status = "<span class='label label-inverse'>New</span>";
				}else if($row->status == 2){
					$status = "<span class='label label-important'>Expired</span>";
				}else if($row->status == 3){
					$status = "<span class='label label-warning'>Pending</span>";
				}else if($row->status == 4){
					$status = "<span class='label label-success'>Complete</span>";
				}else if($row->status == 5){
					$status = "<span class='label label-warning'>Pending</span>";
				}

				$username[$i] = $row->username;
				  if($i > 0){
					  if ($username[$i] != $username[$i-1]){
					  	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";
					   }
				   } else {
				   	$table2 .= "<tr>";
						$table2 .= "<td colspan='6'><h4>".$username[$i]."</h4></td>";
							$table2 .= "</tr>";
						$table2 .= "<tr>";
						$table2 .= "<th>Date</th><th>Time</th><th>Queue</th><th>Recording Filename</th><th>Status</th><th>Active</th>";
						$table2 .= "</tr>";
				   }

				$table2 .= "<tr>";
				$table2 .= "<td>";
				$table2 .=  $date;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $time;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->queuename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $row->record_filename;
				$table2 .= "</td>";
				$table2 .= "<td>";
				$table2 .=  $status;
				$table2 .= "</td>";
				$table2 .= "<td>";
				if($row->status == 1){
					$assign_form_url = site_url('recording/assign_form/'.$row->record_id.'/');
					$table2 .=  "<a href='".$assign_form_url."'   class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form<a>";
				}else if($row->status == 4){
					$url = site_url('qm/qm_form_complete/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}else if($row->status == 5){
					$url = site_url('qm/qm_form_pending_save/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
				}else if($row->status == 3){
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
				}else{
					$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
					$table2 .=  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
				}
				$table2 .= "</td>";
				$table2 .= "</tr>";
				$i++;
			}
		}else{
		 echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4>No Records Found!</h4></div>";
		}
		$table2 .= "</table>";
		echo $table2;
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
		$config['per_page'] =5;
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