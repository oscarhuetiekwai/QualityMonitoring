<?php

class User_model extends MY_Model {

	protected $_table = 'callcenter.users';
	protected $primary_key = 'userid';

	function validate_admin($username,$password)
	{
		//$enc_password = $this->encode($password);
		$this->db->select('*');
		$this->db->from('callcenter.users');
		$this->db->where('username', $username);
		$this->db->where('userpass', $password);
		$this->db->where('userlevel !=', 2);

		$query = $this->db->get();

		if($query->num_rows == 1)
		{
			return $query->row();
		}
		return false;
	}

	function view_admin($id)
	{
		$this->db->select('users.*');
		$this->db->from('callcenter.users');
		$this->db->where('users.userid', $id);

		$query = $this->db->get();

		return $query->row();
	}

	function view_admin_setting()
	{
		$this->db->select('users.*');
		$this->db->from('callcenter.users');
		$this->db->where('users.role_id', '1');

		$query = $this->db->get();

		return $query->result();
	}

	function add_admin_setting($data)
	{
		$this->db->insert('tb_staff',$data);
		$insert = $this->db->insert_id();
		return $insert;
	}

	function validate_delete_admin($userid)
	{
		$this->db->where('userid', $userid);
		$delete = $this->db->delete('users');
		return $delete;
	}
	function check_admin_exist($admin_username,$id)
	{
		$this->db->where('username', $admin_username);
		$this->db->where('userid !=', $id);
		$query = $this->db->get('tb_staff');
		//var_dump($this->db->last_query());
		if($query->num_rows != 0)
		{
			return false;
		}

		return true;
	}
	function edit_admin($data,$id=null)
	{
		$this->db->where('userid ', $id);
		return $this->db->update('tb_staff', $data);
	}

	function check_email_address($data)
	{
		$this->db->select('tb_staff.email_address');
		$this->db->from('tb_staff');
		if((isset($data['email_address']))&&(!empty($data['email_address'])))
		{
			$email_address = $data['email_address'];
			$this->db->where('tb_staff.email_address', $email_address);
		}
		$query = $this->db->get();

		return $query->row();
	}

	function update_password($search_param,$email_address)
	{
		$this->db->where('tb_staff.email_address', $email_address);
		return $this->db->update('tb_staff', $search_param);
	}

	function encode($text)
	{
		$result = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
		return trim(base64_encode($result));
	}

	function get_staff_detail_report()
	{
		$this->db->join('tb_role', 'tb_staff.role_id = tb_role.role_id');
		$this->db->join('tb_position', 'tb_staff.position_id = tb_position.position_id');
		$this->db->join('tb_department', 'tb_staff.department_id = tb_department.department_id');
		$this->db->join('tb_leave_data', 'tb_staff.userid = tb_leave_data.userid');
		$this->db->where('tb_staff.userid !=','1');
		return $this;
	}

	function get_agent()
	{
		$this->load->database('callcenter', TRUE);
		//$this->db->join('qm.dist_profile_agent', 'dist_profile.distid = dist_profile_agent.distid');
		$this->db->join('qm.dist_profile_agent', 'dist_profile_agent.userid = users.userid');

		$this->db->where('callcenter.users.userlevel !=', 4);
		$this->db->where('callcenter.users.userlevel !=', 3);
		return $this;
	}

	function sort_by_supervisor($tenant_id,$userid)
	{
		//$this->db->where('users.supervisor =',$userid);
		$this->db->where('users.tenantid =',$tenant_id);
		$this->db->where('users.userlevel =',2);

		$this->db->order_by('users.username', 'asc');
		return $this;
	}

	function sort_user($tenant_id)
	{
		$this->db->where('users.tenantid =',$tenant_id);
		$this->db->order_by('users.username', 'asc');
		return $this;
	}

	function sort_qa($tenant_id)
	{
		$this->db->where('users.tenantid =',$tenant_id);
		$this->db->where('users.userlevel =',6);
		$this->db->order_by('users.username', 'asc');
		return $this;
	}
}
?>