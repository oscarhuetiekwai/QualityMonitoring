<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->permission->is_logged_in();
		//load model
		$this->load->model('user_model');
		$this->load->model('tenant_model');
		$this->load->model('logged_model');
		$this->load->helper('url');
		$this->load->library('session');
	}

	//load to view
	function index()
	{
		$this->load->view('login/login');
	}

	//login user credentials
	function validate_credentials()
	{
		//$this->session->sess_destroy();
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');

		//$username = preg_replace('/\s\s+/','', $username);
		//$username = $this->removeUnwantedString($username);
		$password = preg_replace('/\s\s+/','', $password);
		if ($this->form_validation->run() !== FALSE){

			if($query = $this->user_model->validate_admin($username,$password))
			{
				$id = $query->userid;
				$username = $query->username;
				$tenant_id = $query->tenantid;

				######################## license for login ########################
				if($query->userlevel == 6){

					## check if user already login ##
					$get_logged = $this->logged_model->get(1);
					$userid = $get_logged->userid;
					$logged = $get_logged->logged;
					$total_logged = 0;
					$total_logged = $logged + 1;
					$license = 16;

					$user_explode = explode(",",$userid);
					$got_user = "no";
					foreach($user_explode as $userid_row){
						if($id == $userid_row){
							$got_user = "yes";
						}
					}

					## count how many user login ady ##
					$user_count = count($user_explode);

					## if this user not login, will update ##
					if(!empty($userid)){
						## if no user in db ##
						if($got_user == "no"){

							## check license ##
							if($total_logged > $license){
								$this->session->set_flashdata('error_login', 'The QA license has been reached maximum limit');
								redirect('login/index');
								exit;
							}

							$userdata = $userid.",".$id;
							$update = $this->logged_model->update(1,array('userid'=>$userdata,'logged'=>$total_logged));
						}else{
							## check license ##
							if($user_count > $license){
								$this->session->set_flashdata('error_login', 'The QA license has been reached maximum limit');
								redirect('login/index');
								exit;
							}
							$update =  $this->logged_model->update(1,array('logged'=>$user_count));
						}
					}else{
						## if user count != how many logged, which mean got problem ady, make sure it same ##

						$update =  $this->logged_model->update(1,array('userid'=>$id,'logged'=>$user_count));

						if($user_count != $logged){
							## check license ##
							if($user_count > $license){
								$this->session->set_flashdata('error_login', 'The QA license has been reached maximum limit');
								redirect('login/index');
								exit;
							}
							//$update =  $this->logged_model->update(1,array('userid'=>$id,'logged'=>$user_count));
						}
					}

				}
				######################## end license for login ########################

				$get_tenant = $this->tenant_model->get_tenant($tenant_id)->get_all();
				$tenant_name = $get_tenant[0]->name;

				$data = array(
					'userid' => $id,
					'username' => $query->username,
					'role_id'=>$query->userlevel,
					'tenant_id'=>$tenant_id,
					'tenant_name'=>$tenant_name,
					'is_logged_in' => true,
					'is_logged_admin_in' => true,
					'hash' => sha1($id.$query->userlevel.HASHTOKENADMIN)
				);

				$this->session->set_userdata($data);
				if($query->userlevel == 4 || $query->userlevel == 3){
					redirect('qm/index');
				}else{
					redirect('recording/index');
				}

			}
			else
			{
				$this->session->set_flashdata('error_login', 'Invalid username or password.');
				redirect('login/index');
			}

		}else{
			$this->session->set_flashdata('error_login', 'Invalid username or password.');

			redirect('login/index');
		}
	}

	function forgot_password()
	{
		$email_address = $this->input->post('email_address');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email_address', 'Email Address', 'required|trim|valid_email');
		if ($this->form_validation->run() == FALSE){
			$data = array();
			$data['page'] = 'forgot_pass';
			$this->load->view('login/login',$data);
		}else{
			$data = array (
				'email_address'=>$email_address
			);
			//$rand_pass = rand(25,100000000);
			## generate random alpha numeric password ##
			$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
			$rand_pass = '';
			for ($i = 0; $i < 10; $i++) {
				$rand_pass .= $characters[rand(0, strlen($characters) - 1)];
			}

			$password = $this->encode($rand_pass);
			$search_param = array (
				'password'=>$password
			);

			if ($query = $this->user_model->check_email_address($data))
			{
				$this->user_model->update_password($search_param,$email_address);
				$to = $email_address;
				$subject = 'Accordia Solution system request password';
				$message = "Kindly be inform that we setup your temparory password as '".$rand_pass."'. Please use this temparory password for your login, and once successful login remember update your password";
				$headers = 'From: <no-reply>';
				mail($to, $subject, $message, $headers);
				$this->session->set_flashdata('success_login', 'Your temporary password has been send out to your email');
				redirect("login/login");
			}
			else
			{
				$this->session->set_flashdata('error_login', 'Email address was not found in our system.');
				redirect("login/login");
			}
		}

	}

	function encode($text)
	{
		$result = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
		return trim(base64_encode($result));
	}

	function logout()
	{
		//if($this->session->userdata('role_id')==ADMIN)
		//{
		######################## license for login ########################

		$role_id = $this->session->userdata('role_id');
		$userid_session = $this->session->userdata('userid');

		if($role_id == 6){

			## check if user already login ##
			$get_logged = $this->logged_model->get(1);
			$userid = $get_logged->userid;
			$logged = $get_logged->logged;
			$total_logged = 0;
			$total_logged = $logged - 1;

			$user_explode = explode(",",$userid);

			$got_user = false; // Not found by default
			$ids_array = array_map("intval", explode(",", $userid));

			foreach ($ids_array AS $key => $value)
			{
				if ($value == $userid_session) // ID exists, remove it from the array and return the modified array
				{
					unset($ids_array[$key]);
					$result = implode(",", $ids_array);
					$got_user = true; // Found ID
				}
			}

			## get last user and remove the comma
			//	$str = substr($all_user, 0, -1);

			## count how many user login ady ##
			$user_count = count($user_explode);

			## if this user not login, will update ##
			if(!empty($userid)){
				## if got user in db ##
				if($got_user == true){

					//$userdata = $userid.",".$id;
					$update = $this->logged_model->update(1,array('userid'=>$result,'logged'=>$total_logged));
					$this->session->sess_destroy();
					redirect('login/index');
					exit;
				}else{
					$this->session->sess_destroy();
					redirect('login/index');
					exit;
				}
			}else{
				$this->session->sess_destroy();
				redirect('login/index');
				exit;
			}

		}else{
			######################## end license for login ########################
			$this->session->sess_destroy();
			redirect('login/index');
			exit;
		}
	}

	public function removeUnwantedString($string){
		$new_string = preg_replace("/[^A-Za-z0-9]/", "", $string);
		return $new_string;
	}

}//end of class
?>