<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//this controllar is proceed all the view and pagination
class Criteria extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->permission->is_logged_in();
		//load model
		$this->load->helper('url');
		$this->load->model('criteria_model');
		$this->load->model('qmandcriteria_model');
		$this->load->model('qm_model');
		$this->load->database('qm', TRUE);
	}

	function index()
	{
		$data = array();
		$data['page'] = 'criteria';
		$qm_id = $this->uri->segment(3);

		$count_criteria_rate = $this->qmandcriteria_model->count_criteria_rate($qm_id);

		// calculate criteria rate not more than 100
		$total = 0;
		foreach($count_criteria_rate as $row_criteria_rate){
			$criteria_rate_count = $row_criteria_rate->criteria_rate;
			$total = $total + $criteria_rate_count;
		}


		$tenant_id = $this->session->userdata('tenant_id');
		if($query = $this->criteria_model->join_qm_and_criteria($qm_id))
		{
			$data['data_record'] = $query;
		}
		if($query = $this->criteria_model->sort_tenant($tenant_id)->get_all())
		{
			$data['data_records'] = $query;
		}
		$query2 = $this->qm_model->get($qm_id);
		$data['count_total_criteria_rate'] = $total;
		$data['qm_title'] = $query2->qm_title;
		$data['weightage'] = $query2->weightage;
		$data['qm_id'] = $qm_id;
		$data['main'] = 'criteria/index';
		$data['js_function'] = array('criteria');
		$this->load->view('template/template',$data);
	}

	function add_criteria()
	{
		$this->load->library('form_validation');
		$criteria_type = $this->input->post('criteria_type');
		$weightage = $this->input->post('weightage');
		if($criteria_type == "y"){
			$this->form_validation->set_rules('old_criteria_title', 'Old Category Title', 'required|trim');
		}else{
			$this->form_validation->set_rules('criteria_title', 'Category Title', 'required|trim');
			if($weightage == 2){
				$this->form_validation->set_rules('criteria_rate', 'Category Rate', 'required|trim|numeric');
			}
		}
		//$this->form_validation->set_rules('start_date', 'News Date', 'required|trim');
		$this->form_validation->set_message('is_unique', 'The %s already exist.');
		$qm_id = $this->uri->segment(3);

		if ($this->form_validation->run() === TRUE)
		{
			$criteria_title = $this->input->post('criteria_title');
			if($weightage == 2){
			$criteria_rate = $this->input->post('criteria_rate');
			$criteria_rate2 = $this->input->post('criteria_rate2');
			}
			$old_criteria_title = $this->input->post('old_criteria_title');
			// if old criteria
			if($criteria_type == "y"){

				$qm_and_criteria = array (
					'qm_id'=>$qm_id,
					'criteria_id'=>$old_criteria_title
				);

				// check criteria rate not more than 100%
				if($weightage == 2){
					$count_criteria_rate2 = $this->qmandcriteria_model->count_criteria_rate($qm_id);

					$criteria_rate_query = $this->criteria_model->get($old_criteria_title);

					$criteria_rate_data = $criteria_rate_query->criteria_rate;
					$criteria_title_data = $criteria_rate_query->criteria_title;

					$total2 = 0;
					foreach($count_criteria_rate2 as $row_criteria_rate2){
						$criteria_rate_count2 = $row_criteria_rate2->criteria_rate;
						$total2 = $total2 + $criteria_rate_count2;
					}
					$total_criteria_rate2 = $total2;
					$count_total_criteria_rate2 = 0;
					$count_total_criteria_rate2 = $total_criteria_rate2 + $criteria_rate2;

					if($count_total_criteria_rate2 > 100){
						$this->session->set_flashdata('error', 'The category rate cannot more than 100%, please try again');
						redirect("criteria/index/$qm_id");
						exit;
					}
				}
				// check duplicate data
				$count = $this->qmandcriteria_model->count_by($qm_and_criteria);
				$tenant_id = $this->session->userdata('tenant_id');
				if($count == 0){
					// if old criteria rate not same as old rate then will add new criteria
					if($criteria_rate_data != $criteria_rate2){
						if($weightage == 2){
							$qm_and_criteria2 = array (
								'criteria_id'=>'',
								'criteria_title'=>$criteria_title_data,
								'criteria_rate'=>$criteria_rate2,
								'tenant_id'=>$tenant_id
							);
						}else{
							$qm_and_criteria2 = array (
								'criteria_id'=>'',
								'criteria_title'=>$criteria_title_data,
								'criteria_rate'=>0,
								'tenant_id'=>$tenant_id
							);
						}
						$this->criteria_model->insert($qm_and_criteria2);
						$last_criteria_id = $this->db->insert_id();
						$qm_and_criteria3 = array (
							'qm_id'=>$qm_id,
							'criteria_id'=>$last_criteria_id
						);

						$this->qmandcriteria_model->insert($qm_and_criteria3);
						$this->session->set_flashdata('success', 'Your category have been successfully added');
						redirect("criteria/index/$qm_id");
						exit;
					}else{
						$this->qmandcriteria_model->insert($qm_and_criteria);
						$this->session->set_flashdata('success', 'Your category have been successfully added');
						redirect("criteria/index/$qm_id");
						exit;
					}

				}else{
					$this->session->set_flashdata('error', 'You have added duplicate category title, please try other category title');
					redirect("criteria/index/$qm_id");
					exit;
				}

			}else{
				if($weightage == 2){
					$count_criteria_rate = $this->qmandcriteria_model->count_criteria_rate($qm_id);

					// calculate criteria rate not more than 100
					$total = 0;
					foreach($count_criteria_rate as $row_criteria_rate){
						$criteria_rate_count = $row_criteria_rate->criteria_rate;
						$total = $total + $criteria_rate_count;
					}
					$total_criteria_rate = $total;
					$count_total_criteria_rate = 0;
					$count_total_criteria_rate = $total_criteria_rate + $criteria_rate;

					if($count_total_criteria_rate > 100){
						$this->session->set_flashdata('error', 'The category rate cannot more than 100%, please try again');
						redirect("criteria/index/$qm_id");
						exit;
					}

					$data = array (
							'criteria_title'=>$criteria_title,
							'criteria_rate'=>$criteria_rate
					);
				}else{
					$data = array (
							'criteria_title'=>$criteria_title,
							'criteria_rate'=>$criteria_rate
					);
				}

				if ($this->criteria_model->insert($data))
				{
					$criteria_id = $this->db->insert_id();
					// insert to qm_and_criteria
					$qm_and_criteria = array (
						'qm_id'=>$qm_id,
						'criteria_id'=>$criteria_id
					);

					$this->qmandcriteria_model->insert($qm_and_criteria);
					$this->session->set_flashdata('success', 'Your category have been successfully added');
					redirect("criteria/index/$qm_id");
				}
				else
				{
					$this->session->set_flashdata('error', 'Error. Please try again.');
					redirect("criteria/index/$qm_id");
				}
			}
		}
		else
		{

			$data = array();
			$data['qm_id'] = $qm_id;
			$data['page'] = 'criteria';

			$tenant_id = $this->session->userdata('tenant_id');

			if($query = $this->criteria_model->sort_tenant($tenant_id)->get_all())
			{
				$data['data_records'] = $query;
			}

			$data['main'] = "criteria/index";
			$data['js_function'] = array('criteria');
			$this->load->view('template/template',$data);

		}
	}

	## Delete notification ##
	function ajax_delete_row()
	{
		//$this->permission->superadmin_admin_only();
		$criteria_id = $this->input->post('criteria_id');
		$qm_id = $this->input->post('qm_id');
		$data = array ();
		$data = array (
			'qm_id'=>$qm_id,
			'criteria_id'=>$criteria_id
		);
		$this->load->model('criteriaandquestion_model');
		$this->criteriaandquestion_model->delete_by($data);
		if($this->qmandcriteria_model->delete_by($data))
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

	## edit_criteria ##
	function edit_criteria()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('criteria_title', 'Category Title', 'required|trim');
		$this->form_validation->set_rules('criteria_rate', 'Category Rate', 'trim');

		//$this->form_validation->set_rules('criteria_score', 'Criteria Scores', 'required|trim');
		$this->form_validation->set_message('is_unique', 'The %s already exist.');

			if ($this->form_validation->run() === TRUE)
			{

				$criteria_id = $this->input->post('criteria_id');
				$qm_id = $this->input->post('qm_id');
				$hash = md5($criteria_id.SECRETTOKEN);
				$criteria_title = $this->input->post('criteria_title');
				$query2 = $this->qm_model->get($qm_id);
				if($query2->weightage == 2){
				$criteria_rate = $this->input->post('criteria_rate');
					$data = array (
						'criteria_title'=>$criteria_title,
						'criteria_rate'=>$criteria_rate
					);
				}else{
					$data = array (
						'criteria_title'=>$criteria_title,
						'criteria_rate'=>0
					);
				}

				if($query2->weightage == 2){
					$count_criteria_rate = $this->qmandcriteria_model->edit_count_criteria_rate($qm_id,$criteria_id);

					// calculate criteria rate not more than 100
					$total = 0;
					foreach($count_criteria_rate as $row_criteria_rate){
						$criteria_rate_count = $row_criteria_rate->criteria_rate;
						$total = $total + $criteria_rate_count;
					}
					$total_criteria_rate = $total;
					$count_total_criteria_rate = 0;
					$count_total_criteria_rate = $total_criteria_rate + $criteria_rate;

					if($count_total_criteria_rate > 100){
						$this->session->set_flashdata('error', 'The category rate cannot more than 100%, please try again');
						redirect("criteria/edit_criteria/$qm_id/$criteria_id/$hash");
						exit;
					}
				}

				if ($this->criteria_model->update($criteria_id,$data))
				{
					$this->session->set_flashdata('success', 'Your category have been successfully updated');
					redirect("criteria/index/$qm_id");
				}
				else
				{
					$this->session->set_flashdata('error', 'Error. Please try again.');
					redirect("criteria/index/$qm_id");
				}
			}
			else
			{
				$qm_id = $this->uri->segment(3);
				$criteria_id = $this->uri->segment(4);

				 $count_criteria_rate = $this->qmandcriteria_model->count_criteria_rate($qm_id);

					// calculate criteria rate not more than 100
					$total = 0;
					foreach($count_criteria_rate as $row_criteria_rate){
						$criteria_rate_count = $row_criteria_rate->criteria_rate;
						$total = $total + $criteria_rate_count;
					}


				$data = array();
				if($query = $this->criteria_model->get_by('criteria_id',$criteria_id))
				{
					$data['data_records'] = $query;
				}

				if($query = $this->criteria_model->join_qm_and_criteria($qm_id))
				{
					$data['data_record'] = $query;
				}

				$tenant_id = $this->session->userdata('tenant_id');

				if($query = $this->criteria_model->sort_tenant($tenant_id)->get_all())
				{
					$data['data_records_all'] = $query;
				}

				$data['js_function'] = array('criteria');
				$query2 = $this->qm_model->get($qm_id);
				$data['qm_title'] = $query2->qm_title;
				$data['weightage'] = $query2->weightage;
				if($query2->weightage == 2){
				$data['count_total_criteria_rate'] = $total;
				}
				$data['qm_id'] = $qm_id;
				$data['page'] = 'edit_criteria';
				$data['main'] = 'criteria/edit_criteria';
				$this->load->view('template/template', $data);
			}

	}

}//end of class
?>