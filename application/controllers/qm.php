<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//this controllar is proceed all the view and pagination
class Qm extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->permission->is_logged_in();
		//load model
		$this->load->helper('url');
		$this->load->model('criteria_model');
		$this->load->model('question_model');
		$this->load->model('qm_model');
		$this->load->model('recording_model');
		$this->load->model('voicetag_model');
		$this->load->model('otherrecordingsfile_model');
		$this->load->model('chatmessage_model');
		$this->load->model('qm_level_rate_model');

		$DB1 = $this->load->database('qm', TRUE);
		//$DB2 = $this->load->database('reportcallcenter', TRUE);
	}

	function submit_tag()
	{
		$data = array();

		$minutes = $this->input->post('minutes');
		$second = $this->input->post('second');
		$minutes2 = $this->input->post('minutes2');
		$second2 = $this->input->post('second2');
		$tag_record_id = $this->input->post('tag_record_id');
		$tag_remark = $this->input->post('tag_remark');

		$start_tag = $minutes.":".$second;
		$end_tag = $minutes2.":".$second2;

		$data = array(
			'record_id'=>$tag_record_id,
			'start_tag'=>$start_tag,
			'end_tag'=>$end_tag,
			'remark'=>$tag_remark
		);
		// insert to rate_info

		$this->voicetag_model->insert($data);

		$msg = "success";
		echo json_encode($msg);
	}

	function submit_other_recording()
	{
		$data = array();
		$other_remark = $this->input->post('other_remark');
		$record_id = $this->input->post('others_record_id');

		$data = array(
			'others_recording'=>$other_remark
		);
		// insert to rate_info
		if($this->recording_model->update($record_id, $data)){
			$msg = "success";
			echo json_encode($msg);
		}else{
			$msg = "error";
			echo json_encode($msg);
		}
	}

	function submit_other_recording2()
	{
		$data = array();
		$other_remark = $this->input->post('other_remark');
		$record_id = $this->input->post('others_record_id');
		$userid = $this->input->post('userid');
		$upload = $this->input->post('upload');

		$upload_file_name = '';
		$config['upload_path'] = './assets/record_file/';
		$config['allowed_types'] = 'gif|jpg|png|GIF|JPG|PNG|txt|doc|docs|csv|html|log|text|swf|pdf';
		$config['max_size']	= 1000000;
		//$config['encrypt_name']  = TRUE;

		$this->load->library('upload', $config);
		if($this->upload->do_upload('upload'))
		{

			$upload_data = $this->upload->data();
			$upload_file_name = $upload_data['file_name'];
			$data = array(
				'others_recording'=>$other_remark
			);

			$other_data = array(
				'record_id'=>$record_id,
				'filename'=>$upload_file_name
			);

			// insert to rate_info
			$this->recording_model->update($record_id, $data);

			$this->otherrecordingsfile_model->insert($other_data);
			$this->session->set_flashdata('success', 'Your other recordings has been added');
			redirect("qm/qm_form/$record_id/$userid");
			exit;
		}else{
			$data = array(
				'others_recording'=>$other_remark
			);
			$this->recording_model->update($record_id, $data);
			$this->session->set_flashdata('success', 'Your other recordings has been added');
			redirect("qm/qm_form/$record_id/$userid");
			exit;
		}
	}

	function submit_other_recording3()
	{
		$data = array();
		$other_remark = $this->input->post('other_remark');
		$record_id = $this->input->post('others_record_id');
		$userid = $this->input->post('userid');
		$upload = $this->input->post('upload');
		//var_dump($upload);
		$upload_file_name = '';
		$config['upload_path'] = './assets/record_file/';
		$config['allowed_types'] = 'gif|jpg|png|GIF|JPG|PNG|txt|doc|docs|csv|html|log|text|swf|pdf';
		$config['max_size']	= 1000000;
		//$config['encrypt_name']  = TRUE;

		$this->load->library('upload', $config);

		if($this->upload->do_upload('upload'))
		{
			$upload_data = $this->upload->data();
			$upload_file_name = $upload_data['file_name'];
			$data = array(
				'others_recording'=>$other_remark
			);

			$other_data = array(
				'record_id'=>$record_id,
				'filename'=>$upload_file_name
			);

			// insert to rate_info
			$this->recording_model->update($record_id, $data);
			$this->otherrecordingsfile_model->insert($other_data);
			$this->session->set_flashdata('success', 'Your other recordings has been added');
			redirect("qm/qm_form_pending_save/$record_id/$userid");
			exit;
		}else{
			$data = array(
				'others_recording'=>$other_remark
			);
			$this->recording_model->update($record_id, $data);
			$this->session->set_flashdata('success', 'Your other recordings has been added');
			redirect("qm/qm_form_pending_save/$record_id/$userid");
			exit;
		}

	}

	## Delete voice tag ##
	function ajax_delete_voice_tag()
	{
		$voice_tag_id = $this->input->post('id');

		if($this->voicetag_model->delete($voice_tag_id)){
			$msg = "success";
			echo json_encode($msg);
		}
		else
		{
			$msg = "error";
			echo json_encode($msg);
		}
	}

	// submit qm form
	function submit_qm_form()
	{
		$data = array();
		$data['page'] = 'submit_qm_form';

		$userid = $this->input->post('userid');
		$lastname = $this->input->post('lastname');
		$firstname = $this->input->post('firstname');
		$connecttime = $this->input->post('connecttime');
		$extension = $this->input->post('extension');
		$callerid = $this->input->post('callerid');
		$record_id = $this->input->post('record_id');
		$qm_title = $this->input->post('qm_title');
		$qm_id = $this->input->post('qm_id');
		$question_overall_remark = $this->input->post('question_overall_remark');
		$recording_type = $this->input->post('recording_type');
		$monitoring_type = $this->input->post('monitoring_type');

		$this->load->model('rateinfo_model');
		$this->load->model('rateinfocriteria_model');
		$this->load->model('rateinfoquestion_model');
		$rate_info_data = array();

		$rate_info_data = array(
			'userid'=>$userid,
			'lastname'=>$lastname,
			'firstname'=>$firstname,
			'connecttime'=>$connecttime,
			'extension'=>$extension,
			'callerid'=>$callerid,
			'record_id'=>$record_id,
			'qm_title'=>$qm_title,
			'qm_id'=>$qm_id,
		);
		// insert to rate_info
		$this->rateinfo_model->insert($rate_info_data);

		foreach(array_unique($this->input->post('criteria_id')) as $criteria)
		{
			$row = $this->criteria_model->get($criteria);

			$criteria_rate_info_data = array(
				'criteria_id'=>$row->criteria_id,
				'criteria_title'=>$row->criteria_title,
				'criteria_rate'=>$row->criteria_rate,
				'record_id'=>$record_id,
			);
			$this->rateinfocriteria_model->insert($criteria_rate_info_data);
			//var_dump($criteria);
		}

		foreach($this->input->post('criteria_id') as $criteria_row)
		{
			$criteria_id[] = $criteria_row;
		}
		$index = 1;
		$index2 = 1;
		$rm = 1;
		$criteria_index = 0;

		foreach($this->input->post('question_id') as $question)
		{
			$count_index = "type_n_".$index;
			$count_index2 = "fatal_".$index2;

			$question_remark_index = "question_remark_".$rm;
			$answer = $this->input->post($count_index);
			$fatal_answer = $this->input->post($count_index2);
			$question_remark = $this->input->post($question_remark_index);

			$row2 = $this->question_model->get($question);
			if($row2->question_format == 1){
				$rate_info_question_data = array(
					'criteria_id'=>$criteria_id[$criteria_index],
					'question_id'=>$question,
					'question_title'=>$row2->question_title,
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'record_id'=>$record_id,
					'question_major'=>$answer,
				);
			}else if($row2->question_format == 2){
				$rate_info_question_data = array(
					'criteria_id'=>$criteria_id[$criteria_index],
					'question_id'=>$question,
					'question_title'=>$row2->question_title,
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'record_id'=>$record_id,
					'question_minor'=>$answer,
				);
			}else if($row2->question_format == 3){
				$rate_info_question_data = array(
					'criteria_id'=>$criteria_id[$criteria_index],
					'question_id'=>$question,
					'question_title'=>$row2->question_title,
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'record_id'=>$record_id,
					'question_fatal'=>$fatal_answer
				);
			}else if($row2->question_format == 4){
				$rate_info_question_data = array(
					'criteria_id'=>$criteria_id[$criteria_index],
					'question_id'=>$question,
					'question_title'=>$row2->question_title,
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'record_id'=>$record_id,
					'question_cb'=>$answer,
				);
			}else if($row2->question_format == 5){
				$rate_info_question_data = array(
					'criteria_id'=>$criteria_id[$criteria_index],
					'question_id'=>$question,
					'question_title'=>$row2->question_title,
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'record_id'=>$record_id,
					'question_cc'=>$answer
				);
			}else if($row2->question_format == 6){
				$rate_info_question_data = array(
					'criteria_id'=>$criteria_id[$criteria_index],
					'question_id'=>$question,
					'question_title'=>$row2->question_title,
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'record_id'=>$record_id,
					'question_nc'=>$answer
				);
			}else{
				$rate_info_question_data = array(
					'criteria_id'=>$criteria_id[$criteria_index],
					'question_id'=>$question,
					'question_title'=>$row2->question_title,
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'record_id'=>$record_id,
					'question_fatal'=>$fatal_answer
				);
			}
			$this->rateinfoquestion_model->insert($rate_info_question_data);
			$index++;
			$index2++;
			$rm++;
			$criteria_index++;
		}

		$record_data_array = array(
			'status'=>5,
			'monitoring_type'=>$monitoring_type
		);
		$update_id = $this->recording_model->update($record_id, $record_data_array);


		redirect("qm/submit_final_score/$record_id/$userid/$qm_id");

	}

	function submit_final_score()
	{
		$this->load->model('rateinfoquestion_model');

		$record_id = $this->uri->segment(3);
		$userid = $this->uri->segment(4);
		$qm_id = $this->uri->segment(5);

		$get_qm = $this->qm_model->get($qm_id);

		$weightage = $get_qm->weightage;
		$major_rate = $get_qm->major_rate;
		$minor_rate = $get_qm->minor_rate;

		## calculate minor and major weightage = 1 ##
		if($weightage == 1){

			## check fatal if fatal failed one, then all score become 0 ###
			$get_fatal_only = $this->rateinfoquestion_model->get_fatal_only($record_id);

			foreach($get_fatal_only as $fatal_row){
				if($fatal_row->question_fatal == 1){
					$this->rateinfoquestion_model->update_by(array('record_id'=>$record_id), array('final_score'=>0,'question_major_total'=>0,'question_minor_total'=>0));
				}
				$this->session->set_flashdata('success', 'Your form score have been successfully submitted');
				redirect("qm/qm_form_pending_save/$record_id/$userid");
				exit;
			}
			## end check fatal ##

			## check if got N / A ##
			$check_major_na = $this->rateinfoquestion_model->check_major_na($record_id);

			$check_minor_na = $this->rateinfoquestion_model->check_minor_na($record_id);

			## get total row major ##
			$get_total_row_major = $this->question_model->get_total_row_major($qm_id,$record_id);
			$total_row_major = $get_total_row_major[0]->total_major;

			## get total row minor ##
			$get_total_row_minor = $this->question_model->get_total_row_minor($qm_id,$record_id);
			$total_row_minor = $get_total_row_minor[0]->total_minor;

			## get total score of major only ##
			$get_total_major_score = $this->rateinfoquestion_model->get_major_only($record_id);
			$total_major_score = $get_total_major_score[0]->total_major_score;
			## get total score of minor only ##
			$get_total_minor_score = $this->rateinfoquestion_model->get_minor_only($record_id);
			$total_minor_score = $get_total_minor_score[0]->total_minor_score;

			## check if got N /A ##
			if($check_major_na[0]->question_major == 9911){
				$total_major_score1 = $total_major_score + $check_major_na[0]->total_major_na;
			}else{
				$total_major_score1 = $get_total_major_score[0]->total_major_score;
			}

			if($check_minor_na[0]->question_minor == 9911){
				$total_minor_score1 = $total_minor_score + $check_minor_na[0]->total_minor_na;
			}else{
				$total_minor_score1 = $get_total_minor_score[0]->total_minor_score;
			}
			################# major minor calculation start ###################
			$total_major = 0;
			$total_minor = 0;
			$major_result = 0;
			$minor_result = 0;
			$total_major_minor_score = 0;
			#### step 1 major calculation #######
			$major_result = (float) $total_major_score1 / (float) $total_row_major;

			$total_major = $major_result * 100;

			#### step 2 minor calculation #######
			$minor_result = (float) $total_minor_score1 / (float) $total_row_minor;

			$total_minor = $minor_result * 100;

			#### step 3 minor + major calculation #######
			$total_major_minor_score = ( (float) $major_result * (float) $major_rate ) + ( (float) $minor_result * (float) $minor_rate );

			if($total_major_minor_score != 100 || $total_major_minor_score != 0 )
			{
				if ( strpos( $total_major_minor_score, '.' ) === false ){
					$total_major_minor_score_final = $total_major_minor_score;
				}else{
					$total_major_minor_score_final = number_format((float)$total_major_minor_score, 2, '.', '');
				}
			}

			if($total_major != 100 || $total_major != 0 ){
				if ( strpos( $total_major, '.' ) === false ){
					$total_major_final = $total_major;
				}else{
					$total_major_final = number_format((float)$total_major, 2, '.', '');
				}
			}

			if($total_minor != 100 || $total_minor != 0 ){

				if ( strpos( $total_minor, '.' ) === false ){
					$total_minor_final = $total_minor;
				}else{
					$total_minor_final = number_format((float)$total_minor, 2, '.', '');
				}
			}

			################# major minor calculation end ###################

			$this->rateinfoquestion_model->update_by(array('record_id'=>$record_id), array('final_score'=>$total_major_minor_score_final,'question_major_total'=>$total_major_final,'question_minor_total'=>$total_minor_final));

		## start calculate datacom flow ##
		}else if($weightage == 3){

		## check if got N / A ##
		$check_cb_na = $this->rateinfoquestion_model->check_cb_na($record_id);

		$check_cc_na = $this->rateinfoquestion_model->check_cc_na($record_id);

		$check_nc_na = $this->rateinfoquestion_model->check_nc_na($record_id);

		## get total score of critical business ##
		$get_total_cb_score = $this->rateinfoquestion_model->get_cb_only($record_id);
		$total_cb_score = $get_total_cb_score[0]->total_cb_score;

		## get total score of critical customer ##
		$get_total_cc_score = $this->rateinfoquestion_model->get_cc_only($record_id);
		$total_cc_score = $get_total_cc_score[0]->total_cc_score;

		## get total score of non critical ##
		$get_total_nc_score = $this->rateinfoquestion_model->get_nc_only($record_id);
		$total_nc_score = $get_total_nc_score[0]->total_nc_score;

		## get total question of critical business ##
		$get_total_row_critical_business = $this->question_model->get_total_row_cb($qm_id,$record_id);
		$total_row_critical_business = $get_total_row_critical_business[0]->total_cb;

		## get total question of critical customer ##
		$get_total_row_critical_customer = $this->question_model->get_total_row_cc($qm_id,$record_id);
		$total_row_critical_customer = $get_total_row_critical_customer[0]->total_cc;

		## get total question of non critical ##
		$get_total_row_non_critical = $this->question_model->get_total_row_nc($qm_id,$record_id);
		$total_row_non_critical = $get_total_row_non_critical[0]->total_nc;

		## check if got N /A ##
		if($check_cb_na[0]->question_cb == 9911){
			$total_cb_score = $total_cb_score + $check_cb_na[0]->total_cb_na;
		}else{
			$total_cb_score = $get_total_cb_score[0]->total_cb_score;
		}

		if($check_cc_na[0]->question_cc == 9911){
			$total_cc_score = $total_cc_score + $check_cc_na[0]->total_cc_na;
		}else{
			$total_cc_score = $get_total_cc_score[0]->total_cc_score;
		}

		if($check_nc_na[0]->question_nc == 9911){
			$total_nc_score = $total_nc_score + $check_nc_na[0]->total_nc_na;
		}else{
			$total_nc_score = $get_total_nc_score[0]->total_nc_score;
		}

		## calculation start here ##

		$total_cb = 0;
		$total_cc = 0;
		$total_nc = 0;
		$cb_result = 0;
		$cc_result = 0;
		$nc_result = 0;

		## critical business calculation ##
		$cb_result = (float) $total_cb_score / (float) $total_row_critical_business;

		$total_cb = $cb_result * 100;

		## critical customer calculation ##
		$cc_result = (float) $total_cc_score / (float) $total_row_critical_customer;

		$total_cc = $cc_result * 100;

		## critical business calculation ##
		$nc_result = (float) $total_nc_score / (float) $total_row_non_critical;

		$total_nc = $nc_result * 100;

/* 		$total_cb = number_format((float)$total_cb, 2, '.', '');
		$total_cc = number_format((float)$total_cc, 2, '.', '');
		$total_nc = number_format((float)$total_nc, 2, '.', ''); */

		$this->rateinfoquestion_model->update_by(array('record_id'=>$record_id), array('question_cb_total'=>$total_cb,'question_cc_total'=>$total_cc,'question_nc_total'=>$total_nc));

		## end calculation datacom ##
		}else{

			######### Calculate without minor and major final score ##############

			############# check fatal 1st ################
			$get_fatal_only = $this->rateinfoquestion_model->get_fatal_only($record_id);

			foreach($get_fatal_only as $fatal_row){
				if($fatal_row->question_fatal == 1){
					$this->rateinfoquestion_model->update_by(array('record_id'=>$record_id,'criteria_id'=>$criteria_id2), array('final_score'=>0,'question_score_total'=>0));
				}
				$this->session->set_flashdata('success', 'Your form score have been successfully submitted');
				redirect("qm/qm_form_pending_save/$record_id/$userid");
				exit;
			}

			$query = $this->rateinfoquestion_model->join_criteria($record_id);

			$top_total_value = 0;
			$total = 0;
			$total_score = 0;

			// get total score where supervisor was scored
			foreach($query as $row3){
				$criteria_rate = $row3->criteria_rate;
				$total_question_score = $row3->total_question_score;
				$total_question = $row3->total_question;
				$question_top_score = $row3->question_top_score;
				$question_id2 = $row3->question_id;
				$criteria_id2 = $row3->criteria_id;

				$criteria_rate = (float) $criteria_rate;
				$total = (float) $total;
				$top_total_value = (float) $top_total_value;
				$total_question_score = (float) $total_question_score;
				$question_top_score = (float) $question_top_score;

				$total = $total_question_score / $question_top_score;
				$total = $total * 100;

				$criteria_rate_score = $criteria_rate * 0.01;
				$total_score = $total * $criteria_rate_score;

				$this->rateinfoquestion_model->update_by(array('record_id'=>$record_id,'criteria_id'=>$criteria_id2), array('final_score'=>$total_score,'question_score_total'=>$total_question_score));
			}
		}
		############### End Of final score#################

		$this->session->set_flashdata('success', 'Your form score have been successfully submitted');
		redirect("qm/qm_form_pending_save/$record_id/$userid");
	}
	function edit_score_qm_form()
	{
		$data = array();
		$data['page'] = 'edit_score_qm_form';

		$record_id = $this->input->post('record_id');
		$qm_id = $this->input->post('qm_id');
		$recover = $this->input->post('recover');
		$monitoring_type = $this->input->post('monitoring_type');

		$question_overall_remark = $this->input->post('question_overall_remark');
		$this->load->model('rateinfo_model');
		$this->load->model('rateinfocriteria_model');
		$this->load->model('rateinfoquestion_model');

		if($recover == 1){
			$recover_data = array(
				'recover'=>$recover,
				'monitoring_type'=>$monitoring_type
			);
			$this->recording_model->update($record_id, $recover_data);
		}else{
			$recover_data = array(
				'recover'=>0,
				'monitoring_type'=>$monitoring_type
			);
			$this->recording_model->update($record_id, $recover_data);
		}

		foreach($this->input->post('criteria_id') as $criteria_row)
		{
			$criteria_id[] = $criteria_row;
		}
		$index = 1;
		$rm = 1;
		$criteria_index = 0;

		foreach($this->input->post('question_id') as $question)
		{
			$count_index = "type_n_".$index;
			$count_index2 = "fatal_".$index;
			$question_remark_index = "question_remark_".$rm;
			$answer = $this->input->post($count_index);
			$fatal_answer = $this->input->post($count_index2);
			$question_remark = $this->input->post($question_remark_index);

			$row2 = $this->question_model->get($question);
			if($row2->question_format == 1){
				$rate_info_question_data = array(
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'question_major'=>$answer
				);
			}else if($row2->question_format == 2){
				$rate_info_question_data = array(
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'question_minor'=>$answer
				);
			}else if($row2->question_format == 3){
				$rate_info_question_data = array(
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'question_major'=>$answer,
					'question_fatal'=>$fatal_answer
				);
			}else if($row2->question_format == 4){
				$rate_info_question_data = array(
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'question_cb'=>$answer,
				);
			}else if($row2->question_format == 5){
				$rate_info_question_data = array(
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'question_cc'=>$answer
				);
			}else if($row2->question_format == 6){
				$rate_info_question_data = array(
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'question_nc'=>$answer
				);
			}else{
				$rate_info_question_data = array(
					'question_score'=>$answer,
					'question_remark'=>$question_remark,
					'question_overall_remark'=>$question_overall_remark,
					'question_fatal'=>$fatal_answer
				);
			}
			$this->rateinfoquestion_model->update_by(array('question_id'=>$question,'record_id'=>$record_id,'criteria_id'=>$criteria_id[$criteria_index]),$rate_info_question_data);

			$index++;
			$rm++;
			$criteria_index++;
		}
		//$update_id = $this->recording_model->update($record_id, array('status'=>'5'));


		######### Calculate final score ##############
		$get_qm = $this->qm_model->get($qm_id);

		$weightage = $get_qm->weightage;
		$major_rate = $get_qm->major_rate;
		$minor_rate = $get_qm->minor_rate;

		## calculate minor and major weightage = 1 ##
		if($weightage == 1){

			## check fatal if fatal failed one, then all score become 0 ###
			$get_fatal_only = $this->rateinfoquestion_model->get_fatal_only($record_id);

			foreach($get_fatal_only as $fatal_row){
				if($fatal_row->question_fatal == 1){
					$this->rateinfoquestion_model->update_by(array('record_id'=>$record_id), array('final_score'=>0,'question_major_total'=>0,'question_minor_total'=>0));
				}
				$this->session->set_flashdata('success', 'Your form have been successfully Updated');
				redirect("qm/qm_form_pending_save/$record_id/$userid");
				exit;
			}
			## end check fatal ##

			## check if got N / A ##
			$check_major_na = $this->rateinfoquestion_model->check_major_na($record_id);

			$check_minor_na = $this->rateinfoquestion_model->check_minor_na($record_id);

			## get total row major ##
			$get_total_row_major = $this->question_model->get_total_row_major($qm_id,$record_id);
			$total_row_major = $get_total_row_major[0]->total_major;

			## get total row minor ##
			$get_total_row_minor = $this->question_model->get_total_row_minor($qm_id,$record_id);
			$total_row_minor = $get_total_row_minor[0]->total_minor;

			## get total score of major only ##
			$get_total_major_score = $this->rateinfoquestion_model->get_major_only($record_id);
			$total_major_score = $get_total_major_score[0]->total_major_score;

			## get total score of minor only ##
			$get_total_minor_score = $this->rateinfoquestion_model->get_minor_only($record_id);
			$total_minor_score = $get_total_minor_score[0]->total_minor_score;

			## check if got N /A ##
			if($check_major_na[0]->question_major == 9911){
				$total_major_score1 = $total_major_score + $check_major_na[0]->total_major_na;
			}else{
				$total_major_score1 = $get_total_major_score[0]->total_major_score;
			}

			if($check_minor_na[0]->question_minor == 9911){
				$total_minor_score1 = $total_minor_score + $check_minor_na[0]->total_minor_na;
			}else{
				$total_minor_score1 = $get_total_minor_score[0]->total_minor_score;
			}

			################# major minor calculation start ###################
			$total_major = 0;
			$total_minor = 0;
			$major_result = 0;
			$minor_result = 0;
			$total_major_minor_score = 0;
			#### step 1 major calculation #######
			$major_result = (float) $total_major_score1 / (float) $total_row_major;

			$total_major = $major_result * 100;

			#### step 2 minor calculation #######
			$minor_result = (float) $total_minor_score1 / (float) $total_row_minor;

			$total_minor = $minor_result * 100;

			#### step 3 minor + major calculation #######
			$total_major_minor_score = ( (float) $major_result * (float) $major_rate ) + ( (float) $minor_result * (float) $minor_rate );

			################# major minor calculation end ###################

			if($total_major_minor_score != 100 || $total_major_minor_score != 0 )
			{
				if ( strpos( $total_major_minor_score, '.' ) === false ){
					$total_major_minor_score_final = $total_major_minor_score;
				}else{
					$total_major_minor_score_final = number_format((float)$total_major_minor_score, 2, '.', '');
				}
			}

			if($total_major != 100 || $total_major != 0 ){
				if ( strpos( $total_major, '.' ) === false ){
					$total_major_final = $total_major;
				}else{
					$total_major_final = number_format((float)$total_major, 2, '.', '');
				}
			}

			if($total_minor != 100 || $total_minor != 0 ){

				if ( strpos( $total_minor, '.' ) === false ){
					$total_minor_final = $total_minor;
				}else{
					$total_minor_final = number_format((float)$total_minor, 2, '.', '');
				}
			}

			$this->rateinfoquestion_model->update_by(array('record_id'=>$record_id), array('final_score'=>$total_major_minor_score_final,'question_major_total'=>$total_major_final,'question_minor_total'=>$total_minor_final));

		}else if($weightage == 3){
				## check if got N / A ##
			$check_cb_na = $this->rateinfoquestion_model->check_cb_na($record_id);

			$check_cc_na = $this->rateinfoquestion_model->check_cc_na($record_id);

			$check_nc_na = $this->rateinfoquestion_model->check_nc_na($record_id);

			## get total score of critical business ##
			$get_total_cb_score = $this->rateinfoquestion_model->get_cb_only($record_id);
			$total_cb_score = $get_total_cb_score[0]->total_cb_score;

			## get total score of critical customer ##
			$get_total_cc_score = $this->rateinfoquestion_model->get_cc_only($record_id);
			$total_cc_score = $get_total_cc_score[0]->total_cc_score;

			## get total score of non critical ##
			$get_total_nc_score = $this->rateinfoquestion_model->get_nc_only($record_id);
			$total_nc_score = $get_total_nc_score[0]->total_nc_score;


			## get total question of critical business ##
			$get_total_row_critical_business = $this->question_model->get_total_row_cb($qm_id,$record_id);
			$total_row_critical_business = $get_total_row_critical_business[0]->total_cb;

			## get total question of critical customer ##
			$get_total_row_critical_customer = $this->question_model->get_total_row_cc($qm_id,$record_id);
			$total_row_critical_customer = $get_total_row_critical_customer[0]->total_cc;

			## get total question of non critical ##
			$get_total_row_non_critical = $this->question_model->get_total_row_nc($qm_id,$record_id);
			$total_row_non_critical = $get_total_row_non_critical[0]->total_nc;

			## check if got N /A ##
			if($check_cb_na[0]->question_cb == 9911){
				$total_cb_score = $total_cb_score + $check_cb_na[0]->total_cb_na;
			}else{
				$total_cb_score = $get_total_cb_score[0]->total_cb_score;
			}

			if($check_cc_na[0]->question_cc == 9911){
				$total_cc_score = $total_cc_score + $check_cc_na[0]->total_cc_na;
			}else{
				$total_cc_score = $get_total_cc_score[0]->total_cc_score;
			}

			if($check_nc_na[0]->question_nc == 9911){
				$total_nc_score = $total_nc_score + $check_nc_na[0]->total_nc_na;
			}else{
				$total_nc_score = $get_total_nc_score[0]->total_nc_score;
			}

			## calculation start here ##

			$total_cb = 0;
			$total_cc = 0;
			$total_nc = 0;
			$cb_result = 0;
			$cc_result = 0;
			$nc_result = 0;

			## critical business calculation ##
			$cb_result = (float) $total_cb_score / (float) $total_row_critical_business;

			$total_cb = $cb_result * 100;

			## critical customer calculation ##
			$cc_result = (float) $total_cc_score / (float) $total_row_critical_customer;

			$total_cc = $cc_result * 100;

			## critical business calculation ##
			$nc_result = (float) $total_nc_score / (float) $total_row_non_critical;

			$total_nc = $nc_result * 100;

/* 			$total_cb = number_format((float)$total_cb, 2, '.', '');
			$total_cc = number_format((float)$total_cc, 2, '.', '');
			$total_nc = number_format((float)$total_nc, 2, '.', ''); */

			$this->rateinfoquestion_model->update_by(array('record_id'=>$record_id), array('question_cb_total'=>$total_cb,'question_cc_total'=>$total_cc,'question_nc_total'=>$total_nc));
		}else{

			############# check fatal 1st ################
			$get_fatal_only = $this->rateinfoquestion_model->get_fatal_only($record_id);

			foreach($get_fatal_only as $fatal_row){
				if($fatal_row->question_fatal == 1){
					$this->rateinfoquestion_model->update_by(array('record_id'=>$record_id,'criteria_id'=>$criteria_id2), array('final_score'=>0,'question_score_total'=>0));
				}
				$this->session->set_flashdata('success', 'Your form have been successfully Updated');
				redirect("qm/qm_form_pending_save/$record_id/$userid");
				exit;
			}

			$query = $this->rateinfoquestion_model->join_criteria($record_id);
			$top_total_value = 0;
			$total = 0;
			$total_score = 0;

			// get total score where supervisor was scored
			foreach($query as $row){

				$criteria_rate = $row->criteria_rate;
				$total_question_score = $row->total_question_score;
				$total_question = $row->total_question;
				$question_top_score = $row->question_top_score;
				$question_id2 = $row->question_id;
				$criteria_id2 = $row->criteria_id;

				$criteria_rate = (float) $criteria_rate;
				$total = (float) $total;
				$top_total_value = (float) $top_total_value;
				$total_question_score = (float) $total_question_score;
				$question_top_score = (float) $question_top_score;

				$total = $total_question_score / $question_top_score;
				$total = $total * 100;

				$criteria_rate_score = $criteria_rate * 0.01;
				$total_score = $total * $criteria_rate_score;

				$this->rateinfoquestion_model->update_by(array('record_id'=>$record_id,'criteria_id'=>$criteria_id2), array('final_score'=>$total_score,'question_score_total'=>$total_question_score));

			}
		}
		############### End Of final score#################

		$this->session->set_flashdata('success', 'Your form have been successfully Updated');
		redirect("qm/qm_form_pending_save/$record_id/$userid");
	}


	function qm_form()
	{
		//$reportcallcenter = $this->load->database('reportcallcenter', TRUE);
		$data = array();
		$data['page'] = 'qm_form';
		$record_id = $this->uri->segment(3);
		$userid = $this->uri->segment(4);
		$this->load->model('recqm_model');

		$recording_query = $this->recording_model->get($record_id);

		$recording_type = $recording_query->recording_type;

		// get qm_id
		$query_qm_id = $this->recqm_model->get_record_id($record_id)->get_all();

		$qm_id = $query_qm_id[0]->qm_id;

		//$userid = $this->session->userdata('userid');

		if($query = $this->recqm_model->join_qm_recording($record_id,$qm_id,$userid,$recording_type)->get_all())
		{
			$data['recording_record'] = $query;
		}

		if($voicetag_query = $this->voicetag_model->get_voice_tag($record_id)->get_all());
		{
			$data['voicetag_record'] = $voicetag_query;
		}


		if($other_recording_file_query = $this->otherrecordingsfile_model->get_record($record_id)->get_all());
		{
			$data['otherrecordingsfile_record'] = $other_recording_file_query;
		}

		if($chatmessage_record_query = $this->chatmessage_model->get_user($record_id)->get_all());
		{
			$data['chatmessage_record'] = $chatmessage_record_query;
		}

		$data['qm_title'] = $query[0]->qm_title;
		$data['record_filename'] = $query[0]->record_filename;
		$data['username'] = $query[0]->username;

		$data['userid'] = $userid;

		$data['lastname'] = $query[0]->lastname;
		$data['firstname'] = $query[0]->firstname;

		if($recording_type == 1){
			$data['connecttime'] = $query[0]->connecttime;
			$data['extension'] = $query[0]->extension;
			$data['callerid'] = $query[0]->callerid;
			$data['queuename'] = $query[0]->queuename;
		}
		$data['record_id'] = $record_id;
		$data['qm_id'] = $qm_id;
		$data['recording_type'] = $query[0]->recording_type;
		$data['others_recording'] = $query[0]->others_recording;

		$data['main'] = 'qm/qm_form';
		$data['js_function'] = array('qm');
		$this->load->view('template/template',$data);
	}

	function qm_form_pending_save()
	{
		//$reportcallcenter = $this->load->database('reportcallcenter', TRUE);
		$data = array();
		$data['page'] = 'qm_form';
		$record_id = $this->uri->segment(3);
		$userid = $this->uri->segment(4);
		$this->load->model('recqm_model');

		$recording_query = $this->recording_model->get($record_id);

		$recording_type = $recording_query->recording_type;


		// get qm_id
		$userid = $this->session->userdata('userid');

		################## check recording type whether is voice or chat or others recording ####################
		if($recording_type == 1){
			if($query = $this->recording_model->join_submitted_recording($record_id)->get_all())
			{
				$data['recording_record'] = $query;
			}

		}else if($recording_type == 2){
			$this->load->model('chatrecording_model');
			if($query = $this->chatrecording_model->join_submitted_recording($record_id)->get_all())
			{
				$data['recording_record'] = $query;
			}

		}else if($recording_type == 3){
			$this->load->model('otherrecording_model');
			if($query = $this->otherrecording_model->join_submitted_recording($record_id)->get_all())
			{
				$data['recording_record'] = $query;
			}

		}
		################## End check recording type whether is voice or chat or others recording ####################

		$this->load->model('rateinfoquestion_model');
		if($query2 = $this->rateinfoquestion_model->sort_criteria($record_id)->get_all())
		{
			$data['final_score_record'] = $query2;
		}

		if($query3 = $this->rateinfoquestion_model->sum_question_point($record_id))
		{
			$data['sum_question_point'] = $query3;
		}

		if($voicetag_query = $this->voicetag_model->get_voice_tag($record_id)->get_all());
		{
			$data['voicetag_record'] = $voicetag_query;
		}

		if($chatmessage_record_query = $this->chatmessage_model->get_user($record_id)->get_all());
		{
			$data['chatmessage_record'] = $chatmessage_record_query;
		}

		if($other_recording_file_query = $this->otherrecordingsfile_model->get_record($record_id)->get_all());
		{
			$data['otherrecordingsfile_record'] = $other_recording_file_query;
		}


		$qm_id = $query[0]->qm_id;
		$weightage = $query[0]->weightage;
		if($weightage == 3){
			if($qm_level_rate_query = $this->qm_level_rate_model->get_qm_level($qm_id)->get_all());
			{
				$data['qm_level_rate_record'] = $qm_level_rate_query;
			}
		}

		$data['qm_title'] = $query[0]->qm_title;
		$data['record_filename'] = $query[0]->record_filename;
		$data['username'] = $query[0]->username;

		$data['userid'] = $userid;

		if($recording_type == 1){
			$data['connecttime'] = $query[0]->connecttime;
			$data['extension'] = $query[0]->extension;
			$data['callerid'] = $query[0]->callerid;
			//$data['queuename'] = $query[0]->queuename;
		}
		$data['recover'] = $query[0]->recover;
		$data['monitoring_type'] = $query[0]->monitoring_type;
		$data['lastname'] = $query[0]->lastname;
		$data['firstname'] = $query[0]->firstname;
		$data['record_id'] = $record_id;
		$data['qm_id'] = $query[0]->qm_id;
		$data['recording_type'] = $query[0]->recording_type;
		$data['others_recording'] = $query[0]->others_recording;

		$data['main'] = 'qm/qm_form_pending_save';
		$data['js_function'] = array('qm');
		$this->load->view('template/template',$data);

	}

	function qm_form_complete()
	{
		//$reportcallcenter = $this->load->database('reportcallcenter', TRUE);
		$data = array();
		$data['page'] = 'qm_form';
		$record_id = $this->uri->segment(3);
		$userid = $this->uri->segment(4);
		$this->load->model('recqm_model');

		$this->load->model('rateinfoquestion_model');
		if($query2 = $this->rateinfoquestion_model->sort_criteria($record_id)->get_all())
		{
			$data['final_score_record'] = $query2;
		}

		$recording_query = $this->recording_model->get($record_id);

		$recording_type = $recording_query->recording_type;
		// get qm_id
		$userid = $this->session->userdata('userid');

		################## check recording type whether is voice or chat or others recording ####################
		if($recording_type == 1){
			if($query = $this->recording_model->join_submitted_recording($record_id)->get_all())
			{
				$data['recording_record'] = $query;
			}

		}else if($recording_type == 2){
			$this->load->model('chatrecording_model');
			if($query = $this->chatrecording_model->join_submitted_recording($record_id)->get_all())
			{
				$data['recording_record'] = $query;
			}

		}else if($recording_type == 3){
			$this->load->model('otherrecording_model');
			if($query = $this->otherrecording_model->join_submitted_recording($record_id)->get_all())
			{
				$data['recording_record'] = $query;
			}

		}
		################## End check recording type whether is voice or chat or others recording ####################

		if($voicetag_query = $this->voicetag_model->get_voice_tag($record_id)->get_all());
		{
			$data['voicetag_record'] = $voicetag_query;
		}

		if($chatmessage_record_query = $this->chatmessage_model->get_user($record_id)->get_all());
		{
			$data['chatmessage_record'] = $chatmessage_record_query;
		}

		$qm_id = $query[0]->qm_id;
		$weightage = $query[0]->weightage;
		if($weightage == 3){
			if($qm_level_rate_query = $this->qm_level_rate_model->get_qm_level($qm_id)->get_all());
			{
				$data['qm_level_rate_record'] = $qm_level_rate_query;
			}
		}

		$data['qm_title'] = $query[0]->qm_title;
		$data['record_filename'] = $query[0]->record_filename;
		$data['username'] = $query[0]->username;
		$data['connecttime'] = $query[0]->connecttime;
		$data['userid'] = $userid;
		$data['callerid'] = $query[0]->callerid;
		$data['recover'] = $query[0]->recover;
		$data['monitoring_type'] = $query[0]->monitoring_type;
		//$data['queuename'] = $query[0]->queuename;
		$data['lastname'] = $query[0]->lastname;
		$data['firstname'] = $query[0]->firstname;
		$data['connecttime'] = $query[0]->connecttime;
		$data['extension'] = $query[0]->extension;
		$data['record_id'] = $record_id;
		$data['recording_type'] = $query[0]->recording_type;
		$data['others_recording'] = $query[0]->others_recording;
		//$data['qm_id'] = $qm_id;

		$data['main'] = 'qm/qm_form_complete';
		$data['js_function'] = array('qm');
		$this->load->view('template/template',$data);

	}

	function index()
	{
		$data = array();
		$data['page'] = 'qm';
		$tenant_id = $this->session->userdata('tenant_id');
		if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
		{
			$data['data_record'] = $query;
		}

		if($qm_level_rate_query = $this->qm_level_rate_model->sort_level()->get_all())
		{
			$data['qm_level_rate_record'] = $qm_level_rate_query;
		}
		$data['main'] = 'qm/index';
		$data['js_function'] = array('qm');
		$this->load->view('template/template',$data);
	}

	function add_qm()
	{
		$this->load->library('form_validation');
		$weightage = $this->input->post('weightage');
		$this->form_validation->set_rules('qm_title', 'QM Title', 'required|trim');
		$this->form_validation->set_rules('weightage', 'Weightage Type', 'trim|required');
		if($weightage == 1){
			$this->form_validation->set_rules('major_rate', 'Major Rate', 'trim|numeric|required');
			$this->form_validation->set_rules('minor_rate', 'Minor Rate', 'trim|numeric|required');
		}
		if($weightage == 3){
			$this->form_validation->set_rules('level_1_min_rate', 'Level 1 Minimum Rate', 'trim|numeric|required');
			$this->form_validation->set_rules('level_2_min_rate', 'Level 2 Minimum Rate', 'trim|numeric|required');
			$this->form_validation->set_rules('level_3_min_rate', 'Level 3 Minimum Rate', 'trim|numeric|required');
			$this->form_validation->set_rules('level_1_max_rate', 'Level 1 Maximum Rate', 'trim|numeric|required');
			$this->form_validation->set_rules('level_2_max_rate', 'Level 2 Maximum Rate', 'trim|numeric|required');
			$this->form_validation->set_rules('level_3_max_rate', 'Level 3 Maximum Rate', 'trim|numeric|required');
		}
		$this->form_validation->set_message('is_unique', 'The %s already exist.');

		if ($this->form_validation->run() === TRUE)
		{
			$tenant_id = $this->session->userdata('tenant_id');
			$qm_title = $this->input->post('qm_title');
			$major_rate = $this->input->post('major_rate');
			$minor_rate = $this->input->post('minor_rate');


			$data = array();
			$data = array(
				'qm_title'=>$qm_title,
				'major_rate'=>$major_rate,
				'minor_rate'=>$minor_rate,
				'weightage'=>$weightage,
				'tenant_id'=>$tenant_id
			);



			if ($this->qm_model->insert($data))
			{
				## if datacom ##
				if($weightage == 3){
					$qm_id = $this->db->insert_id();
					$level_1_min_rate = $this->input->post('level_1_min_rate');
					$level_2_min_rate = $this->input->post('level_2_min_rate');
					$level_3_min_rate = $this->input->post('level_3_min_rate');
					$level_1_max_rate = $this->input->post('level_1_max_rate');
					$level_2_max_rate = $this->input->post('level_2_max_rate');
					$level_3_max_rate = $this->input->post('level_3_max_rate');

					if($level_1_min_rate > $level_1_max_rate){
						$this->session->set_flashdata('error', 'Your level 1 minimum rate unable greater than maximum rate');
						redirect('qm/index');
						exit;
					}

					if($level_2_min_rate > $level_2_max_rate){
						$this->session->set_flashdata('error', 'Your level 2 minimum rate unable greater than maximum rate');
						redirect('qm/index');
						exit;
					}

					if($level_3_min_rate > $level_3_max_rate){
						$this->session->set_flashdata('error', 'Your level 3 minimum rate unable greater than maximum rate');
						redirect('qm/index');
						exit;
					}

					$data_level_1 = array(
						'qm_id'=>$qm_id,
						'level'=>1,
						'minimum_rate'=>$level_1_min_rate,
						'maximum_rate'=>$level_1_max_rate
					);

					$data_level_2 = array(
						'qm_id'=>$qm_id,
						'level'=>2,
						'minimum_rate'=>$level_2_min_rate,
						'maximum_rate'=>$level_2_max_rate
					);

					$data_level_3 = array(
						'qm_id'=>$qm_id,
						'level'=>3,
						'minimum_rate'=>$level_3_min_rate,
						'maximum_rate'=>$level_3_max_rate
					);

					$this->qm_level_rate_model->insert($data_level_1);
					$this->qm_level_rate_model->insert($data_level_2);
					$this->qm_level_rate_model->insert($data_level_3);
				}

				$this->session->set_flashdata('success', 'Your Form have been successfully added');
				redirect('qm/index');
			}
			else
			{
				$this->session->set_flashdata('error', 'Error. Please try again.');
				redirect('qm/index');
			}

		}
		else
		{
			$data = array();
			$data['page'] = 'add_qm';
/* 			if($query = $this->criteria_model->get_all())
			{
				$data['criteria_record'] = $query;
			} */
			$tenant_id = $this->session->userdata('tenant_id');
			if($query = $this->qm_model->sort_qm($tenant_id)->get_all())
			{
				$data['data_record'] = $query;
			}
			if($qm_level_rate_query = $this->qm_level_rate_model->sort_level()->get_all())
			{
				$data['qm_level_rate_record'] = $qm_level_rate_query;
			}
			$data['main'] = 'qm/index';
			$data['js_function'] = array('qm');
			$this->load->view('template/template',$data);
		}
	}

	## Delete notification ##
	function ajax_delete_row()
	{
		$qm_id = $this->input->post('qm_id');
		//$qm_id = 3;
		$this->load->model('criteriaandquestion_model');
		$this->load->model('qmandcriteria_model');
		$this->load->model('recqm_model');
		$query = $this->recqm_model->get_by('recordings_and_qm.qm_id', $qm_id);

		$errors = array_filter($query);

		if(empty($errors)){
			if($this->qm_model->delete_by(array('qm_id'=>$qm_id))){
				if($this->qmandcriteria_model->delete_by(array('qm_id'=>$qm_id))){
					if($this->criteriaandquestion_model->delete_by(array('qm_id'=>$qm_id))){
						$msg = "success";
						echo json_encode($msg);
					}else{
						$msg = "success";
						echo json_encode($msg);
					}
				}else{
					$msg = "success";
					echo json_encode($msg);
				}
			}else{
				$msg = "error";
				echo json_encode($msg);
			}
			$msg = "success";
			echo json_encode($msg);
		}
		else
		{
			$msg = "error_delete";
			echo json_encode($msg);
		}
	}

	## Delete notification ##
	function ajax_delete_other_file_row()
	{
		$other_recordings_file_id = $this->input->post('other_recordings_file_id');
		$file = $this->input->post('file');
		$path = base_url()."assets/record_file/".$file;
		$this->load->helper('file');
		delete_files($path);
		if($this->otherrecordingsfile_model->delete($other_recordings_file_id)){
			$msg = "success";
			echo json_encode($msg);
		}else{
			$msg = "error";
			echo json_encode($msg);
		}
	}

	function change_status_to_complete()
	{
		$record_id = $this->input->post('record_id');
		$date = date('Y-m-d');
		$data = array(
			'status'=>'4',
			'date_complete'=>$date
		);
		$this->recording_model->update($record_id,$data);

		$msg = site_url("qm/qm_form_complete/$record_id");
		echo json_encode($msg);
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
		$major_rate = $query->major_rate;
		$minor_rate = $query->minor_rate;
		$weightage = $query->weightage;
		$tenant_id = $query->tenant_id;

		$data = array(
			'qm_title'=>$qm_title,
			'major_rate'=>$major_rate,
			'minor_rate'=>$minor_rate,
			'weightage'=>$weightage,
			'tenant_id'=>$tenant_id
		);
		$this->qm_model->insert($data);

		## if datacom ##
		if($weightage == 3){
			$qm_level_rate = $this->qm_level_rate_model->get_many_by('qm_id',$qm_id);
			foreach($qm_level_rate as $qm_level_rate_row){

				$data_level = array(
					'qm_id'=>$qm_id,
					'level'=>$qm_level_rate_row->level,
					'minimum_rate'=>$qm_level_rate_row->minimum_rate,
					'maximum_rate'=>$qm_level_rate_row->maximum_rate
				);

				$this->qm_level_rate_model->insert($data_level);
			}
		}

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



	## edit_qm ##
	function edit_qm()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('qm_title', 'QM Title', 'required|trim');
		$weightage = $this->input->post('weightage');
		$this->form_validation->set_rules('qm_title', 'QM Title', 'required|trim');
		$this->form_validation->set_rules('weightage', 'Weightage Type', 'trim|required');
		if($weightage == 1){
			$this->form_validation->set_rules('major_rate', 'Major Rate', 'trim|numeric|required');
			$this->form_validation->set_rules('minor_rate', 'Minor Rate', 'trim|numeric|required');
		}
		if($weightage == 3){
			$this->form_validation->set_rules('level_1_min_rate', 'Level 1 Minimum Rate', 'trim|numeric|required');
			$this->form_validation->set_rules('level_2_min_rate', 'Level 2 Minimum Rate', 'trim|numeric|required');
			$this->form_validation->set_rules('level_3_min_rate', 'Level 3 Minimum Rate', 'trim|numeric|required');
			$this->form_validation->set_rules('level_1_max_rate', 'Level 1 Maximum Rate', 'trim|numeric|required');
			$this->form_validation->set_rules('level_2_max_rate', 'Level 2 Maximum Rate', 'trim|numeric|required');
			$this->form_validation->set_rules('level_3_max_rate', 'Level 3 Maximum Rate', 'trim|numeric|required');
		}

		$this->form_validation->set_message('is_unique', 'The %s already exist.');

		if ($this->form_validation->run() === TRUE)
		{
			$tenant_id = $this->session->userdata('tenant_id');
			$qm_id = $this->input->post('qm_id');
			$qm_title = $this->input->post('qm_title');
			$major_rate = $this->input->post('major_rate');
			$minor_rate = $this->input->post('minor_rate');
			$data = array();
			$data = array(
				'qm_title'=>$qm_title,
				'major_rate'=>$major_rate,
				'minor_rate'=>$minor_rate,
				'weightage'=>$weightage,
				'tenant_id'=>$tenant_id
			);

			$hash = md5($qm_id.SECRETTOKEN);
			if ($this->qm_model->update($qm_id,$data))
			{
				## if datacom ##
				if($weightage == 3){
					## delete all 1st##
					$this->qm_level_rate_model->delete_by( array('qm_id'=>$qm_id));
					$level_1_min_rate = $this->input->post('level_1_min_rate');
					$level_2_min_rate = $this->input->post('level_2_min_rate');
					$level_3_min_rate = $this->input->post('level_3_min_rate');
					$level_1_max_rate = $this->input->post('level_1_max_rate');
					$level_2_max_rate = $this->input->post('level_2_max_rate');
					$level_3_max_rate = $this->input->post('level_3_max_rate');

					if($level_1_min_rate > $level_1_max_rate){
						$this->session->set_flashdata('error', 'Your level 1 minimum rate unable greater than maximum rate');
						redirect('qm/index');
						exit;
					}

					if($level_2_min_rate > $level_2_max_rate){
						$this->session->set_flashdata('error', 'Your level 2 minimum rate unable greater than maximum rate');
						redirect('qm/index');
						exit;
					}

					if($level_3_min_rate > $level_3_max_rate){
						$this->session->set_flashdata('error', 'Your level 3 minimum rate unable greater than maximum rate');
						redirect('qm/index');
						exit;
					}

					$data_level_1 = array(
						'qm_id'=>$qm_id,
						'level'=>1,
						'minimum_rate'=>$level_1_min_rate,
						'maximum_rate'=>$level_1_max_rate
					);

					$data_level_2 = array(
						'qm_id'=>$qm_id,
						'level'=>2,
						'minimum_rate'=>$level_2_min_rate,
						'maximum_rate'=>$level_2_max_rate
					);

					$data_level_3 = array(
						'qm_id'=>$qm_id,
						'level'=>3,
						'minimum_rate'=>$level_3_min_rate,
						'maximum_rate'=>$level_3_max_rate
					);

					$this->qm_level_rate_model->insert($data_level_1);
					$this->qm_level_rate_model->insert($data_level_2);
					$this->qm_level_rate_model->insert($data_level_3);
				}

				$this->session->set_flashdata('success', 'Your form have been successfully updated');
				redirect("qm/index");
			}
			else
			{
				$this->session->set_flashdata('error', 'Error. Please try again.');
				redirect("qm/index");
			}

		}
		else
		{
			$qm_id = $this->uri->segment(3);

			$data = array();
			$tenant_id = $this->session->userdata('tenant_id');
			if($query = $this->qm_model->get_by('qm_id',$qm_id))
			{
				$data['data_records'] = $query;
			}
			if($query2 = $this->qm_model->sort_qm($tenant_id)->get_all())
			{
				$data['data_record'] = $query2;
			}

			if($qm_level_rate_query2 = $this->qm_level_rate_model->sort_level()->get_many_by('qm_id',$qm_id))
			{
				$data['qm_level_rate_records'] = $qm_level_rate_query2;
				$data['minimum_rate1'] = $qm_level_rate_query2[0]->minimum_rate;
				$data['minimum_rate2'] = $qm_level_rate_query2[1]->minimum_rate;
				$data['minimum_rate3'] = $qm_level_rate_query2[2]->minimum_rate;
				$data['maximum_rate1'] = $qm_level_rate_query2[0]->maximum_rate;
				$data['maximum_rate2'] = $qm_level_rate_query2[1]->maximum_rate;
				$data['maximum_rate3'] = $qm_level_rate_query2[2]->maximum_rate;
			}

			if($qm_level_rate_query = $this->qm_level_rate_model->sort_level_report()->get_all())
			{
				$data['qm_level_rate_record'] = $qm_level_rate_query;
			}

			$data['js_function'] = array('qm');
			$data['page'] = 'edit_qm';
			$data['main'] = 'qm/edit_qm';
			$this->load->view('template/template', $data);
		}
	}

	function preview_qm_form()
	{
		$num = 0;
		$no = 0;
		$qm_title = $this->input->post('qm_title');
		$query = $this->qm_model->join_all_for_preview($qm_title);

		$userid = $this->session->userdata('userid');
		$query2 = $this->recording_model->get_base_on_user_id($userid)->get_all();
		$table = "<div class='offset3' style='text-decoration:underline;'><h2>".$qm_title."</h2></div><div class='offset4'>";
		$table .= "<p>Campaign: </p></div><div class='well'><fieldset> <legend>Agent Detail:</legend>Agent Name: <br>Call-out Date: <br>Account Number: <br>Contact Number: <br></fieldset></div>";
	  	$table .= "<fieldset><legend>QM Form:</legend><div class='row'><div class='span5'>";
		foreach($query2 as $row2){

		$table .= "<p>Recording File Name: ".$row2->record_filename."</p>";

		}
		$table .= "</div><div class='span7'>";
		$table .= "<table class='table table-bordered table-hover'>";
		$prev = null;
		foreach($query as $row){

			$num++;
			$no++;

			if($row->question_type == "y"){
				$table .= "<tr class='info'>";
				$table .= "<td colspan='3'>";
				$table .=  $row->criteria_title;
				$table .= "</td>";
				$table .= "</tr>";
				$table .= "<tr>";
				$table .= "<td class='span11'>";
				$table .=  "Q".$num.": ".$row->question_title." (".$row->question_format.")";
				$table .= "</td>";
				$table .= "<td class='span3'>";
				if($row->question_format != 3){
					$table .=  "<label class='radio'><input type='radio' name='type_n_".$no."  id='type_y1' value='yes'>Yes - ".$row->question_score_y_yes."</label><label class='radio'><input type='radio' name='type_n_".$no." id='type_y2' value='no'>No - ".$row->question_score_y_no."</label>";
					if($row->question_na == 1){
						$table .=  "<label class='radio'><input type='radio' name=''  id='' value='1'>N / A</label>";
					}
				}else{
					$table .=  "<label class='radio'><input type='radio' name='fatal".$no."  id='type_y1' value='yes'>Yes</label><label class='radio'><input type='radio' name='fatal".$no." id='type_y2' value='no'>No</label>";
				}
				$table .= "</td>";

			}else{
				$table .= "<tr class='info'>";
				$table .= "<td colspan='3'>";
				$table .=  $row->criteria_title;
				$table .= "</td>";
				$table .= "</tr>";
				$table .= "<tr>";
				$table .= "<td class='span11'>";
				$table .=  "Q".$num.": ".$row->question_title." (".$row->question_format.")" ;
				$table .= "</td>";
				$table .= "<td class='span3'>";
				if($row->question_format != 3){
					if(!empty($row->question_score_n_a_value)){
					$table .= "<label class='radio'><input type='radio' name='type_n_".$no." id='type_n1' value='1' >".$row->question_score_n_a_value." - ".$row->question_score_n_a."</label>";
					}
					if(!empty($row->question_score_n_b_value)){
					$table .= "<label class='radio'><input type='radio' name='type_n_".$no." id='type_n1' value='1' >".$row->question_score_n_b_value." - ".$row->question_score_n_b."</label>";
					}
					if(!empty($row->question_score_n_c_value)){
					$table .= "<label class='radio'><input type='radio' name='type_n_".$no." id='type_n1' value='1' >".$row->question_score_n_c_value." - ".$row->question_score_n_c."</label>";
					}
					if(!empty($row->question_score_n_d_value)){
					$table .= "<label class='radio'><input type='radio' name='type_n_".$no." id='type_n1' value='1' >".$row->question_score_n_d_value." - ".$row->question_score_n_d."</label>";
					}
					if(!empty($row->question_score_n_e_value)){
					$table .= "<label class='radio'><input type='radio' name='type_n_".$no." id='type_n1' value='1' >".$row->question_score_n_e_value." - ".$row->question_score_n_e."</label>";
					}
					if($row->question_na == 1){
						$table .=  "<label class='radio'><input type='radio' name=''  id='' value='1'>N / A</label>";
					}
				}else{
					$table .=  "<label class='radio'><input type='radio' name='fatal".$no."  id='type_y1' value='yes'>Yes</label><label class='radio'><input type='radio' name='fatal".$no." id='type_y2' value='no'>No</label>";
				}
				$table .= "</td>";
			}
				$table .= "<td>";
				$table .=  "<label class='control-label' >Question Remark: </label><div class='controls'><textarea rows='3' name='question_remark[]'></textarea><input type='hidden' name='question_id[]' id='question_id'  value=".$row->question_id."></div>";
				$table .= "</td>";
				$table .= "</tr>";
		}

		$table .= "</table></div></div>";

		echo $table;
	}


	function preview_qm()
	{
		$num = 0;
		$no = 0;
		$qm_id = $this->input->post('qm_id');

		//$qm_id = 1;
		$query = $this->qm_model->get_form($qm_id);
		$query2 = $this->qm_model->get_form2($qm_id);
		$query3 = $this->qm_model->get_form3($qm_id);
		// if only got criteria and form  , will go to 2nd query
		if(!empty($query)){

			$table = "<div class='offset3' style='text-decoration:underline;'><h2>".$query[0]->qm_title."</h2></div>";
			$table .= "<div class='span7 offset1'>";
			$table .= "<table class='table table-bordered table-hover'>";
			$prev = null;

			$i = 0;
			$criteria = array();


			foreach($query as $row){
				$criteria[$i] = $row->criteria_title;


				if($row->question_format == 1){
					$question_format = "( <b>Major</b> )";
				}else if($row->question_format == 2){
					$question_format = "( <b>Minor</b> )";
				}else if($row->question_format == 3){
					$question_format = "( <b>Fatal</b> )";
				}else if($row->question_format == 4){
					$question_format = "( <b>Critical Business</b> )";
				}else if($row->question_format == 5){
					$question_format = "( <b>Critical Customer</b> )";
				}else if($row->question_format == 6){
					$question_format = "( <b>Non Critical</b> )";
				}else{
					$question_format = "";
				}


				$num++;
				$no++;

				if($row->question_type == "y"){

					if($i > 0){
						if ($criteria[$i] != $criteria[$i-1]){

							if($row->weightage == 1 || $row->weightage == 3){
								$table .= "<tr class='info'><td colspan='3'><strong>".$criteria[$i]."</strong>";
							}else{
								$table .= "<tr class='info'><td colspan='3'><strong>".$criteria[$i]."</strong> <span style='font-weight:bold;'>(".$row->criteria_rate."%)</span>";
							}
						}
					} else {

						if($row->weightage == 1 || $row->weightage == 3){
							$table .= "<tr class='info'><td colspan='3'><strong>".$criteria[$i]."</strong></td></tr>";
						}else{
							$table .= "<tr class='info'><td colspan='3'><strong>".$criteria[$i]."</strong> <span style='font-weight:bold;'>(".$row->criteria_rate."%)</span></td></tr>";
						}

					}
					$table .= "<tr>";
					$table .= "<td class='span11' colspan='3'>";
					$table .=  "Q".$num.": ".$row->question_title." ".$question_format;
					$i++;
					$table .= "</td>";
					$table .= "</tr>";
					$table .= "<tr>";
					$table .= "<td class='span3'>";
					$table .=  "<label class='radio'><input type='radio' name='type_n_".$no."  id='type_y1' value='yes'>Yes - ".$row->question_score_y_yes."</label><label class='radio'><input type='radio' name='type_n_".$no." id='type_y2' value='no'>No - ".$row->question_score_y_no."</label>";

					if($row->question_na == 1){
						$table .= "<label class='radio'><input type='radio' id='type_n1' value='9911'>N / A</label>";
					}
					$table .= "</td>";

				}else if($row->question_type == "n"){
				if($i > 0){
						if ($criteria[$i] != $criteria[$i-1]){
							if($row->weightage == 1 || $row->weightage == 3){
								$table .= "<tr class='info'><td colspan='3'><strong>".$criteria[$i]."</strong>";
							}else{
								$table .= "<tr class='info'><td colspan='3'><strong>".$criteria[$i]."</strong> <span style='font-weight:bold;'>(".$row->criteria_rate."%)</span>";
							}
						}
					} else {
						if($row->weightage == 1 || $row->weightage == 3){
							$table .= "<tr class='info'><td colspan='3'><strong>".$criteria[$i]."</strong></td></tr>";
						}else{
							$table .= "<tr class='info'><td colspan='3'><strong>".$criteria[$i]."</strong> <span style='font-weight:bold;'>(".$row->criteria_rate."%)</span></td></tr>";
						}
					}
					$table .= "<tr>";
					$table .= "<td class='span11' colspan='3'>";

					$table .=  "Q".$num.": ".$row->question_title." ".$question_format;
					$i++;
					$table .= "</td>";
					$table .= "</tr>";
					$table .= "<tr>";
					$table .= "<td class='span3'>";
					if(!empty($row->question_score_n_a_value)){
					$table .= "<label class='radio'><input type='radio' name='type_n_".$no." id='type_n1' value='1' >".$row->question_score_n_a_value." - ".$row->question_score_n_a."</label>";
					}
					if(!empty($row->question_score_n_b_value)){
					$table .= "<label class='radio'><input type='radio' name='type_n_".$no." id='type_n1' value='1' >".$row->question_score_n_b_value." - ".$row->question_score_n_b."</label>";
					}
					if(!empty($row->question_score_n_c_value)){
					$table .= "<label class='radio'><input type='radio' name='type_n_".$no." id='type_n1' value='1' >".$row->question_score_n_c_value." - ".$row->question_score_n_c."</label>";
					}
					if(!empty($row->question_score_n_d_value)){
					$table .= "<label class='radio'><input type='radio' name='type_n_".$no." id='type_n1' value='1' >".$row->question_score_n_d_value." - ".$row->question_score_n_d."</label>";
					}
					if(!empty($row->question_score_n_e_value)){
					$table .= "<label class='radio'><input type='radio' name='type_n_".$no." id='type_n1' value='1' >".$row->question_score_n_e_value." - ".$row->question_score_n_e."</label>";
					}

					if($row->question_na == 1){
						$table .= "<label class='radio'><input type='radio' id='type_n1' value='9911'>N / A</label>";
					}
					$table .= "</td>";
				}else{
					if($i > 0){
						if ($criteria[$i] != $criteria[$i-1]){


						$table .= "<tr class='info'><td colspan='3'><strong>".$criteria[$i]."</strong> <span style='font-weight:bold;'>(".$row->criteria_rate."%)</span>";
						}
					} else {


						$table .= "<tr class='info'><td colspan='3'><strong>".$criteria[$i]."</strong> <span style='font-weight:bold;'>(".$row->criteria_rate."%)</span></td></tr>";
					}
					$table .= "<tr>";
					$table .= "<td class='span11' colspan='3'>";
					$table .=  "Q".$num.": ".$row->question_title." ".$question_format;
					$i++;
					$table .= "</td>";
					$table .= "</tr>";
					$table .= "<tr>";
					$table .= "<td class='span3'>";
					$table .=  "<label class='radio'><input type='radio' name='fatal_".$no."  id='type_y1' value='yes'>Yes</label><label class='radio'><input type='radio' name='fatal_".$no." id='type_y2' value='no'>No</label>";
					if($row->question_na == 1){
						$table .= "<label class='radio'><input type='radio' id='type_n1' value='9911'>N / A</label>";
					}
					$table .= "</td>";

				}

				$table .= "<td>";
				$table .=  "<label class='control-label' >Question Remark: </label><div class='controls'><textarea rows='3' name='question_remark' class='span4'></textarea></div>";
				$table .= "</td>";
				$table .= "</tr>";
			}

			$table .= "</table></div></div>";

			echo $table;




		// if criteria , question and form is empty , will go to 2nd query
		}else if(!empty($query2)){

			$table = "<div class='offset4' style='text-decoration:underline;'><h2>".$query2[0]->qm_title."</h2></div>";
			$table .= "<div class='span7 offset1'>";
			$table .= "<table class='table table-bordered table-hover'>";
			$prev = null;
			foreach($query2 as $row){
				$num++;
				$no++;
				$table .= "<tr class='info'>";
				$table .= "<td colspan='3'>";
				$table .=  $row->criteria_title;
				$table .= "</td>";
				$table .= "</tr>";
				$table .= "<tr>";
				$table .= "<td class='span11'>";
				$table .=  "No Question Record Found";
				$table .= "</td>";
				$table .= "</tr>";
			}

			$table .= "</table></div></div>";

			echo $table;


		// if empty criteria and question , will go to 3rd query
		}else if(!empty($query3)){

			$table = "<div class='offset4' style='text-decoration:underline;'><h2>".$query3[0]->qm_title."</h2></div>";
			$table .= "<div class='span7 offset1'>";
			$table .= "<table class='table table-bordered table-hover'>";
			$prev = null;
			foreach($query3 as $row){

				$num++;
				$no++;
				$table .= "<tr class='info'>";
				$table .= "<td colspan='3'>";
				$table .=  "No Criteria Record Found";
				$table .= "</td>";
				$table .= "</tr>";
				$table .= "<tr>";
				$table .= "<td class='span11'>";
				$table .=  "No Question Record Found";
				$table .= "</td>";
				$table .= "</tr>";


			}

			$table .= "</table></div></div>";

			echo $table;


		}
	}

}//end of class
?>