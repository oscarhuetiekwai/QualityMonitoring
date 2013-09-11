<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//this controllar is proceed all the view and pagination
class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->permission->is_logged_in();
		//load model
		$this->load->helper('url');
		$this->load->model('qm_model');
		$this->load->model('criteria_model');
		$this->load->model('question_model');
		$this->load->database('qm', TRUE); 
		$this->load->database('reportcallcenter', TRUE); 
	}

	function index()
	{

		$data = array();
		$data['page'] = 'dashboard';
		$data['main'] = 'dashboard/index';

		$this->load->view('template/template',$data);
	}
}//end of class
?>