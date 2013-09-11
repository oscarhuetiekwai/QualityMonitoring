<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//this controllar is proceed all the view and pagination
class Question extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->permission->is_logged_in();
		//load model
		$this->load->helper('url');
		$this->load->model('question_model');
		$this->load->model('criteria_model');
		$this->load->model('qm_model');
		$this->load->model('criteriaandquestion_model');
		$this->load->database('qm', TRUE);
	}

	function index()
	{
		$data = array();
		$data['page'] = 'question';

		$qm_id = $this->uri->segment(3);
		$criteria_id = $this->uri->segment(4);
		if($query = $this->question_model->join_criteria_and_question($qm_id,$criteria_id))
		{
			$data['data_record'] = $query;
		}
		$query2 = $this->qm_model->get($qm_id);
		$data['qm_title'] = $query2->qm_title;
		$data['weightage'] = $query2->weightage;

		$query3 = $this->criteria_model->get($criteria_id);
		$data['qm_title'] = $query2->qm_title;
		$data['criteria_title'] = $query3->criteria_title;
		$data['qm_id'] = $qm_id;
		$data['criteria_id'] = $criteria_id;
		$tenant_id = $this->session->userdata('tenant_id');
		if($query2->weightage == 1){
			if($query = $this->question_model->sort_question_format1($tenant_id)->get_all())
			{
				$data['question_records'] = $query;
			}
		}else if($query2->weightage == 3){
			if($query = $this->question_model->sort_question_format1($tenant_id)->get_all())
			{
				$data['question_records'] = $query;
			}
		}else{
			if($query = $this->question_model->sort_question_format2($tenant_id)->get_all())
			{
				$data['question_records'] = $query;
			}
		}
		$data['main'] = 'question/index';
		$data['js_function'] = array('question');
		$this->load->view('template/template',$data);
	}

	function add_question()
	{
		$this->load->library('form_validation');
		$question_title_type = $this->input->post('question_title_type');
		$weightage = $this->input->post('weightage');
		$question_format = $this->input->post('question_format');

		$this->form_validation->set_rules('question_title_type', 'Question Title Type', 'required|trim');


		if($question_title_type == 1){
			$this->form_validation->set_rules('question_title_id', 'Question Title', 'required|trim');
		}else{
			$this->form_validation->set_rules('question_title', 'Question Title', 'required|trim');
			if($question_format != 3){
				$this->form_validation->set_rules('question_type', 'Question Type', 'required|trim');
			}
		}
		if($question_format != 3){
			if($this->input->post('question_score_y_yes') && $this->input->post('question_score_y_no')){
				$this->form_validation->set_rules('question_score_y_yes', 'Yes Score', 'required|trim|numeric');
				$this->form_validation->set_rules('question_score_y_no', 'No Score', 'required|trim|numeric');
			}
		}

		if($question_format != 3){
			if($this->input->post('question_score_n_a') && $this->input->post('question_score_n_a_value') && $this->input->post('question_score_n_b') && $this->input->post('question_score_n_b_value')){
				$this->form_validation->set_rules('question_score_n_a', 'A Score', 'required|trim|numeric');
				$this->form_validation->set_rules('question_score_n_a_value', 'A Value', 'required|trim');
				$this->form_validation->set_rules('question_score_n_b', 'B Score', 'required|trim|numeric');
				$this->form_validation->set_rules('question_score_n_b_value', 'B Value', 'required|trim');
			}
		}

		$this->form_validation->set_message('is_unique', 'The %s already exist.');
		$qm_id = $this->uri->segment(3);
		$criteria_id = $this->uri->segment(4);

		if ($this->form_validation->run() === TRUE)
		{
			$question_title = $this->input->post('question_title');
			$question_type = $this->input->post('question_type');
			$question_title_id = $this->input->post('question_title_id');
			$question_na = $this->input->post('question_na');

			// if old question
			if($question_title_type == 1){
				$qm_and_criteria = array (
					'criteria_id'=>$criteria_id,
					'question_id'=>$question_title_id,
					'qm_id'=>$qm_id,
				);

				// check duplicate data
				$count = $this->criteriaandquestion_model->count_by($qm_and_criteria);

				if($count == 0){
					$this->criteriaandquestion_model->insert($qm_and_criteria);
					$this->session->set_flashdata('success', 'Your Question have been successfully added');
					redirect("question/index/$qm_id/$criteria_id");
				}else{
					$this->session->set_flashdata('error', 'You have added duplicate question title, please try other question title');
					redirect("question/add_question/$qm_id/$criteria_id");
				}

			}else{
				$tenant_id = $this->session->userdata('tenant_id');
				$data = array (
					'question_title'=>$question_title,
					'question_type'=>$question_type,
					'question_na'=>$question_na,
					'question_format'=>$question_format,
					'tenant_id'=>$tenant_id
				);

				if($question_format != 3){
					if($question_type == "y")
					{
						$question_score_y_yes = $this->input->post('question_score_y_yes');
						$question_score_y_no = $this->input->post('question_score_y_no');

						if($question_score_y_yes > $question_score_y_no){
							$data = array('question_score_y_yes'=>$question_score_y_yes,'question_score_y_no'=>$question_score_y_no,'question_top_score'=>$question_score_y_yes) + $data ;
						}else{
							$data = array('question_score_y_yes'=>$question_score_y_yes,'question_score_y_no'=>$question_score_y_no,'question_top_score'=>$question_score_y_no) + $data ;
						}

					}else{
						$question_score_n_a = $this->input->post('question_score_n_a');
						$question_score_n_a_value = $this->input->post('question_score_n_a_value');

						$question_score_n_b = $this->input->post('question_score_n_b');
						$question_score_n_b_value = $this->input->post('question_score_n_b_value');

						$question_score_n_c = $this->input->post('question_score_n_c');
						$question_score_n_c_value = $this->input->post('question_score_n_c_value');

						$question_score_n_d = $this->input->post('question_score_n_d');
						$question_score_n_d_value = $this->input->post('question_score_n_d_value');

						$question_score_n_e = $this->input->post('question_score_n_e');
						$question_score_n_e_value = $this->input->post('question_score_n_e_value');
						$array1 = array();
						$array1 = array($question_score_n_a, $question_score_n_b, $question_score_n_c, $question_score_n_d, $question_score_n_e);
						$value = max($array1);

						$data = array(
						'question_score_n_a'=>$question_score_n_a,
						'question_score_n_a_value'=>$question_score_n_a_value,

						'question_score_n_b'=>$question_score_n_b,
						'question_score_n_b_value'=>$question_score_n_b_value,

						'question_score_n_c'=>$question_score_n_c,
						'question_score_n_c_value'=>$question_score_n_c_value,

						'question_score_n_d'=>$question_score_n_d,
						'question_score_n_d_value'=>$question_score_n_d_value,

						'question_score_n_e'=>$question_score_n_e,
						'question_score_n_e_value'=>$question_score_n_e_value,
						'question_top_score'=>$value
						) + $data ;

					}
				}
				if ($this->question_model->insert($data))
				{
					$question_id = $this->db->insert_id();
					// insert to qm_and_criteria
					$criteria_and_question = array (
						'criteria_id'=>$criteria_id,
						'question_id'=>$question_id,
						'qm_id'=>$qm_id
					);

					$this->criteriaandquestion_model->insert($criteria_and_question);

					$this->session->set_flashdata('success', 'Your question have been successfully added');
					redirect("question/index/$qm_id/$criteria_id");
				}
				else
				{
					$this->session->set_flashdata('error', 'Error. Please try again.');
					redirect("question/index/$qm_id/$criteria_id");
				}
			}
		}
		else
		{
			$data = array();
			$data['page'] = 'question';

			$qm_id = $this->uri->segment(3);
			$criteria_id = $this->uri->segment(4);
			$query2 = $this->qm_model->get($qm_id);
			$data['qm_title'] = $query2->qm_title;
			$data['weightage'] = $query2->weightage;
			$tenant_id = $this->session->userdata('tenant_id');
			if($query2->weightage == 1){
				if($query = $this->question_model->sort_question_format1($tenant_id)->get_all())
				{
					$data['question_records'] = $query;
				}
			}else if($query2->weightage == 3){
				if($query = $this->question_model->sort_question_format1($tenant_id)->get_all())
				{
					$data['question_records'] = $query;
				}
			}else{
				if($query = $this->question_model->sort_question_format2($tenant_id)->get_all())
				{
					$data['question_records'] = $query;
				}
			}
			$data['qm_id'] = $qm_id;
			$data['criteria_id'] = $criteria_id;
			$data['main'] = 'question/index';
			$data['js_function'] = array('question');
			$this->load->view('template/template',$data);
		}
	}

	## Delete notification ##
	function ajax_delete_row()
	{
		//$this->permission->superadmin_admin_only();
		$question_id = $this->input->post('question_id');
		$qm_id = $this->input->post('qm_id');
		$criteria_id = $this->input->post('criteria_id');

		$data = array (
			'qm_id'=>$qm_id,
			'criteria_id'=>$criteria_id,
			'question_id'=>$question_id
		);
		if($this->criteriaandquestion_model->delete_by($data))
		{
			$msg = "success";
			echo json_encode($msg);
		}
		else
		{
			$msg = "error";
			echo json_encode($msg);
		}
	}

	## edit_question ##
	function edit_question()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('question_title', 'Question Title', 'required|trim');
		//$this->form_validation->set_rules('question_type', 'Question Type', 'required|trim');
		$this->form_validation->set_message('is_unique', 'The %s already exist.');

			if ($this->form_validation->run() === TRUE)
			{
				
				$question_id = $this->input->post('question_id');
				$qm_id = $this->input->post('qm_id');
				$criteria_id = $this->input->post('criteria_id');
				$hash = md5($question_id.SECRETTOKEN);
				$question_title = $this->input->post('question_title');
				$question_type = $this->input->post('question_type');

				$question_na = $this->input->post('question_na');
				$question_format = $this->input->post('question_format');

				$data = array (
					'question_title'=>$question_title,
					'question_na'=>$question_na,
					'question_format'=>$question_format
				);

				if( $question_format != 3 ){
					if($question_type == "y")
					{
						$question_score_y_yes = $this->input->post('question_score_y_yes');
						$question_score_y_no = $this->input->post('question_score_y_no');
						$data = array(
						'question_score_y_yes'=>$question_score_y_yes,
						'question_score_y_no'=>$question_score_y_no,
						'question_score_n_a'=>'',
						'question_score_n_a_value'=>'',
						'question_score_n_b'=>'',
						'question_score_n_b_value'=>'',
						'question_score_n_c'=>'',
						'question_score_n_c_value'=>'',
						'question_score_n_d'=>'',
						'question_score_n_d_value'=>'',
						'question_score_n_e'=>'',
						'question_score_n_e_value'=>''

						) + $data ;

					}else{
						$question_score_n_a = $this->input->post('question_score_n_a');
						$question_score_n_a_value = $this->input->post('question_score_n_a_value');

						$question_score_n_b = $this->input->post('question_score_n_b');
						$question_score_n_b_value = $this->input->post('question_score_n_b_value');

						$question_score_n_c = $this->input->post('question_score_n_c');
						$question_score_n_c_value = $this->input->post('question_score_n_c_value');

						$question_score_n_d = $this->input->post('question_score_n_d');
						$question_score_n_d_value = $this->input->post('question_score_n_d_value');

						$question_score_n_e = $this->input->post('question_score_n_e');
						$question_score_n_e_value = $this->input->post('question_score_n_e_value');
						$data = array(
						'question_score_y_yes'=>'',
						'question_score_y_no'=>'',
						'question_score_n_a'=>$question_score_n_a,
						'question_score_n_a_value'=>$question_score_n_a_value,
						'question_score_n_b'=>$question_score_n_b,
						'question_score_n_b_value'=>$question_score_n_b_value,
						'question_score_n_c'=>$question_score_n_c,
						'question_score_n_c_value'=>$question_score_n_c_value,
						'question_score_n_d'=>$question_score_n_d,
						'question_score_n_d_value'=>$question_score_n_d_value,
						'question_score_n_e'=>$question_score_n_e,
						'question_score_n_e_value'=>$question_score_n_e_value
						) + $data ;
					}
				}else{
					$data = array(					
						'question_type'=>'',	
						'question_score_y_yes'=>'',
						'question_score_y_no'=>'',
						'question_score_n_a'=>'',
						'question_score_n_a_value'=>'',
						'question_score_n_b'=>'',
						'question_score_n_b_value'=>'',
						'question_score_n_c'=>'',
						'question_score_n_c_value'=>'',
						'question_score_n_d'=>'',
						'question_score_n_d_value'=>'',
						'question_score_n_e'=>'',
						'question_score_n_e_value'=>''
						) + $data ;
				}

		
				if ($this->question_model->update($question_id,$data))
				{
					$this->session->set_flashdata('success', 'Your question have been successfully updated');
					redirect("question/index/$qm_id/$criteria_id/");
					exit;
				}
				else
				{
					$this->session->set_flashdata('error', 'Error. Please try again.');
					redirect("question/index/$qm_id/$criteria_id/");
					exit;
				}
			}
			else
			{
				$qm_id = $this->uri->segment(3);
				$criteria_id = $this->uri->segment(4);
				$question_id = $this->uri->segment(5);

				$data = array();
				if($query = $this->question_model->get_by('question_id',$question_id))
				{
					$data['data_records'] = $query;
				}


				$query2 = $this->qm_model->get($qm_id);
				$data['qm_title'] = $query2->qm_title;
				$data['weightage'] = $query2->weightage;
				$tenant_id = $this->session->userdata('tenant_id');
				if($query2->weightage == 1){
					if($query = $this->question_model->sort_question_format1($tenant_id)->get_all())
					{
						$data['question_records'] = $query;
					}
				}else{
					if($query = $this->question_model->sort_question_format2($tenant_id)->get_all())
					{
						$data['question_records'] = $query;
					}
				}

				$query3 = $this->criteria_model->get($criteria_id);
				$data['criteria_title'] = $query3->criteria_title;
				$data['qm_id'] = $qm_id;
				$data['criteria_id'] = $criteria_id;

				if($query = $this->question_model->join_criteria_and_question($qm_id,$criteria_id))
				{
					$data['data_record'] = $query;
				}

				if($query = $this->question_model->get_all())
				{
					$data['data_record_all'] = $query;
				}

				$data['qm_id'] = $qm_id;
				$data['criteria_id'] = $criteria_id;
				$data['js_function'] = array('question');
				$data['page'] = 'edit_question';
				$data['main'] = 'question/edit_question';
				$this->load->view('template/template', $data);
			}

	}

}//end of class
?>