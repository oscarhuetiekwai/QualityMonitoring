<?phpclass Qm_level_rate_model extends MY_Model {	protected $_table = 'qm.qm_level_rate';	//protected $primary_key = 'qm_id';	function sort_level()	{		//$this->db->join('qm_level_rate', 'qm_form.qm_id = qm_level_rate.qm_id');		$this->db->order_by('qm_level_rate.level', 'asc');		return $this;	}		function get_qm_level($qm_id)	{		//$this->db->join('qm_level_rate', 'qm_form.qm_id = qm_level_rate.qm_id');		$this->db->where('qm_level_rate.qm_id', $qm_id);		$this->db->order_by('qm_level_rate.level', 'asc');		return $this;	}		function sort_level_report()	{		//$this->db->join('qm_level_rate', 'qm_form.qm_id = qm_level_rate.qm_id');		$this->db->order_by('qm_level_rate.level', 'asc');		return $this;	}}?>